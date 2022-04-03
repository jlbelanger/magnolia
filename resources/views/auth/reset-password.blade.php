@extends('layout')

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
			<input id="email" name="email" required type="email" value="{{ old('email', $request->email) }}" />
		</p>

		<p>
			<label class="required" for="password">New password</label>
			<input autofocus id="password" name="password" required type="password" />
		</p>

		<p>
			<label class="required" for="password_confirmation">Confirm new password</label>
			<input id="password_confirmation" name="password_confirmation" required type="password" />
		</p>

		<p>
			<button type="submit">Reset password</button>
		</p>
	</form>
@stop
