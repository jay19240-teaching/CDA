import { createRouter, createWebHistory } from 'vue-router';
// -------------------------------------------------------------
import * as View from '@/views';
import Login from '@/views/Login.vue';
import { useUserStore } from '@/stores/User';
import { creatureResolver } from '@/_resolvers/CreatureResolver';
import * as AccountService from '@/_services/AccountService';
// -------------------------------------------------------------

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'home',
      component: View.Home,
      meta: { requiredLogin: false }
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
router.beforeResolve(async (to, from, next) => {
  const userStore = useUserStore();

  try {
    const res = await AccountService.getUser();
    userStore.setUser(res.data);
  } catch(err) {
    userStore.clearUser();
  }

  if (!to.meta.requiredLogin) {
    return next();
  }

  if (userStore.user.role == to.meta.role) {
    return next();
  }

  if (!userStore.isLogged && to.name !== 'Login') {
    return '/login';
  }
});

export default router;