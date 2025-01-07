<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import * as CreatureService from '@/_services/CreatureService';
import { useGuiStore } from '@/stores/Gui';
import Image from '@/components/Image.vue';
import { imagesPath } from '@/env';

const perPageList = [1, 3, 6, 12];

const orderList = ref([
  { field: 'atk', type: 'ASC' },
  { field: 'def', type: 'ASC' },
  { field: 'speed', type: 'ASC' },
  { field: 'capture_rate', type: 'ASC' }
]);
const filtersOpened = ref(false);
const races = ref([]);
const types = ref([]);
const pagination = ref<CreatureService.CreaturePagination>();
const order = ref(orderList.value[0]);
const perPage = ref(12);
const page = ref(1);
const name = ref('');
const typesFiltered = ref([]);
const racesFiltered = ref([]);
const pageList = ref<number[]>([]);
const form = ref({
  name: '',
  types: [],
  races: []
});

onMounted(async () => {
  const res = await Promise.all([
    CreatureService.getRaces(),
    CreatureService.getTypes(),
    fetchCreatures()
  ]);

  races.value = res[0];
  types.value = res[1];

  const guiStore = useGuiStore();
  guiStore.gui.title = 'Bestiaire';
  guiStore.gui.titleHasBack = false;
});

const prevActive = computed(() => {
  return page.value > 1;
});

const nextActive = computed(() => {
  return pagination.value && page.value < pagination.value.maxPages;
});

function getFormattedId(id?: number, max: number = 4) {
  let res = '';

  if (!id) {
    for (let i = 0; i < max; i++) res += '-';
    return '#' + res;
  }

  const idStringLength = String(id).length;
  res = String(id);

  for (var i = 0; i < (max - idStringLength); i++) {
    res = '0' + res;
  }

  return '#' + res;
}

function toggleFilters() {
  filtersOpened.value = !filtersOpened.value;
}

function handlePrev() {
  if (prevActive.value) {
    page.value -= 1;
    fetchCreatures();
  }
}

function handleNext() {
  if (nextActive.value) {
    page.value += 1;
    fetchCreatures();
  }
}

function selectPerPage(value: number) {
  perPage.value = value;
  fetchCreatures();
}

function selectOrderBy(orderArg: any) {
  orderArg.type = orderArg.type == 'ASC' ? 'DESC' : 'ASC';
  order.value = orderArg;
  fetchCreatures();
}

function changePage(value: number) {
  page.value = value;
  fetchCreatures();
}

async function fetchCreatures() {
  pagination.value = await CreatureService.paginateCreatures({
    page: page.value,
    limit: perPage.value,
    types: typesFiltered.value,
    races: racesFiltered.value,
    name: name.value,
    orderBy: order.value.field,
    orderType: order.value.type
  });

  pageList.value = [];

  for (let i = 1; i <= pagination.value.maxPages; i++) {
    pageList.value.push(i);
  }

  window.scrollTo(0, 0);
}

function search() {
  page.value = 1;
  filtersOpened.value = false;
  name.value = form.value.name;
  typesFiltered.value = form.value.types;
  racesFiltered.value = form.value.races;
  fetchCreatures();
}
</script>

<template>
  <div class="home">
    <div class="home-search" @submit.prevent="search">
      <div class="home-search-text">
        <input type="text" class="home-search-text-input" placeholder="Nom du pokemon..." v-model="form.name" />
        <span class="material-symbols-outlined home-search-text-btn" @click="toggleFilters">filter_list</span>
      </div>
      <div class="home-search-filters" :class="{ active: filtersOpened }">
        <div class="p-2">
          <div class="home-search-filters-title">
            Types:
          </div>
          <div class="grid grid-cols-3 gap-1 mb-4">
            <div v-for="type in types" class="home-search-filters-item">
              <input type="checkbox" :id="type" :value="type" class="home-search-filters-item-checkbox" v-model="form.types" />
              <label :for="type">{{ type }}</label>
            </div>
          </div>
          <div class="home-search-filters-title">
            Races:
          </div>
          <div class="grid grid-cols-3 gap-1 mb-4">
            <div v-for="race in races" class="home-search-filters-item">
              <input type="checkbox" :id="race" :value="race" class="home-search-filters-item-checkbox"
                v-model="form.races" />
              <label :for="race">{{ race }}</label>
            </div>
          </div>
        </div>
      </div>
      <input type="submit" class="home-search-btnSearch" @click="search()" value="Rechercher"/>
    </div>
    <div class="container flex flex-col items-center justify-between sm:flex-row sm:items-start">
      <div class="home-nav">
        <div class="home-nav-title">Par page: </div>
        <div v-for="value in perPageList" class="home-nav-item">
          <span class="home-nav-item-label" @click="selectPerPage(value)" :class="{ active: value == perPage }">{{ value }}</span>
        </div>
      </div>
      <div class="home-nav">
        <div v-for="value in orderList" class="home-nav-item">
          <span v-if="value.type == 'ASC'" class="material-symbols-outlined">arrow_drop_up</span>
          <span v-if="value.type == 'DESC'" class="material-symbols-outlined">arrow_drop_down</span>
          <span class="home-nav-item-label" @click="selectOrderBy(value)" :class="{ active: value == order }">
            {{ value.field }}
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="home-cards sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    <router-link :to="{ name: 'creatures-show', params: { id: creature.id }}" v-if="pagination" v-for="creature in pagination.creatures" :key="creature.id" class="pokecard">
      <Image :src="creature.avatar" default-src="default.jpg" :path="imagesPath" class="pokecard-picture"/>
      <div class="pokecard-name">{{ creature.name }}</div>
      <div class="pokecard-id">{{ getFormattedId(creature.id, 5) }}</div>
    </router-link>
  </div>

  <div class="home-pagination">
    <div v-for="value in pageList" class="home-pagination-item" @click="changePage(value)" :class="{ active: page == value }">{{ value }}</div>
  </div>

  <span class="material-symbols-outlined home-arrow left" @click="handlePrev()" :class="{ active: prevActive }">arrow_left</span>
  <span class="material-symbols-outlined home-arrow right" @click="handleNext()" :class="{ active: nextActive }">arrow_right</span>
  <div class="loading" :class="{ on: !pagination }">
    <img src="/loader.png" class="loading-spinner"/>
  </div>
</template>