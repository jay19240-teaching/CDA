<script setup lang="ts">
    import { ref } from 'vue';

    const props = defineProps(['src', 'defaultSrc', 'path', 'class']);
    const imageLoading = ref(false);
</script>

<template>
    <div v-if="!imageLoading" :class="'ph-item ' + props.class">
        <div class="ph-picture"></div>
    </div>
    <img v-if="props.src" :src="props.path + props.src" :class="props.class" @load="imageLoading = true" :hidden="!imageLoading" />
    <img v-if="!props.src" :src="props.path + props.defaultSrc" :class="props.class" @load="imageLoading = true" :hidden="!imageLoading" />
</template>

<style lang="css" scoped>
    .ph-item {
        padding: 0;
        border: 0;
        @apply border-delta;
    }

    .ph-picture {
        margin-bottom: 0;
    }

    img, .ph-item {
        height: 120px;
        max-height: 120px;
        margin-bottom: 10px;
    }
</style>