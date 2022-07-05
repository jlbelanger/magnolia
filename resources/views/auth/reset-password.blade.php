@extends('layout')

@php ($articleClass = 'article--auth')

@section('content')
	<header id="header">
		<a href="/" id="site-title">Magnolia</a>
	</header>

	<h1>Reset password</h1>

	@include('shared.errors', ['errors' => $errors])

	<form action="/reset-password" method="post">
		@csrf

		<input type="hidden" name="token" value="{{ $request->route('token') }}">

		<p>
			<label class="required" for="email">Email</label>
			<input autocomplete="email" id="email" name="email" required type="email" value="{{ old('email', $request->email) }}" />
			@error('email')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label class="required" for="password">New password</label>
			<span class="password-container">
				<input autocomplete="new-password" autocorrect="off" autofocus class="password-input" id="password" name="password" required type="password" />
				<button class="password-button" data-toggle-password type="button">Show</button>
			</span>
			@error('password')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label class="required" for="password_confirmation">Confirm new password</label>
			<span class="password-container">
				<input autocomplete="new-password" autocorrect="off" class="password-input" id="password_confirmation" name="password_confirmation" required type="password" />
				<button class="password-button" data-toggle-password type="button">Show</button>
			</span>
			@error('password_confirmation')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<button type="submit">Reset password</button>
		</p>
	</form>
@stop
