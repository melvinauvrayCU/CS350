import { API } from "@/model/apiCalls";
import { createRouter, createWebHistory } from "vue-router";
import HomePage from "../views/HomePage.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/:messageTextParam?/:messageTypeParam?",
      name: "home",
      component: HomePage,
      props: route => ({ messageTextParam: route.params.messageTextParam, messageTypeParam: route.params.messageTypeParam })
    },
    {
      path: "/createRecipe/:id?",
      props: true,
      name: "createRecipe",
      component: () => import("../views/CreateRecipePage.vue"),
    },
    {
      path: "/login",
      name: "Login",
      component: () => import("../views/LoginPage.vue"),
      meta: {
        hideNavbar: true,
      }
    },
    {
      path: "/signup",
      name: "Signup",
      component: () => import("../views/SignupPage.vue"),
      meta: {
        hideNavbar: true,
      }
    },
    {
      path:"/viewRecipe/:id",
      name:"viewRecipe",
      props: true,
      component: () => import("../views/ViewRecipePage.vue"),
    },
  ],
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = API.instance.isLoggedIn();
  if (to.name === "createRecipe" && !isAuthenticated) next({ name: "Login" });
  else next();
});

export default router;
