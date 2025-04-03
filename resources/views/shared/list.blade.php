<ul id="img-list">
	@foreach ($recipes as $i => $recipe)
		<li class="img-list__item">
			<a class="img-list__link" href="{{ $recipe->url() }}">
				<img
					alt=""
					class="img-list__img"
					height="180"
					@if ($i >= 3)
						loading="lazy"
					@endif
					@if ($recipe->filename)
						src="/uploads/thumbnails/{{ $recipe->filename }}"
					@else
						src="/assets/img/placeholder.svg"
					@endif
					width="320"
				/>
				{{ $recipe->title  }}
				@if ($recipe->is_private)
					<span aria-label="Private">*</span>
				@endif
			</a>
			@if ($recipe->times->isNotEmpty())
				<div class="img-list__note">
					{{ $recipe->totalTime() }} &middot; ({{ $recipe->activeTime() }} active)
				</div>
			@endif
		</li>
	@endforeach
</ul>
