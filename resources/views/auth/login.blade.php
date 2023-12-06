@extends('layout')

@php ($articleClass = 'article--auth')

@section('content')
	<h1>Login</h1>

	@include('shared.errors', ['errors' => $errors])

	<form action="/login" method="post">
		@csrf
		<input name="redirect" type="hidden" value="{{ request()->query('redirect') }}" />

		<p>
			<label class="required" for="username">Username</label>
			<input
				autocapitalize="none"
				autocomplete="username"
				id="username"
				name="username"
				required
				type="text"
				value="{{ old('username') }}"
			/>
		</p>

		<p>
			<label class="required" for="password">Password</label>
			<span class="password-container">
				<input
					autocomplete="current-password"
					class="password-input prefix"
					id="password"
					name="password"
					required
					spellcheck="false"
					type="password"
				/>
				<button
					aria-controls="password"
					aria-label="Show Password"
					class="button--secondary password-button postfix"
					data-toggle-password
					type="button"
				>
					Show
				</button>
			</span>
		</p>

		<p>
			<label for="remember">
				<input id="remember" name="remember" type="checkbox">
				Remember me
			</label>
		</p>

		<p>
			<button type="submit">Login</button>
			<a class="link" href="/forgot-password">Forgot password?</a>
		</p>
	</form>
@stop
