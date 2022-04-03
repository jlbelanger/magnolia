@extends('layout')

@section('content')
	<header id="header">
		<a href="/" id="title">Magnolia</a>
	</header>

	<h1>Reset password</h1>

	@if (session('status'))
		<p class="alert">{{ session('status') }}</p>
	@endif

	@if ($errors->any())
		@foreach ($errors->all() as $error)
			<p class="alert">{{ $error }}</p>
		@endforeach
	@endif

	<form action="/reset-password" method="post">
		@csrf

		<input type="hidden" name="token" value="{{ $request->route('token') }}">

		<p>
			<label class="required" for="email">Email</label>
			<input autofocus id="email" name="email" required type="email" value="{{ old('email', $request->email) }}" />
		</p>

		<p>
			<label class="required" for="password">New Password</label>
			<input id="password" name="password" required type="password" />
		</p>

		<p>
			<label class="required" for="password_confirmation">Confirm New Password</label>
			<input id="password_confirmation" name="password_confirmation" required type="password" />
		</p>

		<p>
			<button type="submit">Reset password</button>
		</p>
	</form>
@stop
