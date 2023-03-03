<script lang="ts">
import IngredientComponent from "@/components/pantry/ingredient/IngredientComponent.vue";
export default {
    name: "IngredientListComponent",
    props: {
        ingredients: {
            type: Array<string>,
            required: true
            }
    },
    components: {
        IngredientComponent,
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
 filteredList() : Array<string> {
  return this.ingredients.filter((ingredient) =>
    ingredient.toLowerCase().includes(this.search.toLowerCase())
  );
},
addIngredient() : void {
  if (this.nameAdd !== "") {
    this.$emit("add-ingredient", this.nameAdd);
    this.nameAdd = "";
  }
}
}
};

</script>
<template>

<input type="text" v-model="search" placeholder="Search.."/>

<input type="text" v-model="nameAdd" placeholder="Add.."/>

<button @click="addIngredient">+</button>

        <IngredientComponent @delete-ingredient="(ingredient) => $emit('delete-ingredient', ingredient)"
            v-for="ingredient in filteredList()" :key="ingredient"
            :ingredient="ingredient" />
</template>
