<script setup lang="ts">
   const props = defineProps(['messages'])
</script>

<template>
    <div class="form-error" v-for="msg in props['messages']">{{ msg }}</div>
</template>