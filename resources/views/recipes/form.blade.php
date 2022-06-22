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

<p>
	<label for="summary">Summary</label>
	<textarea id="summary" name="summary" rows="5">{{ old('summary', !empty($row) ? $row->summary : '') }}</textarea>
	@error('summary')
		<span class="error">{{ $message }}</span>
	@enderror
</p>

<p>
	<label class="required" for="content">Content</label>
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

<p>
	<button type="submit">Save</button>
</p>
