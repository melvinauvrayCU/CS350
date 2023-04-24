<script lang="ts">
import type { Category } from "@/model/categoryModel";
import { API } from "../model/apiCalls";
import CategoryListComponent from "@/components/CategoryListComponent.vue";
import MessageComponent from "@/components/MessageComponent.vue";

export default {
  name: "HomePage",
  // We using the recipe list component in this page
  components: {
    CategoryListComponent,
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
    categories: Array<Category>,
    messageText: string,
    messageType: "success" | "warning",
    isAuthenticated: boolean,
  } {
    return {
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
    async deleteRecipe(id: number) {
      console.log("Remove recipe " + id);
      const returnMessage = await API.instance.removeRecipe(id);
      if (returnMessage !== undefined) {
        if (returnMessage === "recipe deleted successfully") {
          this.messageType = "success";

          this.categories = await API.instance.getCategories();
        } else {
          this.messageType = "warning";
        }
        console.log("Deleting recipe with ID:", id);
        this.messageText = returnMessage;
      }
      // this.recipes = await API.instance.getRecipes();
    },
    handleSearch(searchText: string) {
      console.log("Performing search for:", searchText);
    },

  },
  /**
   * This method is called when this page is displayed.
   * We want to load the datas from the API, so we retrieve the list of recipes.
   */
  async created() {
    this.categories = await API.instance.getCategories();
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
      <CategoryListComponent :categories="categories" @delete-recipe="deleteRecipe"
        :isUserAuthenticated="isAuthenticated" />
    </div>

    <div v-if="categories.length === 0" class="loader"></div>

    <MessageComponent :type="messageType" v-model="messageText" />
  </main>
</template>

<style scoped>
.loader {
  border: 12px solid #fff;
  border-radius: 50%;
  border-top: 12px solid var(--color-accent);
  width: 100px;
  height: 100px;
  animation: spin 1s linear infinite;
  margin: 50px auto 200px auto;
}

@keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}
</style>