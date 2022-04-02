<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	$recipes = \App\Models\Recipe::all();
	return view('home')
		->with('recipes', $recipes);
});

Route::get('/recipes/{slug}', '\App\Http\Controllers\RecipeController@show');
