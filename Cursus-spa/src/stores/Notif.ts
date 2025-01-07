import { ref } from 'vue';
import { defineStore } from 'pinia';

export const useNotifStore = defineStore('Notif', () => {
  const notif = ref({
    messages: new Array<string>(),
    count: 0
  });

  function pushMessage(message: string) {
    notif.value.messages.push(message);
    notif.value.count++;

    setTimeout(() => {
      notif.value.messages.splice(notif.value.count - 1, 1);
      notif.value.count--;
    }, 1000);
  }

  return {
    notif,
    pushMessage
  };
});