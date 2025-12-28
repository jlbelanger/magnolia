import Spinner from './spinner.js';
import Toast from './toast.js';

function onSubmit(e) {
	e.preventDefault();

	const $form = e.target;
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
		.catch((error) => {
			Spinner.hide($spinner);
			Toast.show(`Save failed. (${error.status} ${error.statusText})`, { class: 'toast--danger' });
		});
}

export const initAjax = () => {
	const $forms = document.querySelectorAll('[data-ajax]');
	$forms.forEach(($form) => {
		$form.addEventListener('submit', onSubmit);
	});
};
