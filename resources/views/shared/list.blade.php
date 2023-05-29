<ul id="img-list">
	@foreach ($recipes as $i => $recipe)
		<li class="img-list__item">
			<a class="img-list__link" href="{{ $recipe->url() }}">
				@if ($recipe->filename)
					<img
						alt=""
						class="img-list__img"
						height="180"
						@if ($i >= 3)
							loading="lazy"
						@endif
						src="/uploads/thumbnails/{{ $recipe->filename }}"
						width="320"
					/>
				@else
					<div class="img-list__img img-list__img--placeholder"></div>
				@endif
				{{ $recipe->title  }}
				@if ($recipe->is_private)
					<span aria-label="Private">*</span>
				@endif
			</a>
		</li>
	@endforeach
</ul>
