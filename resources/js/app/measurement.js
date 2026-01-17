const tsp = 1 / 48;

export const tools = [
	{ value: 1, name: '1 cup' },
	{ value: 0.75, name: '3/4 cups' },
	{ value: 2 / 3, name: '2/3 cups' },
	{ value: 0.5, name: '1/2 cup' },
	{ value: 1 / 3, name: '1/3 cup' },
	{ value: 0.25, name: '1/4 cup' },
	{ value: 0.125, name: '1/8 cup' },
	{ value: 0.0625, name: '1 tbsp' },
	{ value: 0.03125, name: '1/2 tbsp' },
	{ value: tsp * 2, name: '2 tsp' },
	{ value: tsp, name: '1 tsp' },
	{ value: tsp * 0.75, name: '3/4 tsp' },
	{ value: tsp / 2, name: '1/2 tsp' },
	{ value: tsp / 4, name: '1/4 tsp' },
	{ value: tsp / 8, name: '1/8 tsp' },
	{ value: tsp / 16, name: '1/16 tsp' },
];

export const pluralize = (singular) => {
	if (['g', 'oz', 'ml', 'tsp', 'tbsp'].includes(singular)) {
		return singular;
	}
	const lastLetter = singular[singular.length - 1];
	if (['h', 'o'].includes(lastLetter)) {
		return singular.replace(/(.)$/, '$1es');
	}
	if (['f'].includes(lastLetter)) {
		return singular.replace(/f$/, 'ves');
	}
	if (['y'].includes(lastLetter)) {
		return singular.replace(/y$/, 'ies');
	}
	if (singular === 'foot') {
		return 'feet';
	}
	return `${singular}s`;
};

const maybePluralize = (unit, num) => {
	const singularValues = ['1', '1/2', '1/3', '1/4', '1/8', '1/16'];
	return singularValues.includes(num) ? unit : pluralize(unit);
};

export const ouncesToGrams = (n) => Math.round(n * 28.34952);

export const gramsToOunces = (n) => parseFloat((n / 28.34952).toFixed(1));

function findBestSolution(target, availableTools) {
	if (Math.abs(target) <= 0.00000000000001) {
		return [];
	}
	if (target < 0 || availableTools.length === 0) {
		return null;
	}

	let currentTool = availableTools[0];
	const currentValue = currentTool.value;

	// Recursive call without using the current value.
	const resultWithoutCurrent = findBestSolution(target, availableTools.slice(1));

	// Recursive call using the current value.
	let resultWithCurrent;
	if (currentTool.name.match(/^\d+ cups?$/)) {
		resultWithCurrent = findBestSolution(target - currentValue, availableTools);
		if (resultWithCurrent) {
			const numCups = resultWithCurrent
				.filter((t) => t.name.match(/^\d+ cups?$/))
				.map((t) => t.value)
				.reduce((sum, a) => sum + a, 0);
			if (numCups > 0) {
				resultWithCurrent = resultWithCurrent.filter((t) => !t.name.match(/^\d+ cups?$/));
				currentTool = { value: numCups + currentTool.value, name: `${numCups + currentTool.value} cups` };
			}
		}
	} else {
		resultWithCurrent = findBestSolution(target - currentValue, availableTools.slice(1));
	}

	// Determine the shortest result.
	if (resultWithoutCurrent === null && resultWithCurrent === null) {
		// Neither option is valid, sum not possible.
		return null;
	}
	if (resultWithoutCurrent === null) {
		// Include the current value.
		return [currentTool, ...resultWithCurrent];
	}
	if (resultWithCurrent === null) {
		// Exclude the current value.
		return resultWithoutCurrent;
	}

	// Return the solution with the fewest measurements.
	const withoutLength = resultWithoutCurrent.length;
	const withLength = resultWithCurrent.length + 1;
	if (withoutLength < withLength) {
		return resultWithoutCurrent;
	}
	if (withoutLength === withLength) {
		// If the number of measurements are the same, prefer the solution that doesn't use 2 tsp.
		if (resultWithCurrent.map((t) => t.name).includes('2 tsp')) {
			return resultWithoutCurrent;
		}
	}
	return [currentTool, ...resultWithCurrent];
}

export const measuringCups = (allTools, target, unit) => {
	if (unit === 'tbsp') {
		target /= 16;
	} else if (unit === 'tsp') {
		target /= 48;
	}

	const tool = allTools.find((t) => Math.abs(target - t.value) <= 0.00000000000001);
	if (tool) {
		// This is a normal measurement.
		return tool.name;
	}

	// Eliminate all tools that are too large.
	const availableTools = allTools.filter((t) => t.value <= target);
	if (availableTools.length <= 0) {
		return 'pinch';
	}

	const solution = findBestSolution(target, availableTools);
	if (solution) {
		const numTools = solution.length;
		if (numTools === 2 && solution[0].name.match(/^\d+ cups?$/) && solution[1].name.includes('cup')) {
			return `${solution[0].value} ${solution[1].name.replace(/ cups?$/, '')} ${maybePluralize('cup', solution[1].value)}`;
		}
		if (numTools > 0) {
			return solution.map((t) => t.name).join(' + ');
		}
	}

	return `${target.toFixed(2).replace(/(\.[^0])0$/, '$1')} ${maybePluralize(unit, target)}`;
};

const decimalToFraction = (d, unit) => {
	let s = d.toString();
	if (!s.includes('.')) {
		// This is a whole number.
		return `${s} ${maybePluralize(unit, s)}`;
	}

	if (['cup', 'tbsp', 'tsp'].includes(unit)) {
		return measuringCups(tools, d, unit);
	}

	const fractions = [
		{ value: 0.75, fraction: '3/4' },
		{ value: 0.66667, fraction: '2/3' },
		{ value: 0.5, fraction: '1/2' },
		{ value: 0.33333, fraction: '1/3' },
		{ value: 0.25, fraction: '1/4' },
		{ value: 0.125, fraction: '1/8' },
		{ value: 0.0625, fraction: '1/16' },
	];
	const num = fractions.length;
	let i;
	const parts = s.split('.');
	const whole = parts[0] === '0' ? '' : parts[0];
	const fraction = parseFloat(`.${parseFloat(parts[1]).toFixed(5)}`);

	for (i = 0; i < num; i += 1) {
		if (fraction === fractions[i].value) {
			s = `${whole} ${fractions[i].fraction}`.trim();
			return `${s} ${maybePluralize(unit, s)}`;
		}
	}

	return `${s} ${maybePluralize(unit, s)}`;
};

export const fractionToDecimal = (num) => {
	let whole = 0;
	if (num.includes(' ')) {
		num = num.split(' ');
		whole = parseInt(num[0], 10);
		num = num[1];
	}
	if (num.includes('/')) {
		const fraction = num.split('/');
		num = whole + (parseInt(fraction[0], 10) / parseInt(fraction[1], 10)); /* prettier-ignore */
	}
	return parseFloat(num);
};

export const getMeasurement = (num, unit, multiplier, units) => {
	num = num.toString();
	const defaultValue = `${num} ${maybePluralize(unit, num)}`;
	if (multiplier === 1 && unit === units) {
		return defaultValue;
	}

	const useFractions = !['oz', 'g', 'ml'].includes(unit);
	if (multiplier === 1 && useFractions && !num.includes('.')) {
		return defaultValue;
	}

	let value = fractionToDecimal(num.toString()) * multiplier;

	if (useFractions) {
		return decimalToFraction(value, unit);
	}

	if (unit === 'oz' && units === 'g') {
		value = ouncesToGrams(value);
		unit = units;
	} else if (unit === 'g' && units === 'oz') {
		value = gramsToOunces(value);
		unit = units;
	}

	return `${value.toLocaleString()} ${maybePluralize(unit, num.toString())}`;
};

const updateMeasurements = ($amounts, $elements, { multiplier, units }) => {
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
		$span.innerText = getMeasurement($span.getAttribute('data-num'), $span.getAttribute('data-unit'), multiplier, units);
	});

	$amounts.forEach(($span) => {
		$span.innerText = parseFloat($span.getAttribute('data-amount')) * multiplier;
	});
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

export const initMeasurement = () => {
	const $elements = document.querySelectorAll('[data-num][data-unit]');
	if ($elements.length <= 0) {
		return;
	}

	const $amounts = document.querySelectorAll('[data-amount]');

	const $fractionFieldset = document.createElement('fieldset');
	$fractionFieldset.setAttribute('id', 'fraction-fieldset');
	const $fractionLegend = document.createElement('legend');
	$fractionLegend.innerText = 'Multiplier';
	$fractionFieldset.appendChild($fractionLegend);
	const $fractionContainer = document.createElement('div');
	$fractionFieldset.appendChild($fractionContainer);

	const fractionOptions = [
		{ label: '1/2', value: 0.5, disabled: false, aria: 'Half recipe' },
		{ label: '1x', value: 1, disabled: true, aria: 'Normal recipe' },
		{ label: '2x', value: 2, disabled: false, aria: 'Double recipe' },
	];
	fractionOptions.forEach((option) => {
		const $button = document.createElement('button');
		$button.setAttribute('aria-label', option.aria);
		$button.setAttribute('data-multiplier', option.value);
		if (option.disabled) {
			$button.setAttribute('disabled', true);
		}
		$button.setAttribute('class', 'button--secondary');
		$button.setAttribute('type', 'button');
		$button.innerText = option.label;
		$button.addEventListener('click', (e) => {
			selectButton(e.target, 'data-multiplier');
			updateMeasurements($amounts, $elements, { multiplier: e.target.getAttribute('data-multiplier') });
		});
		$fractionContainer.appendChild($button);
	});

	const $container = document.createElement('div');
	$container.setAttribute('id', 'recipe-buttons');
	$container.appendChild($fractionFieldset);

	const $sidebar = document.getElementById('recipe-side');
	if ($sidebar) {
		$sidebar.prepend($container);
	}

	let currentUnit;
	if (document.querySelector('[data-unit="oz"]')) {
		currentUnit = 'oz';
	} else if (document.querySelector('[data-unit="g"]')) {
		currentUnit = 'g';
	} else {
		return;
	}

	const $unitFieldset = document.createElement('fieldset');
	$unitFieldset.setAttribute('id', 'unit-fieldset');
	const $unitLegend = document.createElement('legend');
	$unitLegend.innerText = 'Units';
	$unitFieldset.appendChild($unitLegend);
	const $unitContainer = document.createElement('div');
	$unitFieldset.appendChild($unitContainer);

	const unitOptions = [
		{ unit: 'oz', aria: 'ounces' },
		{ unit: 'g', aria: 'grams' },
	];
	unitOptions.forEach((option) => {
		const $button = document.createElement('button');
		$button.setAttribute('data-units', option.unit);
		$button.setAttribute('aria-label', option.aria);
		if (option.unit === currentUnit) {
			$button.setAttribute('disabled', true);
		}
		$button.setAttribute('class', 'button--secondary');
		$button.setAttribute('type', 'button');
		$button.innerText = option.unit;
		$button.addEventListener('click', (e) => {
			selectButton(e.target, 'data-units');
			updateMeasurements($amounts, $elements, { units: e.target.getAttribute('data-units') });
		});
		$unitContainer.appendChild($button);
	});

	$container.appendChild($unitFieldset);
};
