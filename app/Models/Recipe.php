<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Parsedown;

class Recipe extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'title',
		'slug',
		'filename',
		'summary',
		'content',
		'notes',
		'is_private',
		'published_at',
	];

	public function content() : string
	{
		$content = $this->content;
		$content = $this->hideNotes($content);
		$content = (new Parsedown())->setBreaksEnabled(true)->text($content);
		$content = $this->addCheckboxes($content);
		$content = $this->addTimers($content);
		$content = $this->addLinkTarget($content);
		$content = $this->addHeadingAnchors($content);
		return $content;
	}

	protected function hideNotes(string $content) : string
	{
		if (!Auth::user()) {
			$content = str_replace("\r\n", "\n", $content);
			$content = preg_replace("/\n\s*\*[^\*]+\*\n/", "\n", $content);
			$content = preg_replace('/\s?\*[^\*]+\*/', '', $content);
		}
		return $content;
	}

	protected function addCheckboxes(string $content) : string
	{
		preg_match_all('/<li>(.+)/', $content, $matches);
		foreach ($matches[0] as $i => $m) {
			$step = $i + 1;
			$pos = strpos($content, $m);
			$text = '<li><input class="checkbox" id="step-' . $step . '" type="checkbox"><label for="step-' . $step . '">' . $matches[1][$i] . '</label>';
			$content = substr_replace($content, $text, $pos, strlen($m));
		}
		return $content;
	}

	protected function addLinkTarget(string $content) : string
	{
		$content = str_replace('<a href', '<a target="_blank" href', $content);
		return $content;
	}

	protected function addHeadingAnchors(string $content) : string
	{
		preg_match_all('/<h([1-6])>([^\n]+)<\/h[1-6]>/', $content, $matches);
		$headings = [];

		foreach ($matches[0] as $i => $line) {
			$j = $matches[1][$i];
			$subtitle = $matches[2][$i];
			$slug = Str::slug(preg_replace('/&[A-Za-z0-9]+;/', '', strip_tags($subtitle)));
			$slugSuffix = '';
			if (!empty($headings[$slug])) {
				$slugSuffix = '-' . ($headings[$slug] + 1);
			}

			$newLine = '<h' . $j . ' id="' . $slug . $slugSuffix . '">' . $subtitle . '</h' . $j . '>';
			$oldLine = str_replace('/', '\/', preg_quote($line));
			$content = preg_replace('/' . $oldLine . '/', $newLine, $content, 1);

			if (empty($headings[$slug])) {
				$headings[$slug] = 0;
			}
			$headings[$slug]++;
		}

		return $content;
	}

	protected function addTimers(string $content) : string
	{
		preg_match_all('/( [0-9\.]+-| )([0-9\.]+) (second|minute|hour)s?/', $content, $matches);
		$done = [];
		foreach ($matches[0] as $i => $m) {
			if (in_array($m, $done)) {
				continue;
			}
			$num = $matches[2][$i];
			if (!empty(trim($matches[1][$i]))) {
				$num = trim($matches[1][$i], '- ');
			}
			if ($matches[3][$i] === 'minute') {
				$num *= 60;
			} elseif ($matches[3][$i] === 'hour') {
				$num *= 60 * 60;
			}
			$content = str_replace(
				$m,
				' <button class="timer-link" data-timer="' . $num . '" type="button">' . trim($m) . '</button>',
				$content
			);
			$done[] = $m;
		}
		return $content;
	}

	public function createThumbnail(string $filename) : void
	{
		$lgPath = public_path('uploads/' . $filename);
		$smPath = public_path('uploads/thumbnails/' . $filename);

		$lgWidth = 1600;
		$lgHeight = 900;
		$smWidth = 640;
		$smHeight = 360;

		$src = imagecreatefromjpeg($lgPath);
		$dst = imagecreatetruecolor($smWidth, $smHeight);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $smWidth, $smHeight, $lgWidth, $lgHeight);
		imagejpeg($dst, $smPath);
		imagedestroy($src);
		imagedestroy($dst);
	}

	public static function public() : Collection
	{
		return self::where('is_private', '=', '0')
			->whereNotNull('published_at')
			->orderBy('published_at', 'desc')
			->take(10)
			->get();
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
		$summary = $this->summary;
		$summary = $this->hideNotes($summary);
		$summary = (new Parsedown())->setBreaksEnabled(true)->text($summary);
		$summary = $this->addLinkTarget($summary);
		return $summary;
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
