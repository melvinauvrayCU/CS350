<script lang="ts">

import InputField from "@/components/formComponents/InputFieldComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import { Conversion, type Unit } from "@/model/PantryModels";

export default {
    name: "ConversionComponent",
    emits: ["change-people","change-unit"],
props: {
    options: {
        type: Array<Unit>,
        required: true
    },
    current: {
      type: Conversion,
      required: true
    }
    },
    components: {
      InputField,
      CustomButton
    },
    data(): {
        numPeople: number,
        unitWeightOption: string,
        unitVolumeOption: string,
    } {
      return {
        numPeople: 1,
        unitWeightOption: "",
        unitVolumeOption: "",
      };
    },
    methods: {
      filterOptions(type: string) {
        const Optionslist: Array<Unit> = this.options.filter(options => options.type == type);
        var Options: Array<string> = [];
        for (var i = 0; i < Optionslist.length; i++ ) {
          Options.push(Optionslist[i].name);
        }
        Options.push("");
        return Options;
      }
    },
    created() {
      if (this.current.people !== 0) this.numPeople = this.current.people;
      this.unitVolumeOption = this.current.unitVolume;
      this.unitWeightOption = this.current.unitWeight;
    }
    };
</script>

<template>

  <div class="pair">
    <div class="flexHorizontal">

      <InputField id="numPeople" inputType="number" labelText="" min="0" max="50" placeholder="People Cooking For.." v-model="numPeople"
      :mandatory="false" />

      <CustomButton type="neutral" effect="empty" text="Save Number.." titleText="Click to save the people cooking for"
      @clicked="$emit('change-people', numPeople)" />

    </div>
  </div>

  <div class="pair">
    <div class="flexHorizontal">

      <InputField id="unitWeightOption" inputType="select" labelText="" placeholder="" v-model="unitWeightOption" 
      :options="filterOptions('W')"
      :mandatory="false" />

      <CustomButton type="neutral" effect="empty" text="Save Weight Unit.." titleText="Click to save the weight conversion unit"
      @clicked="$emit('change-unit', 'W', unitWeightOption)" />

    </div>
  </div>

  <div class="pair">
    <div class="flexHorizontal">

      <InputField id="unitVolumeOption" inputType="select" labelText="" placeholder="" v-model="unitVolumeOption" 
      :options="filterOptions('V')"
      :mandatory="false" />

      <CustomButton type="neutral" effect="empty" text="Save Volume Unit.." titleText="Click to save the volume conversion unit"
      @clicked="$emit('change-unit', 'V', unitVolumeOption)" />

    </div>
  </div>

</template>

<style scoped>

.pair {
display: flex;
flex-direction: row;
justify-content: space-between;
align-items: baseline;
font-size: 1.0em;
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