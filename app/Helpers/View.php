<?php

namespace App\Helpers;

class View
{
	public static function bodyClass() : string
	{
		$output = [];
		if (auth()->user()) {
			$output[] = 'auth';
		}
		if (request()->is('recipes/*')) {
			$output[] = 'show-note-form';
		}
		return implode(' ', $output);
	}
}
