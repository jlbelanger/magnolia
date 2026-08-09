<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	protected $fillable = [
		'username',
		'email',
		'password',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	public static function rules(string $id = '') : array
	{
		$unique = $id ? ',' . $id : '';
		$required = $id ? 'filled' : 'required';
		return [
			'username' => [$required, 'max:255', 'unique:users,username' . $unique],
			'email' => [$required, 'max:255', 'unique:users,email' . $unique],
			'password' => [$required, 'current_password'],
		];
	}
}
