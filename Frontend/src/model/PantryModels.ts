import type { Ingredient } from "./recipeModel";

export class IngredientCat {

	type: string;
	id: number;
	name: string;
	ingredients: Ingredient[];

	constructor(id: number, type: string, name: string, ingredients: Ingredient[]) {
		this.id = id;

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


