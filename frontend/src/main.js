import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

const app = createApp(App)

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - TBUY`;
    next();
  });

app.use(router)

app.mount('#app')
