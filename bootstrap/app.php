<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Jlbelanger\Tapioca\Exceptions\JsonApiException;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
	)
	->withMiddleware(function (Middleware $middleware) {
		$middleware->alias([
			'auth' => \App\Http\Middleware\Authenticate::class,
			'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
		]);
	})
	->withExceptions(function (Exceptions $exceptions) {
		$exceptions->dontReport([
			JsonApiException::class,
		]);

		// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		$exceptions->render(function (InvalidSignatureException $e) {
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

		// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		$exceptions->render(function (MethodNotAllowedHttpException $e) {
			if (request()->expectsJson()) {
				return response()->json(['errors' => [['title' => 'URL does not exist.', 'status' => '404', 'detail' => 'Method not allowed.']]], 404);
			}
			return response()->view('errors.404', [], 404);
		});

		$exceptions->render(function (NotFoundHttpException $e) {
			if (request()->expectsJson()) {
				return response()->json(['errors' => [['title' => $e->getMessage() ? $e->getMessage() : 'URL does not exist.', 'status' => '404']]], 404);
			}
			return response()->view('errors.404', [], 404);
		});

		$exceptions->render(function (ThrottleRequestsException $e) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
			if (request()->expectsJson()) {
				return response()->json(['errors' => [['title' => 'Please wait before retrying.', 'status' => '429']]], 429);
			}
		});

		$exceptions->render(function (ValidationException $e) {
			if (!request()->expectsJson()) {
				return back()->withErrors($e->validator)->withInput();
			}
		});

		$exceptions->render(function (Throwable $e) {
			if (request()->expectsJson()) {
				$error = ['title' => 'There was an error connecting to the server.', 'status' => '500'];
				if (config('app.debug')) {
					$error['detail'] = $e->getMessage();
					$error['meta'] = [
						'exception' => get_class($e),
						'file' => $e->getFile(),
						'line' => $e->getLine(),
					];
					if (config('app.env') !== 'testing') {
						$error['meta']['trace'] = $e->getTrace();
					}
				}
				return response()->json(['errors' => [$error]], 500);
			}
			if (!config('app.debug')) {
				return response()->view('errors.500', [], 500);
			}
		});
	})->create();
