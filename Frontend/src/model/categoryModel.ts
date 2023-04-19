import type { Recipe } from "./recipeModel";
/**
 * Model of a category. Contains all necessary fields.
 * Used in apiCalls file format the datas retrieved from the backend.
 */
export class Category {
  /**
   * Static field to increment the id of the category so we can keep track of each one
   */
  private static idCounter: number = 0;

  /**
   * Each category will have an ID, title and an array of recipes and a tag to link recipes to a specific tag 
   */
  id: number;
  title: string;
  linkedRecipeList: Recipe[];
  // categoryTag: string;

  /**
   * Will create a new Category given a title and an option array of Recipes 
   * @param title 
   * @param linkedRecipeList 
   */
  constructor(title: string, linkedRecipeList: Recipe[]) {
    this.id = Category.idCounter;
    Category.idCounter++;

    this.title = title;
    this.linkedRecipeList = linkedRecipeList;
    // this.categoryTag = categoryTag;
    // Category will have an array of recipes or no array at all
    // this.linkedRecipeList = linkedRecipeList?.filter(linkedRecipeList => linkedRecipeList.tags.includes(categoryTag)) || [];
  }

  /**
   * Function will be used to add a recipe to a certain category
   * @param recipe 
   */
  // addRecipe(recipe: Recipe) {
  //   this.linkedRecipeList.push(recipe);
  // }

  /**
  * Function will remove a recipe from a certain category
  * @param recipe 
  */
  // removeRecipe(recipe: Recipe) {
  //   const index = this.linkedRecipeList.findIndex((r) => r.id === recipe.id);
  //   if (index !== -1) {
  //     this.linkedRecipeList.splice(index, 1);
  //   }
  // }
}