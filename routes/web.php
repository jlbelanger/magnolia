<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Models\Recipe;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('home')->with('recipes', Recipe::visible());
});

Route::get('/sitemap.xml', function () {
	return response()
		->view('sitemap', ['recipes' => Recipe::public()])
		->header('Content-Type', 'text/xml');
});

Route::get('/feed.xml', function () {
	return response()
		->view('feed', ['recipes' => Recipe::public()])
		->header('Content-Type', 'text/xml');
});

Route::middleware('guest')->group(function () {
	Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
	Route::post('login', [AuthenticatedSessionController::class, 'store']);

	Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
	Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

	Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
	Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
	Route::get('profile', [ProfileController::class, 'show']);
	Route::put('profile', [ProfileController::class, 'update']);

	Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
	Route::resource('recipes', RecipeController::class)->except(['index', 'show']);
});

Route::get('/recipes/{slug}', [RecipeController::class, 'show']);
