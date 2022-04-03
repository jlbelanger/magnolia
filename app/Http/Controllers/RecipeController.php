<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RecipeController extends Controller
{
	/**
	 * Shows the form for creating a new resource.
	 *
	 * @return View
	 */
	public function create() : View
	{
		return view('recipes/create')
			->with('metaTitle', 'Add Recipe')
			->with('recipes', Recipe::visible());
	}

	/**
	 * Stores a newly created resource in storage.
	 *
	 * @param  Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request) : RedirectResponse
	{
		$request->validate(Recipe::rules());
		$input = $request->input();
		$input['is_private'] = $request->has('is_private');
		$row = Recipe::create($input);
		if ($request->wantsJson()) {
			return response()->json(['message' => 'Recipe added successfully.']);
		}
		return redirect($row->url())
			->with('message', 'Recipe added successfully.')
			->with('status', 'success');
	}

	/**
	 * Displays the specified resource.
	 *
	 * @param  string $slug
	 * @return View
	 */
	public function show(string $slug) : View
	{
		$row = Recipe::where('slug', '=', $slug);
		if (!Auth::user()) {
			$row = $row->where('is_private', '=', '0');
		}
		$row = $row->firstOrFail();
		return view('recipes/show')
			->with('metaTitle', $row->title . ' Recipe')
			->with('recipes', Recipe::visible())
			->with('row', $row);
	}

	/**
	 * Shows the form for editing the specified resource.
	 *
	 * @param  string $id
	 * @return View
	 */
	public function edit(string $id) : View
	{
		$row = Recipe::findOrFail($id);
		return view('recipes/edit')
			->with('metaTitle', 'Edit ' . $row->title . ' Recipe')
			->with('recipes', Recipe::visible())
			->with('row', $row);
	}

	/**
	 * Updates the specified resource in storage.
	 *
	 * @param  Request $request
	 * @param  string  $id
	 * @return JsonResponse|RedirectResponse
	 */
	public function update(Request $request, string $id)
	{
		$row = Recipe::findOrFail($id);
		$request->validate(Recipe::rules($id));
		$input = $request->input();
		$input['is_private'] = $request->has('is_private');
		$row->update($input);
		if ($request->wantsJson()) {
			return response()->json(['message' => 'Recipe updated successfully.']);
		}
		return back()
			->with('message', 'Recipe updated successfully.')
			->with('status', 'success');
	}

	/**
	 * Removes the specified resource from storage.
	 *
	 * @param  string $id
	 * @return View
	 */
	public function destroy(string $id) : RedirectResponse
	{
		$row = Recipe::findOrFail($id);
		$row->delete();
		if ($request->wantsJson()) {
			return response()->json(['message' => 'Recipe deleted successfully.']);
		}
		return redirect(RouteServiceProvider::HOME)
			->with('message', 'Recipe deleted successfully.')
			->with('status', 'success');
	}
}
