<?php

namespace App\Providers;

use DB;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Log;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstraps any application services.
	 *
	 * @return void
	 */
	public function boot() : void
	{
		$this->configureAuth();
		$this->configureRateLimiting();

		if (config('app.debug')) {
			if (!config('app.debugbar')) {
				\Debugbar::disable();
			}

			if (config('logging.database')) {
				DB::listen(function ($q) {
					$trace = debug_backtrace();
					$source = null;
					foreach ($trace as $t) {
						if (!empty($t['file']) && strpos($t['file'], '/vendor/') === false) {
							$source = $t['file'] . ':' . $t['line'];
							break;
						}
					}
					Log::channel('database')->info(json_encode([
						'ms' => $q->time,
						'q' => $q->sql,
						'bindings' => $q->bindings,
						'source' => $source,
					]));
				});
			}
		}

		\App\Models\Recipe::observe(\App\Observers\RecipeObserver::class);
	}

	/**
	 * Registers any authentication / authorization services.
	 *
	 * @return void
	 */
	public function configureAuth() : void
	{
		// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed
		ResetPassword::toMailUsing(function ($notifiable, $token) {
			$url = url(URL::temporarySignedRoute(
				'password.update',
				Carbon::now()->addMinutes(Config::get('auth.passwords.users.expire', 60)),
				['token' => $token],
				false
			));
			return (new MailMessage)
				->subject('[' . config('app.name') . '] Reset Password')
				->line('You are receiving this email because we received a password reset request for your account.')
				->action('Reset Password', $url)
				->line('This link will expire in ' . Config::get('auth.passwords.users.expire', 60) . ' minutes.')
				->line('If you did not request a password reset, no further action is required.');
		});

		// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed
		VerifyEmail::toMailUsing(function ($notifiable, $url) {
			return (new MailMessage)
				->subject('[' . config('app.name') . '] Verify Email Address')
				->line('Please click the button below to verify your email address.')
				->action('Verify Email Address', $url)
				->line('This link will expire in ' . Config::get('auth.verification.expire', 60) . ' minutes.')
				->line('If you did not create an account, no further action is required.');
		});

		VerifyEmail::createUrlUsing(function ($notifiable) {
			return url(URL::temporarySignedRoute(
				'verification.verify',
				Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
				[
					'id' => $notifiable->getKey(),
					'hash' => sha1($notifiable->getEmailForVerification()),
				],
				false
			));
		});

		Password::defaults(function () {
			return Password::min(8);
		});
	}

	/**
	 * Configures the rate limiters for the application.
	 *
	 * @return void
	 */
	protected function configureRateLimiting()
	{
		RateLimiter::for('auth', function (Request $request) {
			if (app()->isLocal()) {
				return Limit::none();
			}
			return Limit::perMinute(config('auth.throttle_max_attempts_auth'))->by($request->ip());
		});

		RateLimiter::for('web', function (Request $request) {
			if (app()->isLocal()) {
				return Limit::none();
			}
			if (empty($_SERVER['HTTP_USER_AGENT'])) {
				$isBot = true;
			} elseif (config('auth.throttle_allow_regex')) {
				$isBot = preg_match(config('auth.throttle_allow_regex'), strtolower($_SERVER['HTTP_USER_AGENT'])) === false;
			} else {
				$isBot = false;
			}
			$limit = $isBot ? config('auth.throttle_max_attempts_bot') : config('auth.throttle_max_attempts_web');
			return Limit::perMinute($limit)->by($request->ip());
		});
	}
}
