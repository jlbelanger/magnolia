<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends AuthController
{
	public function create() : View
	{
		return view('auth.login')->with('metaTitle', 'Login');
	}

	public function store(LoginRequest $request) : RedirectResponse
	{
		try {
			$request->authenticate();
		} catch (\ValidationException $e) {
			self::logWarning(['action' => 'login', 'username' => $request->input('username')]);
			throw $e;
		}

		$request->session()->regenerate();

		$redirect = $request->input('redirect');
		if (!$redirect || $redirect[0] !== '/') {
			$redirect = '/';
		}

		self::log(['action' => 'login', 'email' => $request->user()->email]);

		return redirect($redirect);
	}

	public function destroy(Request $request) : RedirectResponse
	{
		$email = $request->user()->email;
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		self::log(['action' => 'logout', 'email' => $email]);

		return redirect('/');
	}
}
