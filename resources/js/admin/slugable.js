function toSlug(value) {
	if (!value) {
		return '';
	}
	return value
		.normalize('NFD')
		.replace(/[\u0300-\u036f]/g, '')
		.toLowerCase()
		.replace(/ & /g, '-and-')
		.replace(/<[^>]+>/g, '')
		.replace(/['’.]/g, '')
		.replace(/[^a-z0-9-]+/g, '-')
		.replace(/^-+/, '')
		.replace(/-+$/, '')
		.replace(/--+/g, '-');
}

function onChangeInput(e) {
	const $titleInput = e.target;
	const id = $titleInput.getAttribute('id');
	const $slugInput = document.querySelector(`[data-slug="${id}"]`);
	$slugInput.value = toSlug(e.target.value);
}

export const initSlugable = () => {
	const $inputs = document.querySelectorAll('[data-slug]');
	$inputs.forEach(($input) => {
		const id = $input.getAttribute('data-slug');
		const $titleInput = document.getElementById(id);
		$titleInput.addEventListener('keyup', onChangeInput);
	});
};
