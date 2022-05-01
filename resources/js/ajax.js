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

		const $spinner = Spinner.show();

		fetch($form.getAttribute('action'), options)
			.then((response) => {
				Spinner.hide($spinner);
				if (response.status === 200) {
					Toast.show('Saved successfully.', { class: 'toast--success' });
				} else {
					throw response;
				}
			})
			.catch(() => {
				Spinner.hide($spinner);
				Toast.show('There was an error saving your notes.', { class: 'toast--error' });
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
