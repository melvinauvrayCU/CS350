<script lang="ts">
import { RouterLink } from "vue-router";

export default {
  name: "HeaderMenu",
  components: {
    RouterLink,
  },
};
</script>
<template>
  <header>
    <h1>RecipeBuddy</h1>

    <div class="flexFill"></div>

    <nav>
      <RouterLink to="/">Home</RouterLink>
      <RouterLink to="/about">About</RouterLink>
    </nav>
  </header>
</template>

<style scoped>
header {
  width: 100%;
  background-color: var(--color-primary);
  display: flex;
  flex-direction: row;
  padding: 15px 50px;
  height: 80px;
  align-items: center;
}
</style>
