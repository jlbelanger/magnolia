function Toggleable($button) {
	const onClick = () => {
		const selector = $button.getAttribute('data-toggleable');
		document.querySelector(selector).classList.toggle('show');
		const className = $button.getAttribute('data-toggleable-body-class');
		if (className) {
			document.body.classList.toggle(className);
		}
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
