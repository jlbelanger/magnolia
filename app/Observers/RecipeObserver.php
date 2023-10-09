<?php

namespace App\Observers;

use App\Models\Recipe;
use Illuminate\Support\Carbon;

class RecipeObserver
{
	/**
	 * @param  Recipe $recipe
	 * @return void
	 */
	public function deleted(Recipe $recipe)
	{
		$recipe->slug = 'deleted-' . Carbon::now() . '-' . $recipe->slug;
		$recipe->save();
	}
}
