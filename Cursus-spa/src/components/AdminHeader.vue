<script setup lang="ts">
import router from '@/router';
import * as AccountService from '@/_services/AccountService';

function logout() {
  AccountService.logout();
  router.push('/');
}
</script>

<template>
  <div class="ad_head">
    Header Admin
    <button @click="logout()">Logout</button>
  </div>
</template>

<style>
.ad_head {
  border-bottom: solid 1px black;
}

button {
  float: right;
}
</style>