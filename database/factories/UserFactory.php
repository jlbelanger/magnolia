<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
	protected static ?string $password;

	public function definition() : array
	{
		return [
			'username' => 'foo',
			'email' => 'foo@example.com',
			'password' => static::$password ??= Hash::make('password'),
			'remember_token' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZabcdefgh',
		];
	}
}
