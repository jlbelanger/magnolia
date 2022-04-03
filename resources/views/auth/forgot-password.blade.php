@extends('layout')

@section('content')
	<header id="header">
		<a href="/" id="title">Magnolia</a>
	</header>

	<h1>Forgot your password?</h1>

	@if (session('status'))
		<p class="alert">{{ session('status') }}</p>
	@endif

	@if ($errors->any())
		@foreach ($errors->all() as $error)
			<p class="alert">{{ $error }}</p>
		@endforeach
	@endif

	<form action="/forgot-password" method="post">
		@csrf

		<p>
			<label class="required" for="email">Email</label>
			<input autofocus id="email" name="email" required type="email" value="{{ old('email') }}" />
		</p>

		<p>
			<button type="submit">Send reset link</button>
			<a class="link" href="/login">Back to login</a>
		</p>
	</form>
@stop
