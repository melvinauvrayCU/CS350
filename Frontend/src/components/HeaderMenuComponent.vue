<script lang="ts">
import { RouterLink } from "vue-router";
import { API } from "@/model/apiCalls";
import CustomButton from "@/components/formComponents/CustomButtonComponent.vue";

export default {
  name: "HeaderMenuComponent",
  components: {
    RouterLink,
    CustomButton
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
      <RouterLink to="/" title="Go back to home page">
        <img src="@/assets/logo.png" />
        RecipeBuddy
      </RouterLink>
    </h1>

    <div class="flexFill"></div>

    <nav v-if="!$route.meta.hideNavbar">
      <RouterLink to="/">
        <CustomButton type="neutral" :effect="$route.name === 'home' ? 'plain' : 'empty'" text="Home" titleText="Home" />
      </RouterLink>
      <RouterLink v-if="checkIfLoggedIn()" to="/createRecipe">
        <CustomButton type="neutral" :effect="$route.name === 'createRecipe' ? 'plain' : 'empty'" text="Create Recipe"
          titleText="Create Recipe" />
      </RouterLink>
      <RouterLink v-if="checkIfLoggedIn()" to="/pantry">
        <CustomButton type="neutral" :effect="$route.name === 'pantry' ? 'plain' : 'empty'" text="Pantry"
          titleText="Pantry" />
      </RouterLink>
      <RouterLink v-if="!checkIfLoggedIn()" to="/login">
        <CustomButton type="neutral" :effect="$route.name === 'Login' ? 'plain' : 'empty'" text="Login"
          titleText="Login" />
      </RouterLink>
      <CustomButton v-if="checkIfLoggedIn()" @click="clickLogout" type="neutral" effect="empty" text="Logout"
        titleText="Logout" />
      <RouterLink to="/signup" v-if="!checkIfLoggedIn()">
        <CustomButton type="neutral" :effect="$route.name === 'Signup' ? 'plain' : 'empty'" text="Signup"
          titleText="Signup" />
      </RouterLink>

    </nav>
  </header>
</template>

<style scoped>
header {
  width: 100%;
  display: flex;
  flex-direction: row;
  padding: 15px 50px;
  height: 80px;
  align-items: center;
  margin-bottom: 50px;
  border-bottom: 3px solid var(--color-accent);
  position: fixed;
  top: 0;
  left: 0;
  background-color: var(--color-background);
  box-shadow: rgb(0 0 0 / 22%) 0px 2px 18px 0px;
  z-index: 10000;
}

nav {
  display: flex;
  align-items: center;
  height: 100%;
}

nav>* {
  margin: 0 10px;
}

/* a {
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
} */

h1 a {
  font-family: "title";
  color: var(--color-accent);
  transition-property: color;
  transition-duration: .4s;
  text-decoration: none;
  cursor: pointer;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
}

h1 a:hover {
  color: var(--color-accent-light)
}

h1 a img {
  height: 50px;
  margin-right: 10px;
}
</style>
