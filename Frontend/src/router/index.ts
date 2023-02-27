import { createRouter, createWebHistory } from "vue-router";
import HomePage from "../views/HomePage.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomePage,
    },
    {
      path: "/createRecipe",
      name: "createRecipe",
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import("../views/CreateRecipePage.vue"),
    },
    {
      path: "/login",
      name: "Login",
    
      component: () => import("../views/CreateLoginPage.vue"),
    },
    {
      path: "/signup",
      name: "Signup",
    
      component: () => import("../views/CreateSignupPage.vue"),
    },
  ],
});

export default router;
