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
    path: "/tasks",
    name: "task",
    component: () => import("@/Page/Admin/Task/Index.vue"),
    meta: { title: 'Task', requiresAuth: true } 
  }
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
