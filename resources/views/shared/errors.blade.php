@if (session('message'))
	<p class="alert alert--{{ session('status') }}">{{ session('message') }}</p>
@endif

@if ($errors->any())
	<div class="alert alert--danger">
		@foreach ($errors->all() as $error)
			<div>{{ $error }}</div>
		@endforeach
	</div>
@endif
