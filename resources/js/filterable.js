function Filterable($list) {
	const $inputs = document.querySelectorAll('[data-filterable-input]');
	const $items = $list.querySelectorAll('[data-filterable-item]');
	const $noResults = document.getElementById('no-results');

	const afterFilter = () => {
		const hasVisible = Array.from($items).some(($item) => ($item.style.display !== 'none'));
		if (hasVisible) {
			$noResults.style.display = 'none';
		} else {
			$noResults.style.display = '';
		}
	};

	const toSlug = (s) => (
		s.toLowerCase()
			.replace(/ & /g, '-and-')
			.replace(/<[^>]+>/g, '')
			.replace(/['’]/g, '')
			.replace(/[^a-z0-9-]+/g, '-')
			.replace(/^-+/, '')
			.replace(/-+$/, '')
			.replace(/--+/g, '-')
	);

	const getValue = ($value) => {
		if ($value.getAttribute('data-value')) {
			return $value.getAttribute('data-value');
		}
		return toSlug($value.innerText);
	};

	const onChangeInput = (e) => {
		const $input = e.target;
		const filterKey = $input.getAttribute('data-filterable-key');
		const value = toSlug($input.value);
		$items.forEach(($item) => {
			const $element = $item.querySelector(`[data-key="${filterKey}"]`);
			if (!value || ($element && getValue($element).indexOf(value) > -1)) {
				$item.style.display = '';
			} else {
				$item.style.display = 'none';
			}
		});
		afterFilter();
	};

	const init = () => {
		$inputs.forEach(($input) => {
			$input.addEventListener('keyup', debounce(onChangeInput, 100)); // eslint-disable-line no-undef

			if ($input.value) {
				onChangeInput({ target: $input });
			}
		});
	};

	init();
}

function initFilterable() {
	const $elements = document.querySelectorAll('[data-filterable-list]');
	$elements.forEach(($element) => {
		Filterable($element);
	});
}

initFilterable();
