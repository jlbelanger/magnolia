function Times() {
	const $table = document.querySelector('table');
	const $tbody = document.querySelector('tbody');
	const $tfoot = document.querySelector('tfoot');

	const addTd = (name, i, type = 'text') => {
		const $td = document.createElement('td');

		const $input = document.createElement('input');
		$input.setAttribute('aria-labelledby', `header-${name}`);
		$input.setAttribute('name', `new_times[${i}][${name}]`);
		if (type !== 'checkbox') {
			$input.setAttribute('required', 'required');
		} else {
			$input.setAttribute('value', '1');
		}
		$input.setAttribute('type', type);
		$td.appendChild($input);

		return $td;
	};

	const removeTimeRow = (e) => {
		e.target.closest('tr').remove();

		if ($tbody.children.length <= 0 && $tfoot.children.length <= 0) {
			$table.classList.add('hide');
		}
	};

	const addTimeRow = () => {
		const i = $tfoot.children.length;

		const $tr = document.createElement('tr');

		const $tdOrderNum = addTd('order_num', i);
		$tr.appendChild($tdOrderNum);
		$tdOrderNum.querySelector('input').value = i + 1;

		$tr.appendChild(addTd('minutes', i));
		$tr.appendChild(addTd('title', i));
		$tr.appendChild(addTd('is_active', i, 'checkbox'));

		const $td = document.createElement('td');
		const $button = document.createElement('button');
		$button.innerText = 'Remove';
		$button.addEventListener('click', removeTimeRow);
		$button.setAttribute('class', 'button--danger');
		$button.setAttribute('type', 'button');
		$td.appendChild($button);
		$tr.appendChild($td);

		$tfoot.appendChild($tr);

		$table.classList.remove('hide');
	};

	const init = () => {
		const $addTime = document.querySelector('[data-action="add-time"]');
		if (!$addTime) {
			return;
		}

		$addTime.addEventListener('click', addTimeRow);

		Array.from(document.querySelectorAll('[data-action="remove-time"]')).forEach(($button) => {
			$button.addEventListener('click', removeTimeRow);
		});
	};

	init();
}

Times();
