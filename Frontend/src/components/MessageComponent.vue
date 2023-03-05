<script lang="ts">
export default {
    name: "MessageComponent",
    props: {
        modelValue: {
            type: String,
            required: true
        },
        type: {
            type: String as () => "success" | "warning",
            required: true
        }
    },
    methods: {
        removeMessage() {
            this.$emit("update:modelValue", "");
        }
    },
    watch: {
        modelValue(newVal) {
            if (newVal !== "") {
                setTimeout(() => {
                    this.$emit("update:modelValue", "");
                }, 5200);
            }
        }
    }
};
</script>

<template>
    <transition>
        <div v-if="modelValue !== ''" :class="type" @click="removeMessage">
            {{ modelValue }}
        </div>
    </transition>
</template>

<style scoped>
div {
    position: fixed;
    left: 15px;
    bottom: 15px;
    font-size: 1.3em;
    padding: 15px 30px;
    border-radius: 40px;
    z-index: 100000000000000;
    cursor: pointer;
    background-size: 200% 100%;
    animation: popup-background-color 5s linear forwards;
}

@keyframes popup-background-color {
    from {
        background-position: 0 0;
    }

    to {
        background-position: -100% 0;
    }
}

.success {
    color: var(--color-background);
    background-image: linear-gradient(to right, var(--color-success), var(--color-success-light));
}

.warning {
    color: var(--color-background);
    background-image: linear-gradient(to right, var(--color-danger), var(--color-danger-light));
}

.v-enter-active,
.v-leave-active {
    transition: all 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
    transform: translateX(-100%);
}
</style>