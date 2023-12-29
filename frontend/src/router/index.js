import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import storage from "../Services/storage";
import SellerLogin from "@/Page/User/Auth/Seller/Login.vue";

const routes = [
  {
    path: "/",
    name: "login",
    component: SellerLogin,
    meta: { title: 'Login' } 
  },
  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (About.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import("../views/AboutView.vue"),
  },
  {
    path: "/dashboard",
    name: "dashboard",
    component: () => import("@/Page/Admin/Dashboard/Index.vue"),
    meta: { title: 'Dashboard', requiresAuth: true } 
  },
  {
    path: "/banner",
    name: "banner",
    component: () => import("@/Page/Admin/Banner/Index.vue"),
    meta: { title: 'Banner', requiresAuth: true }
  },
  {
    path: "/banner/create",
    name: "CreateBanner",
    component: () => import("@/Page/Admin/Banner/Create.vue"),
    meta: { title: 'Banner', requiresAuth: true }
  },
];
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !localStorage.getItem("token")) {
    return router.push({
      path: "/",
    });
  } else {
    next();
  }
});

export default router;
