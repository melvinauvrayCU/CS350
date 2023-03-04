import { Recipe } from "./recipeModel";
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
		new Recipe("Americain burger", "True og burger", 2, []),
	];

	/*
	Making a few users so that we can test to make sure that if I put in the wrong password it will not work
	and if a user is not defined then we need tell the user they need to sign up
	*/
	userList: User[] = [
		new User("Ava.Megyeri", "Password", "megyeram@clarkson.edu"),
		new User("petesupreme", "password1", "dorovip@clarkson.edu"),
		new User("a", "a", "a@clarkson.edu"),

	];
	currentUser: User = new User("", "", "");

	/** 
	 * variable to check if a user is logged in or not 
	 */
	loggedIn: boolean = false;

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
	createRecipe(recipeObject: Recipe): boolean {
		this.recipeList.push(recipeObject);
		console.log(this.recipeList);
		return true;
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
	 * get username
	 * 
	 */
	getUsername(): string {
		return this.currentUser.username;

	}

}

