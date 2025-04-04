<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
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
			->with('categories', Category::orderBy('title')->get());
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
		if (empty($input['is_private'])) {
			$input['published_at'] = date('Y-m-d H:i:s');
		}
		$row = Recipe::create($input);
		$row->updateTimes($request);
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
			->with('row', $row)
			->with('categories', Category::orderBy('title')->get());
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
		if (empty($row->published_at) && empty($input['published_at']) && empty($input['is_private'])) {
			$input['published_at'] = date('Y-m-d H:i:s');
		}

		if ($request->hasFile('filename')) {
			$file = $request->file('filename');
			$oldPath = $file->getClientOriginalName();
			$filename = !empty($input['slug']) ? $input['slug'] : $row->slug;
			$pathInfo = pathinfo($oldPath);
			$newFilename = $filename . '.' . $pathInfo['extension'];
			$file->move(public_path('uploads'), $newFilename);
			$input['filename'] = $newFilename;
			$row->createThumbnail($newFilename);
		} elseif ($request->has('remove_filename')) {
			$path = public_path('uploads/' . $row->filename);
			if (unlink($path)) {
				$input['filename'] = '';

				$path = public_path('uploads/thumbnails/' . $row->filename);
				unlink($path);
			}
		} elseif ($row->filename) {
			$path = public_path('uploads/thumbnails/' . $row->filename);
			if (!file_exists($path)) {
				$row->createThumbnail(basename($row->filename));
			}
		}

		$row->updateTimes($request);
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
	 * @param  Request $request
	 * @param  string  $id
	 * @return View
	 */
	public function destroy(Request $request, string $id) : RedirectResponse
	{
		$row = Recipe::findOrFail($id);
		$row->delete();
		if ($request->wantsJson()) {
			return response()->json(['message' => 'Recipe deleted successfully.']);
		}
		return redirect('/')
			->with('message', 'Recipe deleted successfully.')
			->with('status', 'success');
	}
}
