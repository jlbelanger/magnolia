function Password($button) {
	$button.addEventListener('click', (e) => {
		const $input = e.target.closest('.password-container').querySelector('.password-input');
		if ($input.getAttribute('type') === 'password') {
			$input.setAttribute('type', 'text');
			$button.innerText = 'Hide';
		} else {
			$input.setAttribute('type', 'password');
			$button.innerText = 'Show';
		}
	});
}

function initPassword() {
	const $elements = document.querySelectorAll('[data-toggle-password]');
	$elements.forEach(($element) => {
		Password($element);
	});
}

initPassword();
