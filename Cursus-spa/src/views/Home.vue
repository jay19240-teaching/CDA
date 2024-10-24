<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import * as CreatureService from '@/_services/CreatureService';

const filtersOpened = ref(false);
const races = ref([]);
const types = ref([]);
const pagination = ref<CreatureService.CreaturePagination>();
const perPageList = [1, 3, 6, 12];
const orderList = ref([
  { field: 'atk', type: 'ASC' },
  { field: 'def', type: 'ASC' },
  { field: 'speed', type: 'ASC' },
  { field: 'capture_rate', type: 'ASC' }
]);

const order = ref(orderList.value[0]);
const perPage = ref(12);
const page = ref(1);
const name = ref('');
const typesFiltered = ref([]);
const racesFiltered = ref([]);

const form = ref({
  name: '',
  types: [],
  races: []
});

onMounted(async () => {
  races.value = await CreatureService.getRaces();
  types.value = await CreatureService.getTypes();
  await fetchCreatures();
});

const prevActive = computed(() => {
  return page.value > 1;
});

const nextActive = computed(() => {
  return pagination.value && page.value < pagination.value.maxPages;
});

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

function selectOrderBy(order: any) {
  order.type = order.type == 'ASC' ? 'DESC' : 'ASC';
  order.value = order;
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
              <input type="checkbox" :id="type" :value="type" class="home-search-filters-item-checkbox"
                v-model="form.types" />
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
    <div class="container flex justify-between">
      <div class="home-nav">
        <div class="home-nav-title">Par page: </div>
        <div v-for="value in perPageList" class="home-nav-item">
          <span class="home-nav-item-label" @click="selectPerPage(value)" :class="{ active: value == perPage }">{{ value
            }}</span>
        </div>
      </div>
      <div class="home-nav">
        <div v-for="value in orderList" class="home-nav-item">
          <span v-if="value.type == 'ASC'" class="material-symbols-outlined">arrow_drop_up</span>
          <span v-if="value.type == 'DESC'" class="material-symbols-outlined">arrow_drop_down</span>
          <span class="home-nav-item-label" @click="selectOrderBy(value)" :class="{ active: value == orderBy }">
            {{ value.field }}
          </span>
        </div>
      </div>
    </div>


    <div class="home-cards sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      <div v-if="pagination" v-for="creature in pagination.creatures" :key="creature.id" class="pokecard">
        <img src="/pokemon-0.png" class="pokecard-picture" />
        <div class="pokecard-name">{{ creature.name }}</div>
        <div class="pokecard-id">#0{{ creature.id }}</div>
      </div>
    </div>
  </div>

  <span class="material-symbols-outlined home-arrow left" @click="handlePrev()" :class="{ active: prevActive }">arrow_left</span>
  <span class="material-symbols-outlined home-arrow right" @click="handleNext()" :class="{ active: nextActive }">arrow_right</span>
</template>