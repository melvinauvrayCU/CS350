<script lang="ts">
import { API } from '@/model/apiCalls';
import type { Recipe } from '@/model/recipeModel';
import PageTitleComponent from '@/components/PageTitleComponent.vue';
import SearchResultsComponent from '@/components/SearchResultsComponent.vue';

export default {
    name: "SearchResultPage",
    components: {
        PageTitleComponent,
        SearchResultsComponent,
    },
    data(): {
        recipes: Array<Recipe>,
        matchingRecipes: Array<Recipe>,
        isAuthenticated: boolean,
    } {
        return {
            recipes: [],
            matchingRecipes: [],
            isAuthenticated: false
        };
    },
    created() {
        this.recipes= API.instance.getRecipes()
        this.isAuthenticated = API.instance.isLoggedIn();
        const searchQuery = this.$route.query.q as string;
        if (searchQuery) {
            this.matchingRecipes = this.recipes.filter((recipe) => {
                const nameMatch = recipe.title.toLowerCase().includes(searchQuery.toLowerCase());
                const descriptionMatch = recipe.description.toLowerCase().includes(searchQuery.toLowerCase());
                const tagMatch = recipe.tags.includes(searchQuery.toLowerCase());
                const ratingMatch = recipe.rating.toString().includes(searchQuery.toLowerCase());
                return nameMatch || descriptionMatch || tagMatch || ratingMatch;
            });
        } else {
            this.matchingRecipes = this.recipes;
        }
    },
}
</script>

<template>
    <div class="contentContainer">
        <PageTitleComponent text="Search Results" hello/>
        <SearchResultsComponent :recipes="matchingRecipes"/>

    </div>
</template>

<style>
.contentContainer {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}
</style>
