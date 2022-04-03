function Ajax($form) {
	$form.addEventListener('submit', (e) => {
		e.preventDefault();

		const formData = new FormData($form);
		const options = {
			method: $form.getAttribute('method'),
			body: formData,
			headers: {
				Accept: 'application/json',
				'X-Requested-With': 'XMLHttpRequest',
			},
		};

		fetch($form.getAttribute('action'), options)
			.then((response) => {
				if (response.status === 200) {
					document.getElementById('add-note-button').click();
				} else {
					throw response;
				}
			})
			.catch(() => {
				window.alert('There was an error saving your notes.'); // eslint-disable-line no-alert
			});
	});
}

function initAjax() {
	const $elements = document.querySelectorAll('[data-ajax]');
	$elements.forEach(($element) => {
		Ajax($element);
	});
}

initAjax();
