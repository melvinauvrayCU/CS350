import { IngredientCat, Conversion, Unit } from "./PantryModels";
import { Category } from "./categoryModel";
import { Recipe, Ingredient } from "./recipeModel";
import type { Step } from "./recipeModel";
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

	alergies: string[] = [
		"Milk",
	];
	unitOptions: Unit[] = [
		new Unit("W", "Lbs", 453.592, 0.00220462),
		new Unit("W", "Oz", 28.3495, 0.035274),
		new Unit("V", "Tbsp", 0.0147868, 67.628),
		new Unit("V", "Tsp", 0.00492892, 202.884),
		new Unit("V", "C", 0.236588, 4.22675),
		new Unit("V", "G", 3.78541, 0.264172),
		new Unit("W", "kg", 1000, 0.001),
		new Unit("W", "g", 1, 1),
		new Unit("W", "mg", 0.001, 1000),
		new Unit("V", "l", 1, 1),
		new Unit("V", "ml", 0.001, 1000),

	];
	conversion: Conversion = new Conversion(0, "", "");

	/** 
	 * variable to check if a user is logged in or not 
	 */
	loggedIn: boolean = false;

	private _apiUrl: string = "https://www.api.cs350.melvinauvray.com/api/v1";
	private _apiUrlshort: string = "https://www.api.cs350.melvinauvray.com/api";
	// * ------------------- Start of the API call methods ------------------------

	/**
	 * Return the full list of recipes.
	 */
	async getRecipes(): Promise<Recipe[]> {
		try {
			// Make an API call to retrieve all recipes
			const response = await axios.get(this._apiUrl + "/recipes");
			console.log(response);
			// Extract the recipe data from the response and map it to an array of Recipe objects
			const recipes = response.data.data.map((recipe: any) => ({
				id: recipe.id,
				title: recipe.title,
				description: recipe.description,
				numberPeople: recipe.numberPeople,
				rating: recipe.rating,
				imageUrl: recipe.imageUrl,
				userId: recipe.user.id,
				recipeSteps: recipe.recipeSteps.map((step: any) => ({
					description: step.description,
					cookTime: step.cook_time,
					prepTime: step.prep_time,
					ingredients: step.ingredients?.map((ingredient: any) => ({
						name: ingredient.name
					})),
					utensils: step.utensils?.map((utensil: any) => ({
						name: utensil.name
					}))
				}))
			}));

			return recipes;
		} catch (error: any) {
			console.error(error);
			return [];
		}
	}



	/**
	 * Return the full list of categories
	 */
	async getCategories(): Promise<Category[]> {
		const returnDatas: Category[] = [];
		try {

			const response = await axios.get(this._apiUrl + "/recipecategories");

			response.data.data.map((cat: any) => {
				returnDatas.push(new Category(
					cat.name,
					cat.recipes.map((recipe: any) => {
						return new Recipe(
							recipe.id,
							recipe.title,
							recipe.description,
							recipe.numberPeople,
							recipe.recipeSteps.map((step: any) => {
								const stepTemp: Step = {
									stepId: step.id,
									descriptionValue: step.description,
									cooktimeValue: step.cookTime,
									preptimeValue: step.prepTime,
									ingredients: step.ingredients.map((ingredient: any) => {
										return new Ingredient(
											ingredient.name,
											ingredient.quantity,
											ingredient.measurement,
											ingredient.id
										);
									}),
									utensils: step.utensils.map((utensil: any) => {
										return utensil.name;
									}),
								};
								return stepTemp;
							})
							,
							recipe.rating,
							recipe.imageUrl,
							[] // tags
							,
							recipe.user.id // Add more infos here ?
						);
					})
				))
			});

		} catch (error: any) {
			console.error(error);
		}
		return returnDatas;
	}

	/**
	 * get a specific recipe
	 * @param id 
	 * @returns 
	 */
	async getRecipe(id: number): Promise<Recipe | null> {
		console.error("test", id);
		try {
			// Make an API call to retrieve the recipe by its ID
			const response = await axios.get(this._apiUrl + "/recipes/" + id);
			console.error(response);

			// Extract the recipe data from the response and map it to a Recipe object
			const recipe = response.data.data;
			console.log(recipe);

			return new Recipe(
				recipe.id,
				recipe.title,
				recipe.description,
				recipe.numberPeople,
				recipe.recipeSteps.map((step: any) => {
					const stepTemp: Step = {
						stepId: step.id,
						descriptionValue: step.description,
						cooktimeValue: step.cookTime,
						preptimeValue: step.prepTime,
						ingredients: step.ingredients.map((ingredient: any) => {
							return new Ingredient(
								ingredient.name,
								ingredient.quantity,
								ingredient.measurement,
								ingredient.id
							);
						}),
						utensils: step.utensils.map((utensil: any) => {
							return utensil.name;
						}),
					};
					return stepTemp;
				})
				,
				recipe.rating,
				recipe.imageUrl,
				[] // tags
				,
				recipe.user.id // Add more infos here ?
			);
		} catch (error: any) {
			console.log(error);
			return null;
		}
	}






	/**
	 * Remove a recipe with the specified id in paramter and returns the new full list of recipes. 
	 * @param id The id of the recipe you want to delete
	 */
	async removeRecipe(id: number): Promise<string | undefined> {
		let returnDatas: string | undefined;
		try {
			const response = await axios.delete(this._apiUrl + "/recipes/" + id);
			returnDatas = response.data.success;
			console.error(returnDatas, response.data.success, response);
		} catch (error: any) {
			return JSON.parse(error.request.response).message || JSON.parse(error.request.response).error;
		}

		return returnDatas;
	}



	/**
	 * Create a new recipe with the datas you're giving in parameter. 
	 * Does not return anything for now, but It may return the request status when the backend will be up.
	 * @param title Title of the recipe
	 * @param description Description of the recipe.
	 */
	async createRecipe(recipe: Recipe): Promise<boolean> {
		try {
			const formData = new FormData();
			const responseImg = await fetch(recipe.imageUrl); // This is probably a terrible way to pass an image through 2 local files
			const imageData = await responseImg.blob();
			const imageFile = new File([imageData], 'image.jpg', { type: 'image/jpeg' });
			formData.append('image_url', imageFile);
			formData.append('title', recipe.title);
			formData.append('description', recipe.description);
			formData.append('number_people', recipe.numberPeople.toString());
			formData.append('rating', recipe.rating.toString());
			if (this.currentUser)
				formData.append('user_id', this.currentUser.id.toString());

			// Add the recipe steps to the FormData object
			recipe.recipeSteps.forEach((recipeStep, index) => {
				formData.append(`recipe_steps[${index}][description]`, recipeStep.descriptionValue);
				formData.append(`recipe_steps[${index}][prep_time]`, recipeStep.preptimeValue);
				formData.append(`recipe_steps[${index}][cook_time]`, recipeStep.cooktimeValue);

				// Add the ingredients to the FormData object
				recipeStep.ingredients.forEach((ingredient, i) => {
					formData.append(`recipe_steps[${index}][ingredients][${i}][name]`, ingredient.name);
					formData.append(`recipe_steps[${index}][ingredients][${i}][quantity]`, ingredient.quantity?.toString() ?? "");
					formData.append(`recipe_steps[${index}][ingredients][${i}][measurement]`, ingredient.unit ?? "");
				});

				// Add the utensils to the FormData object
				recipeStep.utensils.forEach((utensil, i) => {
					formData.append(`recipe_steps[${index}][utensils][${i}][name]`, utensil);
				});
			});
			await axios.post(this._apiUrl + "/recipes", formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
			return true;
		} catch (error: any) {
			console.error(error);
		}
		return false;
	}

	/**
	 * Edit a recipe
	 * @param recipeId Id of the recipe to be edited
	 * @param recipeObj New recipe object to replace the old one
	 */
	async editRecipe(recipe: Recipe): Promise<boolean> {
		try {
			const formData = new FormData();
			const responseImg = await fetch(recipe.imageUrl); // This is probably a terrible way to pass an image through 2 local files
			const imageData = await responseImg.blob();
			if (imageData.type == 'image/jpeg') {
				const imageFile = new File([imageData], 'image.jpg', { type: 'image/jpeg' });
				formData.append('image_url', imageFile);
			} else {
				formData.append('image_url', '');
			}

			formData.append('title', recipe.title);
			formData.append('description', recipe.description);
			formData.append('number_people', recipe.numberPeople.toString());
			formData.append('rating', recipe.rating.toString());
			if (this.currentUser)
				formData.append('user_id', this.currentUser.id.toString());

			// Add the recipe steps to the FormData object
			recipe.recipeSteps.forEach((recipeStep, index) => {
				formData.append(`recipe_steps[${index}][description]`, recipeStep.descriptionValue);
				formData.append(`recipe_steps[${index}][prep_time]`, recipeStep.preptimeValue);
				formData.append(`recipe_steps[${index}][cook_time]`, recipeStep.cooktimeValue);

				// Add the ingredients to the FormData object
				recipeStep.ingredients.forEach((ingredient, i) => {
					formData.append(`recipe_steps[${index}][ingredients][${i}][name]`, ingredient.name);
					formData.append(`recipe_steps[${index}][ingredients][${i}][quantity]`, ingredient.quantity?.toString() ?? "");
					formData.append(`recipe_steps[${index}][ingredients][${i}][measurement]`, ingredient.unit ?? "");
				});

				// Add the utensils to the FormData object
				recipeStep.utensils.forEach((utensil, i) => {
					formData.append(`recipe_steps[${index}][utensils][${i}][name]`, utensil);
				});
			});

			formData.append('_method', 'PUT');
			await axios.post(this._apiUrl + "/recipes/" + recipe.id, formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
			return true;
		} catch (error: any) {
			console.log(error);
			return false;
		}
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
					userId: this.currentUser?.id,
				}
			});

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
				const ingredientToReturn: IngredientCat = new IngredientCat(data.id, "I", data.name, data.ingredients);
				return ingredientToReturn;
			});
		} catch (error) {
			/** If we have an error, we log it */
			console.error(error);
		}

		// Now utensils turn
		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.get(this._apiUrl + "/utensilcategories", {
				params: {
					userId: this.currentUser?.id,
				}
			});
			/**
			 * As the returning datas may not exactly the format we want to have, we apply an extra format on them with this map method
			 * We will loop through the field data that is inside the field data that is in our response
			 * And we extract the name of each data, to create our final array
			 */
			returnDatas.push(...(response.data.data).map((data: any) => {
				/** 
				 * Since we will populate our returning array that is of type Ingredient[],
				 * We make sure that this temp variable is of type Ingredient, so we don't push weird things into our array.
				 */
				const utensilToReturn: IngredientCat = new IngredientCat(data.id, "U", data.name, data.utensils);
				return utensilToReturn;
			}));
			console.error(returnDatas);
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
	 * Delete an utensil category
	 * @param id Id of the utensil category to delete
	 */
	async removeUtensilCat(id: number): Promise<string | undefined> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: string | undefined;

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.delete(this._apiUrl + "/utensilcategories/" + id);
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
				userId: this.currentUser?.id
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
	 * Remove an Utensil from a category
	 * @param idCategory Id of the category to remove the utensil from
	 * @param idUtensil Id of the utensil to remove
	 */
	async removeUtensil(idCategory: number, idUtensil: number): Promise<string | undefined> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: string | undefined;

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.delete(this._apiUrl + "/utensils/" + idUtensil, {
				data: {
					utensilCategory: idCategory
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
	/**
	 * Create an utensil and attach it to a category.
	 * @param id id of the utensil category
	 * @param name Name of the utensil
	 */
	async createUtensil(id: number, name: string): Promise<Ingredient | string | undefined> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: Ingredient | undefined;

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.post(this._apiUrl + "/utensils", {
				name: name,
				utensilCategoryId: id
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

	async createUtensilCat(name: string): Promise<IngredientCat | string | undefined> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: IngredientCat | undefined;

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.post(this._apiUrl + "/utensilcategories", {
				name: name,
				userId: this.currentUser?.id
			});
			/**
			 * As the returning datas may not exactly the format we want to have, we apply an extra format on them with this map method
			 * We will loop through the field data that is inside the field data that is in our response
			 * And we extract the name of each data, to create our final array
			 */
			returnDatas = new IngredientCat(response.data.data.id, "U", response.data.data.name, []);
		} catch (error: any) {
			/** If we have an error, we log it */
			return JSON.parse(error.request.response).message;
		}
		/** We return our data */
		return returnDatas;
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

	getUnitOptions(): Unit[] {
		return this.unitOptions;
	}

	changePeopleEating(people: number): void {
		this.conversion.people = people;
	}

	changeUnitWeightConversion(unitWeight: string): void {
		this.conversion.unitWeight = unitWeight;
	}

	changeUnitVolumeConversion(unitVolume: string): void {
		this.conversion.unitVolume = unitVolume;
	}

	getConversions(): Conversion {
		return this.conversion;
	}

	/**
	 * Login a user: The user needs to enter their username and password. If username matches the password they are logged in
	 * @param username username 
	 * @param password password 
	 */


	async login(email: string, password: string): Promise<boolean> {
		try {
			const response = await axios.post(this._apiUrlshort + "/login", {
				email: email,
				password: password,
			});
			console.log(response);
			this.currentUser = new User(
				response.data.user.name,
				response.data.token,
				response.data.user.email,
				response.data.user.id,
				response.data.user.fname,
				response.data.user.lname,
				response.data.user.bio
			);
			return true;
		} catch (error: any) {
			console.log(error);
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
	currentUser: User | null = null;

	async signup(email: string, username: string, password: string, security_answer_1: string, security_answer_2: string, security_answer_3: string, security_question_1: string, security_question_2: string, security_question_3: string,
		firstname: string,
		lastname: string,
		bio: string): Promise<boolean> {
		try {
			const response = await axios.post(this._apiUrlshort + "/register", {
				name: username,
				bio: bio,
				fname: firstname,
				lname: lastname,
				email: email,
				password: password,
				password_confirmation: password,
				security_answer_1: security_answer_1,
				security_answer_2: security_answer_2,
				security_answer_3: security_answer_3,
				security_question_1: security_question_1,
				security_question_2: security_question_2,
				security_question_3: security_question_3
			});
			console.log(response);
			this.currentUser = new User(
				response.data.user.name,
				response.data.token,
				response.data.user.email,
				response.data.user.id,
				response.data.user.fname,
				response.data.user.lname,
				response.data.user.bio
			);
			return true;
		} catch (error: any) {
			return false;
		}
	}

	/**
	 * checks if the user is logged in or not
	 * 
	 */
	isLoggedIn() {
		return !(this.currentUser == null);
	}

	async logout() {
		try {
			console.error(this.currentUser)
			const response = await axios.post(this._apiUrlshort + "/logout", null, {
				headers: { Authorization: `Bearer ${this.currentUser?.token}` }
			});
			console.log(response);
			console.log({ Authorization: `Bearer ${this.currentUser?.token}` });
			return response.data;
		} catch (error: any) {
			throw new Error(error.response.data.message);
		}
	}




	/**
	 * Goes through the users attributes and updates the first name, last name, username, and bio
	 */

	async updateProfile(): Promise<boolean> {
		try {
			const user_id = this.currentUser?.id;
			const response = await axios.put(`{this._apiUrlshort}+ "/user/${user_id}/edit`, this.currentUser, {
				headers: {
					Authorization: `Bearer ${this.currentUser?.token}`
				}
			});
			console.log(this.currentUser);
			console.log(response.data);
			return true;
		} catch (error: any) {
			throw new Error(error.response.data.message);
			return false;
		}
	}

	async changePassword(newPassword: string, securityQuestion: string, securityAnswer: string): Promise<void> {
		const user_id = this.currentUser?.id;
		const token = this.currentUser?.token;
		try {
			const response = await axios.put(`${this._apiUrlshort}/user/${user_id}/change_password`, {
				newPassword,
				securityQuestion,
				securityAnswer,
			}, {
				headers: {
					Authorization: `Bearer ${token}`
				}
			});
			return response.data;
		} catch (error: any) {
			throw new Error(error.response.data.message);
		}
	}

	async getSecurityQuestions(): Promise<string[]> {
		try {
			const response = await axios.get(`${this._apiUrlshort}/security-questions`);
			console.error("getSecurityQuestions request", response)
			return response.data.data;
		} catch (error: any) {
			return [];
		}
	}



	/**
	 * Returns the current user to easily get their attributes
	 */

	getUser() {
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
				const ingredientToReturn: Ingredient = { "name": data.name, "id": data.id };
				return ingredientToReturn;
			});
		} catch (error) {
			/** If we have an error, we log it */
			console.error(error);
		}
		/** We return our data */
		return returnDatas;
	}

	async getUtensilList(): Promise<string[]> {
		/** We prepare the returning datas. We make sure to set them to the correct type. */
		let returnDatas: string[] = [];

		try {
			/** 
			 * We do the API call to the correct endpoint using the correct method and a body if needed 
			 * We use await to make sure to wait till we have all the datas, that we store in the reponse variable.
			*/
			const response = await axios.get(this._apiUrl + "/utensils");

			/**
			 * As the returning datas may not exactly the format we want to have, we apply an extra format on them with this map method
			 * We will loop through the field data that is inside the field data that is in our response
			 * And we extract the name of each data, to create our final array
			 */
			returnDatas = (response.data.data).map((data: any) => {
				return data.name;
			});
		} catch (error) {
			/** If we have an error, we log it */
			console.error(error);
		}
		/** We return our data */
		return returnDatas;
	}

	/**
	 * Reset password
	 */
	resetPassword(username: string, newPassword: string) {
		const userIndex = this.userList.findIndex(user => user.username === username);
		if (userIndex > -1) {
			this.userList[userIndex].password = newPassword;
			return "success";
		} else {
			return "failure";
		}
	}

}

