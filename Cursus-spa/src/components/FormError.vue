<script setup lang="ts">
   const props = defineProps(['errors'])
</script>

<template>
    <div class="form-error" v-for="error in props.errors">{{ error }}</div>
</template>