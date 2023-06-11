function Passwordable($button) {
	const onClick = (e) => {
		const $input = document.getElementById(e.target.getAttribute('aria-controls'));
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

	const onSubmit = () => {
		const $elements = document.querySelectorAll('[data-toggle-password]');
		$elements.forEach(($element) => {
			const $input = document.getElementById($element.getAttribute('aria-controls'));
			$input.setAttribute('type', 'password');
		});
	};

	const init = () => {
		$button.addEventListener('click', onClick);

		const $form = $button.closest('form');
		$form.addEventListener('submit', onSubmit);
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
