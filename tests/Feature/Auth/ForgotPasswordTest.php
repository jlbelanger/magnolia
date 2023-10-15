<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
	use RefreshDatabase;

	public function testForgotPasswordScreenCanBeRendered() : void
	{
		$response = $this->get('/forgot-password');

		$response->assertStatus(200);
	}

	public function testPasswordResetLinkCanBeRequestedForValidUser() : void
	{
		Notification::fake();
		$user = User::factory()->create();

		$response = $this->post('/forgot-password', ['email' => $user->email]);

		$this->assertGuest();
		$response->assertRedirect('/forgot-password');
		$response->assertSessionHasNoErrors();
		$response->assertSessionHas('message', 'If there is an account with this email address, you will receive a password reset email shortly.');
		$response->assertSessionHas('status', 'success');
		Notification::assertSentTo($user, ResetPassword::class);
	}

	public function testPasswordResetLinkCanBeRequestedForInvalidUser() : void
	{
		Notification::fake();

		$response = $this->post('/forgot-password', ['email' => 'does-not-exist@example.com']);

		$this->assertGuest();
		$response->assertRedirect('/forgot-password');
		$response->assertSessionHasNoErrors();
		$response->assertSessionHas('message', 'If there is an account with this email address, you will receive a password reset email shortly.');
		$response->assertSessionHas('status', 'success');
		Notification::assertNothingSent();
	}
}
