function showElement($button, $element) {
	const controls = $button.getAttribute('aria-controls');
	$button.setAttribute('aria-expanded', 'true');
	$element.classList.add('show');
	document.body.classList.add(`show-${controls}`);
	return $button.getAttribute('data-toggleable-hide');
}

function hideElement($button, $element) {
	const controls = $button.getAttribute('aria-controls');
	$button.setAttribute('aria-expanded', 'false');
	$element.classList.remove('show');
	document.body.classList.remove(`show-${controls}`);
	return $button.getAttribute('data-toggleable-show');
}

function onClick(e) {
	const $button = e.target;
	const selector = $button.getAttribute('data-toggleable');
	const $elements = document.querySelectorAll(selector);
	const className = $button.getAttribute('data-toggleable-body-class');
	if (className) {
		document.body.classList.toggle(className);
	}

	Array.from($elements).forEach(($element) => {
		let text;

		if ($element.classList.contains('show')) {
			text = hideElement($button, $element);
		} else {
			text = showElement($button, $element);
		}

		if (text) {
			$button.setAttribute('title', text);
		}
	});
}

export const initToggleable = () => {
	const $buttons = document.querySelectorAll('[data-toggleable]');
	$buttons.forEach(($button) => {
		$button.addEventListener('click', onClick);
	});
};
