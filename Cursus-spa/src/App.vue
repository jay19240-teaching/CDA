<script setup lang="ts">
import { RouterView } from 'vue-router';
import { ref, onMounted } from 'vue';
import { notification } from 'ant-design-vue';
import { useGuiStore } from '@/stores/Gui';
import { useUserStore } from '@/stores/User';
import { useNotifStore } from '@/stores/Notif';
import { tsParticles } from "@tsparticles/engine";
import { loadAll } from "@tsparticles/all";
import config from './config/tsparticles';
import router from './router';
import * as AccountService from '@/_services/AccountService';
import WS from '@/_services/WSService';

const [api, contextHolder] = notification.useNotification();
const menuOpened = ref(false);
const guiStore = useGuiStore();
const userStore = useUserStore();
const notifStore = useNotifStore();

function toggleMenu() {
  menuOpened.value = !menuOpened.value;
}

function back() {
  router.go(-1);
}

notifStore.$subscribe((mutation, state) => {
  api.info({ message: state.notif.message });
});

async function goto(name: string) {
  toggleMenu();
  router.push({ name: name });
}

async function logout() {
  await AccountService.logout();
  toggleMenu();
  notifStore.setMessage('Déconnexion réussie !');
  router.push('/');
}

onMounted(async () => {
  await loadAll(tsParticles);
  await tsParticles.load(config);

  WS.channel('notification.' + userStore.user.id)
  .listen('.admin-notified', (e: string) => {
    notifStore.setMessage('Un utilisateur vient d\'ajouter un pokemon à ta collection !');
  });
});
</script>

<template>
  <header class="header">
    <div id="particles" class="particles"></div>
    <router-link :to="{name: 'home'}">
      <img src="/logo.png" id="logo" class="header-logo" />
    </router-link>
    <div class="header-nav">
      <button class="header-nav-btn" v-if="guiStore.gui.titleHasBack" @click="back">
        <span class="material-symbols-outlined nav-btn-icon nav-btn-icon--open">arrow_back</span>
      </button>
      <div class="header-nav-title">{{ guiStore.gui.title }}</div>
    </div>
  </header>
  <RouterView />
  <contextHolder />
  <div class="nav">
    <button class="nav-btn" @click="toggleMenu" :class="{ active: menuOpened }">
      <span class="material-symbols-outlined nav-btn-icon nav-btn-icon--open">menu</span>
      <span class="material-symbols-outlined nav-btn-icon nav-btn-icon--close">close</span>
    </button>
    <nav class="nav-bar" :class="{ active: menuOpened }">
      <div class="nav-bar-user" v-if="userStore.isLogged">
        Bienvenue {{ userStore.user.email }} !
      </div>
      <div class="nav-bar-items">
        <router-link class="nav-bar-items-li" :to="{ name: 'home'}" @click.native="toggleMenu">
          <span class="material-symbols-outlined nav-bar-items-li-icon">home</span>
          <span>Bestiaire</span>
        </router-link>
        <router-link class="nav-bar-items-li" :to="{ name: 'create'}" @click.native="toggleMenu">
          <span class="material-symbols-outlined nav-bar-items-li-icon">info</span>
          <span>A propos</span>
        </router-link>
        <router-link class="nav-bar-items-li" :to="{ name: 'login'}" @click.native="toggleMenu" v-if="!userStore.isLogged">
          <span class="material-symbols-outlined nav-bar-items-li-icon">login</span>
          <span>Connexion</span>
        </router-link>
        <div class="nav-bar-items-li" @click="goto('create')" v-if="userStore.isLogged">
          <span class="material-symbols-outlined nav-bar-items-li-icon">add</span>
          <span>Ajouter une créature</span>
        </div>
        <div class="nav-bar-items-li" @click="logout" v-if="userStore.isLogged">
          <span class="material-symbols-outlined nav-bar-items-li-icon">logout</span>
          <span>Déconnexion</span>
        </div>
      </div>
    </nav>
  </div>
  <div class="overlay" :class="{ active: menuOpened }" @click="toggleMenu"></div>
</template>