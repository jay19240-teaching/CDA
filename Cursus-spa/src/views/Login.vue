<script setup lang="ts">
import { ref, onMounted } from 'vue';
import router from '@/router';
import { useGuiStore } from '@/stores/Gui';
import { useNotifStore } from '@/stores/Notif';
import * as AccountService from '@/_services/AccountService';

const auth = ref({
  email: '',
  password: ''
});

const notifStore = useNotifStore();

onMounted(async () => {
  const guiStore = useGuiStore();
  guiStore.gui.title = '';
  guiStore.gui.titleHasBack = false;
});

function login() {
  AccountService.login(auth.value).then(() => {
    notifStore.setMessage('Connexion réussie !');
    router.push('/');
  });
}
</script>

<template>
  <div class="top-container">
    <form @submit.prevent="login">
      <h2 class="form-title">Connexion</h2>
      <div class="form-group">
        <input type="text" class="input" v-model="auth.email" placeholder="Email" />
      </div>
      <div class="form-group">
        <input type="password" class="input" v-model="auth.password" placeholder="Mot de passe" />
      </div>
      <div class="form-group">
        <button type="submit" class="button">Connexion</button>
      </div>
    </form>
  </div>
</template>