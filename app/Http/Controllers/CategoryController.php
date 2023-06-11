<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
	/**
	 * Shows the form for creating a new resource.
	 *
	 * @return View
	 */
	public function create() : View
	{
		return view('categories/create')
			->with('metaTitle', 'Add Category');
	}

	/**
	 * Stores a newly created resource in storage.
	 *
	 * @param  Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request) : RedirectResponse
	{
		$request->validate(Category::rules());
		$input = $request->input();
		$row = Category::create($input);
		if ($request->wantsJson()) {
			return response()->json(['message' => 'Category added successfully.']);
		}
		return redirect($row->url())
			->with('message', 'Category added successfully.')
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
		$row = Category::where('slug', '=', $slug)->firstOrFail();
		return view('categories/show')
			->with('metaTitle', Str::singular($row->title) . ' Recipes')
			->with('row', $row)
			->with('recipes', $row->recipes);
	}

	/**
	 * Shows the form for editing the specified resource.
	 *
	 * @param  string $id
	 * @return View
	 */
	public function edit(string $id) : View
	{
		$row = Category::findOrFail($id);
		return view('categories/edit')
			->with('metaTitle', 'Edit ' . $row->title . ' Recipes')
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
		$row = Category::findOrFail($id);
		$request->validate(Category::rules($id));
		$input = $request->input();
		$row->update($input);
		if ($request->wantsJson()) {
			return response()->json(['message' => 'Category updated successfully.']);
		}

		return back()
			->with('message', 'Category updated successfully.')
			->with('status', 'success');
	}

	/**
	 * Removes the specified resource from storage.
	 *
	 * @param  Request $request
	 * @param  string  $id
	 * @return View
	 */
	public function destroy(Request $request, string $id) : RedirectResponse
	{
		$row = Category::findOrFail($id);
		$row->delete();
		if ($request->wantsJson()) {
			return response()->json(['message' => 'Category deleted successfully.']);
		}
		return redirect(RouteServiceProvider::HOME)
			->with('message', 'Category deleted successfully.')
			->with('status', 'success');
	}
}
