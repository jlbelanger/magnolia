@extends('layout')

@php ($articleClass = 'article--recipe')

@section('content')
	@if ($row->filename)
		<img alt="" height="405" id="recipe-image" src="/uploads/{{ $row->filename }}" width="720" />
	@endif

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
					@if (!empty($row->is_private))
						<input
							checked
							id="is_private"
							name="is_private"
							type="hidden"
							value="1"
						/>
					@endif
					<button type="submit">Save</button>
				</form>
			</div>
		@endif
	</div>

	@if ($row->summary)
		{!! $row->summary() !!}
	@endif

	@if ($row->calories)
		<details>
			<summary>Nutrition facts</summary>

			<dl>
				@if ($row->calories)
					<dt class="nutrition__label">Calories:</dt><dd>{{ $row->calories }}</dd>
				@endif
				@if ($row->fat)
					<dt class="nutrition__label">Fat:</dt><dd>{{ $row->fat }} <span>g</span></dd>
				@endif
				@if ($row->saturated_fat)
					<dt class="nutrition__label">Saturated:</dt><dd>{{ $row->saturated_fat }} <span>g</span></dd>
				@endif
				@if ($row->trans_fat)
					<dt class="nutrition__label">+ Trans:</dt><dd>{{ $row->trans_fat }} <span>g</span></dd>
				@endif
				@if ($row->polyunsaturated_fat)
					<dt class="nutrition__label">Polyunsaturated:</dt><dd>{{ $row->polyunsaturated_fat }} <span>g</span></dd>
				@endif
				@if ($row->omega_6)
					<dt class="nutrition__label">Omega-6:</dt><dd>{{ $row->omega_6 }} <span>g</span></dd>
				@endif
				@if ($row->omega_3)
					<dt class="nutrition__label">Omega-3:</dt><dd>{{ $row->omega_3 }} <span>g</span></dd>
				@endif
				@if ($row->monounsaturated_fat)
					<dt class="nutrition__label">Monounsaturated:</dt><dd>{{ $row->monounsaturated_fat }} <span>g</span></dd>
				@endif
				@if ($row->cholesterol)
					<dt class="nutrition__label">Cholesterol:</dt><dd>{{ $row->cholesterol }} <span>mg</span></dd>
				@endif
				@if ($row->sodium)
					<dt class="nutrition__label">Sodium:</dt><dd>{{ $row->sodium }} <span>mg</span></dd>
				@endif
				@if ($row->potassium)
					<dt class="nutrition__label">Potassium:</dt><dd>{{ $row->potassium }} <span>mg</span></dd>
				@endif
				@if ($row->carbohydrate)
					<dt class="nutrition__label">Carbohydrate:</dt><dd>{{ $row->carbohydrate }} <span>g</span></dd>
				@endif
				@if ($row->fibre)
					<dt class="nutrition__label">Fibre:</dt><dd>{{ $row->fibre }} <span>g</span></dd>
				@endif
				@if ($row->sugars)
					<dt class="nutrition__label">Sugars:</dt><dd>{{ $row->sugars }} <span>g</span></dd>
				@endif
				@if ($row->protein)
					<dt class="nutrition__label">Protein:</dt><dd>{{ $row->protein }} <span>g</span></dd>
				@endif
				@if ($row->vitamin_a)
					<dt class="nutrition__label">Vitamin A:</dt><dd>{{ $row->vitamin_a }}<span>% DV</span></dd>
				@endif
				@if ($row->vitamin_c)
					<dt class="nutrition__label">Vitamin C:</dt><dd>{{ $row->vitamin_c }}<span>% DV</span></dd>
				@endif
				@if ($row->calcium)
					<dt class="nutrition__label">Calcium:</dt><dd>{{ $row->calcium }}<span>% DV</span></dd>
				@endif
				@if ($row->iron)
					<dt class="nutrition__label">Iron:</dt><dd>{{ $row->iron }}<span>% DV</span></dd>
				@endif
				@if ($row->vitamin_d)
					<dt class="nutrition__label">Vitamin D:</dt><dd>{{ $row->vitamin_d }}<span>% DV</span></dd>
				@endif
				@if ($row->vitamin_e)
					<dt class="nutrition__label">Vitamin E:</dt><dd>{{ $row->vitamin_e }}<span>% DV</span></dd>
				@endif
				@if ($row->vitamin_k)
					<dt class="nutrition__label">Vitamin K:</dt><dd>{{ $row->vitamin_k }}<span>% DV</span></dd>
				@endif
				@if ($row->thiamin)
					<dt class="nutrition__label">Thiamin:</dt><dd>{{ $row->thiamin }}<span>% DV</span></dd>
				@endif
				@if ($row->riboflavin)
					<dt class="nutrition__label">Riboflavin:</dt><dd>{{ $row->riboflavin }}<span>% DV</span></dd>
				@endif
				@if ($row->niacin)
					<dt class="nutrition__label">Niacin:</dt><dd>{{ $row->niacin }}<span>% DV</span></dd>
				@endif
				@if ($row->vitamin_b6)
					<dt class="nutrition__label">Vitamin B6:</dt><dd>{{ $row->vitamin_b6 }}<span>% DV</span></dd>
				@endif
				@if ($row->folate)
					<dt class="nutrition__label">Folate:</dt><dd>{{ $row->folate }}<span>% DV</span></dd>
				@endif
				@if ($row->vitamin_b12)
					<dt class="nutrition__label">Vitamin B12:</dt><dd>{{ $row->vitamin_b12 }}<span>% DV</span></dd>
				@endif
				@if ($row->biotin)
					<dt class="nutrition__label">Biotin:</dt><dd>{{ $row->biotin }}<span>% DV</span></dd>
				@endif
				@if ($row->pantothenate)
					<dt class="nutrition__label">Pantothenate:</dt><dd>{{ $row->pantothenate }}<span>% DV</span></dd>
				@endif
				@if ($row->phosphorus)
					<dt class="nutrition__label">Phosphorus:</dt><dd>{{ $row->phosphorus }}<span>% DV</span></dd>
				@endif
				@if ($row->iodine)
					<dt class="nutrition__label">Iodine:</dt><dd>{{ $row->iodine }}<span>% DV</span></dd>
				@endif
				@if ($row->magnesium)
					<dt class="nutrition__label">Magnesium:</dt><dd>{{ $row->magnesium }}<span>% DV</span></dd>
				@endif
				@if ($row->zinc)
					<dt class="nutrition__label">Zinc:</dt><dd>{{ $row->zinc }}<span>% DV</span></dd>
				@endif
				@if ($row->selenium)
					<dt class="nutrition__label">Selenium:</dt><dd>{{ $row->selenium }}<span>% DV</span></dd>
				@endif
				@if ($row->copper)
					<dt class="nutrition__label">Copper:</dt><dd>{{ $row->copper }}<span>% DV</span></dd>
				@endif
				@if ($row->manganese)
					<dt class="nutrition__label">Manganese:</dt><dd>{{ $row->manganese }}<span>% DV</span></dd>
				@endif
				@if ($row->chromium)
					<dt class="nutrition__label">Chromium:</dt><dd>{{ $row->chromium }}<span>% DV</span></dd>
				@endif
				@if ($row->molybdenum)
					<dt class="nutrition__label">Molybdenum:</dt><dd>{{ $row->molybdenum }}<span>% DV</span></dd>
				@endif
				@if ($row->chloride)
					<dt class="nutrition__label">Chloride:</dt><dd>{{ $row->chloride }}<span>% DV</span></dd>
				@endif
			</dl>
		</details>
	@endif

	{!! $row->content() !!}
@stop
