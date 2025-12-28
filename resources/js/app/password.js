function showPassword($button, $input) {
	$input.setAttribute('type', 'text');
	$input.setAttribute('aria-label', 'Hide Password');
	$button.innerText = 'Hide';
}

function hidePassword($button, $input) {
	$input.setAttribute('type', 'password');
	$input.setAttribute('aria-label', 'Show Password');
	$button.innerText = 'Show';
}

function isPasswordVisible($input) {
	return $input.getAttribute('type') === 'text';
}

function onClick(e) {
	const $button = e.target;
	const $input = document.getElementById($button.getAttribute('aria-controls'));
	if (isPasswordVisible($input)) {
		hidePassword($button, $input);
	} else {
		showPassword($button, $input);
	}
}

function onSubmit(e) {
	const $buttons = e.target.querySelectorAll('[data-toggle-password]');
	$buttons.forEach(($button) => {
		const $input = document.getElementById($button.getAttribute('aria-controls'));
		hidePassword($button, $input);
	});
}

export const initPasswordable = () => {
	const $buttons = document.querySelectorAll('[data-toggle-password]');
	$buttons.forEach(($button) => {
		$button.addEventListener('click', onClick);
		$button.closest('form').addEventListener('submit', onSubmit);
	});
};
