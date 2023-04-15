/**
 * Model of a single Recipe. Contains all the necessary fields.
 * Used in the apiCalls file format the datas retrieved from the backend.
 */
export class Recipe {

	/**
	 * Static field to increment the id of the recipe each time we are creating a new one. 
	 */
	private static idCounter: number = 0;

	/**
	 * For now on, each recipe has an id, title and descrption, that are public. 
	 */
	id: number;
	title: string;
	description: string;
	numberPeople: number;
	steps: Step[];
	rating: number;
	tags: string[];
	pictureUrl: string;
	userId: number;

	constructor(id: number, title: string, description: string, numberPeople: number, steps: Step[], rating: number, pictureUrl: string, tags: string[] = [], userId: number) {
		// We set the id automatically with the static field, so it is auto incrementing.
		// this.id = Recipe.idCounter;
		// Recipe.idCounter++;
		this.id = id;
		this.userId = userId;
		this.rating = rating;

		// We create the recipe from the properties passed in parameters.
		this.title = title;
		this.description = description;
		this.numberPeople = numberPeople;
		this.steps = steps;
		this.rating = rating;
		// Default tags for now will be recommended and recent for when a recipe is created
		this.tags = tags.length ? tags : ["Recommended", "Recent"];

		// Picture
		this.pictureUrl = pictureUrl;
		
	}
}

export type Step = {
	stepId: number,
	descriptionValue: string,
	cooktimeValue: string,
	preptimeValue: string,
	ingredients: Ingredient[],
	utensils: string[]
}

export class Ingredient {
	id: number;
	name: string;
	quantity?: number;
	unit?: string;

	constructor(name: string, quantity: number, unit: string, id: number = 0) {
		this.id = id;
		this.name = name;
		this.quantity = quantity;
		this.unit = unit;
	}
}