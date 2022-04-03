<?php

namespace App\Providers;

use App\Http\Kernel;
use App\Models\Recipe;
use App\Observers\RecipeObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @param  Kernel $kernel
	 * @return void
	 */
	public function boot(Kernel $kernel)
	{
		if (env('DISABLE_DEBUGBAR') === '1') {
			\Debugbar::disable();
		}

		if ($this->app->environment() !== 'local') {
			$kernel->appendMiddlewareToGroup('api', \Illuminate\Routing\Middleware\ThrottleRequests::class);
		}

		Recipe::observe(RecipeObserver::class);
	}
}
