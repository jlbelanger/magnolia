<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
	/**
	 * Gets the path the user should be redirected to when they are not authenticated.
	 *
	 * @param  Request $request
	 * @return string|null
	 */
	protected function redirectTo($request) // phpcs:ignore Squiz.Commenting.FunctionComment.TypeHintMissing
	{
		if (!$request->expectsJson()) {
			return '/login?redirect=' . urlencode(str_replace(config('app.url'), '', $request->fullUrl()));
		}
	}
}
