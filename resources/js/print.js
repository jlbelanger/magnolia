window.addEventListener('beforeprint', () => {
	document.querySelectorAll('details').forEach(($details) => {
		if ($details.getAttribute('open') !== null) {
			$details.setAttribute('data-reopen', '1');
		}
		$details.setAttribute('open', 'open');
	});
});

window.addEventListener('afterprint', () => {
	document.querySelectorAll('details').forEach(($details) => {
		if ($details.getAttribute('data-reopen')) {
			$details.setAttribute('open', 'open');
			$details.removeAttribute('data-reopen');
		} else {
			$details.removeAttribute('open');
		}
	});
});
