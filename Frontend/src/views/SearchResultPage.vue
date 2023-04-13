<script lang="ts">
import { API } from "@/model/apiCalls";
import type { Recipe } from "@/model/recipeModel";
import PageTitleComponent from "@/components/PageTitleComponent.vue";
import SearchResultsComponent from "@/components/SearchResultsComponent.vue";

export default {
    name: "SearchResultPage",
    components: {
        PageTitleComponent,
        SearchResultsComponent,
    },
    data(): {
        recipes: Array<Recipe>,
        matchingRecipes: Array<Recipe>,
        isUserAuthenticated: boolean,
        searchQuery: string,
    } {
        return {
            recipes: [],
            matchingRecipes: [],
            isUserAuthenticated: false,
            searchQuery: "",
        };
    },
    async created() {
        this.recipes = await API.instance.getRecipes();
        this.isUserAuthenticated = API.instance.isLoggedIn();
        this.searchQuery = this.$route.query.q as string;
        this.updateMatchingRecipes();
    },
    methods: {
        updateMatchingRecipes() {
            if (this.searchQuery) {
                this.matchingRecipes = this.recipes.filter((recipe) => {
                    const nameMatch = recipe.title.toLowerCase().includes(this.searchQuery.toLowerCase());
                    const descriptionMatch = recipe.description.toLowerCase().includes(this.searchQuery.toLowerCase());
                    const tagMatch = recipe.tags.includes(this.searchQuery.toLowerCase());
                    // Users will most likely look up "3 stars" or "1 star", this handles the stars/star ending
                    const ratingMatch = (this.searchQuery.toLowerCase().endsWith(" stars") && recipe.rating === parseInt(this.searchQuery.toLowerCase().replace(" stars", "")))
                        || (this.searchQuery.toLowerCase().endsWith(" star") && recipe.rating === parseInt(this.searchQuery.toLowerCase().replace(" star", "")));
                    return nameMatch || descriptionMatch || tagMatch || ratingMatch;
                });
            }
        },
        onSearch(query: string) {
            this.searchQuery = query;
            this.updateMatchingRecipes();
            this.$router.push({ query: { q: query } });
        },
        deleteRecipe(id: number) {
            this.recipes = API.instance.removeRecipe(id);
            this.updateMatchingRecipes();

        }
    },
    watch: {
        "$route.query.q"(newQuery: string) {
            this.searchQuery = newQuery;
            this.updateMatchingRecipes();
        }
    }

};
</script>

<template>
    <div class="contentContainer">
        <PageTitleComponent :text="`Search Results for '${$route.query.q}'`" />
        <SearchResultsComponent :recipes="matchingRecipes" @search="onSearch" @delete-recipe="deleteRecipe"
            :isUserAuthenticated="isUserAuthenticated" />
    </div>
</template>

<style>
.contentContainer {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    min-height: calc(100vh - 400px);
}
</style>
