<script lang="ts">
export default {
    name: "RatingComponent",
    props: {
        rating: {
            type: Number,
            required: true,
        },
        recipeId: {
            type: Number,
            required: true,
        }
    },
    data() {
        return {
            currentrating: this.rating,
        };
    },
    methods: {
        setRating(event: MouseEvent, value: number) {
            event.stopPropagation();
            this.currentrating = value;
            this.$emit("input", value);
        },
    }
};
</script>

<template>
    <div>
        <span v-for="i in 5" :key="i" @click="(event) => setRating(event, i)"
            :class="{ 'text-yellow-400': currentrating >= i }">
            <i class="fa fa-star"></i>
        </span>
    </div>
</template>

<style scoped>
.fa-star {
    font-size: 25px;
    color: lightgrey;
    opacity: 50%;
    margin-right: 5px;
    cursor: pointer;
}

.text-yellow-400 .fa-star {
    color: gold;
    opacity: 100%;
}
</style>