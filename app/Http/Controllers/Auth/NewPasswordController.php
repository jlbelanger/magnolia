<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
	/**
	 * Display the password reset view.
	 *
	 * @param  Request $request
	 * @return View
	 */
	public function create(Request $request) : View
	{
		return view('auth.reset-password', ['request' => $request])
			->with('metaTitle', 'Reset Password');
	}

	/**
	 * Handle an incoming new password request.
	 *
	 * @param  Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request) : RedirectResponse
	{
		$request->validate([
			'token' => ['required'],
			'email' => ['required', 'email'],
			'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
		]);

		// Here we will attempt to reset the user's password. If it is successful we
		// will update the password on an actual user model and persist it to the
		// database. Otherwise we will parse the error and return the response.
		$message = Password::reset(
			$request->only('email', 'new_password', 'new_password_confirmation', 'token'),
			function ($user) use ($request) {
				$user->forceFill([
					'new_password' => Hash::make($request->new_password),
					'remember_token' => Str::random(60),
				])->save();

				event(new PasswordReset($user));
			}
		);

		// If the password was successfully reset, we will redirect the user back to
		// the application's home authenticated view. If there is an error we can
		// redirect them back to where they came from with their error message.
		if ($message == Password::PASSWORD_RESET) {
			return redirect('/login')
				->with('message', __($message))
				->with('status', 'success');
		}

		return back()->withInput($request->only('email'))->withErrors(['email' => __($message)]);
	}
}
