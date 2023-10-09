<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SearchController;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	$latestRecipes = Recipe::whereNotNull('filename')
		->orderByDesc('published_at')
		->take(9)
		->get();
	$draftRecipes = collect([]);
	if (Auth::user()) {
		$draftRecipes = Recipe::where('is_private', '=', '1')
			->orderByDesc('created_at')
			->take(3)
			->get();
	}
	return view('home')
		->with('latestRecipes', $latestRecipes)
		->with('draftRecipes', $draftRecipes);
});

Route::get('/sitemap.xml', function () {
	return response()
		->view('sitemap', ['recipes' => Recipe::public()->orderBy('slug')->get()])
		->header('Content-Type', 'text/xml');
});

Route::get('/feed.xml', function () {
	return response()
		->view('feed', ['recipes' => Recipe::public()->orderBy('published_at', 'desc')->take(10)->get()])
		->header('Content-Type', 'text/xml');
});

Route::group(['middleware' => ['guest']], function () {
	Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
	Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');

	Route::group(['middleware' => ['throttle:' . config('auth.throttle_max_attempts') . ',1']], function () {
		Route::post('login', [AuthenticatedSessionController::class, 'store']);
		Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
		Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
		Route::post('reset-password/{token}', [NewPasswordController::class, 'store'])->middleware('signed:relative')->name('password.update');
	});
});

Route::middleware('auth')->group(function () {
	Route::get('profile', [ProfileController::class, 'show']);
	Route::put('profile', [ProfileController::class, 'update']);

	Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
	Route::resource('categories', CategoryController::class)->except(['index', 'show']);
	Route::resource('recipes', RecipeController::class)->except(['index', 'show']);
});

Route::get('/search', [SearchController::class, 'show']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);
Route::get('/recipes/{slug}', [RecipeController::class, 'show']);
