<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAuth extends Command
{
	protected $signature = 'auth:reset-admin';

	protected $description = 'Reset admin credentials';

	public function handle()
	{
		if (!app()->isLocal()) {
			echo "Error: This is not the local environment.\n";
			return;
		}

		echo "Resetting password...\n";
		$user = User::where('username', '!=', 'demo')->orderBy('id')->first();
		$data = [
			'password' => Hash::make('password'),
		];
		if (!$user) {
			$user = new User();
			$data['username'] = 'test';
			$data['email'] = 'test@example.com';
		}
		$user->forceFill($data)->save();
		echo "Success!\n";
	}
}
