import { IngredientCat, Conversion } from "./PantryModels";
import { Recipe } from "./recipeModel";

/**
 * API Class, it will contain all the methods that will interact with the Backend / Datas.
 * This class will be using singleton design pattern, 
 * therefore we will be able to access it wherever in the app with the same set of data associated.
 * 
 * In order to use one of its method, just call API.instance.yourMethod();
 */
export class API {

	// * ----------- Singleton design pattern ------------------------
	// We set this as private so it is not possible to init the class without using the singleton design pattern
	private constructor() { }

	// Private static variable that will be the API instance
	private static _instance: API;

	// Method to retrieve the API instance outside of this class
	public static get instance(): API {
		if (!API._instance)
			API._instance = new API();
		return API._instance;
	}
	/* ----------- End of Singleton design pattern ------------------------ */


	/**
	 * List of all recipes, this is temporary because we don't have the backend setup yet.
	 * Its type is an array of Recipe class, defined in another file.
	 * When backend is setup, datas will be stored in external database and will be retrieved using the different methods.
	 * 
	 * But for now we need to use that to act like a local database.
	 * But obviously we will not have any persistency of our datas when reloading the website.
	 */
	recipeList: Recipe[] = [
		new Recipe("Americain burger", "True og burger"),
		new Recipe("French burger", "Same burger, but better"),
	];
	ingredientCatList: IngredientCat[] = [
		new IngredientCat("I", "Protein", ["Beef", "Chicken"]),
		new IngredientCat("I", "Dairy", ["Milk", "Cheese"]),
		new IngredientCat("U", "Silverware", ["Spoon", "Knife"]),
		new IngredientCat("U", "Electric Appliances", ["Blender", "Food Proccessor"]),
	];
	utensilCatList: IngredientCat[] = [

	];
	alergies: string[] = [
		"Milk",
		"Clarkson"
	];
	unitOptions: string[] = [
		"Cups",
		"Gallons",
	];
	conversion: Conversion = new Conversion(1,"");

	// * ------------------- Start of the API call methods ------------------------

	/**
	 * Return the full list of recipes.
	 */
	getRecipes(): Recipe[] {
		return this.recipeList;
	}

	/**
	 * Remove a recipe with the specified id in paramter and returns the new full list of recipes. 
	 * @param id The id of the recipe you want to delete
	 */
	removeRecipe(id: number): Recipe[] {
		this.recipeList = this.recipeList.filter(recipe => recipe.id !== id);
		return this.recipeList;
	}

	/**
	 * Create a new recipe with the datas you're giving in parameter. 
	 * Does not return anything for now, but It may return the request status when the backend will be up.
	 * @param title Title of the recipe
	 * @param description Description of the recipe.
	 */
	createRecipe(title: string, description: string): void {
		this.recipeList.push(new Recipe(title, description));
	}

// ----IngredientCatagory Methods----

getIngredientCats(): IngredientCat[] {
	return this.ingredientCatList;
}

removeIngredientCat(id: number): IngredientCat[] {
	this.ingredientCatList = this.ingredientCatList.filter(ingredientcat => ingredientcat.id !== id);
	return this.ingredientCatList;
}

createIngredientCat(name: string, ingredients: Array<string>): IngredientCat[] {
	this.ingredientCatList.push(new IngredientCat("I", name, ingredients));
	return this.ingredientCatList;
}

getIngredientCat(id: number): IngredientCat {
	return this.ingredientCatList.filter(ingredientcat => ingredientcat.id == id)[0];
}

removeIngredient(id: number, name: string): IngredientCat[] {
	const templist: IngredientCat[] = this.ingredientCatList.filter(ingredientcat => ingredientcat.id !== id);
	const temp: IngredientCat = this.ingredientCatList.filter(ingredientcat => ingredientcat.id == id)[0];
	temp.ingredients = temp.ingredients.filter(ingredient => ingredient !== name);
	templist.push(temp);
	this.ingredientCatList = templist;
	return this.ingredientCatList;
}

createIngredient(id: number, name: string): IngredientCat[] {
	const templist: IngredientCat[] = this.ingredientCatList.filter(ingredientcat => ingredientcat.id !== id);
	const temp: IngredientCat = this.ingredientCatList.filter(ingredientcat => ingredientcat.id == id)[0];
	temp.ingredients.push(name);
	templist.push(temp);
	this.ingredientCatList = templist;
	return this.ingredientCatList;
}

// ----UtensilCatagory Methods----

createUtensilCat(name: string, utensils: Array<string>): IngredientCat[] {
	this.ingredientCatList.push(new IngredientCat("U", name, utensils));
	return this.ingredientCatList;
}

//----Allergy Methods----

getAllergies(): string[] {
	return this.alergies;
}

removeAllergy(name: string) : string[] {
this.alergies = this.alergies.filter(allergy => allergy !== name);
	return this.alergies;
}

createAllergy(name: string) : void {
	this.alergies.push(name);
}

//----Conversion Methods----

getUnitOptions() : string[] {
	return this.unitOptions;
}

changePeopleEating(people: number) : void {
	this.conversion.people = people;
}

changeUnitConversion(unit: string) : void {
	this.conversion.unit = unit;
}

}
