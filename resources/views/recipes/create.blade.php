@extends('layout')

@section('content')
	<h1>Add Recipe</h1>

	@include('shared.errors', ['errors' => $errors])

	<form action="/recipes" method="post">
		@include('recipes.form')
	</form>
@stop
