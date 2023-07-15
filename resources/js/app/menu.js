function Menu() {
	const $button = document.getElementById('nav-show');
	const controls = $button.getAttribute('aria-controls');
	const $element = document.getElementById(controls);

	const onResize = () => {
		if (window.innerWidth >= 1024) {
			hideElement();
			onTransitionEnd();
		}
	};

	const onTransitionEnd = () => {
		const $dialog = $element.closest('dialog');
		document.body.classList.remove(`show-${controls}`);
		$dialog.close();

		$dialog.parentNode.appendChild($element);
		$dialog.remove();

		$element.removeEventListener('transitionend', onTransitionEnd);
	};

	const hideElement = () => {
		window.removeEventListener('resize', onResize);
		$button.setAttribute('aria-expanded', 'false');
		document.body.classList.remove(`animate-${controls}`);
		$element.addEventListener('transitionend', onTransitionEnd);
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
		$button.setAttribute('aria-expanded', 'true');

		const $dialog = document.createElement('dialog');
		$dialog.setAttribute('id', `${controls}-dialog`);
		$dialog.addEventListener('cancel', onCancelDialog);
		$dialog.addEventListener('click', onClickDialog);

		const $closeButton = document.createElement('button');
		$closeButton.setAttribute('aria-controls', controls);
		$closeButton.setAttribute('aria-expanded', 'true');
		$closeButton.setAttribute('class', 'button--icon');
		$closeButton.setAttribute('id', `${controls}-close`);
		$closeButton.setAttribute('title', 'Close Menu');
		$closeButton.setAttribute('type', 'button');
		$closeButton.innerText = 'Close Menu';
		$closeButton.addEventListener('click', (e) => {
			hideElement(e.target.closest('dialog'));
		});
		$dialog.appendChild($closeButton);

		document.body.classList.add(`show-${controls}`);

		const $container = $element.parentNode;
		$element.remove();

		$dialog.appendChild($element);
		$container.appendChild($dialog);
		$dialog.showModal();
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
