<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
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
		'category_id',
		'summary',
		'sources',
		'content',
		'notes',
		'is_private',
		'published_at',
		'serving_size',
		'calories',
		'fat',
		'saturated_fat',
		'trans_fat',
		'polyunsaturated_fat',
		'omega_6',
		'omega_3',
		'monounsaturated_fat',
		'cholesterol',
		'sodium',
		'potassium',
		'carbohydrate',
		'fibre',
		'sugars',
		'protein',
		'vitamin_a',
		'vitamin_c',
		'calcium',
		'iron',
		'vitamin_d',
		'vitamin_e',
		'vitamin_k',
		'thiamin',
		'riboflavin',
		'niacin',
		'vitamin_b6',
		'folate',
		'vitamin_b12',
		'biotin',
		'pantothenate',
		'phosphorus',
		'iodine',
		'magnesium',
		'zinc',
		'selenium',
		'copper',
		'manganese',
		'chromium',
		'molybdenum',
		'chloride',
	];

	protected $casts = [
		'category_id' => 'integer',
		'calories' => 'integer',
		'fat' => 'float',
		'saturated_fat' => 'float',
		'trans_fat' => 'float',
		'polyunsaturated_fat' => 'float',
		'omega_6' => 'float',
		'omega_3' => 'float',
		'monounsaturated_fat' => 'float',
		'cholesterol' => 'float',
		'sodium' => 'float',
		'potassium' => 'float',
		'carbohydrate' => 'float',
		'fibre' => 'float',
		'sugars' => 'float',
		'protein' => 'float',
		'vitamin_a' => 'integer',
		'vitamin_c' => 'integer',
		'calcium' => 'integer',
		'iron' => 'integer',
		'vitamin_d' => 'integer',
		'vitamin_e' => 'integer',
		'vitamin_k' => 'integer',
		'thiamin' => 'integer',
		'riboflavin' => 'integer',
		'niacin' => 'integer',
		'vitamin_b6' => 'integer',
		'folate' => 'integer',
		'vitamin_b12' => 'integer',
		'biotin' => 'integer',
		'pantothenate' => 'integer',
		'phosphorus' => 'integer',
		'iodine' => 'integer',
		'magnesium' => 'integer',
		'zinc' => 'integer',
		'selenium' => 'integer',
		'copper' => 'integer',
		'manganese' => 'integer',
		'chromium' => 'integer',
		'molybdenum' => 'integer',
		'chloride' => 'integer',
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
		$content = $this->highlightAmounts($content);
		$content = $this->addMeasurements($content);
		$content = str_replace('° F', '°&nbsp;F', $content);
		$content = str_replace('° C', '°&nbsp;C', $content);
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

	public function activeTime() : string
	{
		$minutes = $this->times->where('is_active')->pluck('minutes')->sum();
		return Time::formatTime($minutes);
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

	public function editUrl() : string
	{
		return '/recipes/' . $this->id . '/edit';
	}

	protected function highlightAmounts(string $summary) : string
	{
		return preg_replace('/\[(\d+)\]/', '<span data-amount="$1">$1</span>', $summary);
	}

	protected function addMeasurements(string $content) : string
	{
		$hasMatches = preg_match_all('/\[((?:\d+ )?[0-9\.\/-]+) ?([^\]]+)\]/', $content, $matches);
		if (!$hasMatches) {
			return $content;
		}

		$replaced = [];
		$singularValues = ['1', '1/2', '1/3', '1/4', '1/8', '1/16'];

		foreach ($matches[0] as $i => $m) {
			if (in_array($m, $replaced)) {
				continue;
			}

			$replaced[] = $m;
			$num = $matches[1][$i];
			$unit = $matches[2][$i];
			$plural = in_array($unit, ['tsp', 'tbsp', 'oz', 'ml', 'g']) ? $unit : Str::plural($unit);
			$text = $num . ' ' . (in_array($num, $singularValues) ? $unit : $plural);

			$new = '<span data-num="' . $num . '" data-unit="' . $unit . '">' . $text . '</span>';
			$content = str_replace($m, $new, $content);
		}

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
			$content = preg_replace(
				'/' . $m . '(\b)/',
				' <button class="timer-link" data-timer="' . $num . '" type="button">' . trim($m) . '</button>$1',
				$content
			);
			$done[] = $m;
		}
		return $content;
	}

	protected static function booted()
	{
		static::addGlobalScope('ancient', function (Builder $builder) {
			if (!Auth::user()) {
				$builder->where('is_private', '=', '0');
			}
		});
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

	public static function public() : Builder
	{
		return self::where('is_private', '=', '0')
			->whereNotNull('published_at');
	}

	public static function rules(string $id = '') : array
	{
		$unique = $id ? ',' . $id : '';
		$required = $id ? 'filled' : 'required';
		return [
			'title' => [$required, 'max:255', 'unique:recipes,title' . $unique],
			'slug' => [$required, 'max:255', 'alpha_dash', 'unique:recipes,slug' . $unique],
			'category_id' => [$required, 'integer'],
			'content' => [$required],
			'is_private' => ['boolean'],
			'serving_size' => ['nullable', 'max:255'],
			'calories' => ['nullable', 'integer'],
			'fat' => ['nullable', 'numeric'],
			'saturated_fat' => ['nullable', 'numeric'],
			'trans_fat' => ['nullable', 'numeric'],
			'polyunsaturated_fat' => ['nullable', 'numeric'],
			'omega_6' => ['nullable', 'numeric'],
			'omega_3' => ['nullable', 'numeric'],
			'monounsaturated_fat' => ['nullable', 'numeric'],
			'cholesterol' => ['nullable', 'numeric'],
			'sodium' => ['nullable', 'numeric'],
			'potassium' => ['nullable', 'numeric'],
			'carbohydrate' => ['nullable', 'numeric'],
			'fibre' => ['nullable', 'numeric'],
			'sugars' => ['nullable', 'numeric'],
			'protein' => ['nullable', 'numeric'],
			'vitamin_a' => ['nullable', 'integer'],
			'vitamin_c' => ['nullable', 'integer'],
			'calcium' => ['nullable', 'integer'],
			'iron' => ['nullable', 'integer'],
			'vitamin_d' => ['nullable', 'integer'],
			'vitamin_e' => ['nullable', 'integer'],
			'vitamin_k' => ['nullable', 'integer'],
			'thiamin' => ['nullable', 'integer'],
			'riboflavin' => ['nullable', 'integer'],
			'niacin' => ['nullable', 'integer'],
			'vitamin_b6' => ['nullable', 'integer'],
			'folate' => ['nullable', 'integer'],
			'vitamin_b12' => ['nullable', 'integer'],
			'biotin' => ['nullable', 'integer'],
			'pantothenate' => ['nullable', 'integer'],
			'phosphorus' => ['nullable', 'integer'],
			'iodine' => ['nullable', 'integer'],
			'magnesium' => ['nullable', 'integer'],
			'zinc' => ['nullable', 'integer'],
			'selenium' => ['nullable', 'integer'],
			'copper' => ['nullable', 'integer'],
			'manganese' => ['nullable', 'integer'],
			'chromium' => ['nullable', 'integer'],
			'molybdenum' => ['nullable', 'integer'],
			'chloride' => ['nullable', 'integer'],
			'times.*.order_num' => ['required_with:times.*.minutes,times.*.title', 'integer'],
			'times.*.minutes' => ['required_with:times.*.order_num,times.*.title', 'integer'],
			'times.*.title' => ['required_with:times.*.order_num,times.*.minutes', 'max:255'],
			'times.*.is_active' => ['in:0,1'],
			'new_times.*.order_num' => ['required_with:new_times.*.minutes,new_times.*.title', 'integer'],
			'new_times.*.minutes' => ['required_with:new_times.*.order_num,new_times.*.title', 'integer'],
			'new_times.*.title' => ['required_with:new_times.*.order_num,new_times.*.minutes', 'max:255'],
			'new_times.*.is_active' => ['in:0,1'],
		];
	}

	public function sources() : string
	{
		if (!$this->sources) {
			return '';
		}
		$sources = $this->sources;
		$sources = $this->hideNotes($sources);
		$sources = (new Parsedown())->setBreaksEnabled(true)->text($sources);
		$sources = $this->addLinkTarget($sources);
		return $sources;
	}

	public function summary() : string
	{
		if (!$this->summary) {
			return '';
		}
		$summary = $this->summary;
		$summary = $this->hideNotes($summary);
		$summary = (new Parsedown())->setBreaksEnabled(true)->text($summary);
		$summary = $this->highlightAmounts($summary);
		$summary = $this->addMeasurements($summary);
		return $summary;
	}

	public function times() : HasMany
	{
		return $this->hasMany(Time::class)->orderBy('order_num');
	}

	public function totalTime() : string
	{
		$minutes = $this->times->pluck('minutes')->sum();
		return Time::formatTime($minutes);
	}

	public function type() : string
	{
		return 'Recipe';
	}

	public function updateTimes(Request $request) : void
	{
		if ($request->has('times')) {
			// Delete removed times.
			$times = $this->times->keyBy('id');
			$allIds = $times->keys();
			$keepIds = array_keys($request->input('times'));
			$removeIds = $allIds->diff($keepIds);
			if ($removeIds) {
				Time::whereIn('id', $removeIds)->delete();
			}

			// Update existing times.
			foreach ($times as $time) {
				if ($request->has('times.' . $time->getKey())) {
					$input = $request->input('times.' . $time->getKey());
					if (empty($input['is_active'])) {
						$input['is_active'] = false;
					}
					$time->update($input);
				}
			}
		}

		if ($request->has('new_times')) {
			// Add new times.
			$this->times()->createMany($request->input('new_times'));
		}
	}

	public function url() : string
	{
		return '/recipes/' . $this->slug;
	}
}
