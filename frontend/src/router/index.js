import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue';
import storage from '../Services/storage';
import SellerLogin from '@/Page/User/Auth/Seller/Login.vue'

const  routes = [
  {
    path: '/',
    name: 'login',
    component: SellerLogin
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (About.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import('../views/AboutView.vue')
  },

]
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !localStorage.getItem('token')) {


      // return { name: 'Login' };

      return router.push({
          path: '/login'
      });

  }
  else {
      next();
  }
  
});

export default router
