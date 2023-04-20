<script lang="ts">
import ViewUtensil from "@/components/view/ViewUtensilComponent.vue";

export default {
    name: "ViewUtensilList",
    props: {
        utensils: {
            type: Array<string>,
            required: true
        }
    },
    components: {
        ViewUtensil
    },
    methods: {
        
    },
};
</script>

<template>
        <ViewUtensil v-for="utensil in utensils" :key="utensil" :utensil="utensil"/>
</template>