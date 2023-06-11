@extends('layout')

@section('content')
	<div id="recipe-header">
		<h1>Edit {{ $row->title }} Category</h1>

		<form action="/categories/{{ $row->id }}" id="delete-form" method="post">
			@csrf
			@method('DELETE')
			<button class="button--danger" data-confirmable="Are you sure you want to delete this category?" type="button">Delete</button>
		</form>
	</div>

	@include('shared.errors', ['errors' => $errors])

	<form action="/categories/{{ $row->id }}" enctype="multipart/form-data" id="form" method="post">
		@method('PUT')
		@include('categories.form', ['row' => $row])
	</form>
@stop
