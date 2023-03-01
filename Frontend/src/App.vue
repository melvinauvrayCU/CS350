<script setup lang="ts">
import { RouterView } from "vue-router";
import HeaderMenuComponent from "./components/HeaderMenuComponent.vue";
import FooterComponent from "./components/FooterComponent.vue";
</script>

<template>
  <div class="App">
    <!-- Common components of all pages, App.vue is the page always up -->

    <!-- Menu of our application, present on all pages so we put it in this file -->
    <HeaderMenuComponent />

    <!-- RouterView element, a native VueJs component which contains the content of each page -->
    <RouterView />

    <!-- Footer of the application, present on all pages so we put it in this file -->
    <FooterComponent />

  </div>
</template>
