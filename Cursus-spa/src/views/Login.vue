<script setup lang="ts">
import { ref, onMounted } from 'vue';
import router from '@/router';
import { useGuiStore } from '@/stores/Gui';
import { useNotifStore } from '@/stores/Notif';
import { useUserStore } from '@/stores/User';
import * as AccountService from '@/_services/AccountService';
import * as WSService from '@/_services/WSService';
import FormError from '@/components/FormError.vue';
import { handleError } from '@/_utils/errors-handler';

const auth = ref({
  email: '',
  password: ''
});

const errors = ref<any>({});
const notifStore = useNotifStore();

onMounted(async () => {
  const guiStore = useGuiStore();
  const userStore = useUserStore();

  guiStore.gui.title = '';
  guiStore.gui.titleHasBack = false;

  if (userStore.isLogged) {
    router.push('/');
  }
});

async function login() {
  try {
    await AccountService.login(auth.value);
    notifStore.pushMessage('Connexion réussie !');
    WSService.subscribeNotifications();
    router.push('/');
  } catch(axiosError: any) {
    notifStore.pushMessage('Echec de connexion !');
    errors.value = handleError(axiosError);
  }
}
</script>

<template>
  <div class="top-container">
    <div v-if="errors.general" class="text-center text-red-500 mb-5">
      {{ errors.general }}
    </div>
    <form @submit.prevent="login">
      <h2 class="form-title">Connexion</h2>
      <div class="form-group">
        <input type="text" class="input" v-model="auth.email" placeholder="Email" />
        <FormError :errors="errors.email"/>
      </div>
      <div class="form-group">
        <input type="password" class="input" v-model="auth.password" placeholder="Mot de passe" />
        <FormError :errors="errors.password"/>
      </div>
      <div class="form-group">
        <button type="submit" class="button">Connexion</button>
      </div>
    </form>
  </div>
</template>