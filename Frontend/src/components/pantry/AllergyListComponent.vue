<script lang="ts">
import AllergyComponent from "@/components/pantry/AllergyComponent.vue";
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
    
<input type="text" v-model="nameAdd" placeholder="Add Allergy.."/>

<button @click="addAllergy">+</button>

<input type="text" v-model="search" placeholder="Search Allergy.."/>

<AllergyComponent 
@delete-allergy="(allergy) => $emit('delete-allergy', allergy)"
v-for="allergy in filteredList()" :key="allergy"
:allergy="allergy" />

</template>

<style scoped>

</style>