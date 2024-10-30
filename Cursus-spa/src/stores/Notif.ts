import { ref } from 'vue';
import { defineStore } from 'pinia';

export const useNotifStore = defineStore('Notif', () => {
  const notif = ref({
    message: ''
  });

  function setMessage(message: string) {
    notif.value.message = message;
  }

  return {
    notif,
    setMessage
  };
});