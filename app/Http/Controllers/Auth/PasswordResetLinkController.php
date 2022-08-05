<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
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

		Password::sendResetLink($request->only('email'));

		return redirect('/login')
			->with('message', __(Password::RESET_LINK_SENT))
			->with('status', 'success');
	}
}
