<script lang="ts">
import AllergyComponent from "@/components/pantry/AllergyComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";

export default {
    name: "AllergyListComponent",
    props: {
        allergies: {
            type: Array<string>,
            required: true
        }
    },
    components: {
        AllergyComponent,
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
 filteredList() : Array<string> {
  return this.allergies.filter((allergy) =>
  allergy.toLowerCase().includes(this.search.toLowerCase())
  );
},
addAllergy() {
  if (this.nameAdd !== "") {
    this.$emit("add-allergy", this.nameAdd);
    this.nameAdd = "";
  }
}
},

};
</script>

<template>
<div class="transparent">
<div class="pair">
            <div class="flexHorizontal">

              <InputField id="nameAdd" inputType="text" labelText="" max-length="200" placeholder="New Allergen.." v-model="nameAdd"
              :mandatory="false" />

              <CustomButton type="neutral" effect="plain" text="Add Allergen" titleText="Click to add the allergen" icon="add"
              @clicked="addAllergy" />

          </div>
        </div>

<InputField id="search" inputType="text" labelText="" max-length="200" placeholder="Search Allergen.." v-model="search"
:mandatory="false" />

<div class="list">
<AllergyComponent 
@delete-allergy="(allergy) => $emit('delete-allergy', allergy)"
v-for="allergy in filteredList()" :key="allergy"
:allergy="allergy" />
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