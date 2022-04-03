<?php

namespace App\Observers;

use App\Models\Recipe;

class RecipeObserver
{
	/**
	 * @param  Recipe $recipe
	 * @return void
	 */
	public function deleted(Recipe $recipe)
	{
		$recipe->slug = 'deleted-' . strtotime('now') . '-' . $recipe->slug;
		$recipe->save();
	}
}
