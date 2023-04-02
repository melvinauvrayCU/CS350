<script lang="ts">
import type { Recipe } from '@/model/recipeModel';
import RecipeListComponent from './RecipeListComponent.vue';

export default {
    name: "SearchResultsComponent",
    components: {
        RecipeListComponent,
    },
    props: {
        recipes: {
            type: Array as () => Recipe[],
            required: true,
        },
        isUserAuthenticated: {
            type: Boolean,
            required: true,
        }
    },
    data() {
        return {
            searchText: '',
        };
    },
    computed: {
        filteredRecipes(): Recipe[] {
            if (this.searchText.length === 0) {
                return this.recipes;
            }
            const searchTerms = this.searchText.toLowerCase().split(' ');
                return this.recipes.filter((recipe) => {
                    return searchTerms.some(term => {
                    const nameMatch = recipe.title.toLowerCase().includes(term);
                    const descriptionMatch = recipe.description.toLowerCase().includes(term);
                    const tagMatch = recipe.tags.some(tag => tag.toLowerCase().includes(term));
                    const ratingMatch = (this.searchText.toLowerCase().endsWith(' stars') && recipe.rating === parseInt(this.searchText.toLowerCase().replace(' stars', '')))
                                    || (this.searchText.toLowerCase().endsWith(' star') && recipe.rating === parseInt(this.searchText.toLowerCase().replace(' star', '')));
                    return nameMatch || descriptionMatch || tagMatch || ratingMatch;
            });
        });
        },
        queryText(): string {
            return this.$route.query.q as string;
        },
    },
    watch: {
        searchText() {
            this.$nextTick(() => {
                // Update the filtered recipes when the searchText changes
                // by emitting a search event with the new searchText
                this.$emit("search", this.searchText);
            })
        }
    },
    methods: {
        resetFilteredRecipes() {
            this.filteredRecipes = this.recipes;
        }
    },
    created() {
        this.resetFilteredRecipes();
    }
}
</script>

<template>
    <div class="containerText">
        <div v-if="filteredRecipes.length === 0 && searchText.length === 0">
            <h3>No matching recipes found.</h3>
        </div>
        <div v-else class="recipe-list-container">
            <RecipeListComponent 
            :recipes="filteredRecipes" 
            :isUserAuthenticated="isUserAuthenticated"
            @editRecipe="(recipe) => $emit('edit-recipe', recipe)" 
            @delete-recipe="(id) => $emit('delete-recipe', id)" />
        </div>
    </div>
</template>

<style scoped>
.recipe-list-container .recipe-list {
    align-items: center;
    flex-direction: column;
    overflow-y: auto;
    margin-top: 10px;
    margin-bottom: px;
    padding-right: 12px;
}
</style>