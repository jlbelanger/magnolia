<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
	use RefreshDatabase;

	public function testResetPasswordScreenCanBeRendered()
	{
		Notification::fake();
		$user = User::factory()->create();

		$this->post('/forgot-password', ['email' => $user->email]);

		Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
			$url = URL::temporarySignedRoute(
				'password.update',
				Carbon::now()->addMinutes(60),
				['token' => $notification->token],
				false
			);

			$response = $this->get($url);

			$this->assertGuest();
			$response->assertStatus(200);
			$response->assertSessionHasNoErrors();
			$response->assertSessionMissing('message');
			$response->assertSessionMissing('status');

			return true;
		});
	}

	public function testResetPasswordScreenCannotBeRenderedWithExpiredToken()
	{
		Notification::fake();
		$user = User::factory()->create();

		$this->post('/forgot-password', ['email' => $user->email]);

		Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
			$url = URL::temporarySignedRoute(
				'password.update',
				Carbon::now()->subMinutes(60),
				['token' => $notification->token],
				false
			);

			$response = $this->get($url);

			$this->assertGuest();
			$response->assertRedirect('/forgot-password');
			$response->assertSessionHasNoErrors();
			$response->assertSessionHas('message', 'This link has expired.');
			$response->assertSessionHas('status', 'danger');

			return true;
		});
	}

	public function testPasswordCanBeResetWithValidToken()
	{
		Notification::fake();
		$user = User::factory()->create();

		$this->post('/forgot-password', ['email' => $user->email]);

		Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
			$url = URL::temporarySignedRoute(
				'password.update',
				Carbon::now()->addMinutes(60),
				['token' => $notification->token],
				false
			);

			$response = $this->post($url, [
				'email' => $user->email,
				'new_password' => 'password2',
				'new_password_confirmation' => 'password2',
			]);

			$this->assertGuest();
			$response->assertRedirect('/login');
			$response->assertSessionHasNoErrors();
			$response->assertSessionHas('message', 'Your password has been reset.');
			$response->assertSessionHas('status', 'success');

			return true;
		});
	}

	public function testPasswordCannotBeResetTwiceWithSameToken()
	{
		Notification::fake();
		$user = User::factory()->create();

		$this->post('/forgot-password', ['email' => $user->email]);

		Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
			$url = URL::temporarySignedRoute(
				'password.update',
				Carbon::now()->addMinutes(60),
				['token' => $notification->token],
				false
			);

			$response = $this->post($url, [
				'email' => $user->email,
				'new_password' => 'password2',
				'new_password_confirmation' => 'password2',
			]);

			$this->assertGuest();
			$response->assertRedirect('/login');
			$response->assertSessionHasNoErrors();
			$response->assertSessionHas('message', 'Your password has been reset.');
			$response->assertSessionHas('status', 'success');

			$response = $this->post($url, [
				'email' => $user->email,
				'new_password' => 'password3',
				'new_password_confirmation' => 'password3',
			]);

			$this->assertGuest();
			$response->assertRedirect();
			$response->assertSessionHasNoErrors();
			$response->assertSessionHas('message', 'This password reset link is invalid or the email is incorrect.');
			$response->assertSessionHas('status', 'danger');

			return true;
		});
	}

	public function testPasswordCannotBeResetWithWrongEmail()
	{
		Notification::fake();
		$user = User::factory()->create();

		$this->post('/forgot-password', ['email' => $user->email]);

		Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
			$url = URL::temporarySignedRoute(
				'password.update',
				Carbon::now()->addMinutes(60),
				['token' => $notification->token],
				false
			);

			$response = $this->post($url, [
				'email' => 'wrong-email@example.com',
				'new_password' => 'password2',
				'new_password_confirmation' => 'password2',
			]);

			$this->assertGuest();
			$response->assertRedirect();
			$response->assertSessionHasNoErrors();
			$response->assertSessionHas('message', 'This password reset link is invalid or the email is incorrect.');
			$response->assertSessionHas('status', 'danger');

			return true;
		});
	}

	public function testPasswordCannotBeResetWithExpiredToken()
	{
		Notification::fake();
		$user = User::factory()->create();

		$this->post('/forgot-password', ['email' => $user->email]);

		Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
			$url = URL::temporarySignedRoute(
				'password.update',
				Carbon::now()->subMinutes(60),
				['token' => $notification->token],
				false
			);

			$response = $this->post($url, [
				'email' => $user->email,
				'new_password' => 'password2',
				'new_password_confirmation' => 'password2',
			]);

			$this->assertGuest();
			$response->assertRedirect();
			$response->assertSessionHasNoErrors();
			$response->assertSessionHas('message', 'This link has expired.');
			$response->assertSessionHas('status', 'danger');

			return true;
		});
	}

	public function testPasswordCannotBeResetWithInvalidToken()
	{
		Notification::fake();
		$user = User::factory()->create();

		$this->post('/forgot-password', ['email' => $user->email]);

		Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
			$url = URL::temporarySignedRoute(
				'password.update',
				Carbon::now()->addMinutes(60),
				['token' => $notification->token],
				false
			);
			$url = str_replace('?', 'a?', $url);

			$response = $this->post($url, [
				'email' => $user->email,
				'new_password' => 'password2',
				'new_password_confirmation' => 'password2',
			]);

			$this->assertGuest();
			$response->assertRedirect();
			$response->assertSessionHasNoErrors();
			$response->assertSessionHas('message', 'This password reset link is invalid or the email is incorrect.');
			$response->assertSessionHas('status', 'danger');

			return true;
		});
	}
}
