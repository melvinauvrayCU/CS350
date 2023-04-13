<script lang="ts">

export default {
    name: "ViewIngredient",
    props: {
        utensil: {
            type: String,
            required: true
        }
    },
    components: {
    },
};
</script>

<template>
<div class="ViewIngredientComponent">

    <p>●</p>

    <p>{{ utensil }}</p>

</div>
</template>

<style scoped>

.ViewIngredientComponent {
    display: flex;
    flex-direction: row;
    border-radius: 25px;
    margin: 10px;
    padding: 2px;
}

p {
    padding: 4px;
    font-size: 1.2em;
    font-weight: 500;
    font-family: "common";
}
</style>