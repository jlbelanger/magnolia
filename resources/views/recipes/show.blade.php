@extends('layout')

@section('content')
	<div id="recipe-header">
		<h1>{{ $row->title }} Recipe</h1>

		@if (Auth::user())
			<div class="admin">
				<a class="button" href="/recipes/{{ $row->id }}/edit" id="edit-button">
					Edit
				</a><span class="sticky-container">
					<span class="sticky" data-sticky data-sticky-top="12">
						<button
							aria-label="Stopwatch"
							class="floating-button"
							data-timer="0"
							id="stopwatch-button"
							type="button"
						>
							⏱
						</button><button
							aria-label="Add Note"
							class="floating-button"
							data-toggleable="#note-form"
							data-toggleable-body-class="show-note"
							id="add-note-button"
							type="button"
						>
							+
						</button>
					</span>
				</span><form action="/recipes/{{ $row->id }}" data-ajax id="note-form" method="post">
					@csrf
					@method('PUT')
					<textarea id="notes" name="notes" rows="5">{{ $row->notes }}</textarea>
					<button type="submit">Save</button>
				</form>
			</div>
		@endif
	</div>

	@if ($row->summary)
		{!! $row->summary() !!}
	@endif

	{!! $row->content() !!}
@stop
