import Modal from './modal';
import { removeUnloadListener } from './beforeunload';

function Confirmable($button) {
	const onClick = (e) => {
		const message = e.target.getAttribute('data-confirmable');

		Modal({
			message,
			buttons: [
				{
					label: 'Cancel',
					class: 'button--secondary',
				},
				{
					label: e.target.innerText,
					class: e.target.getAttribute('class'),
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
	};

	const init = () => {
		$button.addEventListener('click', onClick, true);
	};

	init();
}

function initConfirmable() {
	const $elements = document.querySelectorAll('[data-confirmable]');
	$elements.forEach(($element) => {
		Confirmable($element);
	});
}

initConfirmable();
