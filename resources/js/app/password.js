function Passwordable($button) {
	const onClick = (e) => {
		const $input = e.target.closest('.password-container').querySelector('.password-input');
		if ($input.getAttribute('type') === 'password') {
			$input.setAttribute('type', 'text');
			$input.setAttribute('aria-label', 'Hide Password');
			$button.innerText = 'Hide';
		} else {
			$input.setAttribute('type', 'password');
			$input.setAttribute('aria-label', 'Show Password');
			$button.innerText = 'Show';
		}
	};

	const init = () => {
		$button.addEventListener('click', onClick);
	};

	init();
}

function initPasswordable() {
	const $elements = document.querySelectorAll('[data-toggle-password]');
	$elements.forEach(($element) => {
		Passwordable($element);
	});
}

initPasswordable();
