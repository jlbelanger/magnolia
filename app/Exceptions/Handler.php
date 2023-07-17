<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array<int, class-string<Throwable>>
	 */
	protected $dontReport = [];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array<int, string>
	 */
	protected $dontFlash = [
		'current_password',
		'password',
		'password_confirmation',
		'new_password',
		'new_password_confirmation',
	];

	/**
	 * Registers the exception handling callbacks for the application.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->renderable(function (Throwable $e) {
			if (request()->expectsJson()) {
				$error = ['title' => 'There was an error connecting to the server.', 'status' => '500'];
				if (config('app.debug')) {
					$error['detail'] = $e->getMessage();
					$error['meta'] = [
						'exception' => get_class($e),
						'file' => $e->getFile(),
						'line' => $e->getLine(),
						'trace' => $e->getTrace(),
					];
				}
				return response()->json(['errors' => [$error]], 500);
			}
			if (!config('app.debug')) {
				return response()->view('errors.500', [], 500);
			}
		});
	}
}
