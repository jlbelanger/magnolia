import Modal from './modal.js';
import { removeUnloadListener } from './beforeunload.js';

function onClick(e) {
	const $button = e.target;
	const message = $button.getAttribute('data-confirmable');

	const modal = new Modal({
		message,
		buttons: [
			{
				label: 'Cancel',
				class: 'button--secondary',
			},
			{
				label: $button.innerText,
				class: $button.getAttribute('class'),
				onClick: () => {
					const $form = $button.closest('form');
					if ($form.getAttribute('data-ignore-unsaved') !== undefined) {
						removeUnloadListener();
					}
					$form.submit();
				},
			},
		],
	});
	modal.show();
}

export const initConfirmable = () => {
	const $buttons = document.querySelectorAll('[data-confirmable]');
	$buttons.forEach(($button) => {
		$button.addEventListener('click', onClick, true);
	});
};
