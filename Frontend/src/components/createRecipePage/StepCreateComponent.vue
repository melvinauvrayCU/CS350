<script lang="ts">
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import type { Ingredient, Step } from "@/model/recipeModel";
import type { PropType } from "vue";
import CustomSelectIngredients from "@/components/formComponents/CustomSelectIngredientsComponent.vue";
import CustomSelectUtensils from "@/components/formComponents/CustomSelectUtensilsComponent.vue";

export default {
    name: "StepCreate",
    props: {
        stepObject: {
            type: Object as PropType<Step>,
            required: true
        },
        stepIndex: {
            type: Number,
            required: true
        },
        stepIndexLength: {
            type: Number,
            required: true
        },
        utensilList: {
            type: Object as () => string[],
            required: true
        },
        ingredientList: {
            type: Object as () => Ingredient[],
            required: true
        }
    },
    data(): {
        descriptionPrivateValue: string
        cooktimePrivateValue: string
        preptimePrivateValue: string
        ingredientsPrivateValue: Ingredient[]
        utensilsPrivateValue: string[]
    } {
        return {
            descriptionPrivateValue: "",
            cooktimePrivateValue: "",
            preptimePrivateValue: "",
            ingredientsPrivateValue: [],
            utensilsPrivateValue: [],
        };
    },
    components: {
        CustomButton,
        InputField,
        CustomSelectIngredients,
        CustomSelectUtensils
    },
    methods: {
        updateDescription() {
            this.$emit("update:descriptionModelValue", this.descriptionPrivateValue);
        },
        updateCooktime() {
            this.$emit("update:cooktimeModelValue", this.cooktimePrivateValue);
        },
        updatePreptime() {
            this.$emit("update:preptimeModelValue", this.preptimePrivateValue);
        },
        updateIngredients() {
            this.$emit("update:ingredientsModelValue", this.ingredientsPrivateValue);
        },
        updateUtensils() {
            this.$emit("update:utensilsModelValue", this.utensilsPrivateValue);
        }
    },
    created() {
        this.descriptionPrivateValue = this.stepObject.descriptionValue;
        this.cooktimePrivateValue = this.stepObject.cooktimeValue;
        this.preptimePrivateValue = this.stepObject.preptimeValue;
        this.ingredientsPrivateValue = this.stepObject.ingredients;
        this.utensilsPrivateValue = this.stepObject.utensils;
    }
};
</script>

<template>
    <div class="StepCreateComponent">
        <div class="containerTitle">
            <h4>Step {{ stepIndex }}</h4>
            <hr>
            <CustomButton type="danger" effect="plain" icon="trash" text="Delete" v-if="stepIndexLength !== 1"
                @clicked="$emit('stepDeleted', stepObject)" :titleText="'Click to delete step ' + stepIndex" />
        </div>
        <div class="containerContent">
            <InputField id="stepDescription" labelText="Step description:"
                placeholder="Tell us some detailed informations about this step..." :mandatory="true" inputType="textarea"
                initialHeight="100" maxLength="650" v-model="descriptionPrivateValue"
                @update:modelValue="updateDescription" />

            <div class="flexHorizontal">
                <InputField :id="'cooktime' + stepObject.stepId" labelText="Cook time:" inputType="time"
                    v-model="cooktimePrivateValue" @update:modelValue="updateCooktime" />

                <InputField :id="'preptime' + stepObject.stepId" labelText="Preparation time:" inputType="time"
                    v-model="preptimePrivateValue" @update:modelValue="updatePreptime" />
            </div>

            <CustomSelectIngredients v-model="ingredientsPrivateValue" @update:modelValue="updateIngredients"
                :ingredientList="ingredientList" />

            <CustomSelectUtensils v-model="utensilsPrivateValue" @update:modelValue="updateUtensils"
                :utensilList="utensilList" />

        </div>
    </div>
</template>

<style scoped>
.StepCreateComponent {
    display: flex;
    flex-direction: column;
    width: 100%;
    margin-bottom: 30px;
}

.containerTitle {
    display: flex;
    flex-direction: row;
    width: 100%;
    justify-content: center;
    align-items: center;
}

.containerTitle h4 {
    font-size: 1.4em;
    font-weight: 600;
    color: var(--color-text);
    font-family: "common";
}

.containerTitle hr {
    border: 0;
    height: 1px;
    background-color: var(--color-background-light);
    flex: 1;
    margin: 0 20px;
}

.containerContent {
    padding: 0 20px;
}
</style>