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

	constructor(title: string, description: string, numberPeople: number, steps: Step[]) {
		// We set the id automatically with the static field, so it is auto incrementing.
		this.id = Recipe.idCounter;
		Recipe.idCounter++;

		// We create the recipe from the properties passed in parameters.
		this.title = title;
		this.description = description;
		this.numberPeople = numberPeople;
		this.steps = steps;
	}
}

export type Step = {
	stepId: number,
	descriptionValue: string,
	cooktimeValue: string,
	preptimeValue: string,
}
