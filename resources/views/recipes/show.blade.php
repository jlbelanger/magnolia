@extends('layout')

@section('content')
	<h1>{{ $row->title }}</h1>

	<p>{{ $row->summary }}</p>

	{!! $row->content() !!}
@stop
