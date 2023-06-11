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
	<button type="submit">Save</button>
</p>
