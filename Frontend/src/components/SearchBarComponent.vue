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
        <input type="text" v-model="searchText" placeholder="Search...">
        <div class="search-button">
            <button @click="search">Search</button>
        </div>
    </div>
</template>

<style scoped>
.SearchBarComponent {
    display: flex;
    flex-direction: row;
    margin: 15px;
    text-align-last: left;
    background-color: white;
}

.search-button {
    display: flex;
    flex-direction: row;
    background-color: green;
}
</style>