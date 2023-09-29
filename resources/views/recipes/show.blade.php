@extends('layout')

@php ($ogImage = !empty($row->filename) ? url('/uploads/' . $row->filename) : '')

@section('content')
	@if ($row->filename)
		<div id="recipe-image-container">
			<img alt="" height="562" id="recipe-image" src="/uploads/{{ $row->filename }}" width="1024" />
		</div>
	@endif

	<div id="recipe">
		<header id="recipe-header">
			<h1>
				{{ $row->title }} Recipe
				@if ($row->is_private)
					<span aria-label="Private">*</span>
				@endif
			</h1>
		</header>

		<aside id="recipe-side">
			{!! $row->summary() !!}

			<div class="sticky-container">
				<div class="sticky-inner" data-sticky data-sticky-top-margin="16">
					<button
						aria-label="Stopwatch"
						class="floating-button"
						data-timer="0"
						id="stopwatch-button"
						title="Stopwatch"
						type="button"
					>
						⏱️
					</button>
					@if (Auth::user())
						<button
							aria-controls="note-form"
							aria-expanded="false"
							aria-label="Add Note"
							class="floating-button"
							data-toggleable="#note-form"
							data-toggleable-body-class="show-note-form"
							data-toggleable-hide="Close Notes"
							data-toggleable-show="Add Note"
							id="add-note-button"
							title="Add Note"
							type="button"
						>
							🗒️
						</button>
						<form action="/recipes/{{ $row->id }}" data-ajax id="note-form" method="post">
							@csrf
							@method('PUT')
							<div class="contain">
								<textarea aria-label="Notes" class="prefix" id="notes" name="notes" placeholder="Enter notes" rows="5">{{ $row->notes }}</textarea>
								@if (!empty($row->is_private))
									<input
										checked
										id="is_private"
										name="is_private"
										type="hidden"
										value="1"
									/>
								@endif
								<button class="postfix" type="submit">Save</button>
							</div>
						</form>
					@endif
				</div>
			</div>
		</aside>

		<section id="recipe-main">
			{!! $row->content() !!}

			@if ($row->sources || $row->serving_size)
				<footer id="recipe-footer">
					<hr>

					@if ($row->sources)
						{!! $row->sources() !!}
					@endif

					@if ($row->serving_size)
						<h2>Nutrition facts</h2>

						<p>Per {{ $row->serving_size }}</p>

						<dl>
							@if ($row->calories)
								<div class="line"><dt>Calories</dt><dd>{{ $row->calories }}</dd></div>
							@endif
							<div class="double">
								@if ($row->fat)
									<div class="line"><dt>Fat</dt><dd>{{ $row->fat }} <span aria-label="grams">g</span></dd></div>
								@endif
								@if ($row->saturated_fat)
									<div class="line indent"><dt>Saturated</dt><dd>{{ $row->saturated_fat }} <span aria-label="grams">g</span></dd></div>
								@endif
								@if ($row->trans_fat)
									<div class="line indent"><dt>+ Trans</dt><dd>{{ $row->trans_fat }} <span aria-label="grams">g</span></dd></div>
								@endif
								@if ($row->polyunsaturated_fat)
									<div class="line indent"><dt>Polyunsaturated</dt><dd>{{ $row->polyunsaturated_fat }} <span aria-label="grams">g</span></dd></div>
								@endif
								@if ($row->omega_6)
									<div class="line indent"><dt>Omega-6</dt><dd>{{ $row->omega_6 }} <span aria-label="grams">g</span></dd></div>
								@endif
								@if ($row->omega_3)
									<div class="line indent"><dt>Omega-3</dt><dd>{{ $row->omega_3 }} <span aria-label="grams">g</span></dd></div>
								@endif
								@if ($row->monounsaturated_fat)
									<div class="line indent"><dt>Monounsaturated</dt><dd>{{ $row->monounsaturated_fat }} <span aria-label="grams">g</span></dd></div>
								@endif
							</div>
							@if ($row->cholesterol)
								<div class="line"><dt>Cholesterol</dt><dd>{{ $row->cholesterol }} <span aria-label="milligrams">mg</span></dd></div>
							@endif
							@if ($row->sodium)
								<div class="line"><dt>Sodium</dt><dd>{{ $row->sodium }} <span aria-label="milligrams">mg</span></dd></div>
							@endif
							@if ($row->potassium)
								<div class="line"><dt>Potassium</dt><dd>{{ $row->potassium }} <span aria-label="milligrams">mg</span></dd></div>
							@endif
							<div class="double">
								@if ($row->carbohydrate)
									<div class="line"><dt>Carbohydrate</dt><dd>{{ $row->carbohydrate }} <span aria-label="grams">g</span></dd></div>
								@endif
								@if ($row->fibre)
									<div class="line indent"><dt>Fibre</dt><dd>{{ $row->fibre }} <span aria-label="grams">g</span></dd></div>
								@endif
								@if ($row->sugars)
									<div class="line indent"><dt>Sugars</dt><dd>{{ $row->sugars }} <span aria-label="grams">g</span></dd></div>
								@endif
							</div>
							@if ($row->protein)
								<div class="line"><dt>Protein</dt><dd>{{ $row->protein }} <span aria-label="grams">g</span></dd></div>
							@endif
							<div class="double">
								@if ($row->vitamin_a)
									<div class="line"><dt>Vitamin A</dt><dd>{{ $row->vitamin_a }}<span>%</span></dd></div>
								@endif
								@if ($row->vitamin_c)
									<div class="line"><dt>Vitamin C</dt><dd>{{ $row->vitamin_c }}<span>%</span></dd></div>
								@endif
								@if ($row->calcium)
									<div class="line"><dt>Calcium</dt><dd>{{ $row->calcium }}<span>%</span></dd></div>
								@endif
								@if ($row->iron)
									<div class="line"><dt>Iron</dt><dd>{{ $row->iron }}<span>%</span></dd></div>
								@endif
								@if ($row->vitamin_d)
									<div class="line"><dt>Vitamin D</dt><dd>{{ $row->vitamin_d }}<span>%</span></dd></div>
								@endif
								@if ($row->vitamin_e)
									<div class="line"><dt>Vitamin E</dt><dd>{{ $row->vitamin_e }}<span>%</span></dd></div>
								@endif
								@if ($row->vitamin_k)
									<div class="line"><dt>Vitamin K</dt><dd>{{ $row->vitamin_k }}<span>%</span></dd></div>
								@endif
								@if ($row->thiamin)
									<div class="line"><dt>Thiamin</dt><dd>{{ $row->thiamin }}<span>%</span></dd></div>
								@endif
								@if ($row->riboflavin)
									<div class="line"><dt>Riboflavin</dt><dd>{{ $row->riboflavin }}<span>%</span></dd></div>
								@endif
								@if ($row->niacin)
									<div class="line"><dt>Niacin</dt><dd>{{ $row->niacin }}<span>%</span></dd></div>
								@endif
								@if ($row->vitamin_b6)
									<div class="line"><dt>Vitamin B6</dt><dd>{{ $row->vitamin_b6 }}<span>%</span></dd></div>
								@endif
								@if ($row->folate)
									<div class="line"><dt>Folate</dt><dd>{{ $row->folate }}<span>%</span></dd></div>
								@endif
								@if ($row->vitamin_b12)
									<div class="line"><dt>Vitamin B12</dt><dd>{{ $row->vitamin_b12 }}<span>%</span></dd></div>
								@endif
								@if ($row->biotin)
									<div class="line"><dt>Biotin</dt><dd>{{ $row->biotin }}<span>%</span></dd></div>
								@endif
								@if ($row->pantothenate)
									<div class="line"><dt>Pantothenate</dt><dd>{{ $row->pantothenate }}<span>%</span></dd></div>
								@endif
								@if ($row->phosphorus)
									<div class="line"><dt>Phosphorus</dt><dd>{{ $row->phosphorus }}<span>%</span></dd></div>
								@endif
								@if ($row->iodine)
									<div class="line"><dt>Iodine</dt><dd>{{ $row->iodine }}<span>%</span></dd></div>
								@endif
								@if ($row->magnesium)
									<div class="line"><dt>Magnesium</dt><dd>{{ $row->magnesium }}<span>%</span></dd></div>
								@endif
								@if ($row->zinc)
									<div class="line"><dt>Zinc</dt><dd>{{ $row->zinc }}<span>%</span></dd></div>
								@endif
								@if ($row->selenium)
									<div class="line"><dt>Selenium</dt><dd>{{ $row->selenium }}<span>%</span></dd></div>
								@endif
								@if ($row->copper)
									<div class="line"><dt>Copper</dt><dd>{{ $row->copper }}<span>%</span></dd></div>
								@endif
								@if ($row->manganese)
									<div class="line"><dt>Manganese</dt><dd>{{ $row->manganese }}<span>%</span></dd></div>
								@endif
								@if ($row->chromium)
									<div class="line"><dt>Chromium</dt><dd>{{ $row->chromium }}<span>%</span></dd></div>
								@endif
								@if ($row->molybdenum)
									<div class="line"><dt>Molybdenum</dt><dd>{{ $row->molybdenum }}<span>%</span></dd></div>
								@endif
								@if ($row->chloride)
									<div class="line"><dt>Chloride</dt><dd>{{ $row->chloride }}<span>%</span></dd></div>
								@endif
							</div>
						</dl>
					@endif
				</footer>
			@endif
		</section>
	</div>
@stop
