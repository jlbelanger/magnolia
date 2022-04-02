<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeController extends Controller
{
	/**
	 * @param  Request $request
	 * @param  string  $slug
	 * @return View
	 */
	public function show(Request $request, string $slug) : View // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassBeforeLastUsed
	{
		$row = Recipe::where('slug', '=', $slug)->firstOrFail();
		$recipes = Recipe::all();
		return view('recipes/show')
			->with('metaTitle', $row->title)
			->with('recipes', $recipes)
			->with('row', $row);
	}
}
