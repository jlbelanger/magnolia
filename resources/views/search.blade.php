@extends('layout')

@section('content')
	<h2>Search results{{ $q ? ': ' . $q : '' }}</h2>
	@if (!$q)
		<p>Please enter a search term.</p>
	@elseif ($recipes->isNotEmpty())
		@include('shared.list', ['recipes' => $recipes])
	@else
		<p>No results found for <b>{{ $q }}</b>.</p>
	@endif
@stop
