<script lang="ts">

export default {
    name: 'SearchBarComponent',
    data() {
        return {
            searchText: '',
        };
    },
    methods: {
        search(){
            this.$emit('search', this.searchText);
        },
    },
};
</script>

<template>
    <div class="SearchBarComponent">
        <input class="search-textbox" type="text" v-model="searchText" placeholder="Search...">
        <div class="search-button">
            <button class="search-button__button" @click="search">Search</button>
        </div>
    </div>
</template>

<style scoped>
.SearchBarComponent {
    display: flex;
    flex-direction: row;
}

.search-button {
    display: flex;
    flex-direction: row;
    margin: 10px 10px;
}

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
</style>