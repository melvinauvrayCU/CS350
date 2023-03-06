<script lang="ts">
import StepView from "@/components/StepViewComponent.vue";
import { API } from "@/model/apiCalls";
import type { Recipe } from "@/model/recipeModel";
 export default{
    name: "ViewRecipePage",
    props: {
        id: { type: String, default: "0" }
    },
    data(): {
        recipe: Recipe;
    } {
        return {
            recipe: API.instance.getRecipe(parseInt(this.id)),
        };
    },
    components: { 
        StepView },
};

</script>
<template>
  <main class="ViewRecipePage">
    <h1>{{ recipe.title }}</h1>
    <h2>{{ recipe.description }}</h2>
    <p>Cooks for {{ recipe.numberPeople }} people</p>
    <transition-group name="list">
        <StepView v-for="(step, index) in recipe.steps" :key="step.stepId" :stepObject="step"
          :stepIndex="index + 1" :stepIndexLength="recipe.steps.length"
          v-model:descriptionModelValue="step.descriptionValue" v-model:cooktimeModelValue="step.cooktimeValue"
          v-model:preptimeModelValue="step.preptimeValue"  />
      </transition-group>

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

.ViewRecipePage {
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