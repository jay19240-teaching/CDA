<script setup lang="ts">
import CreateEdit from '@/components/CreateEdit.vue';
const props = defineProps(['id']);
</script>

<template>
    <CreateEdit :id="props.id"/>
</template>