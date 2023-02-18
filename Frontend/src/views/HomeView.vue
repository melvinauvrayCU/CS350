<script lang="ts">
import type { Recipe } from "@/model/recipeModel";
import TheWelcome from "../components/TheWelcome.vue";
import { API } from "../model/apiCalls";

export default {
  name: "HomeView",
  components: {
    TheWelcome
  },
  data(): {
    recipes: Array<Recipe>,
  } {
    return {
      recipes: []
    };
  },
  created() {
    this.recipes = API.getRecipes();
  }
};

</script>

<template>
  <main>
    <TheWelcome />

    <div :key="recipe.title" v-for="recipe in recipes">
      <p>{{ recipe.title }}</p>
    </div>
  </main>
</template>

