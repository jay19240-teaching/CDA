import { ref } from 'vue';
import { defineStore } from 'pinia';

export const useGuiStore = defineStore('Gui', () => {
  const gui = ref({
    title: '',
    titleHasBack: false
  });

  function setTitle(title: string, hasBack: boolean) {
    gui.value.title = title;
    gui.value.titleHasBack = hasBack;
  }

  return {
    gui,
    setTitle
  };
});