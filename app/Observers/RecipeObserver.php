<?php

namespace App\Observers;

use App\Models\Recipe;
use Illuminate\Support\Carbon;

class RecipeObserver
{
	public function deleted(Recipe $recipe) : void
	{
		$recipe->slug = 'deleted-' . Carbon::now() . '-' . $recipe->slug;
		$recipe->save();
	}
}
