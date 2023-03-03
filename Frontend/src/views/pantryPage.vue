<script lang="ts">
import { API } from "@/model/apiCalls";
import { IngredientCat } from "@/model/PantryModels";
import IngredientCatListComponent from "@/components/pantry/ingredient/IngredientCatListComponent.vue";
import IngredientModalComponent from "@/components/pantry/ingredient/IngredientModalComponent.vue";
import AllergyListComponent from "@/components/pantry/AllergyListComponent.vue";
import ConversionComponent from "@/components/pantry/ConversionComponent.vue";

export default {
  name: "PantryPage",

  components: {
    IngredientCatListComponent,
    IngredientModalComponent,
    AllergyListComponent,
    ConversionComponent
},

data(): {
  ingredientcats: Array<IngredientCat>,
  allergies: Array<string>,
  options: Array<string>,

  ingredientcat: IngredientCat,
  isModalVisible: boolean,
  newIngredientCat: string,
  newUtensilCat: string,
} {
  return {
    ingredientcats: [],
    allergies: [],
    options: [],

    ingredientcat: new IngredientCat("E", "Error", []),
    isModalVisible: false,
    newIngredientCat: "",
    newUtensilCat: "",
  };
},

methods: {

  //----Ingredient Methods----
deleteIngredientCat(id: number) {
  console.log("Remove IngredientCat " + id);
  this.ingredientcats = API.instance.removeIngredientCat(id);
},

addIngredientCat() {
  if(this.newIngredientCat !== "") {
    console.log("Add IngredientCat " + this.newIngredientCat);
    this.ingredientcats = API.instance.createIngredientCat(this.newIngredientCat, []);
  this.newIngredientCat = "";
  }
},

getIngredientCat(id: number) {
  console.log("Get IngredientCat " + id);
  this.ingredientcat = API.instance.getIngredientCat(id);
  this.isModalVisible = true;
},

//----Utensil Methods----
addUtensilCat() {
  if (this.newUtensilCat !== "") {
    console.log("Add UtensilCat " + this.newUtensilCat);
    this.ingredientcats = API.instance.createUtensilCat(this.newUtensilCat, []);
    this.newUtensilCat = "";
  }
},

filterIngredientCats(type: string) {
  return this.ingredientcats.filter(ingredientcat => ingredientcat.type == type);
},

//----Modal Methods----
showModal() {
  this.isModalVisible = true;
},
closeModal() {
  this.isModalVisible = false;
},

deleteIngredient(name: string) {
  console.log("Remove Ingredient " + name + " from " + this.ingredientcat.name);
  this.ingredientcats = API.instance.removeIngredient(this.ingredientcat.id, name);
},

addIngredient(name: string) {
  console.log("Add Ingredient " + name + " to " + this.ingredientcat.name);
  this.ingredientcats = API.instance.createIngredient(this.ingredientcat.id, name);
},

//----Allergy Methods----
deleteAllergy(name: string) {
  console.log("Remove Allergy " + name);
  this.allergies = API.instance.removeAllergy(name);
},

addAllergy(name: string) {
  console.log("Add Allergy " + name);
  API.instance.createAllergy(name);
},

//----Conversion Methods---

changePeople(people: number) {
  console.log("Change People Eating to " + people);
  API.instance.changePeopleEating(people);
},

changeUnit(unit: string) {
  console.log("Change Unit Conversion to " + unit);
API.instance.changeUnitConversion(unit);
}

},

created() {
  this.ingredientcats = API.instance.getIngredientCats();
  this.allergies = API.instance.getAllergies();
  this.options = API.instance.getUnitOptions();
}



};

</script>

<template>
  <body>
    <div class="grid">
      <div class="ingredients">
        <div class="containerText">
          <h3>Ingredient Catagories</h3>

          <input type="text" v-model="newIngredientCat" placeholder="Add Category.."/>
          <button @click="addIngredientCat">+</button>

        <IngredientCatListComponent 
        @delete-ingredientcat="deleteIngredientCat"
        @open-ingredientmodal="getIngredientCat"
        :ingredientcats="filterIngredientCats('I')" />
        </div>
      </div>
      <div class="utensils">
        <div class="containerText">
          <h3>Untensil Catagories</h3>

          <input type="text" v-model="newUtensilCat" placeholder="Add Category.."/>
          <button @click="addUtensilCat">+</button>

          <IngredientCatListComponent 
        @delete-ingredientcat="deleteIngredientCat"
        @open-ingredientmodal="getIngredientCat"
        :ingredientcats="filterIngredientCats('U')" />
        </div>
      </div>
      <div class="conversion">
        <div class="containerText">
          <h3>Conversions</h3>
          <ConversionComponent
          @change-people="changePeople"
          @change-unit="changeUnit"
          :options="options"
          />

        </div>
      </div>
      <div class="alergies">
        <div class="containerText">
          <h3>Allergies</h3>

          <AllergyListComponent
          @delete-allergy="deleteAllergy"
          @add-allergy="addAllergy"
          :allergies="allergies" />

        </div>
      </div>
    </div>
  </body>
  <IngredientModalComponent 
  @add-ingredient="addIngredient"
  @delete-ingredient="deleteIngredient"
  @close="closeModal" 
  v-show="isModalVisible" 
  :ingredientcat="ingredientcat"/>
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
.utensils {
  grid-area: 1 / 2 / 2 / 3;
  border-style: solid;
  border-width: 0;
  margin: 10px;
}

.conversions {
  grid-area: 2 / 1 / 3 / 2;
  border-style: solid;
  border-width: 0;
  margin: 10px;
}

.alergies {
  grid-area: 2 / 2 / 3 / 3;
  border-style: solid;
  border-width: 0;
  margin: 10px;
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