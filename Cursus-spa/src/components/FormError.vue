<script setup lang="ts">
   const props = defineProps(['errors'])
</script>

<template>
    <div>
        <div class="form-error" v-for="error in props.errors">{{ error }}</div>
    </div>
</template>