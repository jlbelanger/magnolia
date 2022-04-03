function Toggleable($button) {
	$button.addEventListener('click', (e) => {
		const selector = e.target.getAttribute('data-toggleable');
		document.querySelector(selector).classList.toggle('show');
	});
}

function initToggleable() {
	const $elements = document.querySelectorAll('[data-toggleable]');
	$elements.forEach(($element) => {
		Toggleable($element);
	});
}

initToggleable();
