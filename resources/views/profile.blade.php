@extends('layout')

@section('content')
	<h1>Profile</h1>

	@include('shared.errors', ['errors' => $errors])

	<form action="/profile" data-form method="post">
		@method('PUT')
		@csrf

		<p>
			<label class="required" for="username">Username</label>
			<input
				autocapitalize="none"
				autocomplete="username"
				id="username"
				maxlength="255"
				name="username"
				required
				type="text"
				value="{{ old('username', !empty($row) ? $row->username : '') }}"
			/>
			@error('username')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label class="required" for="email">Email</label>
			<input
				autocapitalize="none"
				autocomplete="email"
				id="email"
				maxlength="255"
				name="email"
				required
				type="email"
				value="{{ old('email', !empty($row) ? $row->email : '') }}"
			/>
			@error('email')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label class="required" for="password">Current Password</label>
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
			@error('password')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<button type="submit">Save</button>
		</p>
	</form>
@stop
