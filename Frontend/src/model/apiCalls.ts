import { Recipe } from "./recipeModel";

export class API {
	static recipeList: Recipe[] = [
		new Recipe("Title1", "desc1"),
		new Recipe("title2", "desc2"),
	];

	static getRecipes(): Recipe[] {
		return this.recipeList;
	}
}
