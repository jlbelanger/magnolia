<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
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
		$request->authenticate();

		$request->session()->regenerate();

		return redirect()->intended(RouteServiceProvider::HOME);
	}

	/**
	 * Destroys an authenticated session.
	 *
	 * @param  Request $request
	 * @return RedirectResponse
	 */
	public function destroy(Request $request) : RedirectResponse
	{
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return back();
	}
}
