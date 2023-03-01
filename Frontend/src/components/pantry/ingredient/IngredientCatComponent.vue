<script lang="ts">
import IngredientModalComponent from "@/components/pantry/ingredient/IngredientModalComponent.vue";
import { IngredientCat } from "@/model/CatagoryModel";
export default {
    name: "IngredientCatComponent",
    props: {
        ingredientcat: {
            type: IngredientCat,
            required: true
        },
    },
    components: {
        IngredientModalComponent,
    },
    data() {
      return {
        isModalVisible: false,
      };
    },
    methods: {
      showModal() {
        this.isModalVisible = true;
      },
      closeModal() {
        this.isModalVisible = false;
      }
    }
};



</script>

<template>
    <div class="IngredientCatComponent">
        <div class="containerText">
            <h5>{{ ingredientcat.name }}</h5>
        </div>

        <div class="flexFill"></div>

        <button @click="showModal">
            -
        </button>

        <IngredientModalComponent @close="closeModal" v-show="isModalVisible"/>

        <button @click="$emit('delete-ingredientcat', ingredientcat.id)">
            X
        </button>

</div>
</template>

<style scoped>
.IngredientCatComponent {
    background-color: white;
    width: 100px;
    display: flex;
    padding: 5px;
    margin: 10px;
    flex-direction: row;
}

.containerText {
    display: flex;
    flex-direction: row;
}

</style>