<script lang="ts">
import { API } from "@/model/apiCalls";
import type { IngredientCat, UntensilCat } from "@/model/CatagoryModel";
import IngredientCatListComponent from "@/components/pantry/ingredient/IngredientCatListComponent.vue";
import UntensilCatListComponent from "@/components/pantry/untensil/UntensilCatListComponent.vue";

export default {
  name: "PantryPage",

  components: {
    IngredientCatListComponent,
    UntensilCatListComponent,
  },

data(): {
  ingredientcats: Array<IngredientCat>,
  untensilcats: Array<UntensilCat>,
} {
  return {
    ingredientcats: [],
    untensilcats: [],
  };
},

methods: {

  //----Ingredient Methods----
deleteIngredientCat(id: number) {
  this.ingredientcats = API.instance.removeIngredientCat(id);
},

//----Untensil Methods----
deleteUntensilCat(id: number) {
  this.untensilcats = API.instance.removeUntensilCat(id);
}

},

created() {
  this.ingredientcats = API.instance.getIngredientCats();
  this.untensilcats = API.instance.getUntensilCats();
}



};

</script>

<template>
  <body>
    <div class="grid">
      <div class="ingredients">
        <div class="containerText">
          <h3>Ingredient Catagories</h3>
        <IngredientCatListComponent @delete-ingredientcat="deleteIngredientCat" :ingredientcats="ingredientcats" />
        </div>
      </div>
      <div class="untensils">
        <div class="containerText">
          <h3>Untensil Catagories</h3>
        <UntensilCatListComponent @delete-untensilcat="deleteUntensilCat" :untensilcats="untensilcats" />
        </div>
      </div>
    </div>
  </body>
</template>

<style scoped>

.grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-template-rows: repeat(2, 1fr);
  grid-column-gap: 10px;
  grid-row-gap: 10px;
}

.ingredients {
  grid-area: 1 / 1 / 2 / 2;
  border-style: solid;
  border-width: 0;
  margin: 10px;
}
.untensils {
  grid-area: 1 / 2 / 2 / 3;
  border-style: solid;
  border-width: 0;
  margin: 10px;
}

.conversions {
  grid-area: 2 / 1 / 3 / 2;
}

.alergies {
  grid-area: 2 / 2 / 3 / 3;
}

.containerText {
  background-color: lightgray;
    display: flex;
    flex-direction: column;
}

.h3 {
  background-color: white;
  color: black;
  text-align: center;
}

</style>