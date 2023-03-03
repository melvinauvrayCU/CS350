<script lang="ts">

export default {
    name: "ConversionComponent",
props: {
    options: {
        type: Array<string>,
        required: true
    }
    },
    data(): {
        numPeople: number,
      unitOption: string,
    } {
      return {
        numPeople: 1,
        unitOption: "",
      };
    },
};
</script>

<template>

<input type="number" id="numPeople" placeholder="People Cooking For.."/>

<button @click="$emit('change-people', numPeople)">+</button>

<select v-model="unitOption">
<option v-for="option in options" :key="option">
{{ option }}
</option>
</select>

<button @click="$emit('change-unit', unitOption)">+</button>

</template>

<style scoped>

</style>