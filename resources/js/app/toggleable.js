function Toggleable($button) {
	const onClick = () => {
		const selector = $button.getAttribute('data-toggleable');
		const $elements = document.querySelectorAll(selector);
		const className = $button.getAttribute('data-toggleable-body-class');
		if (className) {
			document.body.classList.toggle(className);
		}

		Array.from($elements).forEach(($element) => {
			let text;
			if ($element.classList.contains('show')) {
				text = $button.getAttribute('data-toggleable-show');
				$button.setAttribute('aria-expanded', 'false');
				$element.classList.remove('show');
			} else {
				text = $button.getAttribute('data-toggleable-hide');
				$button.setAttribute('aria-expanded', 'true');
				$element.classList.add('show');
			}
			if (text) {
				$button.innerText = text;
			}
		});
	};

	const init = () => {
		$button.addEventListener('click', onClick);
	};

	init();
}

function initToggleable() {
	const $elements = document.querySelectorAll('[data-toggleable]');
	$elements.forEach(($element) => {
		Toggleable($element);
	});
}

initToggleable();
