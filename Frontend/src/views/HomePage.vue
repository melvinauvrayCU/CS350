<script lang="ts">
import type { Recipe } from "@/model/recipeModel";
import type { Category } from "@/model/categoryModel";
import { API } from "../model/apiCalls";
import CategoryListComponent from "@/components/CategoryListComponent.vue";
import SearchBarComponent from "@/components/SearchBarComponent.vue";
import MessageComponent from "@/components/MessageComponent.vue";

export default {
  name: "HomePage",
  // We using the recipe list component in this page
  components: {
    CategoryListComponent,
    SearchBarComponent,
    MessageComponent,
  },
  props: {
    messageTextParam: {
      type: String,
      default: ""
    },
    messageTypeParam: {
      type: String as () => "success" | "warning",
      default: "success"
    }
  },
  // For the data we will use the list of recipe.
  // This may have a strange look at first:
  // The first bracket is defining the type of the datas
  // and the return one is the datas themself. 
  // We don't initialize the recipes yet, we will do so in the created method.
  data(): {
    recipes: Array<Recipe>,
    categories: Array<Category>,
    messageText: string,
    messageType: "success" | "warning",
    isAuthenticated: boolean,
  } {
    return {
      recipes: [],
      categories: [],
      messageText: "",
      messageType: "success",
      isAuthenticated: false,
    };
  },
  methods: {
    /**
     * Method called when button in children components is clicked.
     * It does the API call to remove a recipe.
     * @param id id of the recipe you want to delete
     */
    deleteRecipe(id: number) {
      // Show a success message when the recipe is deleted
      this.messageText = "Recipe deleted sucessfully"
      this.messageType = "success"
      this.recipes = API.instance.removeRecipe(id);
    },
    handleSearch(searchText: string) {
      console.log("Performing search for:", searchText);
    }
  },
  /**
   * This method is called when this page is displayed.
   * We want to load the datas from the API, so we retrieve the list of recipes.
   */
  created() {
    this.categories = API.instance.getCategories();
    this.recipes = API.instance.getRecipes();
    this.isAuthenticated = API.instance.isLoggedIn();
  },
  /**
   * We use mounted because we want to init these two variables after the page being created
   */
  mounted() {
    this.messageText = this.messageTextParam;
    this.messageType = this.messageTypeParam;
  }
};
</script>

<template>
  <main>
    <div>
      <SearchBarComponent @search="handleSearch" />
    </div>
    <div>
      <CategoryListComponent :categories="categories" :recipes="recipes" @delete-recipe="deleteRecipe"
        :isUserAuthenticated="isAuthenticated" />
    </div>

    <MessageComponent :type="messageType" v-model="messageText" />
  </main>
</template>