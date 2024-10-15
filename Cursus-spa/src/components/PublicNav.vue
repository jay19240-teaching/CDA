<script setup lang="ts">
import { useUserStore } from '@/stores/User';
import * as AccountService from '@/_services/AccountService';
const userStore = useUserStore();
</script>

<template>
  <div class="navs px-2">
    <nav>
      <router-link to='/'>Accueil</router-link> |
      <router-link to='/creatures-list'>Creatures</router-link> |
      <router-link to='/contact'>Contact</router-link> |
      <router-link to='/admin/dashboard'>Admin</router-link>
    </nav>
    <nav class="nav-auth">
      <div v-if="userStore.isLogged">
        <router-link to='/creatures-create' v-if="userStore.isLogged">Créer</router-link> |
        <span>{{ userStore.user.email }}</span>
      </div>
      <router-link to='/login' v-if="!userStore.isLogged">Connexion</router-link> |
      <button @click="AccountService.logout()" v-if="userStore.isLogged">Déconnexion</button> |
    </nav>
  </div>
</template>

<style>

</style>