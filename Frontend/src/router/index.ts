import { API } from "@/model/apiCalls";
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
      path: "/profile",
      name: "profilepage",
      component: () => import("../views/ProfilePage.vue"),

    },
    {
      path: "/editprofile",
      name: "editprofile",
      component: () => import("../views/EditProfile.vue"),

    }
  ],
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = API.instance.isLoggedIn();
  if (to.name === "createRecipe" && !isAuthenticated) next({ name: "Login" });
  if (to.name === "profilepage" && !isAuthenticated) next({ name: "Login" });
  else next();
});



export default router;
