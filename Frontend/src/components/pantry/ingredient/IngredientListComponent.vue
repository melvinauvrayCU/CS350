<script lang="ts">
import IngredientComponent from "@/components/pantry/ingredient/IngredientComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import type { Ingredient } from "@/model/recipeModel";
export default {
  name: "IngredientListComponent",
  emits: ["add-ingredient", "delete-ingredient"],
  props: {
    ingredients: {
      type: Array<Ingredient>,
      required: true
    }
  },
  components: {
    IngredientComponent,
    InputField,
    CustomButton
  },

  data(): {
    search: string,
    nameAdd: string,
  } {
    return {
      search: "",
      nameAdd: "",
    };
  },
  methods: {
    filteredList(): Array<Ingredient> {
      return this.ingredients.filter((ingredient) =>
        ingredient.name.toLowerCase().includes(this.search.toLowerCase())
      );
    },
    addIngredient(): void {
      if (this.nameAdd !== "") {
        this.$emit("add-ingredient", this.nameAdd);
        this.nameAdd = "";
      }
    }
  }
};

</script>
<template>
  <div class="background">

    <InputField id="search" inputType="text" labelText="" max-length="200" placeholder="Search Item Name.."
      v-model="search" :mandatory="false" />

    <div class="pair">
      <div class="flexHorizontal">

        <InputField id="nameAdd" inputType="text" labelText="" max-length="200" placeholder="Add Item Name.."
          v-model="nameAdd" :mandatory="false" />

        <CustomButton type="neutral" effect="plain" text="Add Item" titleText="Click to add the item" icon="add"
          @clicked="addIngredient" />
      </div>
    </div>
    <div class="list">
      <IngredientComponent @delete-ingredient="(ingredient) => $emit('delete-ingredient', ingredient)"
        v-for="ingredient in filteredList()" :key="ingredient.id" :ingredient="ingredient" />
    </div>

  </div>
</template>

<style scoped>
.background {
  background-color: transparent;
}

.pair {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: baseline;
}

.flexHorizontal div:nth-child(1) {
  flex: 1.5;
  width: 60%;
}

.flexHorizontal div:nth-child(2) {
  padding: 25px;
  flex: 1;
}

.list {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}
</style>