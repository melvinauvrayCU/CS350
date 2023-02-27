<script lang="ts">
import { RouterLink } from "vue-router";

export default {
  name: "HeaderMenuComponent",
  components: {
    RouterLink,
  }
};
</script>
<template>
  <header>
    <h1>
      <RouterLink to="/">RecipeBuddy</RouterLink>
    </h1>

    <div class="flexFill"></div>

    <nav>
      <RouterLink to="/" exact>Home</RouterLink>
      <RouterLink to="/createRecipe" exact>Create Recipe</RouterLink>
      <RouterLink to = "/login" exact>Login</RouterLink>
      <RouterLink to = "/signup" exact>Signup</RouterLink>
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
  margin-bottom: 50px;
}

nav {
  display: flex;
  align-items: center;
  height: 100%;
}

a {
  text-decoration: none;
  color: var(--color-text);
}

nav a {
  box-shadow: inset 0 0 0 0 var(--color-text);
  padding: 0 1rem;
  margin: 0 10px;
  transition: color .3s ease-in-out, box-shadow .3s ease-in-out;
  font-size: 1.4em;
  line-height: 1.7;
}

nav a:hover {
  color: #fff;
  box-shadow: inset 200px 0 0 0 var(--color-text);
  ;
}

nav .router-link-active {
  box-shadow: inset 200px 0 0 0 var(--color-text);
  color: #fff;
}
</style>
