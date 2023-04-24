import { API } from "@/model/apiCalls";
import { createRouter, createWebHistory } from "vue-router";
import HomePage from "../views/HomePage.vue";
import NProgress from "nprogress";
import "nprogress/nprogress.css"; // Import NProgress CSS

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
      path: "/pantry",
      name: "pantry",
      component: () => import("../views/pantryPage.vue"),
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
      path: "/forgotPassword",
      name: "forgotPassword",
      component: () => import("../views/ForgotPasswordPage.vue"),
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

    },
    {
      path: "/viewRecipe/:id",
      name: "viewRecipe",
      props: true,
      component: () => import("../views/ViewRecipePage.vue"),
    },
    {
      path: "/credits",
      name: "credits",
      component: () => import("../views/CreditPage.vue"),
    },
    {
      path: "/searchresults",
      name: "searchresults",
      component: () => import("../views/SearchResultPage.vue")
    }
  ],
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = API.instance.isLoggedIn();
  if (to.name === "createRecipe" && !isAuthenticated) next({ name: "Login" });
  if (to.name === "profilepage" && !isAuthenticated) next({ name: "Login" });
  if (to.name === "pantry" && !isAuthenticated) next({ name: "Login" });
  if (to.name === "profilepage" && !isAuthenticated) next({ name: "Login" });
  else next();
});

router.beforeResolve((to, from, next) => {
  // If this isn't an initial page load.
  if (to.name) {
    // Start the route progress bar.
    const element = document.querySelector("header");
    if (element) {
      element.style.borderColor = "var(--color-background)";
    }
    NProgress.start();
  }
  next();
});

router.afterEach((to, from) => {
  // Complete the animation of the route progress bar.
  NProgress.done();
  const element = document.querySelector("header");
  if (element) {
    element.style.borderColor = "var(--color-accent)";
  }
});


export default router;
