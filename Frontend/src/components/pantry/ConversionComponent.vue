<script lang="ts">

import InputField from "@/components/formComponents/InputFieldComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";


export default {
    name: "ConversionComponent",
    emits: ["change-people","change-unit"],
props: {
    options: {
        type: Array<string>,
        required: true
    }
    },
    components: {
      InputField,
      CustomButton
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

  <div class="pair">
    <div class="flexHorizontal">

      <InputField id="numPeople" inputType="number" labelText="" min="1" max="50" placeholder="People Cooking For.." v-model="numPeople"
      :mandatory="false" />

      <CustomButton type="neutral" effect="empty" text="Save Number.." titleText="Click to save the people cooking for"
      @clicked="$emit('change-people', numPeople)" />

    </div>
  </div>

  <div class="pair">
    <div class="flexHorizontal">

      <InputField id="unitOption" inputType="select" labelText="" placeholder="People Cooking For.." v-model="unitOption" :options="options"
      :mandatory="false" />

      <CustomButton type="neutral" effect="empty" text="Save Unit.." titleText="Click to save the conversion unit"
      @clicked="$emit('change-unit', unitOption)" />

    </div>
  </div>

</template>

<style scoped>

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

.options {
  display: block;
    margin-top: 5px;
    border: 1px solid var(--color-background-light);
    transition: border-color 0.4s ease, box-shadow 0.4s ease;
    padding: 10px 20px;
    font-size: 1.2em;
    border-radius: 5px;
    font-family: "common";
    color: var(--color-text);

    box-shadow: inset 0 0 0 0px var(--color-accent);
    overflow: hidden;
}

</style>