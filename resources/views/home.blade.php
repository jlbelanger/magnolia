@extends('layout')

@php ($articleClass = 'article--home')

@section('content')
	@if ($recipes->isNotEmpty())
		<ul id="img-list">
			@foreach ($recipes as $recipe)
				@if ($recipe->filename)
					<li class="img-list__item">
						<a class="img-list__link" href="{{ $recipe->url() }}">
							<img
								alt=""
								class="img-list__img"
								height="180"
								loading="lazy"
								src="/uploads/thumbnails/{{ $recipe->filename }}"
								width="320"
							/>
							{{ $recipe->title . ($recipe->is_private ? ' *' : '') }}
						</a>
					</li>
				@endif
			@endforeach
		</ul>
	@endif
@stop
