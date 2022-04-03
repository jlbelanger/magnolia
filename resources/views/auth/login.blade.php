@extends('layout')

@section('content')
	<header id="header">
		<a href="/" id="site-title">Magnolia</a>
	</header>

	<h1>Login</h1>

	@include('shared.errors', ['errors' => $errors])

	<form action="/login" method="post">
		@csrf

		<p>
			<label class="required" for="username">Username</label>
			<input autofocus id="username" name="username" required type="text" value="{{ old('username') }}" />
		</p>

		<p>
			<label class="required" for="password">Password</label>
			<input id="password" name="password" required type="password" />
		</p>

		<p>
			<label for="remember">
				<input id="remember" name="remember" type="checkbox">
				Remember me
			</label>
		</p>

		<p>
			<button type="submit">Login</button>
			<a class="link" href="/forgot-password">Forgot your password?</a>
		</p>
	</form>
@stop
