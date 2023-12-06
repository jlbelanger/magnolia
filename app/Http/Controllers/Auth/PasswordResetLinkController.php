<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends AuthController
{
	/**
	 * Displays the password reset link request view.
	 *
	 * @return View
	 */
	public function create() : View
	{
		return view('auth.forgot-password')
			->with('metaTitle', 'Forgot Your Password?');
	}

	/**
	 * Handles an incoming password reset link request.
	 *
	 * @param  Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request) : RedirectResponse
	{
		$request->validate([
			'email' => ['required', 'email'],
		]);

		$email = $request->only('email');
		try {
			$status = Password::sendResetLink(['email' => $email]);
		} catch (Exception $e) {
			self::logWarning(['action' => 'forgotPassword', 'email' => $email]);
			return redirect('/forgot-password')
				->with('message', __('passwords.send_error'))
				->with('status', 'danger');
		}

		$success = $status === Password::RESET_LINK_SENT;
		if ($status === Password::RESET_LINK_SENT) {
			self::log(['action' => 'forgotPassword', 'email' => $email]);
		} else {
			self::logWarning(['action' => 'forgotPassword', 'email' => $email, 'info' => $status]);
		}
		return redirect('/forgot-password')
			->with('message', __(Password::RESET_LINK_SENT))
			->with('status', 'success');
	}
}
