<script lang="ts">

import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";

export default {
    name: "AllergyComponent",
    emits: ["delete-allergy"],
    props: {
        allergy: {
            type: String,
            required: true
        },
    },
    components: {
        CustomButton
    }
};



</script>

<template>
    <div class="listItem">

        <h4 class="text">{{ allergy }}</h4>

        <CustomButton class="button" type="danger" effect="inline" text="" titleText="Delete allergen"
        icon="trash" @clicked="$emit('delete-allergy', allergy)" />

    </div>
</template>

<style scoped>
.listItem {
    display: flex;
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
    padding-left: 7px;
    padding-top: 5px;
    display: flex;
    flex-direction: row;
}

.button {
    padding-left: 10px;
    padding-bottom: 5px;
}

</style>