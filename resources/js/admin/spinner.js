class Spinner { // eslint-disable-line no-unused-vars
	static show() {
		let $spinner = document.querySelector('.spinner');
		if (!$spinner) {
			$spinner = document.createElement('div');
			$spinner.setAttribute('class', 'spinner');
			$spinner.setAttribute('role', 'status');
			$spinner.innerText = 'Loading...';
			document.body.appendChild($spinner);
		}
		$spinner.classList.remove('hide');

		return $spinner;
	}

	static hide($spinner) {
		$spinner.classList.add('hide');
	}
}
