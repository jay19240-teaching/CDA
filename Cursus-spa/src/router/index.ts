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
    { path: '/edit/:id', name: 'edit', component: View.Edit, meta: { roles: ['ROLE_USER', 'ROLE_ADMIN'] }, props: true },
    { path: '/settings', name: 'settings', component: View.Settings, meta: { roles: ['ROLE_USER', 'ROLE_ADMIN'] } },
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

  if (!userStore.isLogged && to.meta.roles && to.name !== 'Login') {
    return '/login';
  }

  if (!to.meta.roles) {
    return next();
  }

  if (to.meta.roles instanceof Array && to.meta.roles.indexOf(userStore.user.role) != -1) {
    return next();
  }

  return '/forbidden';
});

export default router;