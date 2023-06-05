function Toggleable($button) {
	const onClick = () => {
		const selector = $button.getAttribute('data-toggleable');
		const $elements = document.querySelectorAll(selector);
		const className = $button.getAttribute('data-toggleable-body-class');
		if (className) {
			document.body.classList.toggle(className);
		}

		Array.from($elements).forEach(($element) => {
			if ($element.classList.contains('show')) {
				$button.setAttribute('aria-expanded', 'false');
				$button.innerText = $button.getAttribute('data-toggleable-show');

				let transitionDuration = getComputedStyle($element).transitionDuration;
				if (transitionDuration.indexOf('ms') > -1) {
					transitionDuration = parseFloat(transitionDuration.replace('ms', ''));
				} else if (transitionDuration.indexOf('s') > -1) {
					transitionDuration = parseFloat(transitionDuration.replace('s', '')) * 1000;
				}

				$element.classList.remove('animate');
				setTimeout(() => {
					$element.classList.remove('show');
				}, transitionDuration);
			} else {
				$button.setAttribute('aria-expanded', 'true');
				$button.innerText = $button.getAttribute('data-toggleable-hide');

				$element.classList.add('show');
				setTimeout(() => {
					$element.classList.add('animate');
				}, 10);
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
