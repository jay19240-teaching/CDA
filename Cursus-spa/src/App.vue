<script setup lang="ts">
import { RouterView } from 'vue-router';
import { ref, onMounted } from 'vue';
import NotifBar from '@/components/NotifBar.vue';
import { tsParticles } from "@tsparticles/engine";
import { loadAll } from "@tsparticles/all";
import config from './config/tsparticles';

onMounted(async () => {
  await loadAll(tsParticles);
  await tsParticles.load(config);
});

const menuOpened = ref(false);

function toggleMenu() {
  menuOpened.value = !menuOpened.value;
}
</script>

<template>
  <NotifBar />
  <header class="header">
    <div id="particles" class="particles"></div>
    <img src="/logo.png" id="logo" class="header-logo" />
  </header>
  <RouterView />

  <div class="nav">
    <button class="nav-btn" @click="toggleMenu" :class="{ active: menuOpened }">
      <span class="material-symbols-outlined nav-btn-icon nav-btn-icon--open">menu</span>
      <span class="material-symbols-outlined nav-btn-icon nav-btn-icon--close">close</span>
    </button>
    <nav class="nav-bar" :class="{ active: menuOpened }">
      <div class="nav-bar-items">
        <router-link class="nav-bar-items-li" :to="{ name: 'home'}">
          <span class="material-symbols-outlined nav-bar-items-li-icon">search</span>
          <span>Rechercher</span>
        </router-link>
        <router-link class="nav-bar-items-li" :to="{ name: 'creatures-list'}">
          <span class="material-symbols-outlined nav-bar-items-li-icon">star</span>
          <span>Favoris</span>
        </router-link>
        <router-link class="nav-bar-items-li" :to="{ name: 'creatures-list'}">
          <span class="material-symbols-outlined nav-bar-items-li-icon">settings</span>
          <span>Paramètres</span>
        </router-link>
        <router-link class="nav-bar-items-li" :to="{ name: 'creatures-list'}">
          <span class="material-symbols-outlined nav-bar-items-li-icon">logout</span>
          <span>Déconnexion</span>
        </router-link>
      </div>
    </nav>
  </div>
  <div class="navOverlay" :class="{ active: menuOpened }" @click="toggleMenu"></div>
</template>