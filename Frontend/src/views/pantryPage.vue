<script lang="ts">
import { API } from "@/model/apiCalls";
import { IngredientCat } from "@/model/PantryModels";
import IngredientCatListComponent from "@/components/pantry/ingredient/IngredientCatListComponent.vue";
import IngredientModalComponent from "@/components/pantry/ingredient/IngredientModalComponent.vue";
import AllergyListComponent from "@/components/pantry/AllergyListComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import ConversionComponent from "@/components/pantry/ConversionComponent.vue";
import MessageComponent from "@/components/MessageComponent.vue";

export default {
  name: "PantryPage",

  components: {
    IngredientCatListComponent,
    IngredientModalComponent,
    AllergyListComponent,
    ConversionComponent,
    InputField,
    CustomButton,
    MessageComponent
},

data(): {
  ingredientcats: Array<IngredientCat>,
  allergies: Array<string>,
  options: Array<string>,

  ingredientcat: IngredientCat,
  isModalVisible: boolean,
  newIngredientCat: string,
  newUtensilCat: string,
  messageText: string
} {
  return {
    ingredientcats: [],
    allergies: [],
    options: [],

    ingredientcat: new IngredientCat("E", "Error", []),
    isModalVisible: false,
    newIngredientCat: "",
    newUtensilCat: "",
    messageText: "",
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
  this.messageText = "Saved Number of People Eating as " + people;
  API.instance.changePeopleEating(people);
},

changeUnit(unit: string) {
  console.log("Change Unit Conversion to " + unit);
  this.messageText = "Saved Unit Conversion as " + unit;
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
  <main>

    <div class="grid">
      <div class="ingredients">

        <img draggable="false" src="@/assets/foodIcons/meat.png">

        <div class="text">

          <h2>Ingredient Catagories</h2>

          <div class="pair">
            <div class="flexHorizontal">

              <InputField id="newIngredientCat" inputType="text" labelText="" max-length="200" placeholder="New Ingredient Category Name.." v-model="newIngredientCat"
              :mandatory="false" />

              <CustomButton type="neutral" effect="plain" text="Add Category" titleText="Click to add the category" icon="add"
              @clicked="addIngredientCat" />

          </div>
        </div>
        <IngredientCatListComponent 
        @delete-ingredientcat="deleteIngredientCat"
        @open-ingredientmodal="getIngredientCat"
        :ingredientcats="filterIngredientCats('I')" />
        </div>
      </div>
      <div class="utensils">

        <img draggable="false" src="@/assets/foodIcons/pepper.png">
        <img draggable="false" src="@/assets/foodIcons/cheese.png">

        <div class="text">

          <h2>Untensil Catagories</h2>

          <div class="pair">
            <div class="flexHorizontal">

              <InputField id="newUtensilCat" inputType="text" labelText="" max-length="200" placeholder="New Utensil Category Name.." v-model="newUtensilCat"
              :mandatory="false" />

              <CustomButton type="neutral" effect="plain" text="Add Category" titleText="Click to add the category" icon="add"
              @clicked="addUtensilCat" />

          </div>
        </div>
          <IngredientCatListComponent 
        @delete-ingredientcat="deleteIngredientCat"
        @open-ingredientmodal="getIngredientCat"
        :ingredientcats="filterIngredientCats('U')" />
        </div>
      </div>
      <div class="conversions">

        <img draggable="false" src="">
        <img draggable="false" src="@/assets/foodIcons/banana.png">

        <div class="text">

          <h2>Conversions</h2>

          <ConversionComponent
          @change-people="changePeople"
          @change-unit="changeUnit"
          :options="options"
          />

        </div>
      </div>
      <div class="alergies">

        <img draggable="false" src="@/assets/foodIcons/lemon.png">

        <div class="text">

          <h2>Allergies</h2>

          <AllergyListComponent
          @delete-allergy="deleteAllergy"
          @add-allergy="addAllergy"
          :allergies="allergies" />

        </div>
      </div>
    </div>

    <IngredientModalComponent 
    @add-ingredient="addIngredient"
    @delete-ingredient="deleteIngredient"
    @close="closeModal" 
    v-show="isModalVisible" 
    :ingredientcat="ingredientcat"/>

    <MessageComponent :type="'success'" v-model="messageText" />

  </main>
</template>



<style scoped>
h2 {
  font-weight: bold;
  padding: 5px 15px;
}
.grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-template-rows: repeat(2, 1fr);
  grid-column-gap: 10px;
  grid-row-gap: 10px;
}

.ingredients {
  grid-area: 1 / 1 / 2 / 2;
  border-radius: 25px;
  border-style: solid;
  border-color: var(--color-accent);
  background-color: var(--color-background);
  border-width: 1;
  padding: 10px;
  margin: 10px;
}
.utensils {
  grid-area: 1 / 2 / 2 / 3;
  border-radius: 25px;
  border-style: solid;
  border-color: var(--color-accent);
  background-color: var(--color-background);
  padding: 10px;
  border-width: 1;
  margin: 10px;
}

.conversions {
  grid-area: 2 / 1 / 3 / 2;
  border-radius: 25px;
  border-style: solid;
  border-color: var(--color-accent);
  background-color: var(--color-background);
  padding: 10px;
  border-width: 1;
  margin: 10px;
}

.alergies {
  grid-area: 2 / 2 / 3 / 3;
  border-radius: 25px;
  border-style: solid;
  border-color: var(--color-accent);
  background-color: var(--color-background);
  padding: 10px;
  border-width: 1;
  margin: 10px;
}

.text {
  background-color: transparent;
  display: flex;
  flex-direction: column;
  padding: 5px 10px;
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

img {
    width: 40px;
    position: absolute;
    -webkit-user-drag: none;
    user-select: none;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
}

img:nth-child(1) {
  top: 75%;
  right: 8%;
}

img:nth-child(2) {
  top: 85%;
  right: 85%;
  transform: rotate(45deg);
}

</style>