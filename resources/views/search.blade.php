@extends('layout')

@section('content')
	<h1>Search results{{ $q ? ': ' . $q : '' }}</h1>
	@if (!$q)
		<p>Please enter a search term.</p>
		<form action="/search" id="search" method="get">
			<input aria-label="Search recipes" autocomplete="off" class="prefix" id="search-input" name="q" type="text">
			<button class="postfix" id="search-submit" type="submit">Search</button>
		</form>
	@elseif ($recipes->isNotEmpty())
		@include('shared.list', ['recipes' => $recipes])
	@else
		<p>No results found for <b>{{ $q }}</b>.</p>
	@endif
@stop
