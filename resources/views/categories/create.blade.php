@extends('layout')

@section('content')
	<h1>Add Category</h1>

	@include('shared.errors', ['errors' => $errors])

	<form action="/categories" enctype="multipart/form-data" id="form" method="post">
		@include('categories.form')
	</form>
@stop
