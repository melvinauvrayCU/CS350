<script lang="ts">
export default {
    name: "PageTitle",
    props: {
        text: {
            type: String,
            required: true,
        }
    }
};
</script>

<template>
    <h1>{{ text }}</h1>
</template>

<style scoped>
h1 {
    margin: 20px 0;
    color: var(--color-text);
}
</style>