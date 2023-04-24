<script lang="ts">
import { Category } from "@/model/categoryModel";

export default {
    name: "CategoryComponent",
    props: {
        // This component will contain props named category which will be a single type of category the recipe is organzied under
        // Is mandagtory for the page
        category: {
            type: Category,
            required: true,
        },
    }
};
</script>

<template>
    <div class="category">
        <h2>{{ category.title }}</h2>
    </div>
</template>

<style scoped>
.category {
    margin-left: 20px;
    font-family: common;
    margin-top: 40px;
}

h2 {
    font-family: "title";
    color: var(--color-text);
    font-size: 1.8em;
    margin-bottom: 5px;
    font-weight: bold;
    text-shadow: 2px solid black;
}
</style>