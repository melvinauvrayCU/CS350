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
    methods: {
        // To reset the textbox to empty after a search is performed
        resetText() {
            this.searchText = "";
        },
        // To perform the search only if the search text is not empty
        performSearch() {
            if (this.searchText.trim() !== "") {
                this.$emit("search", this.searchText);
                this.resetText();
            }
        },
    }
};
</script>

<template>
    <div class="SearchBarComponent">
        <div class="search-bar">
            <InputField id="searchName" labelText="" placeholder="Search for...." v-model="searchText" :mandatory="false"
                @keyup.enter="$emit('search', searchText); resetText();" />
        </div>
        <div class="search-button">
            <CustomButton type="neutral" text="Search" titleText="Search" @click="performSearch" />
        </div>
    </div>
</template>

<style scoped>
.SearchBarComponent {
    display: flex;
    flex-direction: row;
    margin-left: 20px;
    margin-top: 5px;
    margin-right: -5px;
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