import type { User } from "./userModel";

/**
 * Model of a single Recipe. Contains all the necessary fields.
 * Used in the apiCalls file format the datas retrieved from the backend.
 */
export class Recipe {

	/**
	 * For now on, each recipe has an id, title and descrption, that are public. 
	 */
	id: number;
	title: string;
	description: string;
	numberPeople: number;
	recipeSteps: Step[];
	rating: number;
	tags: string[];
	imageUrl: string;
	user: User | null;

	constructor(id: number, title: string, description: string, numberPeople: number, recipeSteps: Step[], rating: number, imageUrl: string, tags: string[] = [], user: User | null) {
		// We set the id automatically with the static field, so it is auto incrementing.
		// this.id = Recipe.idCounter;
		// Recipe.idCounter++;
		this.id = id;
		this.user = user;
		this.rating = rating;

		// We create the recipe from the properties passed in parameters.
		this.title = title;
		this.description = description;
		this.numberPeople = numberPeople;
		this.recipeSteps = recipeSteps;
		this.rating = rating;
		// Default tags for now will be recommended and recent for when a recipe is created
		this.tags = tags.length ? tags : ["Recommended", "Recent"];

		// Picture
		this.imageUrl = imageUrl;

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