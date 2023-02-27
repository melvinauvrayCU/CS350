<script lang="ts">
import CustomButton from "@/components/CustomButtonComponent.vue";
import InputField from "@/components/InputFieldComponent.vue";
import type { Step } from "@/views/CreateRecipePage.vue";
import type { PropType } from "vue";

export default {
    name: "StepCreate",
    props: {
        stepObject: {
            type: Object as PropType<Step>,
            required: true
        },
        descriptionModelValue: {
            type: String,
            required: true
        }
    },
    data(): {
        descriptionPrivateValue: string
        cooktimePrivateValue: string
    } {
        return {
            descriptionPrivateValue: "",
            cooktimePrivateValue: "",
        };
    },
    components: {
        CustomButton,
        InputField,
    },
    methods: {
        updateDescription() {
            this.$emit("update:descriptionModelValue", this.descriptionPrivateValue);
        },
        updateCooktime() {
            this.$emit("update:cooktimeModelValue", this.cooktimePrivateValue);
        }
    },
    created() {
        this.descriptionPrivateValue = this.descriptionModelValue;
        this.cooktimePrivateValue = this.stepObject.cooktimeValue;
    }
};
</script>

<template>
    <div class="StepCreateComponent">
        <div class="containerTitle">
            <h4>Step {{ stepObject.stepNumber }}</h4>
            <CustomButton text="Delete" />
        </div>
        <InputField id="stepDescription" labelText="Step description:"
            placeholder="Tell us some detailed informations about this step..." :mandatory="true" inputType="textarea"
            initialHeight="100" maxLength="650" v-model="descriptionPrivateValue" @update:modelValue="updateDescription" />

        <div class="flexHorizontal">
            <InputField :id="'cooktime' + stepObject.stepNumber" labelText="Cook time:" inputType="time"
                :v-model="stepObject.cooktimeValue" v-model="cooktimePrivateValue" @update:modelValue="updateCooktime" />
            <InputField :id="'preptime' + stepObject.stepNumber" labelText="Preparation time:" inputType="time"
                :v-model="stepObject.preptimeValue" />
        </div>
    </div>
</template>

<style scoped>
.StepCreateComponent {
    background-color: var(--color-background-light);
    display: flex;
    flex-direction: column;
    padding: 15px;
    width: 100%;
}

.containerTitle {
    display: flex;
    flex-direction: row;
    width: 100%;
    justify-content: space-between;
}

.containerTitle h4 {
    font-size: 1.4em;
    font-weight: bold;
    color: var(--color-text);
    font-family: Arial, Helvetica, sans-serif;
}
</style>