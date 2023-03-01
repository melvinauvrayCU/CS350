
export class IngredientCat {

	private static idCounter: number = 0;

	id: number;
	name: string;

	constructor(name: string) {
		this.id = IngredientCat.idCounter;
		IngredientCat.idCounter++;

		this.name = name;
	}
}

export class UntensilCat {

	private static idCounter: number = 0;

	id: number;
	name: string;

	constructor(name: string) {
		this.id = UntensilCat.idCounter;
		UntensilCat.idCounter++;

		this.name = name;
	}
}
