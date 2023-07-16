<?php

namespace App\Providers;

use App\Http\Kernel;
use App\Models\Recipe;
use App\Observers\RecipeObserver;
use DB;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Registers any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		\Laravel\Sanctum\Sanctum::ignoreMigrations();
	}

	/**
	 * Bootstraps any application services.
	 *
	 * @param  Kernel $kernel
	 * @return void
	 */
	public function boot(Kernel $kernel) // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
	{
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

		Recipe::observe(RecipeObserver::class);
	}
}
