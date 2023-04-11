
export class IngredientCat {

	private static idCounter: number = 0;

	type: string;
	id: number;
	name: string;
	ingredients: Array<string>;

	constructor(type: string, name: string, ingredients: Array<string>) {
		this.id = IngredientCat.idCounter;
		IngredientCat.idCounter++;

		this.type = type;
		this.name = name;
		this.ingredients = ingredients;
	}
}

export class Conversion {

	people: number;
	unitWeight: string;
	unitVolume: string;

	constructor(people: number, unitWeight: string, unitVolume: string) {
		this.people = people;
		this.unitWeight = unitWeight;
		this.unitVolume = unitVolume;
	}

}

export class Unit {

	type: string; //W for weight, V for volume
	name: string;
	convertToSt: number; //for mass, grams. for volume, liter
	convertFromSt: number;

	constructor(type: string, name: string, convertToSt: number, convertFromSt: number) {
		this.type = type;
		this.name = name;
		this.convertToSt = convertToSt;
		this.convertFromSt = convertFromSt;
	}

}


