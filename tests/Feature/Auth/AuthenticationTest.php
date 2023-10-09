<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
	use RefreshDatabase;

	public function testLoginScreenCanBeRendered()
	{
		$response = $this->get('/login');

		$response->assertStatus(200);
	}

	public function testUsersCanAuthenticateUsingTheLoginScreen()
	{
		$user = User::factory()->create();

		$response = $this->post('/login', [
			'username' => $user->username,
			'password' => 'password',
		]);

		$this->assertAuthenticated();
		$response->assertRedirect(RouteServiceProvider::HOME);
		$response->assertSessionHasNoErrors();
		$response->assertSessionMissing('message');
		$response->assertSessionMissing('status');
	}

	public function testUsersCannotAuthenticateWithInvalidPassword()
	{
		$user = User::factory()->create();

		$response = $this->post('/login', [
			'username' => $user->username,
			'password' => 'wrong-password',
		]);

		$this->assertGuest();
		$response->assertRedirect();
		$response->assertSessionHasErrors(['username' => 'Username or password is incorrect.']);
		$response->assertSessionMissing('message');
		$response->assertSessionMissing('status');
	}

	public function testUsersCannotAuthenticateWithInvalidUsername()
	{
		$response = $this->post('/login', [
			'username' => 'does-not-exist',
			'password' => 'password',
		]);

		$this->assertGuest();
		$response->assertRedirect();
		$response->assertSessionHasErrors(['username' => 'Username or password is incorrect.']);
		$response->assertSessionMissing('message');
		$response->assertSessionMissing('status');
	}
}
