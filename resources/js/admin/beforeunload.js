function onBeforeUnload(e) {
	e.preventDefault();
	return e.returnValue = 'You have unsaved changes. Are you sure you want to leave the page?'; // eslint-disable-line no-return-assign
}

function addUnloadListener() {
	window.addEventListener('beforeunload', onBeforeUnload, { capture: true });
}

function removeUnloadListener() {
	window.removeEventListener('beforeunload', onBeforeUnload, { capture: true });
}

function initBeforeUnload() {
	const $form = document.getElementById('form');
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
