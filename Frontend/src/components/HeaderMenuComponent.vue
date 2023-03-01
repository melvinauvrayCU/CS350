<script lang="ts">
import { RouterLink } from "vue-router";
import { API } from "@/model/apiCalls";

export default {
  name: "HeaderMenuComponent",
  components: {
    RouterLink,
  },
  methods: {
    clickLogout() {
      // We call the API to logout
      if (API.instance.logout()) {
        this.$router.push("/");
        // We force the refresh of the menu component to it recall the checkIfLoggedIn method.
        this.$forceUpdate();
      }
    },
    checkIfLoggedIn() {
      return API.instance.isLoggedIn();
    }
  }
};
</script>
<template>
  <header>
    <h1>
      <RouterLink to="/">RecipeBuddy</RouterLink>
    </h1>

    <div class="flexFill"></div>

    <nav v-if="!$route.meta.hideNavbar">
      <RouterLink to="/" exact>Home</RouterLink>
      <RouterLink v-if="checkIfLoggedIn()" to="/createRecipe" exact>Create Recipe</RouterLink>
      <RouterLink v-if="!checkIfLoggedIn()" to="/login" exact>Login</RouterLink>
      <a v-if="checkIfLoggedIn()" @click="clickLogout">Logout</a>
      <RouterLink to="/signup" v-if="!checkIfLoggedIn()" exact>Signup</RouterLink>

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
  cursor: pointer;
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
