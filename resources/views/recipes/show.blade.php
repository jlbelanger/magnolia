@extends('layout')

@section('content')
	<h1>{{ $row->title }} Recipe</h1>

	@if (Auth::user())
		<a class="button admin" href="/recipes/{{ $row->id }}/edit">Edit</a>
	@endif

	@if ($row->summary)
		{!! $row->summary() !!}
	@endif

	{!! $row->content() !!}
@stop
