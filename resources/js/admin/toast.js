class Toast { // eslint-disable-line no-unused-vars
	static show(message, args = {}) {
		args.class = args.class || '';
		args.closeButtonClass = args.closeButtonClass || '';
		args.closeButtonText = args.closeButtonText || 'Close';
		args.duration = args.duration || 5000;

		let $container = document.getElementById('toast-container');
		if (!$container) {
			$container = document.createElement('div');
			$container.setAttribute('id', 'toast-container');
			document.body.append($container);
		}

		const id = `toast-${new Date().getTime()}`;
		const $div = document.createElement('div');
		$div.setAttribute('aria-live', 'polite');
		$div.setAttribute('class', `toast ${args.class}`.trim());
		$div.setAttribute('id', id);
		$div.setAttribute('role', 'alert');
		$div.style.animationDuration = `${args.duration}ms`;
		$container.appendChild($div);

		const $p = document.createElement('p');
		$p.setAttribute('class', 'toast-text');
		$p.innerText = message;
		$div.appendChild($p);

		if (!args.hideClose) {
			const callback = (e) => {
				Toast.hide(e);
			};

			const $closeButton = document.createElement('button');
			$closeButton.setAttribute('aria-label', args.closeButtonText);
			$closeButton.setAttribute('class', `toast-close ${args.closeButtonClass}`.trim());
			$closeButton.setAttribute('type', 'button');
			if (args.closeButtonAttributes) {
				Object.keys(args.closeButtonAttributes).forEach((property) => {
					$closeButton.setAttribute(property, args.closeButtonAttributes[property]);
				});
			}
			$closeButton.addEventListener('click', callback);
			$div.appendChild($closeButton);
		}

		setTimeout(() => {
			$div.remove();
		}, args.duration + 1000);

		return $div;
	}

	static hide(e) {
		e.target.closest('.toast').remove();
	}
}
