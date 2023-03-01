<script lang="ts">
import type { Category } from '@/model/categoryModel';
import CategoryComponent from './CategoryComponent.vue';
export default {
    name: "CategoryListComponent",
    // This component will include an array of Category since we want to display the full list of categories available
    props: {
        categories: Array<Category>,
    },
    components: {
        CategoryComponent,
    }
}
</script>

<template>
    <div>
        <CategoryComponent type="text" v-for="category in categories" :key="category.id" :category="category"/>
    </div>
</template>