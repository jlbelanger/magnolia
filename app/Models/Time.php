<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
	protected $fillable = [
		'title',
		'minutes',
		'is_active',
		'order_num',
	];

	protected $casts = [
		'recipe_id' => 'integer',
		'minutes' => 'integer',
		'is_active' => 'boolean',
		'order_num' => 'integer',
	];

	public static function formatTime(int $minutes) : string {
		if ($minutes < 60) {
			return $minutes . ' minute' . ($minutes !== 1 ? 's' : '');
		}
		$hours = round($minutes / 60, 2);
		return $hours . ' hour' . ($hours !== 1.0 ? 's' : '');
	}

	public function formattedTime() : string {
		return self::formatTime($this->minutes);
	}
}
