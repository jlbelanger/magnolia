export default class Modal {
	constructor(args) {
		this.args = args;
	}

	show() {
		document.body.classList.add('modal-open');

		const $dialog = document.createElement('dialog');
		$dialog.setAttribute('class', 'modal');
		$dialog.setAttribute('tabindex', '-1');

		const $box = document.createElement('div');
		$box.setAttribute('class', 'modal__box');
		$dialog.appendChild($box);

		const $p = document.createElement('p');
		$p.innerText = this.args.message;
		$box.appendChild($p);

		const $options = document.createElement('p');
		$options.setAttribute('class', 'modal__options');
		$box.appendChild($options);

		this.args.buttons.forEach((data) => {
			const $button = document.createElement('button');
			$button.setAttribute('class', `button ${data.class}`.trim());
			$button.setAttribute('type', 'button');
			$button.innerText = data.label;
			$button.addEventListener('click', () => {
				if (Object.hasOwn(data, 'onClick')) {
					data.onClick();
				}
				$dialog.close();
			});
			$options.appendChild($button);
		});

		$dialog.addEventListener('click', (e) => {
			if (e.target.tagName === 'DIALOG') {
				$dialog.close();
			}
		});

		document.body.appendChild($dialog);

		$dialog.showModal();
		$dialog.focus();
	}
}
