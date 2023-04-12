<script setup lang="ts">
import { RouterView } from "vue-router";
import { reactive } from "vue";
import HeaderMenuComponent from "./components/HeaderMenuComponent.vue";
import FooterComponent from "./components/FooterComponent.vue";
import TimerComponent, { type timerObject } from "./components/TimerComponent.vue";

interface TimerData {
  value: timerObject | undefined;
}
const datasTimer = reactive<TimerData>({
  // Initialize the datasTimer object with a "value" property
  value: undefined,
});
function startTimer(datas: any) {
  datasTimer.value = datas;
}
</script>

<template>
  <div class="App">
    <!-- Common components of all pages, App.vue is the page always up -->

    <!-- Menu of our application, present on all pages so we put it in this file -->
    <HeaderMenuComponent />

    <Transition>
      <!-- RouterView element, a native VueJs component which contains the content of each page -->
      <RouterView @startTimer="startTimer" />
    </Transition>
    <Transition>
      <TimerComponent v-model="datasTimer.value" />
    </Transition>

    <!-- Footer of the application, present on all pages so we put it in this file -->
    <FooterComponent />

  </div>
</template>

<style scoped>
.v-enter-active,
.v-leave-active {
  transition: all 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
