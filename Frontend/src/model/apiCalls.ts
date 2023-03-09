import { IngredientCat, Conversion } from "./PantryModels";
import { Category } from "./categoryModel";
import { Recipe, type Ingredient } from "./recipeModel";
import { User } from "./userModel";

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
		new Recipe("Americain burger", "The best burger you will ever eat", 2, [{
			stepId: 0,
			descriptionValue: "Cook the steak",
			cooktimeValue: "12:00",
			preptimeValue: "02:00",
			ingredients: [],
			utensils: []
		},
		{
			stepId: 1,
			descriptionValue: "Cook the onions",
			cooktimeValue: "16:00",
			preptimeValue: "02:00",
			ingredients: [],
			utensils: []
		},
		{
			stepId: 2,
			descriptionValue: "Put steak and onions inside bread",
			cooktimeValue: "00:00",
			preptimeValue: "02:00",
			ingredients: [],
			utensils: []
		}], 3, ["Recommended", "Recent"]),
		new Recipe("French Burger", "A burger, but french", 1, [], 4, ["Highest Rated", "Frequently Cooked"]),
		new Recipe("Blueberry Pancakes", "Pancakes with blueberries", 3, [], 5, ["Recommended", "Highest Rated", "Recent", "Frequently Cooked"]),
		new Recipe("Pancakes", "Pancakes but plain", 3, [], 4, ["Highest Rated", "Recent"]),
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
	];
	unitOptions: string[] = [
		"Cups",
		"Gallons",
	];
	conversion: Conversion = new Conversion(1, "");

	/*
	Making a few users so that we can test to make sure that if I put in the wrong password it will not work
	and if a user is not defined then we need tell the user they need to sign up
	*/
	userList: User[] = [
		new User("Ava.Megyeri", "Password", "megyeram@clarkson.edu"),
		new User("petesupreme", "password1", "dorovip@clarkson.edu"),
		new User("a", "a", "a@clarkson.edu"),
		new User("Melvin Auvray", "melvin", "auvraym@clarkson.edu"),

	];
	currentUser: User = new User("", "", "");

	/** 
	 * variable to check if a user is logged in or not 
	 */
	loggedIn: boolean = false;

	/**
	 * List of all Categories, this is temporary because we don't have the backend setup yet.
	 * Its type is an array of Category class, defined in another file.
	 * Will have a title and an array of recipes associated with category
	 */
	categoryList: Category[] = [
		new Category("Recommended", "Recommended", this.recipeList),
		new Category("Highest Rated", "Highest Rated", this.recipeList),
		new Category("Recent", "Recent", this.recipeList),
		new Category("Frequently Cooked", "Frequently Cooked", this.recipeList,),
	];

	ingredientList: Ingredient[] = [
		{ name: "Salt", quantity: "", unit: "g" },
		{ name: "Beef", quantity: "", unit: "g" },
		{ name: "Pepper", quantity: "", unit: "g" },
		{ name: "Butter", quantity: "", unit: "g" },
		{ name: "Cheddar", quantity: "", unit: "g" },
		{ name: "Bread", quantity: "", unit: "g" },
		{ name: "Onion", quantity: "", unit: "g" }
	];

	utensilList: string[] = [
		"Chef's knife",
		"Cutting board",
		"Mixing bowls",
		"Wooden spoon",
		"Measuring cups and spoons",
		"Whisk",
		"Tongs",
		"Spatula",
		"Oven mitts",
		"Colander",
	];

	// * ------------------- Start of the API call methods ------------------------

	/**
	 * Return the full list of recipes.
	 */
	getRecipes(): Recipe[] {
		return this.recipeList;
	}

	/**
	 * Return the full list of categories
	 */
	getCategories(): Category[] {
		return this.categoryList;
	}

	getRecipe(id: number): Recipe | undefined {
		const recipeObj = this.recipeList.find((recipe) => recipe.id === id);
		if (recipeObj === undefined)
			return undefined;
		return JSON.parse(JSON.stringify(recipeObj));
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
	createRecipe(recipeObject: Recipe): boolean {
		this.recipeList.push(recipeObject);
		recipeObject.tags.forEach((tag) => {
			const categoryIndex = this.categoryList.findIndex((category) => category.categoryTag === tag);
			if (categoryIndex > -1) {
				this.categoryList[categoryIndex].linkedRecipeList.push(recipeObject);
			} else {
				const newCategory = new Category(tag, tag, [recipeObject]);
				this.categoryList.push(newCategory);
			}
		});
		console.log(this.recipeList);
		return true;
	}

	/**
	 * Edit a recipe
	 * @param recipeId Id of the recipe to be edited
	 * @param recipeObj New recipe object to replace the old one
	 */
	editRecipe(recipeId: number, recipeObj: Recipe): boolean {
		this.recipeList = this.recipeList.map(recipe => {
			// We go through all recipes, if the id is the one we're looking for then we return the new obj, else the old obj
			if (recipe.id === recipeId) {
				return recipeObj;
			} else {
				return recipe;
			}
		});
		return true;
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

	removeAllergy(name: string): string[] {
		this.alergies = this.alergies.filter(allergy => allergy !== name);
		return this.alergies;
	}

	createAllergy(name: string): void {
		this.alergies.push(name);
	}

	//----Conversion Methods----

	getUnitOptions(): string[] {
		return this.unitOptions;
	}

	changePeopleEating(people: number): void {
		this.conversion.people = people;
	}

	changeUnitConversion(unit: string): void {
		this.conversion.unit = unit;
	}

	/**
	 * Login a user: The user needs to enter their username and password. If username matches the password they are logged in
	 * @param username username 
	 * @param password password 
	 */
	login(username: string, password: string): boolean {
		if (this.userList.find(user => user.password === password && (user.username === username || user.email === username))) {
			console.warn(`Welcome back ${username}`);
			const temp = this.userList.find(user => user.username === username || user.email === username);
			if (temp !== undefined) this.currentUser = temp;
			this.loggedIn = true;
			return true;
		} else {
			console.warn("Error!");
			return false;
		}

	}


	/**
	 * Signup a user: User needs to enter the username, password, and email. If the username is already taken then
	 * they need a new username. Password must be longer than 6 characters long
	 * @param username username user creates
	 * @param password password the user creates
	 * @param email email the user puts it
	 */
	signup(email: string, username: string, password: string): boolean {
		if (this.userList.find(user => user.email === email) || this.userList.find(user => user.username === username)) {
			console.log("Email or username already taken");
			return false;
		} else {

			this.userList.push(new User(email, username, password));
			console.log("User created!");
			this.loggedIn = true;
			return true;
		}


	}

	/**
	 * checks if the user is logged in or not
	 * 
	 */
	isLoggedIn(): boolean {
		return this.loggedIn;
	}

	logout(): boolean {
		this.loggedIn = false;
		return true;
	}




	/**
	 * Goes through the users attributes and updates the first name, last name, username, and bio
	 */
	updateProfile(fname: string, lname: string, username: string, bio: string): boolean {
		if (this.userList.find(user => user.username === username)) {
			if (this.currentUser.username === username) {
				this.currentUser.fname = fname;
				this.currentUser.lname = lname;
				this.currentUser.username = username;
				this.currentUser.bio = bio;
				return true;

			}

			console.log("username already taken");
			return false;
		}

		this.currentUser.fname = fname;
		this.currentUser.lname = lname;
		this.currentUser.username = username;
		this.currentUser.bio = bio;


		return true;

	}

	/**
	 * Returns the current user to easily get their attributes
	 */

	getUser(): User {
		return this.currentUser;

	}

	getIngredientList(): Ingredient[] {
		return this.ingredientList;
	}

	getUtensilList(): string[] {
		return this.utensilList;
	}


}

