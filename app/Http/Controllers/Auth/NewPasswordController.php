<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
	/**
	 * Displays the password reset view.
	 *
	 * @param  Request $request
	 * @return RedirectResponse|View
	 */
	public function create(Request $request)
	{
		if ($request->query('expires') < Carbon::now()->timestamp) {
			return redirect('/forgot-password')
				->with('message', __('passwords.expired'))
				->with('status', 'danger');
		}

		return view('auth.reset-password', ['request' => $request])
			->with('metaTitle', 'Reset Password');
	}

	/**
	 * Handles an incoming new password request.
	 *
	 * @param  Request $request
	 * @param  string  $token
	 * @return RedirectResponse
	 */
	public function store(Request $request, string $token) : RedirectResponse
	{
		$request->validate([
			'email' => ['required', 'email'],
			'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
		]);

		if ($request->query('expires') < Carbon::now()->timestamp) {
			return redirect('/forgot-password')
				->with('message', __('passwords.expired'))
				->with('status', 'danger');
		}

		$status = Password::reset(
			[
				'email' => $request->input('email'),
				'password' => $request->input('new_password'),
				'password_confirmation' => $request->input('new_password_confirmation'),
				'token' => $token,
			],
			function ($user) use ($request) {
				$userData = [
					'password' => Hash::make($request->input('new_password')),
					'remember_token' => Str::random(60),
				];
				if ($user instanceof MustVerifyEmail && !$user->email_verified_at) {
					$userData['email_verified_at'] = Carbon::now();
				}
				$user->forceFill($userData)->save();

				event(new PasswordReset($user));
			}
		);

		if ($status !== Password::PASSWORD_RESET) {
			if ($status === 'passwords.user') {
				$status = 'passwords.token';
			}
			return back()->withInput($request->only('email'))->with('message', __($status))->with('status', 'danger');
		}

		return redirect('/login')
			->with('message', __($status))
			->with('status', 'success');
	}
}
