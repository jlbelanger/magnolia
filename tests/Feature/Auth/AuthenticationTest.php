<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
	use RefreshDatabase;

	public function testLoginScreenCanBeRendered() : void
	{
		$response = $this->get('/login');

		$response->assertStatus(200);
	}

	public function testUsersCanAuthenticateUsingTheLoginScreen() : void
	{
		$user = User::factory()->create();

		$response = $this->post('/login', [
			'username' => $user->username,
			'password' => 'password',
		]);

		$this->assertAuthenticated();
		$response->assertRedirect('/');
		$response->assertSessionHasNoErrors();
		$response->assertSessionMissing('message');
		$response->assertSessionMissing('status');
	}

	public function testUsersCannotAuthenticateWithInvalidPassword() : void
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

	public function testUsersCannotAuthenticateWithInvalidUsername() : void
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
