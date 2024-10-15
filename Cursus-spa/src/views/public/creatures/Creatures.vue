<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import * as CreatureService from '@/_services/CreatureService';

const pagination = ref<CreatureService.CreaturePagination>();
const page = ref(1);

onMounted(async () => {
  pagination.value = await CreatureService.paginateCreatures({ page: 1});
});

const comptage = computed(() => {
  return (pagination.value) ? ` Il y a ${pagination.value.maxPages} pages` : ' Aucun creatures';
});

const prevActive = computed(() => {
  return page.value > 1;
});

const nextActive = computed(() => {
  return pagination.value && page.value < pagination.value.maxPages;
});

function handleDelete(index: number) {
  if (!pagination.value) {
    return;
  }

  const creature = pagination.value.creatures[index];
  CreatureService.deleteCreature(creature.id).then(() => {
    if (pagination.value) {
      pagination.value.creatures.splice(index, 1);
    }    
  });
}

async function handlePrev() {
  if (prevActive.value) {
    page.value -= 1;
    pagination.value = await CreatureService.paginateCreatures({ page: page.value });
  }
}

async function handleNext() {
  if (nextActive.value) {
    page.value += 1;
    pagination.value = await CreatureService.paginateCreatures({ page: page.value });
  }
}
</script>

<template>
  {{ comptage }}
  <div>Nous sommes à la page {{ page }}</div>
  <hr/>
  <div v-if="pagination" v-for="(creature, index) in pagination.creatures" :key="creature.id">
    <span @click="handleDelete(index)">X</span>
    <router-link :to="{ name: 'creatures-edit', params: { id: creature.id }}">
      {{ creature.name }}
    </router-link>
  </div>
  <hr/>
  <div class="paginationButtons">
    <span @click="handlePrev()" class="paginationButtons-btn" :class="{'disabled': !prevActive}">Précédent</span>
    <span @click="handleNext()" class="paginationButtons-btn" :class="{'disabled': !nextActive}">Suivant</span>
  </div>
</template>

<style>
.paginationButtons {
  display: flex;
  justify-content: space-between;
}
.paginationButtons-btn {
  display: block;
  background-color:grey;
  cursor: pointer;
}
.paginationButtons-btn.disabled {
  opacity: 0.5;
  cursor:default;
}
</style>