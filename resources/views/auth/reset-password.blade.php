@extends('layout')

@php ($articleClass = 'article--auth')

@section('content')
	<h1>Reset password</h1>

	@include('shared.errors', ['errors' => $errors])

	<form action="{{ $request->fullUrl() }}" method="post">
		@csrf

		<p>
			<label class="required" for="email">Email</label>
			<input autocomplete="email" id="email" name="email" required type="email" value="{{ old('email', $request->email) }}" />
			@error('email')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label class="required" for="new_password">New password</label>
			<span class="password-container">
				<input
					autocomplete="new-password"
					autocorrect="off"
					class="password-input prefix"
					id="new_password"
					name="new_password"
					required
					type="password"
				/>
				<button
					aria-controls="new_password"
					aria-label="Show Password"
					class="button--secondary password-button postfix"
					data-toggle-password
					type="button"
				>
					Show
				</button>
			</span>
			@error('new_password')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label class="required" for="new_password_confirmation">Confirm new password</label>
			<span class="password-container">
				<input
					autocomplete="new-password"
					autocorrect="off"
					class="password-input prefix"
					id="new_password_confirmation"
					name="new_password_confirmation"
					required
					type="password"
				/>
				<button
					aria-controls="new_password_confirmation"
					aria-label="Show Password"
					class="button--secondary password-button postfix"
					data-toggle-password
					type="button"
				>
					Show
				</button>
			</span>
			@error('new_password_confirmation')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<button type="submit">Reset password</button>
		</p>
	</form>
@stop
