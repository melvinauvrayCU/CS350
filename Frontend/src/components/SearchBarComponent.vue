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
        search(){
            this.$emit("search", this.searchText);
        },
    },
};
</script>

<template>
    <div class="SearchBarComponent">
        <div class="search-bar">
            <InputField id="searchName" labelText="" max-length="100"
          placeholder="Search for...." v-model="searchText" :mandatory="false" />
            <!--
            Old Search Bar 
            <input class="search-textbox" type="text" v-model="searchText" placeholder="Search...">
            -->
        </div>
        <div class="search-button">
            <CustomButton titleText="Click to search" text="Search" effect="plain" @click="search"/>
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
/**
Previous Search Bar

.search-textbox {
    background-color: white;
    font-size: 20px;
    border: 3px solid lightgrey ;
    border-radius: 5px;
    display: flex;
    width: 100%;
    margin: 10px ;
    height: 40px;
}

.search-button__button {
    background-color: green;
    border: none;
    color: white;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
    height: 40px;
}

.search-button__button:hover {
    background-color: darkgreen;
}

*/

</style>