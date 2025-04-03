<tr>
	<td>
		<input
			aria-labelledby="header-order_num"
			name="{{ $prefix }}times[{{ $key }}][order_num]"
			required
			type="text"
			value="{{ old($prefix . 'times.'. $key .'.order_num', !empty($time) ? $time->order_num : '') }}"
		/>
		@error($prefix . 'times.'. $key .'.order_num')
			<span class="error">{{ $message }}</span>
		@enderror
	</td>
	<td>
		<input
			aria-labelledby="header-minutes"
			name="{{ $prefix }}times[{{ $key }}][minutes]"
			required
			type="text"
			value="{{ old($prefix . 'times.'. $key .'.minutes', !empty($time) ? $time->minutes : '') }}"
		/>
		@error($prefix . 'times.'. $key .'.minutes')
			<span class="error">{{ $message }}</span>
		@enderror
	</td>
	<td>
		<input
			aria-labelledby="header-title"
			name="{{ $prefix }}times[{{ $key }}][title]"
			required
			type="text"
			value="{{ old($prefix . 'times.'. $key .'.title', !empty($time) ? $time->title : '') }}"
		/>
		@error($prefix . 'times.'. $key .'.title')
			<span class="error">{{ $message }}</span>
		@enderror
	</td>
	<td>
		<input
			aria-labelledby="header-is_active"
			name="{{ $prefix }}times[{{ $key }}][is_active]"
			type="checkbox"
			value="1"
			{{ old($prefix . 'times.'. $key .'.is_active', !empty($time) && $time->is_active ? 'checked' : '') }}
		/>
		@error($prefix . 'times.'. $key .'.is_active')
			<span class="error">{{ $message }}</span>
		@enderror
	</td>
	<td>
		<button class="button--danger" data-action="remove-time" type="button">Remove</button>
	</td>
</tr>
