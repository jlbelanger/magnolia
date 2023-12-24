<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
	/**
	 * Displays the specified resource.
	 *
	 * @return View
	 */
	public function show() : View
	{
		$row = Auth::user();
		return view('profile')
			->with('metaTitle', 'Profile')
			->with('row', $row);
	}

	/**
	 * Updates the specified resource in storage.
	 *
	 * @param  Request $request
	 * @return JsonResponse|RedirectResponse
	 */
	public function update(Request $request)
	{
		$row = Auth::user();
		$request->validate(User::rules($row->id));
		$row->update($request->except('password'));
		if ($request->wantsJson()) {
			return response()->json(['message' => 'Profile updated successfully.']);
		}

		return back()
			->with('message', 'Profile updated successfully.')
			->with('status', 'success');
	}
}
