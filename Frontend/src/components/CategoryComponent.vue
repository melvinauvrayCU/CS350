<script lang="ts">
import { Category } from '@/model/categoryModel';

export default {
    name: "CategoryComponent",
    props: {
        // This component will contain props named category which will be a single type of category the recipe is organzied under
        // Is mandagtory for the page
        category: {
            type: Category,
            required: true,
        }
    }
}
</script>

<template>
    <div class="CategoryComponent">
        <div class="containerText">
            <h2>{{ category.title }}</h2>
        </div>
    </div>
</template>

<style scoped>
.CategoryComponent {
    background-color: var(--color-accent);
    width: 200px;
    display: block;
    padding: 10px;
    margin: 20px;
    flex-direction: row;
}

.containerText {
    display: flex;
    flex-direction: row;
}
</style>