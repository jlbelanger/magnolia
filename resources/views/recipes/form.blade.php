@csrf

<p>
	<label class="required" for="title">Title</label>
	<input id="title" name="title" required type="text" value="{{ old('title', !empty($row) ? $row->title : '') }}" />
	@error('title')
		<span class="error">{{ $message }}</span>
	@enderror
</p>

<p>
	<label class="required" for="slug">Slug</label>
	<input data-slug="title" id="slug" name="slug" required type="text" value="{{ old('slug', !empty($row) ? $row->slug : '') }}" />
	@error('slug')
		<span class="error">{{ $message }}</span>
	@enderror
</p>

<p>
	<label class="required" for="category_id">Category</label>
	<span class="select-container">
		<select id="category_id" name="category_id">
			<option></option>
			@foreach ($categories as $category)
				<option value="{{ $category->id }}"{{ old('category_id', !empty($row) ? $row->category_id : '') == $category->id ? ' selected' : '' }}>
					{{ $category->title }}
				</option>
			@endforeach
		</select>
	</span>
	@error('category_id')
		<span class="form-error">{{ $message }}</span>
	@enderror
</p>

<p>
	<label for="published_at">Published</label> <small>(YYYY-MM-DD HH:MM:SS)</small>
	<input id="published_at" name="published_at" type="text" value="{{ old('published_at', !empty($row) ? $row->published_at : '') }}" />
	@error('published_at')
		<span class="error">{{ $message }}</span>
	@enderror
</p>

<p>
	<label for="filename">Image</label> <small>(1600px &times; 900px)</small>
	<input accept="image/*" id="filename" name="filename" type="file" />
	@error('filename')
		<span class="error">{{ $message }}</span>
	@enderror
	@if (!empty($row) && $row->filename)
		<br />
		<img alt="" id="filename-preview" src="/uploads/thumbnails/{{ $row->filename }}" />
		<label>
			<input
				id="remove_filename"
				name="remove_filename"
				type="checkbox"
				value="1"
			/>
			Remove image?
		</label>
	@endif
</p>

<table class="{{ empty(old('new_times', [])) && (empty($row) || $row->times->isEmpty()) ? 'hide' : '' }}">
	<caption>Time</caption>
	<thead>
		<tr>
			<th id="header-order_num">#</th>
			<th id="header-minutes">Minutes</th>
			<th id="header-title">Label</th>
			<th id="header-active">Active?</th>
			<th id="header-action">Action</th>
		</tr>
	</thead>
	<tbody>
		@if (!empty($row))
			@foreach ($row->times as $time)
				@include('shared.time', ['time' => $time, 'key' => $time->getKey(), 'prefix' => ''])
			@endforeach
		@endif
	</tbody>
	<tfoot>
		@foreach (old('new_times', []) as $i => $time)
			@include('shared.time', ['time' => null, 'key' => $i, 'prefix' => 'new_'])
		@endforeach
	</tfoot>
</table>

<button data-action="add-time" type="button">Add time</button>

<p>
	<label for="summary">Summary</label> <small>(supports Markdown)</small>
	<textarea id="summary" name="summary" rows="5">{{ old('summary', !empty($row) ? $row->summary : '') }}</textarea>
	@error('summary')
		<span class="error">{{ $message }}</span>
	@enderror
</p>

<p>
	<label for="sources">Sources</label> <small>(supports Markdown)</small>
	<textarea id="sources" name="sources" rows="5">{{ old('sources', !empty($row) ? $row->sources : '') }}</textarea>
	@error('sources')
		<span class="error">{{ $message }}</span>
	@enderror
</p>

<p>
	<label class="required" for="content">Content</label> <small>(supports Markdown)</small>
	<textarea class="textarea--large" id="content" name="content" required>{{ old('content', !empty($row) ? $row->content : '') }}</textarea>
	@error('content')
		<span class="error">{{ $message }}</span>
	@enderror
</p>

<p>
	<label for="notes">Notes</label> <small>(private)</small>
	<textarea id="notes" name="notes" rows="5">{{ old('notes', !empty($row) ? $row->notes : '') }}</textarea>
	@error('notes')
		<span class="error">{{ $message }}</span>
	@enderror
</p>

<p>
	<label for="is_private">
		<input
			id="is_private"
			name="is_private"
			type="checkbox"
			value="1"
			{{ old('is_private', !empty($row) ? $row->is_private : true) ? 'checked' : '' }}
		/>
		Private?
	</label>
	@error('is_private')
		<span class="error">{{ $message }}</span>
	@enderror
</p>

<details>
	<summary>Nutrition facts</summary>

	<div id="nutrition-facts">
		<p>
			<label for="serving_size">Serving Size</label>
			<input id="serving_size" name="serving_size" size="18" type="text" value="{{ old('serving_size', !empty($row) ? $row->serving_size : '') }}">
			@error('serving_size')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="calories">Calories</label>
			<input id="calories" name="calories" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('calories', !empty($row) ? $row->calories : '') }}">
			@error('calories')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="fat">Fat</label>
			<input class="prefix" id="fat" name="fat" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('fat', !empty($row) ? $row->fat : '') }}">
			@error('fat')
				<span class="error">{{ $message }}</span>
			@enderror
			<span class="postfix">g</span>
		</p>

		<p>
			<label for="saturated_fat">Saturated</label>
			<input class="prefix" id="saturated_fat" name="saturated_fat" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('saturated_fat', !empty($row) ? $row->saturated_fat : '') }}">
			<span class="postfix">g</span>
			@error('saturated_fat')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="trans_fat">+ Trans</label>
			<input class="prefix" id="trans_fat" name="trans_fat" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('trans_fat', !empty($row) ? $row->trans_fat : '') }}">
			<span class="postfix">g</span>
			@error('trans_fat')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="polyunsaturated_fat">Polyunsaturated</label>
			<input class="prefix" id="polyunsaturated_fat" name="polyunsaturated_fat" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('polyunsaturated_fat', !empty($row) ? $row->polyunsaturated_fat : '') }}">
			<span class="postfix">g</span>
			@error('polyunsaturated_fat')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="omega_6">Omega-6</label>
			<input class="prefix" id="omega_6" name="omega_6" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('omega_6', !empty($row) ? $row->omega_6 : '') }}">
			<span class="postfix">g</span>
			@error('omega_6')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="omega_3">Omega-3</label>
			<input class="prefix" id="omega_3" name="omega_3" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('omega_3', !empty($row) ? $row->omega_3 : '') }}">
			<span class="postfix">g</span>
			@error('omega_3')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="monounsaturated_fat">Monounsaturated</label>
			<input class="prefix" id="monounsaturated_fat" name="monounsaturated_fat" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('monounsaturated_fat', !empty($row) ? $row->monounsaturated_fat : '') }}">
			<span class="postfix">g</span>
			@error('monounsaturated_fat')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="cholesterol">Cholesterol</label>
			<input class="prefix" id="cholesterol" name="cholesterol" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('cholesterol', !empty($row) ? $row->cholesterol : '') }}">
			<span class="postfix">mg</span>
			@error('cholesterol')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="sodium">Sodium</label>
			<input class="prefix" id="sodium" name="sodium" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('sodium', !empty($row) ? $row->sodium : '') }}">
			<span class="postfix">mg</span>
			@error('sodium')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="potassium">Potassium</label>
			<input class="prefix" id="potassium" name="potassium" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('potassium', !empty($row) ? $row->potassium : '') }}">
			<span class="postfix">mg</span>
			@error('potassium')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="carbohydrate">Carbohydrate</label>
			<input class="prefix" id="carbohydrate" name="carbohydrate" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('carbohydrate', !empty($row) ? $row->carbohydrate : '') }}">
			<span class="postfix">g</span>
			@error('carbohydrate')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="fibre">Fibre</label>
			<input class="prefix" id="fibre" name="fibre" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('fibre', !empty($row) ? $row->fibre : '') }}">
			<span class="postfix">g</span>
			@error('fibre')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="sugars">Sugars</label>
			<input class="prefix" id="sugars" name="sugars" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('sugars', !empty($row) ? $row->sugars : '') }}">
			<span class="postfix">g</span>
			@error('sugars')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="protein">Protein</label>
			<input class="prefix" id="protein" name="protein" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('protein', !empty($row) ? $row->protein : '') }}">
			<span class="postfix">g</span>
			@error('protein')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="vitamin_a">Vitamin A</label>
			<input class="prefix" id="vitamin_a" name="vitamin_a" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('vitamin_a', !empty($row) ? $row->vitamin_a : '') }}">
			<span class="postfix">%</span>
			@error('vitamin_a')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="vitamin_c">Vitamin C</label>
			<input class="prefix" id="vitamin_c" name="vitamin_c" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('vitamin_c', !empty($row) ? $row->vitamin_c : '') }}">
			<span class="postfix">%</span>
			@error('vitamin_c')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="calcium">Calcium</label>
			<input class="prefix" id="calcium" name="calcium" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('calcium', !empty($row) ? $row->calcium : '') }}">
			<span class="postfix">%</span>
			@error('calcium')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="iron">Iron</label>
			<input class="prefix" id="iron" name="iron" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('iron', !empty($row) ? $row->iron : '') }}">
			<span class="postfix">%</span>
			@error('iron')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="vitamin_d">Vitamin D</label>
			<input class="prefix" id="vitamin_d" name="vitamin_d" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('vitamin_d', !empty($row) ? $row->vitamin_d : '') }}">
			<span class="postfix">%</span>
			@error('vitamin_d')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="vitamin_e">Vitamin E</label>
			<input class="prefix" id="vitamin_e" name="vitamin_e" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('vitamin_e', !empty($row) ? $row->vitamin_e : '') }}">
			<span class="postfix">%</span>
			@error('vitamin_e')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="vitamin_k">Vitamin K</label>
			<input class="prefix" id="vitamin_k" name="vitamin_k" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('vitamin_k', !empty($row) ? $row->vitamin_k : '') }}">
			<span class="postfix">%</span>
			@error('vitamin_k')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="thiamin">Thiamin</label>
			<input class="prefix" id="thiamin" name="thiamin" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('thiamin', !empty($row) ? $row->thiamin : '') }}">
			<span class="postfix">%</span>
			@error('thiamin')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="riboflavin">Riboflavin</label>
			<input class="prefix" id="riboflavin" name="riboflavin" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('riboflavin', !empty($row) ? $row->riboflavin : '') }}">
			<span class="postfix">%</span>
			@error('riboflavin')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="niacin">Niacin</label>
			<input class="prefix" id="niacin" name="niacin" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('niacin', !empty($row) ? $row->niacin : '') }}">
			<span class="postfix">%</span>
			@error('niacin')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="vitamin_b6">Vitamin B6</label>
			<input class="prefix" id="vitamin_b6" name="vitamin_b6" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('vitamin_b6', !empty($row) ? $row->vitamin_b6 : '') }}">
			<span class="postfix">%</span>
			@error('vitamin_b6')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="folate">Folate</label>
			<input class="prefix" id="folate" name="folate" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('folate', !empty($row) ? $row->folate : '') }}">
			<span class="postfix">%</span>
			@error('folate')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="vitamin_b12">Vitamin B12</label>
			<input class="prefix" id="vitamin_b12" name="vitamin_b12" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('vitamin_b12', !empty($row) ? $row->vitamin_b12 : '') }}">
			<span class="postfix">%</span>
			@error('vitamin_b12')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="biotin">Biotin</label>
			<input class="prefix" id="biotin" name="biotin" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('biotin', !empty($row) ? $row->biotin : '') }}">
			<span class="postfix">%</span>
			@error('biotin')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="pantothenate">Pantothenate</label>
			<input class="prefix" id="pantothenate" name="pantothenate" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('pantothenate', !empty($row) ? $row->pantothenate : '') }}">
			<span class="postfix">%</span>
			@error('pantothenate')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="phosphorus">Phosphorus</label>
			<input class="prefix" id="phosphorus" name="phosphorus" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('phosphorus', !empty($row) ? $row->phosphorus : '') }}">
			<span class="postfix">%</span>
			@error('phosphorus')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="iodine">Iodine</label>
			<input class="prefix" id="iodine" name="iodine" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('iodine', !empty($row) ? $row->iodine : '') }}">
			<span class="postfix">%</span>
			@error('iodine')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="magnesium">Magnesium</label>
			<input class="prefix" id="magnesium" name="magnesium" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('magnesium', !empty($row) ? $row->magnesium : '') }}">
			<span class="postfix">%</span>
			@error('magnesium')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="zinc">Zinc</label>
			<input class="prefix" id="zinc" name="zinc" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('zinc', !empty($row) ? $row->zinc : '') }}">
			<span class="postfix">%</span>
			@error('zinc')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="selenium">Selenium</label>
			<input class="prefix" id="selenium" name="selenium" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('selenium', !empty($row) ? $row->selenium : '') }}">
			<span class="postfix">%</span>
			@error('selenium')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="copper">Copper</label>
			<input class="prefix" id="copper" name="copper" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('copper', !empty($row) ? $row->copper : '') }}">
			<span class="postfix">%</span>
			@error('copper')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="manganese">Manganese</label>
			<input class="prefix" id="manganese" name="manganese" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('manganese', !empty($row) ? $row->manganese : '') }}">
			<span class="postfix">%</span>
			@error('manganese')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="chromium">Chromium</label>
			<input class="prefix" id="chromium" name="chromium" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('chromium', !empty($row) ? $row->chromium : '') }}">
			<span class="postfix">%</span>
			@error('chromium')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="molybdenum">Molybdenum</label>
			<input class="prefix" id="molybdenum" name="molybdenum" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('molybdenum', !empty($row) ? $row->molybdenum : '') }}">
			<span class="postfix">%</span>
			@error('molybdenum')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>

		<p>
			<label for="chloride">Chloride</label>
			<input class="prefix" id="chloride" name="chloride" inputmode="numeric" pattern="[0-9.]*" size="4" type="text" value="{{ old('chloride', !empty($row) ? $row->chloride : '') }}">
			<span class="postfix">%</span>
			@error('chloride')
				<span class="error">{{ $message }}</span>
			@enderror
		</p>
	</div>
</details>

<p>
	<button type="submit">Save</button>
</p>
