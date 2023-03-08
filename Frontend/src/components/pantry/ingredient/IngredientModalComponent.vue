<script lang="ts">
import { IngredientCat } from "@/model/PantryModels";
import IngredientListComponent from "@/components/pantry/ingredient/IngredientListComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
export default {
  name: "IngredientModalComponent",
  emits: ["close", "delete-ingredient", "add-ingredient"],
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
    CustomButton
  }
};
</script>

<template>
  <transition name="modal-fade">
    <div class="modal-overlay">
      <div class="modal" role="dialog">
        <div class="header">
          <h2>{{ ingredientcat.name }}</h2>
          <div class="btn-close">
            <CustomButton type="danger" effect="inline" text="" titleText="Close category" icon="x" @clicked="close" />
          </div>
        </div>
        <IngredientListComponent @delete-ingredient="(ingredient) => $emit('delete-ingredient', ingredient)"
          @add-ingredient="(nameAdd) => $emit('add-ingredient', nameAdd)" :ingredients="ingredientcat.ingredients" />
      </div>
    </div>
  </transition>
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
  z-index: 2;
}

.modal {
  width: 40%;
  border-radius: 25px;
  background: var(--color-background);
  box-shadow: 2px 2px 20px 1px;
  overflow-x: auto;
  display: flex;
  flex-direction: column;
  padding: 10px;
  position: relative;
  z-index: 3;
}

.header {
  flex-direction: row;
  justify-content: space-between;
  position: relative;
  background-color: transparent;
  align-items: baseline;
  padding: 5px;
}

.btn-close {
  position: absolute;
  top: 1px;
  right: 0;
  padding-top: 5px;
  padding-right: 10px;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: all 0.5s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}
</style>