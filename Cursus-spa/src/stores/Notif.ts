import { ref, computed } from 'vue';
import { defineStore } from 'pinia';

export const useNotifStore = defineStore('notif', () => {
  const notif = ref({
    isActive: false,
    message: ''
  });

  const isActive = computed(() => {
    return notif.value.isActive;
  });

  function setMessage(message: string) {
    notif.value.message = message;
    notif.value.isActive = true;
  }

  function setActive(active: boolean) {
    notif.value.isActive = false;
  }

  return {
    notif,
    isActive,
    setMessage,
    setActive
  };
});