@extends('layout')

@section('content')
	<h1 class="{{ Auth::user() ? 'shrink' : '' }}">{{ $row->title }} Recipe</h1>

	@if (Auth::user())
		<a class="button admin" href="/recipes/{{ $row->id }}/edit" id="edit-button">Edit</a>
		<button aria-label="Add Note" class="admin" data-toggleable="#note-form" id="add-note-button" type="button">+</button>
		<form action="/recipes/{{ $row->id }}" data-ajax id="note-form" method="post">
			@csrf
			@method('PUT')
			<textarea id="notes" name="notes" rows="5">{{ $row->notes }}</textarea>
			<button type="submit">Save</button>
		</form>
	@endif

	@if ($row->summary)
		{!! $row->summary() !!}
	@endif

	{!! $row->content() !!}
@stop
