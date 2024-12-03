import { ref, computed } from 'vue';
import { defineStore } from 'pinia';

interface ConnectedUser {
  id: number | null;
  email: string | null;
  role: string | null;
};

export const useUserStore = defineStore('user', () => {
  const user = ref<ConnectedUser>({
    id: -1,
    email: '',
    role: ''
  });

  user.value.id = localStorage.getItem('id') as number | null;
  user.value.email = localStorage.getItem('email');
  user.value.role = localStorage.getItem('role');

  const isLogged = computed(() => {
    return !!user.value.email;
  });

  function setUser(data: ConnectedUser) {
    user.value.id = data.id;
    user.value.email = data.email;
    user.value.role = data.role;

    localStorage.setItem('id', String(data.id));
    localStorage.setItem('email', String(data.email));
    localStorage.setItem('role', String(data.role));
  }

  function clearUser() {
    setUser({
      id: -1,
      email: '',
      role: ''
    });
  }

  return {
    user,
    isLogged,
    setUser,
    clearUser
  };
});