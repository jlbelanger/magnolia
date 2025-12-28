export const initTimes = () => {
	const $addTime = document.querySelector('[data-action="add-time"]');
	if (!$addTime) {
		return;
	}

	const $table = document.querySelector('table');
	const $tbody = document.querySelector('tbody');
	const $tfoot = document.querySelector('tfoot');

	const addTd = (name, i, type = 'text') => {
		const $td = document.createElement('td');

		const $input = document.createElement('input');
		$input.setAttribute('aria-labelledby', `header-${name}`);
		$input.setAttribute('name', `new_times[${i}][${name}]`);
		if (type === 'checkbox') {
			$input.setAttribute('value', '1');
		} else {
			$input.setAttribute('required', 'required');
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
		const i = $tbody.children.length + $tfoot.children.length;

		const $tr = document.createElement('tr');

		const $tdOrderNum = addTd('order_num', i);
		$tr.appendChild($tdOrderNum);
		$tdOrderNum.querySelector('input').value = i + 1;

		const $minutes = addTd('minutes', i);
		$tr.appendChild($minutes);
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

		$minutes.querySelector('input').focus();
	};

	const init = () => {
		$addTime.addEventListener('click', addTimeRow);

		const $buttons = document.querySelectorAll('[data-action="remove-time"]');
		$buttons.forEach(($button) => {
			$button.addEventListener('click', removeTimeRow);
		});
	};

	init();
};
