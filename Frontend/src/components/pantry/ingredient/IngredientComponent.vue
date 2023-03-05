<script lang="ts">
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
export default {
    name: "IngredientComponent",
    components: {
        CustomButton
    },
    props: {
        ingredient: {
            type: String,
            required: true
        },
    },
};



</script>

<template>
    <div class="IngredientCatComponent">

        <h4 class="text">{{ ingredient }}</h4>

        <div >
            <CustomButton class="button" type="danger" effect="inline" text="" titleText="Delete ingredient" 
            icon="trash" @clicked="$emit('delete-ingredient', ingredient)" />
        </div>

</div>
</template>

<style scoped>
.IngredientCatComponent {
    display: flex;
    padding: 5px;
    margin: 10px;
    flex-direction: row;
    border-radius: 25px;
    border-width: 1;
    border-style: solid;
    border-color: var(--color-background-light);
    background-color: var(--color-background-extra-light);
    padding: 10px;
    margin: 5px;
}

.text {
    padding-top: 5px;
    display: flex;
    flex-direction: row;
}

.button {
    padding-left: 10px;
    padding-bottom: 5px;
}

</style>