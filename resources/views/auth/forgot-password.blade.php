@extends('layout')

@php ($articleClass = 'article--auth')

@section('content')
	<header id="header">
		<a href="/" id="site-title">Magnolia</a>
	</header>

	<h1>Forgot your password?</h1>

	@include('shared.errors', ['errors' => $errors])

	<form action="/forgot-password" method="post">
		@csrf

		<p>
			<label class="required" for="email">Email</label>
			<input autocomplete="email" autofocus id="email" name="email" required type="email" value="{{ old('email') }}" />
		</p>

		<p>
			<button type="submit">Send link</button>
			<a class="link" href="/login">Back to login</a>
		</p>
	</form>
@stop
