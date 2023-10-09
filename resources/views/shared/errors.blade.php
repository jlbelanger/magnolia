@if (session('message'))
	<p class="alert alert--{{ session('status') }}">{{ (session('status') === 'danger' ? 'Error: ' : '') . session('message') }}</p>
@endif

@if ($errors->any())
	<div class="alert alert--danger">
		@foreach ($errors->all() as $error)
			<div>Error: {{ $error }}</div>
		@endforeach
	</div>
@endif
