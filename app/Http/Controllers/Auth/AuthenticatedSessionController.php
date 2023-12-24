<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends AuthController
{
	/**
	 * Displays the login view.
	 *
	 * @return View
	 */
	public function create() : View
	{
		return view('auth.login')->with('metaTitle', 'Login');
	}

	/**
	 * Handles an incoming authentication request.
	 *
	 * @param  LoginRequest $request
	 * @return RedirectResponse
	 */
	public function store(LoginRequest $request) : RedirectResponse
	{
		try {
			$request->authenticate();
		} catch (\Exception $e) {
			self::logWarning(['action' => 'login', 'username' => $request->input('username')]);
			throw $e;
		}

		$request->session()->regenerate();

		$redirect = $request->input('redirect');
		if (!$redirect || $redirect[0] !== '/') {
			$redirect = RouteServiceProvider::HOME;
		}

		self::log(['action' => 'login', 'email' => $request->user()->email]);

		return redirect($redirect);
	}

	/**
	 * Destroys an authenticated session.
	 *
	 * @param  Request $request
	 * @return RedirectResponse
	 */
	public function destroy(Request $request) : RedirectResponse
	{
		$email = $request->user()->email;
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		self::log(['action' => 'logout', $email]);

		return redirect(RouteServiceProvider::HOME);
	}
}
