<script setup lang="ts">
import { useNotifStore } from '@/stores/Notif';
const notifStore = useNotifStore();

function close() {
  notifStore.setActive(false);
}
</script>

<template>
  <div id="notif_ctn" v-if="notifStore.isActive">
    <span id="notif_close" @click="close">X</span>
    <p id="notif_text">{{ notifStore.notif.message }}</p>
  </div>
</template>

<style>
#notif_ctn {
  width: 230px;
  height: 60px;
  background-color: red;
  position: absolute;
  top: 40px;
  right: 15px;
  color: #ffffff;
}

#notif_close {
  position: absolute;
  top: 5px;
  right: 5px;
  font-size: 8px;
  height: 10px;
  width: 10px;
  border: solid 2px white;
  border-radius: 10px;
  line-height: 10px;
  text-align: center;
  cursor: pointer;
}

#notif_text {
  text-align: left;
  padding-left: 10px;
}
</style>