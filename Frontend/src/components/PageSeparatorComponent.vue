<script lang="ts">
export default {
    name: "PageSeparator",
    props: {
        title: {
            type: String,
            required: true
        }
    }
};
</script>
<template>
    <div>
        <h3>{{ title }}</h3>
        <hr>
    </div>
</template>

<style scoped>
div {
    width: 100%;
    margin: 50px 0 15px 0;
}

h3 {
    font-family: Arial, Helvetica, sans-serif;
    color: var(--color-text);
    font-size: 1.3em;
    margin-bottom: 5px;
    font-weight: bold;
}

hr {
    border: 0;
    height: 2px;
    background-color: var(--color-accent);
    width: 100%;
}
</style>