<script lang="ts">
export default {
    name: "RatingComponent",
    data() {
        return {
            currentRating: 0,
            maxRating: 5,
            stars: [0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5]
        };
    },
    methods: {
        setRating(rating: number) {
            this.currentRating = rating;
            this.$emit('rating-selected',rating)
        }
    }
}
</script>

<template>
    <div>
        <span
            v-for="(star,index) in stars"
            :key="index"
            @click="setRating(index)"
            :class="{ 'star-filled': index === currentRating }">
        ★
        </span>
    </div>
</template>

<style scoped>
.star-filled {
    color: yellow
}
</style>