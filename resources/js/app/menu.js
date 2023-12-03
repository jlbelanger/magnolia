function Menu() {
	const maxWidth = 1024;
	const $button = document.getElementById('nav-show');
	const controls = $button.getAttribute('aria-controls');
	const $element = document.getElementById(controls);
	const supportsDialog = typeof HTMLDialogElement === 'function';

	const onTransitionEnd = () => {
		const $dialog = document.getElementById(`${controls}-dialog`);
		document.body.classList.remove(`show-${controls}`);
		if (supportsDialog) {
			$dialog.close();
		}

		$dialog.parentNode.appendChild($element);
		$dialog.remove();

		$element.removeEventListener('transitionend', onTransitionEnd);
	};

	const hideElement = () => {
		window.removeEventListener('resize', onResize); // eslint-disable-line no-use-before-define
		$button.setAttribute('aria-expanded', 'false');
		document.body.classList.remove(`animate-${controls}`);
		$element.addEventListener('transitionend', onTransitionEnd);
	};

	const onResize = () => {
		if (window.innerWidth >= maxWidth) {
			hideElement();
			onTransitionEnd();
		}
	};

	const onCancelDialog = (e) => {
		e.preventDefault();
		hideElement(e.target);
	};

	const onClickDialog = (e) => {
		if (e.target.tagName === 'DIALOG') {
			hideElement(e.target);
		}
	};

	const showElement = () => {
		if (window.innerWidth >= maxWidth) {
			return;
		}

		$button.setAttribute('aria-expanded', 'true');

		const $dialog = document.createElement(supportsDialog ? 'dialog' : 'div');
		$dialog.setAttribute('id', `${controls}-dialog`);
		if (supportsDialog) {
			$dialog.addEventListener('cancel', onCancelDialog);
			$dialog.addEventListener('click', onClickDialog);
		}

		const $closeButton = document.createElement('button');
		$closeButton.setAttribute('aria-controls', controls);
		$closeButton.setAttribute('aria-expanded', 'true');
		$closeButton.setAttribute('class', 'button--icon');
		$closeButton.setAttribute('id', `${controls}-close`);
		$closeButton.setAttribute('title', 'Close Menu');
		$closeButton.setAttribute('type', 'button');
		$closeButton.innerText = 'Close Menu';
		$closeButton.addEventListener('click', () => {
			hideElement(document.getElementById(`${controls}-dialog`));
		});
		$dialog.appendChild($closeButton);

		document.body.classList.add(`show-${controls}`);

		const $container = $element.parentNode;
		$element.remove();

		$dialog.appendChild($element);
		$container.appendChild($dialog);
		if (supportsDialog) {
			$dialog.showModal();
		}
		window.addEventListener('resize', onResize);

		setTimeout(() => {
			document.body.classList.add(`animate-${controls}`);
		}, 10);
	};

	const init = () => {
		$button.addEventListener('click', showElement);
	};

	init();
}

Menu();
