<script lang="ts">
import { API } from "@/model/apiCalls";
import type { Recipe } from "@/model/recipeModel";
import PageTitleComponent from "@/components/PageTitleComponent.vue";
import SearchResultsComponent from "@/components/SearchResultsComponent.vue";
import MessageComponent from "@/components/MessageComponent.vue";

export default {
    name: "SearchResultPage",
    components: {
        PageTitleComponent,
        SearchResultsComponent,
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
    data(): {
        recipes: Array<Recipe>,
        matchingRecipes: Array<Recipe>,
        isUserAuthenticated: boolean,
        messageText: string,
        messageType: "success" | "warning",
        searchQuery: string,
    } {
        return {
            recipes: [],
            matchingRecipes: [],
            isUserAuthenticated: false,
            messageText: "",
            messageType: "success",
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
                    // const tagMatch = recipe.tags.includes(this.searchQuery.toLowerCase());
                    // Users will most likely look up "3 stars" or "1 star", this handles the stars/star ending
                    const ratingMatch = (this.searchQuery.toLowerCase().endsWith(" stars") && recipe.rating === parseInt(this.searchQuery.toLowerCase().replace(" stars", "")))
                        || (this.searchQuery.toLowerCase().endsWith(" star") && recipe.rating === parseInt(this.searchQuery.toLowerCase().replace(" star", "")));
                    return nameMatch || descriptionMatch || ratingMatch;
                });
            }
        },
        onSearch(query: string) {
            this.searchQuery = query;
            this.updateMatchingRecipes();
            this.$router.push({ query: { q: query } });
        },
        async deleteRecipe(id: number) {
            console.log("Remove recipe " + id);
            const returnMessage = await API.instance.removeRecipe(id);
            if (returnMessage !== undefined) {
                if (returnMessage === "recipe deleted successfully") {
                    this.messageType = "success";
                    console.log("Recipes before deletion:", this.recipes);
                    this.recipes = this.recipes.filter(item => item.id !== id);
                    console.log("Recipes after deletion:", this.recipes);
                    this.updateMatchingRecipes();
                } else {
                    this.messageType = "warning";
                }
                console.log("Deleting recipe with ID:", id);
                this.messageText = returnMessage;
            }
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
    <MessageComponent :type="messageType" v-model="messageText" />
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
