<script lang="ts">
import { API } from '@/model/apiCalls';


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
        setRating(value: number) {
            this.currentrating = value;
        },
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
    font-size: 20px;
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