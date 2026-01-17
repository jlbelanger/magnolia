import {
	fractionToDecimal,
	getMeasurement,
	gramsToOunces,
	measuringCups,
	ouncesToGrams,
	pluralize,
	tools,
} from './measurement.js';

describe('pluralize', () => {
	[
		{ value: 'berry', expected: 'berries' },
		{ value: 'cup', expected: 'cups' },
		{ value: 'egg', expected: 'eggs' },
		{ value: 'g', expected: 'g' },
		{ value: 'ml', expected: 'ml' },
		{ value: 'oz', expected: 'oz' },
		{ value: 'pinch', expected: 'pinches' },
		{ value: 'potato', expected: 'potatoes' },
		{ value: 'tbsp', expected: 'tbsp' },
		{ value: 'tsp', expected: 'tsp' },
	].forEach((row) => {
		it(`converts ${row.value} to ${row.expected}`, () => {
			expect(pluralize(row.value)).toEqual(row.expected);
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

describe('measuringCups', () => {
	[
		// Common fractions in cups.
		{ unit: 'cup', value: 1, expected: '1 cup' },
		{ unit: 'cup', value: 0.75, expected: '3/4 cups' },
		{ unit: 'cup', value: 0.66666666666667, expected: '2/3 cups' },
		{ unit: 'cup', value: 0.5, expected: '1/2 cup' },
		{ unit: 'cup', value: 0.33333333333333, expected: '1/3 cup' },
		{ unit: 'cup', value: 0.25, expected: '1/4 cup' },
		{ unit: 'cup', value: 0.125, expected: '1/8 cup' },
		{ unit: 'cup', value: 0.0625, expected: '1 tbsp' },
		{ unit: 'cup', value: 0.03125, expected: '1/2 tbsp' },
		{ unit: 'cup', value: 0.04166666666667, expected: '2 tsp' },
		{ unit: 'cup', value: 0.02083333333333, expected: '1 tsp' },
		{ unit: 'cup', value: 0.015625, expected: '3/4 tsp' },
		{ unit: 'cup', value: 0.01041666666667, expected: '1/2 tsp' },
		{ unit: 'cup', value: 0.00520833333333, expected: '1/4 tsp' },
		{ unit: 'cup', value: 0.00260416666667, expected: '1/8 tsp' },
		{ unit: 'cup', value: 0.00130208333333, expected: '1/16 tsp' },

		// Combined fractions.
		{ unit: 'cup', value: (3 / 4) + (1 / 3), expected: '3/4 cups + 1/3 cup' },
		{ unit: 'cup', value: (3 / 4) + (1 / 8), expected: '3/4 cups + 1/8 cup' },
		{ unit: 'cup', value: (2 / 3) + (1 / 8), expected: '2/3 cups + 1/8 cup' },
		{ unit: 'cup', value: (1 / 2) + (1 / 3), expected: '1/2 cup + 1/3 cup' },
		{ unit: 'cup', value: (1 / 2) + (1 / 8), expected: '1/2 cup + 1/8 cup' },
		{ unit: 'cup', value: (1 / 2) + (1 / 16), expected: '1/2 cup + 1 tbsp' },
		{ unit: 'cup', value: (1 / 3) + (1 / 4), expected: '1/3 cup + 1/4 cup' },
		{ unit: 'cup', value: (1 / 3) + (1 / 8), expected: '1/3 cup + 1/8 cup' },
		{ unit: 'cup', value: (1 / 3) + (1 / 16), expected: '1/3 cup + 1 tbsp' },
		{ unit: 'cup', value: (1 / 4) + (1 / 8), expected: '1/4 cup + 1/8 cup' },
		{ unit: 'cup', value: (1 / 4) + (1 / 16), expected: '1/4 cup + 1 tbsp' },
		{ unit: 'cup', value: (1 / 8) + (1 / 16), expected: '1/8 cup + 1 tbsp' },

		// Whole numbers and fractions.
		{ unit: 'cup', value: 1.0625, expected: '1 cup + 1 tbsp' },
		{ unit: 'cup', value: 1.125, expected: '1 1/8 cups' },
		{ unit: 'cup', value: 1.25, expected: '1 1/4 cups' },
		{ unit: 'cup', value: 1.33333333333333, expected: '1 1/3 cups' },
		{ unit: 'cup', value: 1.5, expected: '1 1/2 cups' },
		{ unit: 'cup', value: 1.66666666666667, expected: '1 2/3 cups' },
		{ unit: 'cup', value: 1.75, expected: '1 3/4 cups' },
	].forEach((row) => {
		it(`converts ${row.value} ${row.unit} to ${row.expected}`, () => {
			expect(measuringCups(tools, row.value, row.unit)).toEqual(row.expected);
		});
	});
});

describe('fractionToDecimal', () => {
	[
		{ value: '1', expected: 1 },
		{ value: '3/4', expected: 0.75 },
		{ value: '2/3', expected: 0.6666666666666666 },
		{ value: '1/2', expected: 0.5 },
		{ value: '1/3', expected: 0.3333333333333333 },
		{ value: '1/4', expected: 0.25 },
		{ value: '1/8', expected: 0.125 },
		{ value: '1/16', expected: 0.0625 },
		{ value: '1 3/4', expected: 1.75 },
		{ value: '1 2/3', expected: 1.6666666666666665 },
		{ value: '1 1/2', expected: 1.5 },
		{ value: '1 1/3', expected: 1.3333333333333333 },
		{ value: '1 1/4', expected: 1.25 },
		{ value: '1 1/8', expected: 1.125 },
		{ value: '1 1/16', expected: 1.0625 },
	].forEach((row) => {
		it(`converts ${row.value} to ${row.expected}`, () => {
			expect(fractionToDecimal(row.value)).toEqual(row.expected);
		});
	});
});

describe('getMeasurement', () => {
	[
		// Ounces.
		{ num: 100, unit: 'oz', multiplier: 1, units: 'oz', expected: '100 oz' },
		{ num: 2, unit: 'oz', multiplier: 1, units: 'oz', expected: '2 oz' },
		{ num: 1, unit: 'oz', multiplier: 1, units: 'oz', expected: '1 oz' },
		{ num: 1, unit: 'oz', multiplier: 2, units: 'oz', expected: '2 oz' },
		{ num: 1, unit: 'oz', multiplier: 0.5, units: 'oz', expected: '0.5 oz' },

		// Grams.
		{ num: 100, unit: 'g', multiplier: 1, units: 'g', expected: '100 g' },
		{ num: 2, unit: 'g', multiplier: 1, units: 'g', expected: '2 g' },
		{ num: 1, unit: 'g', multiplier: 1, units: 'g', expected: '1 g' },
		{ num: 1, unit: 'g', multiplier: 2, units: 'g', expected: '2 g' },
		{ num: 1, unit: 'g', multiplier: 0.5, units: 'g', expected: '0.5 g' },

		// Non-standard unit.
		{ num: 100, unit: 'egg', multiplier: 1, units: 'g', expected: '100 eggs' },
		{ num: 2, unit: 'egg', multiplier: 1, units: 'g', expected: '2 eggs' },
		{ num: 1, unit: 'egg', multiplier: 1, units: 'g', expected: '1 egg' },
		{ num: 1, unit: 'egg', multiplier: 2, units: 'g', expected: '2 eggs' },
		{ num: 1, unit: 'egg', multiplier: 0.5, units: 'g', expected: '1/2 egg' },

		// Cups.
		{ num: 0.0625, unit: 'cup', multiplier: 1, units: 'g', expected: '1 tbsp' },
		{ num: 0.125, unit: 'cup', multiplier: 1, units: 'g', expected: '1/8 cup' },
		{ num: 0.25, unit: 'cup', multiplier: 1, units: 'g', expected: '1/4 cup' },
		{ num: 0.33333333333333, unit: 'cup', multiplier: 1, units: 'g', expected: '1/3 cup' },
		{ num: '1/3', unit: 'cup', multiplier: 1, units: 'g', expected: '1/3 cup' },
		{ num: 0.5, unit: 'cup', multiplier: 1, units: 'g', expected: '1/2 cup' },
		{ num: 0.66666666666667, unit: 'cup', multiplier: 1, units: 'g', expected: '2/3 cups' },
		{ num: '2/3', unit: 'cup', multiplier: 1, units: 'g', expected: '2/3 cups' },
		{ num: 0.75, unit: 'cup', multiplier: 1, units: 'g', expected: '3/4 cups' },
		{ num: 1, unit: 'cup', multiplier: 1, units: 'g', expected: '1 cup' },
		{ num: 1.0625, unit: 'cup', multiplier: 1, units: 'g', expected: '1 cup + 1 tbsp' },
		{ num: 1.125, unit: 'cup', multiplier: 1, units: 'g', expected: '1 1/8 cups' },
		{ num: 1.25, unit: 'cup', multiplier: 1, units: 'g', expected: '1 1/4 cups' },
		{ num: 1.33333333333333, unit: 'cup', multiplier: 1, units: 'g', expected: '1 1/3 cups' },
		{ num: '1 1/3', unit: 'cup', multiplier: 1, units: 'g', expected: '1 1/3 cups' },
		{ num: 1.5, unit: 'cup', multiplier: 1, units: 'g', expected: '1 1/2 cups' },
		{ num: 1.66666666666667, unit: 'cup', multiplier: 1, units: 'g', expected: '1 2/3 cups' },
		{ num: '1 2/3', unit: 'cup', multiplier: 1, units: 'g', expected: '1 2/3 cups' },
		{ num: 1.75, unit: 'cup', multiplier: 1, units: 'g', expected: '1 3/4 cups' },
		{ num: 2, unit: 'cup', multiplier: 1, units: 'g', expected: '2 cups' },
		{ num: 2.5, unit: 'cup', multiplier: 1, units: 'g', expected: '2 1/2 cups' },
		{ num: 100, unit: 'cup', multiplier: 1, units: 'g', expected: '100 cups' },

		// Cups doubled.
		{ num: 0.0625, unit: 'cup', multiplier: 2, units: 'g', expected: '1/8 cup' },
		{ num: 0.125, unit: 'cup', multiplier: 2, units: 'g', expected: '1/4 cup' },
		{ num: 0.25, unit: 'cup', multiplier: 2, units: 'g', expected: '1/2 cup' },
		{ num: 0.33333333333333, unit: 'cup', multiplier: 2, units: 'g', expected: '2/3 cups' },
		{ num: '1/3', unit: 'cup', multiplier: 2, units: 'g', expected: '2/3 cups' },
		{ num: 0.5, unit: 'cup', multiplier: 2, units: 'g', expected: '1 cup' },
		{ num: 0.66666666666667, unit: 'cup', multiplier: 2, units: 'g', expected: '1 1/3 cups' },
		{ num: '2/3', unit: 'cup', multiplier: 2, units: 'g', expected: '1 1/3 cups' },
		{ num: 0.75, unit: 'cup', multiplier: 2, units: 'g', expected: '1 1/2 cups' },
		{ num: 1, unit: 'cup', multiplier: 2, units: 'g', expected: '2 cups' },
		{ num: 1.0625, unit: 'cup', multiplier: 2, units: 'g', expected: '2 1/8 cups' },
		{ num: 1.125, unit: 'cup', multiplier: 2, units: 'g', expected: '2 1/4 cups' },
		{ num: 1.25, unit: 'cup', multiplier: 2, units: 'g', expected: '2 1/2 cups' },
		{ num: 1.33333333333333, unit: 'cup', multiplier: 2, units: 'g', expected: '2 2/3 cups' },
		{ num: '1 1/3', unit: 'cup', multiplier: 2, units: 'g', expected: '2 2/3 cups' },
		{ num: 1.5, unit: 'cup', multiplier: 2, units: 'g', expected: '3 cups' },
		{ num: 1.66666666666667, unit: 'cup', multiplier: 2, units: 'g', expected: '3 1/3 cups' },
		{ num: '1 2/3', unit: 'cup', multiplier: 2, units: 'g', expected: '3 1/3 cups' },
		{ num: 1.75, unit: 'cup', multiplier: 2, units: 'g', expected: '3 1/2 cups' },
		{ num: 2, unit: 'cup', multiplier: 2, units: 'g', expected: '4 cups' },
		{ num: 2.5, unit: 'cup', multiplier: 2, units: 'g', expected: '5 cups' },
		{ num: 100, unit: 'cup', multiplier: 2, units: 'g', expected: '200 cups' },

		// Cups halved.
		{ num: 0.0625, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/2 tbsp' },
		{ num: 0.125, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1 tbsp' },
		{ num: 0.25, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/8 cup' },
		{ num: 0.33333333333333, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/8 cup + 2 tsp' },
		{ num: '1/3', unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/8 cup + 2 tsp' },
		{ num: 0.5, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/4 cup' },
		{ num: 0.66666666666667, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/3 cup' },
		{ num: '2/3', unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/3 cup' },
		{ num: 0.75, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/4 cup + 1/8 cup' },
		{ num: 1, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/2 cup' },
		{ num: 1.0625, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/2 cup + 1/2 tbsp' },
		{ num: 1.125, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/2 cup + 1 tbsp' },
		{ num: 1.25, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/2 cup + 1/8 cup' },
		{ num: 1.33333333333333, unit: 'cup', multiplier: 0.5, units: 'g', expected: '2/3 cups' },
		{ num: '1 1/3', unit: 'cup', multiplier: 0.5, units: 'g', expected: '2/3 cups' },
		{ num: 1.5, unit: 'cup', multiplier: 0.5, units: 'g', expected: '3/4 cups' },
		{ num: 1.66666666666667, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/2 cup + 1/3 cup' },
		{ num: '1 2/3', unit: 'cup', multiplier: 0.5, units: 'g', expected: '1/2 cup + 1/3 cup' },
		{ num: 1.75, unit: 'cup', multiplier: 0.5, units: 'g', expected: '3/4 cups + 1/8 cup' },
		{ num: 2, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1 cup' },
		{ num: 2.5, unit: 'cup', multiplier: 0.5, units: 'g', expected: '1 1/4 cups' },
		{ num: 100, unit: 'cup', multiplier: 0.5, units: 'g', expected: '50 cups' },

		// Tablespoons.
		{ num: 1, unit: 'tbsp', multiplier: 1, units: 'g', expected: '1 tbsp' },
		{ num: 0.5, unit: 'tbsp', multiplier: 1, units: 'g', expected: '1/2 tbsp' },
		{ num: 2, unit: 'tbsp', multiplier: 1, units: 'g', expected: '2 tbsp' },
		{ num: 100, unit: 'tbsp', multiplier: 1, units: 'g', expected: '100 tbsp' },

		// Tablespoons doubled.
		{ num: 1, unit: 'tbsp', multiplier: 2, units: 'g', expected: '2 tbsp' },
		{ num: 0.5, unit: 'tbsp', multiplier: 2, units: 'g', expected: '1 tbsp' },
		{ num: 2, unit: 'tbsp', multiplier: 2, units: 'g', expected: '4 tbsp' },
		{ num: 100, unit: 'tbsp', multiplier: 2, units: 'g', expected: '200 tbsp' },

		// Tablespoons halved.
		{ num: 1, unit: 'tbsp', multiplier: 0.5, units: 'g', expected: '1/2 tbsp' },
		{ num: 0.5, unit: 'tbsp', multiplier: 0.5, units: 'g', expected: '3/4 tsp' },
		{ num: 2, unit: 'tbsp', multiplier: 0.5, units: 'g', expected: '1 tbsp' },
		{ num: 100, unit: 'tbsp', multiplier: 0.5, units: 'g', expected: '50 tbsp' },

		// Teaspoons.
		{ num: 1, unit: 'tsp', multiplier: 1, units: 'g', expected: '1 tsp' },
		{ num: 0.75, unit: 'tsp', multiplier: 1, units: 'g', expected: '3/4 tsp' },
		{ num: 0.5, unit: 'tsp', multiplier: 1, units: 'g', expected: '1/2 tsp' },
		{ num: 0.25, unit: 'tsp', multiplier: 1, units: 'g', expected: '1/4 tsp' },
		{ num: 0.125, unit: 'tsp', multiplier: 1, units: 'g', expected: '1/8 tsp' },
		{ num: 0.0625, unit: 'tsp', multiplier: 1, units: 'g', expected: '1/16 tsp' },
		{ num: 2, unit: 'tsp', multiplier: 1, units: 'g', expected: '2 tsp' },
		{ num: 100, unit: 'tsp', multiplier: 1, units: 'g', expected: '100 tsp' },

		// Teaspoons doubled.
		{ num: 1, unit: 'tsp', multiplier: 2, units: 'g', expected: '2 tsp' },
		{ num: 0.75, unit: 'tsp', multiplier: 2, units: 'g', expected: '1/2 tbsp' },
		{ num: 0.5, unit: 'tsp', multiplier: 2, units: 'g', expected: '1 tsp' },
		{ num: 0.25, unit: 'tsp', multiplier: 2, units: 'g', expected: '1/2 tsp' },
		{ num: 0.125, unit: 'tsp', multiplier: 2, units: 'g', expected: '1/4 tsp' },
		{ num: 0.0625, unit: 'tsp', multiplier: 2, units: 'g', expected: '1/8 tsp' },
		{ num: 2, unit: 'tsp', multiplier: 2, units: 'g', expected: '4 tsp' },
		{ num: 100, unit: 'tsp', multiplier: 2, units: 'g', expected: '200 tsp' },

		// Teaspoons halved.
		{ num: 1, unit: 'tsp', multiplier: 0.5, units: 'g', expected: '1/2 tsp' },
		{ num: 0.75, unit: 'tsp', multiplier: 0.5, units: 'g', expected: '1/4 tsp + 1/8 tsp' },
		{ num: 0.5, unit: 'tsp', multiplier: 0.5, units: 'g', expected: '1/4 tsp' },
		{ num: 0.25, unit: 'tsp', multiplier: 0.5, units: 'g', expected: '1/8 tsp' },
		{ num: 0.125, unit: 'tsp', multiplier: 0.5, units: 'g', expected: '1/16 tsp' },
		{ num: 0.0625, unit: 'tsp', multiplier: 0.5, units: 'g', expected: 'pinch' },
		{ num: 2, unit: 'tsp', multiplier: 0.5, units: 'g', expected: '1 tsp' },
		{ num: 100, unit: 'tsp', multiplier: 0.5, units: 'g', expected: '50 tsp' },

		// Uncommon measurements.
		{ num: 0.9, unit: 'cup', multiplier: 1, units: 'g', expected: '0.9 cups' },
		{ num: 0.9, unit: 'cup', multiplier: 2, units: 'g', expected: '1.8 cups' },
		{ num: 0.9, unit: 'cup', multiplier: 0.5, units: 'g', expected: '0.45 cups' },
	].forEach((row) => {
		it(`converts ${row.num} ${row.unit} x ${row.multiplier} to '${row.expected}'`, () => {
			expect(getMeasurement(row.num, row.unit, row.multiplier, row.units)).toEqual(row.expected);
		});
	});
});
