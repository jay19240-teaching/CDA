<script setup lang="ts">
import { ref } from 'vue';
import router from '@/router';
import * as AccountService from '@/_services/AccountService';

const user = ref({
  email: '',
  password: ''
});

function login() {
  AccountService.login(user.value).then(() => {
    router.push('/');
  });
}
</script>

<template>
  <div>
    <form @submit.prevent="login">
      <h2 class="form-title">Connexion</h2>
      <div class="form-group">
        <label for="user_email">Email</label>
        <input type="text" id="user_email" v-model="user.email" />
      </div>
      <div class="form-group">
        <label for="user_password">Mot de passe</label>
        <input type="text" id="user_password" v-model="user.password" />
      </div>
      <div class="form-group">
        <button type="submit" class="button">Connexion</button>
      </div>
    </form>
  </div>
</template>

<style>
form {
  max-width: 300px;
  margin: 0 auto;
}
.form-title {
  text-align: center;
  border-bottom: 1px black solid;
  margin-bottom:10px;
}
.form-group {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
}
</style>