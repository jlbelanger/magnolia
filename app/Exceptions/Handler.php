<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
		// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
		$this->renderable(function (InvalidSignatureException $e) {
			if (!url()->signatureHasNotExpired(request())) {
				if (request()->expectsJson()) {
					return response()->json(['errors' => [['title' => __('passwords.expired'), 'status' => '403']]], 403);
				}
				return back()->with('message', __('passwords.expired'))->with('status', 'danger');
			}
			if (request()->expectsJson()) {
				return response()->json(['errors' => [['title' => __('passwords.token'), 'status' => '403']]], 403);
			}
			return back()->with('message', __('passwords.token'))->with('status', 'danger');
		});

		// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
		$this->renderable(function (MethodNotAllowedHttpException $e) {
			if (request()->expectsJson()) {
				return response()->json(['errors' => [['title' => 'URL does not exist.', 'status' => '404', 'detail' => 'Method not allowed.']]], 404);
			}
			return response()->view('errors.404', [], 404);
		});

		$this->renderable(function (NotFoundHttpException $e) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
			if (request()->expectsJson()) {
				return response()->json(['errors' => [['title' => 'URL does not exist.', 'status' => '404']]], 404);
			}
			return response()->view('errors.404', [], 404);
		});

		$this->renderable(function (ThrottleRequestsException $e) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClass
			if (request()->expectsJson()) {
				return response()->json(['errors' => [['title' => 'Please wait before retrying.', 'status' => '429']]], 429);
			}
		});

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
