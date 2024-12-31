<script setup lang="ts">
import { ref, onMounted } from 'vue';
import router from '@/router';
import { useGuiStore } from '@/stores/Gui';
import { useNotifStore } from '@/stores/Notif';
import * as AccountService from '@/_services/AccountService';
import FormError from '@/components/FormError.vue';

const auth = ref({
  email: '',
  password: ''
});

const errors = ref<any>({});
const notifStore = useNotifStore();

onMounted(async () => {
  const guiStore = useGuiStore();
  guiStore.gui.title = '';
  guiStore.gui.titleHasBack = false;
});

async function login() {
  try {
    await AccountService.login(auth.value).then(() => {
      notifStore.setMessage('Connexion réussie !');
      router.push('/');
    });
  } catch(error: any) {
    if (error.response.status == 401) {
      errors.value.general = 'Identifiant ou mot de passe incorrect.';
    }
    else {
      errors.value = error.response.data.errors;
    }    
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