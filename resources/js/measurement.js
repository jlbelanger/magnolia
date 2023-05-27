function initMeasurement() {
	const $elements = document.querySelectorAll('[data-num][data-unit]');
	if ($elements.length <= 0) {
		return;
	}

	const $amount = document.querySelector('[data-amount]');

	const decimalToFraction = (d) => {
		d = d.toString();
		const fractions = [
			{ value: /\.5$/, fraction: '1/2' },
			{ value: /\.25$/, fraction: '1/4' },
			{ value: /\.125$/, fraction: '1/8' },
			{ value: /\.3+4?$/, fraction: '1/3' },
			{ value: /\.6+7?$/, fraction: '2/3' },
			{ value: /\.75$/, fraction: '3/4' },
			{ value: /\.0625$/, fraction: '1/16' },
			{ value: /\.83+$/, fraction: '1/2 + 1/3' },
			{ value: /\.625$/, fraction: '1/2 + 1/8' },
			{ value: /\.5625$/, fraction: '1/2 + 1/16' },
			{ value: /\.583+$/, fraction: '1/3 + 1/4' },
			{ value: /\.4583+$/, fraction: '1/3 + 1/8' },
			{ value: /\.39583+$/, fraction: '1/3 + 1/16' },
			{ value: /\.375$/, fraction: '1/4 + 1/8' },
			{ value: /\.3125$/, fraction: '1/4 + 1/16' },
			{ value: /\.1875$/, fraction: '1/8 + 1/16' },
		];
		const num = fractions.length;
		let i;
		for (i = 0; i < num; i += 1) {
			if (d.match(fractions[i].value)) {
				return d.replace(/(^0)?\..+$/, ` ${fractions[i].fraction}`).trim();
			}
		}
		return d;
	};

	const ouncesToGrams = (n) => (Math.round(n * 28.34952));

	const gramsToOunces = (n) => (parseFloat((n / 28.34952).toFixed(1)));

	const getMeasurement = (num, unit, plural, multiplier, units) => {
		num = parseFloat(num);
		let value = num * multiplier;

		if (!['oz', 'g', 'ml'].includes(unit)) {
			value = decimalToFraction(value);
		} else if (unit === 'oz' && units === 'g') {
			value = ouncesToGrams(value);
			unit = units;
			plural = units;
		} else if (unit === 'g' && units === 'oz') {
			value = gramsToOunces(value);
			unit = units;
			plural = units;
		}

		return `${value} ${['1', '1/2', '1/3', '1/4', '1/8'].includes(value) ? unit : plural}`;
	};

	const updateMeasurements = ({ multiplier, units }) => {
		if (!multiplier) {
			const $multiplier = document.querySelector('[data-multiplier][disabled]');
			if ($multiplier) {
				multiplier = $multiplier.getAttribute('data-multiplier');
			}
		}

		if (!units) {
			const $units = document.querySelector('[data-units][disabled]');
			if ($units) {
				units = $units.getAttribute('data-units');
			}
		}

		$elements.forEach(($span) => {
			$span.innerText = getMeasurement(
				$span.getAttribute('data-num'),
				$span.getAttribute('data-unit'),
				$span.getAttribute('data-unit-plural'),
				multiplier,
				units
			);
		});

		if ($amount) {
			$amount.innerText = parseFloat($amount.getAttribute('data-amount')) * multiplier;
		}
	};

	const selectButton = ($button, selector) => {
		document.querySelector(`[${selector}][disabled]`).removeAttribute('disabled');
		$button.setAttribute('disabled', true);
		if ($button.nextSibling) {
			$button.nextSibling.focus();
		} else {
			$button.previousSibling.focus();
		}
	};

	const $fractionContainer = document.createElement('fieldset');
	document.getElementById('recipe-header').appendChild($fractionContainer);

	const fractionOptions = [
		{ label: '1/2', value: 0.5, disabled: false },
		{ label: '1x', value: 1, disabled: true },
		{ label: '2x', value: 2, disabled: false },
	];
	fractionOptions.forEach((option) => {
		const $button = document.createElement('button');
		$button.setAttribute('data-multiplier', option.value);
		if (option.disabled) {
			$button.setAttribute('disabled', true);
		}
		$button.setAttribute('class', 'button--secondary');
		$button.setAttribute('type', 'button');
		$button.innerText = option.label;
		$button.addEventListener('click', (e) => {
			selectButton(e.target, 'data-multiplier');
			updateMeasurements({ multiplier: e.target.getAttribute('data-multiplier') });
		});
		$fractionContainer.appendChild($button);
	});

	let currentUnit;
	if (document.querySelector('[data-unit="oz"]')) {
		currentUnit = 'oz';
	} else if (document.querySelector('[data-unit="g"]')) {
		currentUnit = 'g';
	} else {
		return;
	}

	const $unitContainer = document.createElement('fieldset');
	document.getElementById('recipe-header').appendChild($unitContainer);

	const unitOptions = ['oz', 'g'];
	unitOptions.forEach((unit) => {
		const $button = document.createElement('button');
		$button.setAttribute('data-units', unit);
		if (unit === currentUnit) {
			$button.setAttribute('disabled', true);
		}
		$button.setAttribute('class', 'button--secondary');
		$button.setAttribute('type', 'button');
		$button.innerText = unit;
		$button.addEventListener('click', (e) => {
			selectButton(e.target, 'data-units');
			updateMeasurements({ units: e.target.getAttribute('data-units') });
		});
		$unitContainer.appendChild($button);
	});
}

initMeasurement();
