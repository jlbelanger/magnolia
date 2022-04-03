<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parsedown;

class Recipe extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'title',
		'slug',
		'content',
		'notes',
	];

	public function content() : string
	{
		$content = $this->content;
		$content = (new Parsedown())->setBreaksEnabled(true)->text($content);

		preg_match_all('/<li>(.+)/', $content, $matches);
		foreach ($matches[0] as $i => $m) {
			$step = $i + 1;
			$pos = strpos($content, $m);
			$text = '<li><input class="checkbox" id="step-' . $step . '" type="checkbox"><label for="step-' . $step . '">' . $matches[1][$i] . '</label>';
			$content = substr_replace($content, $text, $pos, strlen($m));
		}

		preg_match_all('/([0-9\.]+) (second|minute|hour)s?/', $content, $matches);
		$done = [];
		foreach ($matches[0] as $i => $m) {
			if (in_array($m, $done)) {
				continue;
			}
			$num = $matches[1][$i];
			if ($matches[2][$i] === 'minute') {
				$num *= 60;
			} elseif ($matches[2][$i] === 'hour') {
				$num *= 60 * 60;
			}
			$content = str_replace($m, '<button class="timer-link" data-timer="' . $num . '" type="button">' . $m . '</button>', $content);
			$done[] = $m;
		}

		return $content;
	}


	public function summary() : string
	{
		return (new Parsedown())->setBreaksEnabled(true)->text($this->summary);
	}
}
