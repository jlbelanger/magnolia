<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Parsedown;

class Recipe extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'title',
		'slug',
		'summary',
		'content',
		'notes',
		'is_private',
	];

	public function content() : string
	{
		$content = $this->content;

		if (!Auth::user()) {
			$content = str_replace("\r\n", "\n", $content);
			$content = preg_replace("/\n\s*\*[^\*]+\*\n/", "\n", $content);
			$content = preg_replace('/\s?\*[^\*]+\*/', '', $content);
		}

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

	public function rules(string $id = '') : array
	{
		$unique = $id ? ',' . $id : '';
		$required = $id ? 'filled' : 'required';
		return [
			'title' => [$required, 'max:255', 'unique:recipes,title' . $unique],
			'slug' => [$required, 'max:255', 'alpha_dash', 'unique:recipes,slug' . $unique],
			'content' => [$required],
			'is_private' => ['boolean'],
		];
	}

	public function summary() : string
	{
		if (!$this->summary) {
			return '';
		}
		return (new Parsedown())->setBreaksEnabled(true)->text($this->summary);
	}

	public function url() : string
	{
		return '/recipes/' . $this->slug;
	}

	public static function visible() : Collection
	{
		$rows = self::orderBy('slug');
		if (!Auth::user()) {
			$rows = $rows->where('is_private', '=', '0');
		}
		return $rows->get();
	}
}
