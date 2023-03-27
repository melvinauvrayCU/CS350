<script lang="ts">
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";

export default {
    name: "SearchBarComponent",
    components: {
        CustomButton,
        InputField,
    },
    data() {
        return {
            searchText: "",
        };
    },
};
</script>

<template>
    <div class="SearchBarComponent">
        <div class="search-bar">
            <InputField id="searchName" labelText="" placeholder="Search for...." v-model="searchText" :mandatory="false" />
        </div>
        <div class="search-button">
            <CustomButton type="neutral" text="Search" titleText="Search" @click="$emit('search', searchText)"/>
        </div>
    </div>
</template>

<style scoped>
.SearchBarComponent {
    display: flex;
    flex-direction: row;
    margin-left: 20px;
}

.search-button {
    display: flex;
    flex-direction: row;
    margin: 12px;
}

.search-bar {
    width: 100%;
    margin-top: -10px;
}

</style>