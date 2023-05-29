<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
	/**
	 * Displays the specified resource.
	 *
	 * @return View
	 */
	public function show(Request $request) : View
	{
		$q = $request->query('q');
		$like = '%' . Str::slug($q) . '%';
		$recipes = Recipe::where('slug', 'like', $like)->get();
		return view('search')
			->with('metaTitle', 'Search Results')
			->with('recipes', $recipes)
			->with('q', $q);
	}
}
