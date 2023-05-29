@extends('layout')

@section('content')
	<h1>{{ Str::singular($row->title) }} Recipes</h1>
	@if ($recipes->isNotEmpty())
		@include('shared.list', ['recipes' => $recipes])
	@else
		<p>No recipes found.</p>
	@endif
@stop
