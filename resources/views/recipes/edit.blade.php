@extends('layout')

@section('content')
	<div id="recipe-header">
		<h1>Edit {{ $row->title }} Recipe</h1>

		<form action="/recipes/{{ $row->id }}" id="delete-form" method="post">
			@csrf
			@method('DELETE')
			<button class="button--danger" data-confirmable="Are you sure you want to delete this recipe?" type="button">Delete</button>
		</form>
	</div>

	@include('shared.errors', ['errors' => $errors])

	<form action="/recipes/{{ $row->id }}" data-form enctype="multipart/form-data" id="form" method="post">
		@method('PUT')
		@include('recipes.form', ['row' => $row])
	</form>
@stop
