import { createRouter, createWebHistory } from 'vue-router';
// -------------------------------------------------------------
import * as View from '@/views';
import Login from '@/views/Login.vue';
import { useUserStore } from '@/stores/User';
import { creatureResolver } from '@/_resolvers/CreatureResolver';
// -------------------------------------------------------------

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: View.Home
    },
    {
      path: '/creatures-show/:id(\\d+)',
      name: 'creatures-show',
      component: View.Detail,
      props: true,
      beforeEnter: creatureResolver
    },
    { path: '/create', name: 'create', component: View.Create },
    { path: '/edit/:id', name: 'edit', component: View.Edit, props: true },
    { path: '/settings', name: 'settings', component: View.Settings },
    {
      path: '/login', name: 'login', component: Login
    },
    {
      path: '/:pathMatch(.*)*', redirect: '/'
    }
  ]
});

// Gestion du guard
router.beforeEach((to, from, next) => {
  const userStore = useUserStore();
  const role = userStore.user.role;

  if (!to.meta.role) {
    return next();
  }
  else if (role == to.meta.role) {
    return next();
  }

  router.push('/login');
});

export default router;