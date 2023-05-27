@extends('layout')

@php ($articleClass = 'article--recipe')
@php ($ogImage = !empty($row->filename) ? url('/uploads/' . $row->filename) : '')

@section('content')
	@if (Auth::user())
		<div class="sticky-container" id="admin">
			<div class="sticky" data-sticky data-sticky-top="12">
				<a class="button" href="/recipes/{{ $row->id }}/edit" id="edit-button">
					Edit
				</a>
				<button
					aria-label="Stopwatch"
					class="floating-button button--secondary"
					data-timer="0"
					id="stopwatch-button"
					type="button"
				>
					⏱
				</button>
				<button
					aria-label="Add Note"
					class="floating-button button--secondary"
					data-toggleable="#note-form"
					data-toggleable-body-class="show-note"
					id="add-note-button"
					type="button"
				>
					+
				</button>
				<form action="/recipes/{{ $row->id }}" data-ajax id="note-form" method="post">
					@csrf
					@method('PUT')
					<textarea aria-label="Notes" id="notes" name="notes" rows="5">{{ $row->notes }}</textarea>
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
		</div>
	@endif

	@if ($row->filename)
		<img alt="" height="405" id="recipe-image" src="/uploads/{{ $row->filename }}" width="720" />
	@endif

	<div id="recipe-header">
		<h1>{{ $row->title }} Recipe</h1>
	</div>

	@if ($row->summary)
		{!! $row->summary() !!}
	@endif

	@if ($row->serving_size)
		<details>
			<summary>Nutrition facts <small>({{ $row->serving_size }})</small></summary>

			<dl>
				@if ($row->calories)
					<div><dt>Calories:</dt><dd>{{ $row->calories }}</dd></div>
				@endif
				@if ($row->fat)
					<div><dt>Fat:</dt><dd>{{ $row->fat }} <span>g</span></dd></div>
				@endif
				@if ($row->saturated_fat)
					<div><dt>Saturated:</dt><dd>{{ $row->saturated_fat }} <span>g</span></dd></div>
				@endif
				@if ($row->trans_fat)
					<div><dt>+ Trans:</dt><dd>{{ $row->trans_fat }} <span>g</span></dd></div>
				@endif
				@if ($row->polyunsaturated_fat)
					<div><dt>Polyunsaturated:</dt><dd>{{ $row->polyunsaturated_fat }} <span>g</span></dd></div>
				@endif
				@if ($row->omega_6)
					<div><dt>Omega-6:</dt><dd>{{ $row->omega_6 }} <span>g</span></dd></div>
				@endif
				@if ($row->omega_3)
					<div><dt>Omega-3:</dt><dd>{{ $row->omega_3 }} <span>g</span></dd></div>
				@endif
				@if ($row->monounsaturated_fat)
					<div><dt>Monounsaturated:</dt><dd>{{ $row->monounsaturated_fat }} <span>g</span></dd></div>
				@endif
				@if ($row->cholesterol)
					<div><dt>Cholesterol:</dt><dd>{{ $row->cholesterol }} <span>mg</span></dd></div>
				@endif
				@if ($row->sodium)
					<div><dt>Sodium:</dt><dd>{{ $row->sodium }} <span>mg</span></dd></div>
				@endif
				@if ($row->potassium)
					<div><dt>Potassium:</dt><dd>{{ $row->potassium }} <span>mg</span></dd></div>
				@endif
				@if ($row->carbohydrate)
					<div><dt>Carbohydrate:</dt><dd>{{ $row->carbohydrate }} <span>g</span></dd></div>
				@endif
				@if ($row->fibre)
					<div><dt>Fibre:</dt><dd>{{ $row->fibre }} <span>g</span></dd></div>
				@endif
				@if ($row->sugars)
					<div><dt>Sugars:</dt><dd>{{ $row->sugars }} <span>g</span></dd></div>
				@endif
				@if ($row->protein)
					<div><dt>Protein:</dt><dd>{{ $row->protein }} <span>g</span></dd></div>
				@endif
				@if ($row->vitamin_a)
					<div><dt>Vitamin A:</dt><dd>{{ $row->vitamin_a }}<span>% DV</span></dd></div>
				@endif
				@if ($row->vitamin_c)
					<div><dt>Vitamin C:</dt><dd>{{ $row->vitamin_c }}<span>% DV</span></dd></div>
				@endif
				@if ($row->calcium)
					<div><dt>Calcium:</dt><dd>{{ $row->calcium }}<span>% DV</span></dd></div>
				@endif
				@if ($row->iron)
					<div><dt>Iron:</dt><dd>{{ $row->iron }}<span>% DV</span></dd></div>
				@endif
				@if ($row->vitamin_d)
					<div><dt>Vitamin D:</dt><dd>{{ $row->vitamin_d }}<span>% DV</span></dd></div>
				@endif
				@if ($row->vitamin_e)
					<div><dt>Vitamin E:</dt><dd>{{ $row->vitamin_e }}<span>% DV</span></dd></div>
				@endif
				@if ($row->vitamin_k)
					<div><dt>Vitamin K:</dt><dd>{{ $row->vitamin_k }}<span>% DV</span></dd></div>
				@endif
				@if ($row->thiamin)
					<div><dt>Thiamin:</dt><dd>{{ $row->thiamin }}<span>% DV</span></dd></div>
				@endif
				@if ($row->riboflavin)
					<div><dt>Riboflavin:</dt><dd>{{ $row->riboflavin }}<span>% DV</span></dd></div>
				@endif
				@if ($row->niacin)
					<div><dt>Niacin:</dt><dd>{{ $row->niacin }}<span>% DV</span></dd></div>
				@endif
				@if ($row->vitamin_b6)
					<div><dt>Vitamin B6:</dt><dd>{{ $row->vitamin_b6 }}<span>% DV</span></dd></div>
				@endif
				@if ($row->folate)
					<div><dt>Folate:</dt><dd>{{ $row->folate }}<span>% DV</span></dd></div>
				@endif
				@if ($row->vitamin_b12)
					<div><dt>Vitamin B12:</dt><dd>{{ $row->vitamin_b12 }}<span>% DV</span></dd></div>
				@endif
				@if ($row->biotin)
					<div><dt>Biotin:</dt><dd>{{ $row->biotin }}<span>% DV</span></dd></div>
				@endif
				@if ($row->pantothenate)
					<div><dt>Pantothenate:</dt><dd>{{ $row->pantothenate }}<span>% DV</span></dd></div>
				@endif
				@if ($row->phosphorus)
					<div><dt>Phosphorus:</dt><dd>{{ $row->phosphorus }}<span>% DV</span></dd></div>
				@endif
				@if ($row->iodine)
					<div><dt>Iodine:</dt><dd>{{ $row->iodine }}<span>% DV</span></dd></div>
				@endif
				@if ($row->magnesium)
					<div><dt>Magnesium:</dt><dd>{{ $row->magnesium }}<span>% DV</span></dd></div>
				@endif
				@if ($row->zinc)
					<div><dt>Zinc:</dt><dd>{{ $row->zinc }}<span>% DV</span></dd></div>
				@endif
				@if ($row->selenium)
					<div><dt>Selenium:</dt><dd>{{ $row->selenium }}<span>% DV</span></dd></div>
				@endif
				@if ($row->copper)
					<div><dt>Copper:</dt><dd>{{ $row->copper }}<span>% DV</span></dd></div>
				@endif
				@if ($row->manganese)
					<div><dt>Manganese:</dt><dd>{{ $row->manganese }}<span>% DV</span></dd></div>
				@endif
				@if ($row->chromium)
					<div><dt>Chromium:</dt><dd>{{ $row->chromium }}<span>% DV</span></dd></div>
				@endif
				@if ($row->molybdenum)
					<div><dt>Molybdenum:</dt><dd>{{ $row->molybdenum }}<span>% DV</span></dd></div>
				@endif
				@if ($row->chloride)
					<div><dt>Chloride:</dt><dd>{{ $row->chloride }}<span>% DV</span></dd></div>
				@endif
			</dl>
		</details>
	@endif

	{!! $row->content() !!}
@stop
