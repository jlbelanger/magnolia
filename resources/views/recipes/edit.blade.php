@extends('layout')

@section('content')
	<div id="recipe-header">
		<h1>Edit {{ $row->title }} Recipe</h1>

		<a class="button admin" href="{{ $row->url() }}">View</a>

		<form action="/recipes/{{ $row->id }}" class="admin" id="delete-form" method="post">
			@csrf
			@method('DELETE')
			<button class="button--danger" data-confirmable="Are you sure you want to delete this recipe?" type="button">Delete</button>
			<button type="submit" style="display:none"></button>
		</form>
	</div>

	@include('shared.errors', ['errors' => $errors])

	<form action="/recipes/{{ $row->id }}" method="post">
		@method('PUT')
		@include('recipes.form', ['row' => $row])
	</form>
@stop
