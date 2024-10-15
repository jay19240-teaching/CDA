import { createRouter, createWebHistory } from 'vue-router';
// -------------------------------------------------------------
import * as Public from '@/views/public';
import Login from '@/views/auth/Login.vue';
import { useUserStore } from '@/stores/User';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'public',
      component: Public.PublicLayout,
      children: [
        { path: '', name: 'home', component: Public.Home },
        { path: 'creatures-list', name: 'creatures-list', component: Public.Creatures },
        { path: 'creatures-create', name: 'creatures-create', component: Public.CreatureCreate, meta: { role: 'ROLE_USER' }},
        { path: 'creatures-edit/:id(\\d+)', name: 'creatures-edit', component: Public.CreatureEdit, meta: { role: 'ROLE_USER' }, props: true },
        { path: 'contact', name: 'contact', component: Public.Contact },
      ]
    },
    {
      path: '/login', name: 'Login', component: Login
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