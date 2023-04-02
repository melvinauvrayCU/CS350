import { IngredientCat, Conversion } from "./PantryModels";
import { Category } from "./categoryModel";
import { Recipe, type Ingredient } from "./recipeModel";
import { User } from "./userModel";
import axios from "axios";
import NProgress from "nprogress";
import "nprogress/nprogress.css"; // Import NProgress CSS

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
		function hideProgressBar() {
			NProgress.done();
			const element = document.querySelector("header");
			if (element) {
				element.style.borderColor = "var(--color-accent)";
			}
		}
		if (!API._instance) {
			// Add a request interceptor
			axios.interceptors.request.use(function (config) {
				// Do something before request is sent
				NProgress.start();
				const element = document.querySelector("header");
				if (element) {
					element.style.borderColor = "var(--color-background)";
				}
				return config;
			}, function (error) {
				// Do something with request error
				console.error(error);
				hideProgressBar();
				return Promise.reject(error);
			});

			// Add a response interceptor
			axios.interceptors.response.use((response) => {
				// Do something with response data
				hideProgressBar();
				return response;
			}, function (error) {
				// Do something with response error
				console.error(error);
				hideProgressBar();
				return Promise.reject(error);
			});
			API._instance = new API();

		}
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
		}], 3, "https://www.photodoiso.fr/inc/image/oiseaux/1790.jpgT.jpg", ["Recommended", "Recent"]),
		new Recipe("French Burger", "A burger, but french", 1, [], 4, "", ["Highest Rated", "Frequently Cooked"]),
		new Recipe("Blueberry Pancakes", "Pancakes with blueberries", 3, [], 5, "", ["Recommended", "Highest Rated", "Recent", "Frequently Cooked"]),
		new Recipe("Pancakes", "Pancakes but plain", 3, [], 4, "", ["Highest Rated", "Recent"]),
	];
	// ingredientCatList: IngredientCat[] = [
	// 	new IngredientCat("I", "Protein", ["Beef", "Chicken"]),
	// 	new IngredientCat("I", "Dairy", ["Milk", "Cheese"]),
	// 	new IngredientCat("U", "Silverware", ["Spoon", "Knife"]),
	// 	new IngredientCat("U", "Electric Appliances", ["Blender", "Food Proccessor"]),
	// ];
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

	private _apiUrl: string = "https://www.api.cs350.melvinauvray.com/api/v1";

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

	/**
	 * Retrieve the list of ingredient categories of the connected user
	 */
	async getIngredientCats(): Promise<IngredientCat[]> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: IngredientCat[] = [];

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.get(this._apiUrl + "/ingredientcategories", {
				params: {
					userId: this.currentUser.id,
				}
			});

			/**
			 * As the returning datas may not exactly the format we want to have, we apply an extra format on them with this map method
			 * We will loop through the field data that is inside the field data that is in our response
			 * And we extract the name of each data, to create our final array
			 */
			returnDatas = (response.data.data).map((data: any) => {
				console.error(data);
				/** 
				 * Since we will populate our returning array that is of type Ingredient[],
				 * We make sure that this temp variable is of type Ingredient, so we don't push weird things into our array.
				 */
				const ingredientToReturn: IngredientCat = new IngredientCat(data.id, "I", data.name, data.ingredients);
				return ingredientToReturn;
			});
		} catch (error) {
			/** If we have an error, we log it */
			console.error(error);
		}
		/** We return our data */
		return returnDatas;
	}

	/**
	 * Delete an ingredient category
	 * @param id If of the ingredinet category to delete
	 */
	async removeIngredientCat(id: number): Promise<string | undefined> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: string | undefined;

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.delete(this._apiUrl + "/ingredientcategories/" + id);
			/**
			 * As the returning datas may not exactly the format we want to have, we apply an extra format on them with this map method
			 * We will loop through the field data that is inside the field data that is in our response
			 * And we extract the name of each data, to create our final array
			 */
			returnDatas = response.data.success;
		} catch (error: any) {
			/** If we have an error, we log it */
			return JSON.parse(error.request.response).message || JSON.parse(error.request.response).error;
		}
		/** We return our data */
		return returnDatas;
	}

	/**
	 * Create a new ingredient category
	 * @param name Name of the category
	 */
	async createIngredientCat(name: string): Promise<IngredientCat | string | undefined> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: IngredientCat | undefined;

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.post(this._apiUrl + "/ingredientcategories", {
				name: name,
				userId: this.currentUser.id
			});
			/**
			 * As the returning datas may not exactly the format we want to have, we apply an extra format on them with this map method
			 * We will loop through the field data that is inside the field data that is in our response
			 * And we extract the name of each data, to create our final array
			 */
			returnDatas = new IngredientCat(response.data.data.id, "I", response.data.data.name, []);
		} catch (error: any) {
			/** If we have an error, we log it */
			return JSON.parse(error.request.response).message;
		}
		/** We return our data */
		return returnDatas;
	}

	/**
	 * Remove an ingredient from a category
	 * @param idCategory Id of the category to remove the ingredient from
	 * @param idIngredient Id of the ingredient to remove
	 */
	async removeIngredient(idCategory: number, idIngredient: number): Promise<string | undefined> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: string | undefined;

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.delete(this._apiUrl + "/ingredients/" + idIngredient, {
				data: {
					ingredientCategory: idCategory
				}
			});
			/**
			 * As the returning datas may not exactly the format we want to have, we apply an extra format on them with this map method
			 * We will loop through the field data that is inside the field data that is in our response
			 * And we extract the name of each data, to create our final array
			 */
			returnDatas = response.data.success;
		} catch (error: any) {
			/** If we have an error, we log it */
			return JSON.parse(error.request.response).message || JSON.parse(error.request.response).error;
		}
		/** We return our data */
		return returnDatas;
	}

	/**
	 * Create an ingredient and attach it to a category.
	 * @param id id of the ingredient category
	 * @param name Name of the ingredient
	 */
	async createIngredient(id: number, name: string): Promise<Ingredient | string | undefined> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: Ingredient | undefined;

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.post(this._apiUrl + "/ingredients", {
				name: name,
				ingredientCategoryId: id
			});
			/**
			 * As the returning datas may not exactly the format we want to have, we apply an extra format on them with this map method
			 * We will loop through the field data that is inside the field data that is in our response
			 * And we extract the name of each data, to create our final array
			 */
			returnDatas = {
				id: response.data.data.id,
				name: response.data.data.name
			};
		} catch (error: any) {
			/** If we have an error, we log it */
			return JSON.parse(error.request.response).message;
		}
		/** We return our data */
		return returnDatas;
	}

	// ----UtensilCatagory Methods----

	createUtensilCat(name: string, utensils: Array<string>): IngredientCat[] | void {
		// this.ingredientCatList.push(new IngredientCat("U", name, utensils));
		// return this.ingredientCatList;
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

	/**
	 * Note that this method is async so we can await it somewhere else to wait for the datas.
	 */
	async getIngredientList(): Promise<Ingredient[]> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: Ingredient[] = [];

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.get(this._apiUrl + "/ingredients");

			/**
			 * As the returning datas may not exactly the format we want to have, we apply an extra format on them with this map method
			 * We will loop through the field data that is inside the field data that is in our response
			 * And we extract the name of each data, to create our final array
			 */
			returnDatas = (response.data.data).map((data: any) => {
				/** 
				 * Since we will populate our returning array that is of type Ingredient[],
				 * We make sure that this temp variable is of type Ingredient, so we don't push weird things into our array.
				 */
				const ingredientToReturn: Ingredient = { "id": data.id, "name": data.name };
				return ingredientToReturn;
			});
		} catch (error) {
			/** If we have an error, we log it */
			console.error(error);
		}
		/** We return our data */
		return returnDatas;
	}

	getUtensilList(): string[] {
		return this.utensilList;
	}


}

