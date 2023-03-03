
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
	unit: string;

	constructor(people: number, unit: string) {
		this.people = people;
		this.unit = unit;
	}

}


