<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'title',
		'slug',
	];

	public function editUrl() : string
	{
		return '/categories/' . $this->id . '/edit';
	}

	public function recipes() : HasMany
	{
		return $this->hasMany(Recipe::class)->orderBy('slug');
	}

	public static function rules(string $id = '') : array
	{
		$unique = $id ? ',' . $id : '';
		$required = $id ? 'filled' : 'required';
		return [
			'title' => [$required, 'max:255', 'unique:categories,title' . $unique],
			'slug' => [$required, 'max:255', 'alpha_dash', 'unique:categories,slug' . $unique],
		];
	}

	public function type() : string
	{
		return 'Category';
	}

	public function url() : string
	{
		return '/categories/' . $this->slug;
	}
}
