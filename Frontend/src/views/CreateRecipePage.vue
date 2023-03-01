<script lang="ts">
import { API } from "@/model/apiCalls";
import PageTitle from "@/components/PageTitleComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import StepCreate from "@/components/createRecipePage/StepCreateComponent.vue";
import PageSeparator from "@/components/PageSeparatorComponent.vue";
import BackgroundIcons from "@/components/BackgroundIconsComponent.vue";
import { Recipe, type Step } from "@/model/recipeModel";

export default {
  name: "CreateRecipePage",
  components: {
    PageTitle,
    InputField,
    CustomButton,
    StepCreate,
    PageSeparator,
    BackgroundIcons,
  },
  // In the first bracket, we define the types of the variables we will use,
  // And in the second bracket we define the initiale values.
  data(): {
    title: string,
    description: string,
    numberPeople: number,
    steps: Step[],
    stepCounter: number,
  } {
    // We are setting the title and description datas that will be linked to the form.
    // And a boolean created variable, which will be true when a recipe has been created to display a success message.
    return {
      title: "",
      description: "",
      numberPeople: 1,
      steps: [],
      stepCounter: 1,
    };
  },
  methods: {
    /**
     * Method called when clicking on the create recipe button.
     */
    createRecipe(): void {

      /** 
       * Data validation 
       */
      let error: boolean = false;
      if (this.title === ""
        || this.description === "" || this.description.length > 650
        || this.numberPeople < 1)
        error = true;

      this.steps.forEach(step => {
        if (step.descriptionValue === "") {
          error = true;
          console.error("description du step ", step, " vide");
        }

      });

      if (error) {
        // errors, don't send datas.
        // TODO: Display error message here
        console.error("Some fields are empty");
      } else {
        // No errors, send datas
        // TODO: create recipe model here
        const result = API.instance.createRecipe(new Recipe(
          this.title,
          this.description,
          this.numberPeople,
          this.steps
        ));

        if (result) {
          // TODO: Redirect to another page with success message here
        } else {
          // TODO: Display error message here
        }
      }

    },
    addStep(): void {
      this.stepCounter++;
      this.steps.push({
        stepId: this.stepCounter,
        descriptionValue: "",
        cooktimeValue: "",
        preptimeValue: "",
      });
    },
    deleteStep(stepObjectToDelete: Step): void {
      console.error(this.steps);
      this.steps = this.steps.filter(step => step.stepId !== stepObjectToDelete.stepId);
      console.error(this.steps);
    }
  },
  created() {
    this.steps.push({
      stepId: this.stepCounter,
      descriptionValue: "",
      cooktimeValue: "",
      preptimeValue: "",
    });
  }
};

</script>
<template>
  <main class="CreateRecipePage">
    <div class="contentConainer">

      <PageTitle text="Create a new recipe !" />

      <PageSeparator title="🍔 Global informations about your recipe" />

      <div class="flexHorizontal">
        <InputField id="recipeTitle" labelText="Recipe Title:" placeholder="Please enter the recipe title..."
          v-model="title" :mandatory="true" />
        <InputField id="numberPeople" labelText="Number of people:"
          placeholder="Please enter the number of people this recipe is for..." v-model="numberPeople" inputType="number"
          min="1" :mandatory="true" />
      </div>

      <InputField id="recipeDescription" labelText="Recipe description:"
        placeholder="Tell us some global informations about your recipe..." v-model="description" :mandatory="true"
        inputType="textarea" initialHeight="100" maxLength="650" />

      <PageSeparator title="📜 Give us the steps to complete your recipe" />

      <transition-group name="list">
        <StepCreate v-for="(step, index) in steps" :key="step.stepId" :stepObject="step" :stepIndex="index + 1"
          :stepIndexLength="steps.length" v-model:descriptionModelValue="step.descriptionValue"
          v-model:cooktimeModelValue="step.cooktimeValue" v-model:preptimeModelValue="step.preptimeValue"
          @stepDeleted="deleteStep" />
      </transition-group>

      <div class="containerAddStep">
        <CustomButton text="Add a new step" type="success" effect="plain" icon="add" titleText="Click to add a new step"
          @clicked="addStep" />
        <hr>
      </div>


      <CustomButton text="🥧 Create the recipe !" titleText="Click to create the recipe" @clicked="createRecipe" />


    </div>

    <BackgroundIcons />

  </main>
</template>

<style scoped>
/* ----- transition for step list ------- */
.list-move,
/* apply transition to moving elements */
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(-100%);
}

/* ensure leaving items are taken out of layout flow so that moving
   animations can be calculated correctly. */
.list-leave-active {
  position: absolute;
}

/* ------- */

.CreateRecipePage {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.contentConainer {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 60%;
}

form {
  display: flex;
  flex-direction: column;
  width: 100%;
  background-color: var(--color-background-light);
  padding: 30px;
}

form input {
  margin-bottom: 15px;
}

.flexHorizontal div:nth-child(1) {
  flex: 2;
}

.flexHorizontal div:nth-child(2) {
  flex: 1;
}

.containerAddStep {
  width: 100%;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  margin-bottom: 40px;
}

.containerAddStep hr {
  border: 0;
  height: 1px;
  background-color: var(--color-background-light);
  flex: 1;
  margin-left: 20px;
}
</style>
