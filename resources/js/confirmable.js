function Confirmable($button) {
	$button.addEventListener('click', (e) => {
		const message = e.target.getAttribute('data-confirmable');
		if (window.confirm(message)) { // eslint-disable-line no-alert
			e.target.closest('form').submit();
		}
	});
}

function initConfirmable() {
	const $elements = document.querySelectorAll('[data-confirmable]');
	$elements.forEach(($element) => {
		Confirmable($element);
	});
}

initConfirmable();
