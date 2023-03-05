<script lang="ts">
import { API } from "@/model/apiCalls";
import PageTitle from "@/components/PageTitleComponent.vue";
import InputField from "@/components/formComponents/InputFieldComponent.vue";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";
import StepCreate from "@/components/createRecipePage/StepCreateComponent.vue";
import PageSeparator from "@/components/PageSeparatorComponent.vue";
import BackgroundIcons from "@/components/BackgroundIconsComponent.vue";
import { Recipe, type Step } from "@/model/recipeModel";
import MessageComponent from "@/components/MessageComponent.vue";
import router from "@/router/index";

export default {
  name: "CreateRecipePage",
  components: {
    PageTitle,
    InputField,
    CustomButton,
    StepCreate,
    PageSeparator,
    BackgroundIcons,
    MessageComponent
  },
  props: {
    /** Id is the props we retrieve from URL parameter when we want to edit a recipe */
    id: { type: String, default: "" },
  },
  // In the first bracket, we define the types of the variables we will use,
  // And in the second bracket we define the initiale values.
  data(): {
    recipeTempObject: Recipe,
    stepCounter: number,
    mode: "create" | "edit",
    messageText: string,
    messageType: "success" | "warning",
  } {
    // We are setting the title and description datas that will be linked to the form.
    // And a boolean created variable, which will be true when a recipe has been created to display a success message.
    return {
      stepCounter: 1,
      recipeTempObject: new Recipe("", "", 1, [{
        stepId: 1,
        descriptionValue: "",
        cooktimeValue: "",
        preptimeValue: "",
      }]),
      mode: "create",
      messageText: "",
      messageType: "success"
    };
  },
  methods: {
    /**
     * Method called when clicking on the create recipe button.
     */
    createRecipe(): void {

      if (this.verifyInputs()) {
        // No errors, send datas
        const result = API.instance.createRecipe(this.recipeTempObject);

        if (result) {
          // We redirect to home page with a success message
          router.push({ name: "home", params: { messageTextParam: "Recipe created !", messageTypeParam: "success" } });
        } else {
          this.messageType = "warning";
          this.messageText = "An error has occured";
        }
      } else {
        // errors, don't send datas.
        this.messageType = "warning";
        this.messageText = "Some mandatory fields are empty";
      }

    },
    editRecipe(): void {
      if (this.verifyInputs()) {
        // No errors, send datas
        const result = API.instance.editRecipe(parseInt(this.id), this.recipeTempObject);

        if (result) {
          // We redirect to home page with a success message
          router.push({ name: "home", params: { messageTextParam: "Recipe edited !", messageTypeParam: "success" } });
        } else {
          this.messageType = "warning";
          this.messageText = "An error has occured";
        }
      } else {
        // errors, don't send datas.
        this.messageType = "warning";
        this.messageText = "Some mandatory fields are empty";
      }
    },
    /**
     * This check if the inputs are correct, return true if there is no error, false otherwise (eg: title empty)
     */
    verifyInputs(): boolean {
      let noErrors: boolean = true;
      if (this.recipeTempObject.title === ""
        || this.recipeTempObject.description === "" || this.recipeTempObject.description.length > 650
        || this.recipeTempObject.numberPeople < 1)
        noErrors = false;

      this.recipeTempObject.steps.forEach(step => {
        if (step.descriptionValue === "") {
          noErrors = false;
          console.error("description du step ", step, " vide");
        }

      });
      return noErrors;
    }
    ,
    addStep(): void {
      this.stepCounter++;
      this.recipeTempObject.steps.push({
        stepId: this.stepCounter,
        descriptionValue: "",
        cooktimeValue: "",
        preptimeValue: "",
      });
    },

    deleteStep(stepObjectToDelete: Step): void {
      this.recipeTempObject.steps = this.recipeTempObject.steps.filter(step => step.stepId !== stepObjectToDelete.stepId);
    }

  },
  created() {
    // If the id parameter is not empty, then it means we will edit a recipe, so we get the current recipe from an API call and change the mode
    if (this.id !== "") {
      const recipeObject = API.instance.getRecipe(parseInt(this.id));
      if (recipeObject !== undefined) {
        this.recipeTempObject = recipeObject;
        this.mode = "edit";
      }
    }
  }
};

</script>
<template>
  <main class="CreateRecipePage">
    <div class="contentConainer">

      <PageTitle :text="mode === 'create' ? 'Create a new recipe !' : 'Edit the recipe : ' + recipeTempObject.title" />

      <PageSeparator title="🍔 Global informations about your recipe" />

      <div class="flexHorizontal">
        <InputField id="recipeTitle" labelText="Recipe Title:" max-length="200"
          placeholder="Please enter the recipe title..." v-model="recipeTempObject.title" :mandatory="true" />
        <InputField id="numberPeople" labelText="Number of people:"
          placeholder="Please enter the number of people this recipe is for..." v-model="recipeTempObject.numberPeople"
          inputType="number" min="1" max="50" :mandatory="true" />
      </div>

      <InputField id="recipeDescription" labelText="Recipe description:"
        placeholder="Tell us some global informations about your recipe..." v-model="recipeTempObject.description"
        :mandatory="true" inputType="textarea" initialHeight="100" maxLength="650" />

      <PageSeparator title="📜 Give us the steps to complete your recipe" />

      <transition-group name="list">
        <StepCreate v-for="(step, index) in recipeTempObject.steps" :key="step.stepId" :stepObject="step"
          :stepIndex="index + 1" :stepIndexLength="recipeTempObject.steps.length"
          v-model:descriptionModelValue="step.descriptionValue" v-model:cooktimeModelValue="step.cooktimeValue"
          v-model:preptimeModelValue="step.preptimeValue" @stepDeleted="deleteStep" />
      </transition-group>

      <div class="containerAddStep">
        <CustomButton text="Add a new step" type="success" effect="plain" icon="add" titleText="Click to add a new step"
          @clicked="addStep" />
        <hr>
      </div>


      <CustomButton v-if="mode === 'create'" type="neutral" effect="plain" text="Create the recipe !"
        titleText="Click to create the recipe" @clicked="createRecipe" />
      <CustomButton v-else type="neutral" effect="plain" text="Edit your recipe !" titleText="Click to edit this recipe"
        @clicked="editRecipe" />


    </div>

    <BackgroundIcons />
    <MessageComponent :type="messageType" v-model="messageText" />

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
