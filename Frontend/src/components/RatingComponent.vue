<script lang="ts">
export default {
    name: "RatingComponent",
    data() {
        return {
            rating: 0,
        };
    },
    methods: {
        setRating(value: number) {
            this.rating = value
        }
    }
}
</script>

<template>
    <div >
        <span
            v-for="i in 5"
            :key="i"
            @click="setRating(i)"
            :class="{ 'text-yellow-400': rating >= i }">
        <i class="fa fa-star"></i>
        </span>
    </div>
</template>

<style scoped>
.fa-star {
    font-size: 15px;
    color: lightgrey;
    opacity: 50%;
    margin-right: 5px;
    cursor: pointer;
    display: inline-block;
}

.text-yellow-400 .fa-star {
    color: gold;
    opacity: 100%;
}
</style>