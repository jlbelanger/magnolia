function onBeforeUnload(e) {
	e.preventDefault();
	return e.returnValue = 'You have unsaved changes. Are you sure you want to leave the page?'; // eslint-disable-line no-return-assign
}

function addUnloadListener() {
	if (!window.HAS_UNSAVED_CHANGES) {
		window.HAS_UNSAVED_CHANGES = true;
		window.addEventListener('beforeunload', onBeforeUnload, { capture: true });
		document.title = `* ${document.title}`;
	}
}

export const removeUnloadListener = () => {
	window.HAS_UNSAVED_CHANGES = false;
	window.removeEventListener('beforeunload', onBeforeUnload, { capture: true });
	document.title = document.title.replace(/^\* /, '');
};

function initBeforeUnload() {
	const $form = document.querySelector('[data-form]');
	if ($form) {
		const $inputs = $form.querySelectorAll('input,select,textarea');
		$inputs.forEach(($input) => {
			$input.addEventListener('keyup', addUnloadListener);
			$input.addEventListener('change', addUnloadListener);
		});

		$form.addEventListener('submit', removeUnloadListener);
	}
}

initBeforeUnload();
