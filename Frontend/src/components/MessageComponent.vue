<script lang="ts">
export default {
    name: "MessageComponent",
    props: {
        message: {
            type: String,
            required: true
        },
        type: {
            type: String as () => "success" | "warning",
            required: true
        }
    }
};
</script>

<template>
    <div :class="type">
        {{ message }}
    </div>
</template>

<style scoped>
div {
    position: fixed;
    left: 15px;
    bottom: 15px;
    font-size: 1.4em;
    padding: 15px;
}

.success {
    color: green;
}

.warning {
    color: red;

}
</style>