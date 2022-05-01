function Slugable($slugInput) {
	const id = $slugInput.getAttribute('data-slug');
	const $titleInput = document.getElementById(id);

	const toSlug = (value) => {
		if (!value) {
			return '';
		}
		return value.toLowerCase()
			.replace(/['.]/g, '')
			.replace(/[^a-z0-9-]+/g, '-')
			.replace(/^-+/, '')
			.replace(/-+$/, '')
			.replace(/--+/g, '-');
	};

	const onChangeInput = (e) => {
		$slugInput.value = toSlug(e.target.value);
	};

	const init = () => {
		$titleInput.addEventListener('keyup', onChangeInput);
	};

	init();
}

function initSlugable() {
	const $elements = document.querySelectorAll('[data-slug]');
	$elements.forEach(($element) => {
		Slugable($element);
	});
}

initSlugable();
