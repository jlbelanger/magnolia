@extends('layout')

@section('content')
	<h1>{{ $row->title }} Recipe</h1>

	@if ($row->summary)
		{!! $row->summary() !!}
	@endif

	{!! $row->content() !!}
@stop
