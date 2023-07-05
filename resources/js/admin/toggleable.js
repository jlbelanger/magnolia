function Toggleable($button) {
	const showElement = ($element) => {
		const controls = $button.getAttribute('aria-controls');
		$button.setAttribute('aria-expanded', 'true');
		$element.classList.add('show');
		document.body.classList.add(`show-${controls}`);
		return $button.getAttribute('data-toggleable-hide');
	};

	const hideElement = ($element) => {
		const controls = $button.getAttribute('aria-controls');
		$button.setAttribute('aria-expanded', 'false');
		$element.classList.remove('show');
		document.body.classList.remove(`show-${controls}`);
		return $button.getAttribute('data-toggleable-show');
	};

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
				text = hideElement($element);
			} else {
				text = showElement($element);
			}

			if (text) {
				$button.setAttribute('title', text);
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
