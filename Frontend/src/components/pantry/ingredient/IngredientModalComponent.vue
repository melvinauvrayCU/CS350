<script lang="ts">
import { IngredientCat } from "@/model/PantryModels";
import IngredientListComponent from "@/components/pantry/ingredient/IngredientListComponent.vue";
 export default {
    name: "IngredientModalComponent",

    props: {
        ingredientcat: {
            type: IngredientCat,
            required: true
        },

    },

    methods: {
      close() {
        this.$emit("close");
      },
    },
    components: {
        IngredientListComponent,
    }
  };
</script>

<template>
    <div class="modal-overlay">
      <div class="modal" role="dialog">
        <div class="containerText">
          <div class="header">
            <h3>{{ ingredientcat.name }}</h3>
            <button
              type="button"
              class="btn-close"
              @click="close"
            >
              x
            </button>
          </div>
        </div>

        <IngredientListComponent
        @delete-ingredient="(ingredient) => $emit('delete-ingredient', ingredient)"
        @add-ingredient="(nameAdd) => $emit('add-ingredient', nameAdd)"
        :ingredients="ingredientcat.ingredients" />    

        
      </div>
    </div>
  </template>

<style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal {
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    padding: 10px;
  }

.header {

  justify-content: space-between;
  position: relative;
}

  h3 {
    text-align: center;
    display: flex;

  }

  .modal-header,
  .modal-footer {
    padding: 15px;
    display: flex;
  }

  .modal-header {
    position: relative;
    border-bottom: 1px solid #eeeeee;
    color: #4AAE9B;
    
  }

  .modal-footer {
    border-top: 1px solid #eeeeee;
    flex-direction: column;
    justify-content: flex-end;
  }

  .modal-body {
    position: relative;
    padding: 20px 10px;
  }

  .btn-close {
    position: absolute;
    top: 0px;
    right: 0;
    border: none;
    font-size: 15px;
    padding: 5px;
    cursor: pointer;
    font-weight: bold;
    color: #ff0000;
    background: transparent;
  }
  .containerText {
  background-color: lightgray;
  padding: 5px;
    display: flex;
    flex-direction: column;
}
</style>