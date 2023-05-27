describe('decimalToFraction', () => {
	[
		// Common fractions.
		{ value: 0.0625, expected: '1/16' },
		{ value: 0.125, expected: '1/8' },
		{ value: 0.25, expected: '1/4' },
		{ value: 0.5, expected: '1/2' },
		{ value: 0.3, expected: '1/3' },
		{ value: 0.333, expected: '1/3' },
		{ value: 0.33333333333334, expected: '1/3' },
		{ value: 0.6, expected: '2/3' },
		{ value: 0.666, expected: '2/3' },
		{ value: 0.66666666666667, expected: '2/3' },
		{ value: 0.75, expected: '3/4' },

		// Uncommon fractions.
		{ value: 0.625, expected: '1/2 + 1/8' },
		{ value: 0.5625, expected: '1/2 + 1/16' },
		{ value: 0.83, expected: '1/2 + 1/3' },
		{ value: 0.8333, expected: '1/2 + 1/3' },
		{ value: 0.583, expected: '1/3 + 1/4' },
		{ value: 0.58333, expected: '1/3 + 1/4' },
		{ value: 0.4583, expected: '1/3 + 1/8' },
		{ value: 0.458333, expected: '1/3 + 1/8' },
		{ value: 0.39583, expected: '1/3 + 1/16' },
		{ value: 0.3958333, expected: '1/3 + 1/16' },
		{ value: 0.375, expected: '1/4 + 1/8' },
		{ value: 0.3125, expected: '1/4 + 1/16' },
		{ value: 0.1875, expected: '1/8 + 1/16' },

		// Whole numbers.
		{ value: 1, expected: '1' },
		{ value: 2, expected: '2' },
		{ value: 99, expected: '99' },

		// Whole numbers and fractions
		{ value: 1.5, expected: '1 1/2' },
		{ value: 1.3, expected: '1 1/3' },
		{ value: 1.333, expected: '1 1/3' },
		{ value: 2.75, expected: '2 3/4' },
	].forEach((row) => {
		it(`converts ${row.value} to ${row.expected}`, () => {
			expect(decimalToFraction(row.value)).toEqual(row.expected);
		});
	});
});

describe('ouncesToGrams', () => {
	[
		{ value: 1, expected: 28 },
		{ value: 2, expected: 57 },
		{ value: 3, expected: 85 },
		{ value: 4, expected: 113 },
		{ value: 7.5, expected: 213 },
		{ value: 8, expected: 227 },
	].forEach((row) => {
		it(`converts ${row.value} oz to ${row.expected} g`, () => {
			expect(ouncesToGrams(row.value)).toEqual(row.expected);
		});
	});
});

describe('gramsToOunces', () => {
	[
		{ value: 28, expected: 1 },
		{ value: 57, expected: 2 },
		{ value: 85, expected: 3 },
		{ value: 113, expected: 4 },
		{ value: 213, expected: 7.5 },
		{ value: 227, expected: 8 },
	].forEach((row) => {
		it(`converts ${row.value} oz to ${row.expected} g`, () => {
			expect(gramsToOunces(row.value)).toEqual(row.expected);
		});
	});
});

describe('getMeasurement', () => {
	[
		{ num: 1, unit: 'oz', plural: 'oz', multiplier: 1, units: 'oz', expected: '1 oz' },
		{ num: 1, unit: 'oz', plural: 'oz', multiplier: 2, units: 'oz', expected: '2 oz' },
		{ num: 1, unit: 'oz', plural: 'oz', multiplier: 0.5, units: 'oz', expected: '0.5 oz' },
	].forEach((row) => {
		it(`converts ${row.num} ${row.unit} to ${row.expected} (${row.multiplier}x)`, () => {
			expect(getMeasurement(row.num, row.unit, row.plural, row.multiplier, row.units))
				.toEqual(row.expected);
		});
	});
});
