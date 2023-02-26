<script lang="ts">
import { API } from "@/model/apiCalls";
import PageTitle from "@/components/PageTitleComponent.vue";
import InputField from "@/components/InputFieldComponent.vue";
import CustomButton from "@/components/CustomButtonComponent.vue";

export default {
  name: "CreateRecipePage",
  components: {
    PageTitle,
    InputField,
    CustomButton
  },
  // In the first bracket, we define the types of the variables we will use,
  // And in the second bracket we define the initiale values.
  data(): {
    title: string,
    description: string,
    numberPeople: number,
    created: boolean,
  } {
    // We are setting the title and description datas that will be linked to the form.
    // And a boolean created variable, which will be true when a recipe has been created to display a success message.
    return {
      title: "",
      description: "",
      numberPeople: 1,
      created: false
    };
  },
  methods: {
    /**
     * Method called when clicking on the create recipe button.
     */
    createRecipe() {
      // We make sure that users have filled all fields
      if (this.title !== "" && this.description !== "") {

        // We do the API call to create a recipe.
        API.instance.createRecipe(this.title, this.description);

        // We reset the form
        this.title = "";
        this.description = "";

        // Here we set the created boolean value to true to display the success message
        // but we set a 2 seconds timeout to set it back to false to the message is not displayed forever.
        this.created = true;
        setTimeout(() => {
          this.created = false;
        }, 2000);

      }
    }
  }
};

</script>
<template>
  <div class="CreateRecipePage">

    <div class="contentConainer">

      <PageTitle text="Create a new recipe !" />

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


      <CustomButton text="Create the recipe !" @clicked="createRecipe" />

      <!-- This is the confirmation message, that we display only if the created variable is set to true ! -->
      <p v-if="created">Recipe created !</p>

    </div>

  </div>
</template>

<style scoped>
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

.flexHorizontal {
  display: flex;
  flex-direction: row;
  width: 100%;
}


.flexHorizontal div:nth-child(1) {
  flex: 2;
  margin-right: 20px;
}

.flexHorizontal div:nth-child(2) {
  flex: 1;
  margin-left: 20px;
}
</style>
