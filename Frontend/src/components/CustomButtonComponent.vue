<script lang="ts">
export default {
    name: "CustomButton",
    props: {
        text: {
            type: String,
            required: true
        },
        type: {
            type: String as () => "neutral" | "success" | "danger",
            default: "neutral"
        }
    }
};
</script>
<template>
    <div>
        <button @click="$emit('clicked')" :class="type">
            {{ text }}
        </button>
    </div>
</template>