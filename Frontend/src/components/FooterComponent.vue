<script lang="ts">
export default {
    name: "FooterComponent"
};
</script>
<template>
    <footer>
        © RecipeBuddy - 2023
    </footer>
</template>

<style scoped>
footer {
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background-color: var(--color-accent);
    color: white;
    margin-top: 100px;
    font-family: "title";
    font-size: 1.2em;
}
</style>