<script setup lang="ts">
import { ref } from 'vue';
import { onMounted } from 'vue';
import router from '@/router';
import { CreatureType, CreatureRace } from '@/_models/Enums';
import { useNotifStore } from '@/stores/Notif';
import type { Creature } from '@/_models/Creature';
import * as CreatureService from '@/_services/CreatureService';
import { useGuiStore } from '@/stores/Gui';
import FormError from '@/components/FormError.vue';

const props = defineProps(['id']);
const types = Object.values(CreatureType);
const races = Object.values(CreatureRace);
const notifStore = useNotifStore();

const creature = ref<Creature>({
  id: -1,
  name: '',
  pv: 0,
  atk: 0,
  def: 0,
  speed: 0,
  capture_rate: 0,
  type: types[0],
  race: races[0]
});

const errors = ref<any>({});

onMounted(async () => {
  const guiStore = useGuiStore();

  if (props.id) {
    creature.value = await CreatureService.getCreature(props.id);
    guiStore.gui.title = 'Editer une créature';
    guiStore.gui.titleHasBack = true;
  }
  else {
    guiStore.gui.title = 'Ajouter une créature';
    guiStore.gui.titleHasBack = true;
  }
});

function handleFileUpload(event: any) {
  creature.value.avatar_blob = event.target.files[0];
}

async function create() {
  errors.value = {};
  CreatureService.createCreature(creature.value).then(() => {
    notifStore.setMessage('Créature ajoutée !');
    router.push('/');
  }).catch(error => {
    notifStore.setMessage('Echec de soumission !');
    errors.value = error.response.data.errors;
  });
}

async function edit() {
  errors.value = {};
  CreatureService.updateCreature(creature.value).then(() => {
    notifStore.setMessage('Créature éditée !');
    router.push('/creatures-show/' + creature.value.id);
  }).catch(error => {
    notifStore.setMessage('Echec de soumission !');
    errors.value = error.response.data.errors;
  });
}

async function submit() {
  props.id ? await edit() : await create();
}
</script>

<template>
  <div class="top-container">
    <form @submit.prevent="submit" class="form">
      <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 mb-2">
        <div class="form-fields">
          <div class="form-group">
            <input type="text" class="input" id="creature_name" v-model="creature.name" placeholder="Nom" />
            <FormError :messages="errors?.name" />
          </div>
          <div class="form-group">
            <input type="number" class="input" id="creature_pv" v-model="creature.pv" placeholder="Point de vie" />
            <FormError :messages="errors?.pv" />
          </div>
          <div class="form-group">
            <input type="number" class="input" id="creature_atk" v-model="creature.atk" placeholder="ATK" />
            <FormError :messages="errors?.atk" />
          </div>
          <div class="form-group">
            <input type="number" class="input" id="creature_def" v-model="creature.def" placeholder="DEF" />
            <FormError :messages="errors?.def" />
          </div>
          <div class="form-group">
            <input type="number" class="input" id="creature_speed" v-model="creature.speed" placeholder="Vitesse" />
            <FormError :messages="errors?.speed" />
          </div>
          <div class="form-group">
            <input type="number" class="input" id="creature_capture_rate" v-model="creature.capture_rate" placeholder="Taux de capture" />
            <FormError :messages="errors?.capture_rate" />
          </div>
          <div class="form-group">
            <a-select ref="select" v-model:value="creature.type">
              <a-select-option v-for="type in types" :value="type">{{ $t("ENUMS.CREATURE_TYPE." + type) }}</a-select-option>
            </a-select>
            <FormError :messages="errors?.type" />
          </div>
          <div class="form-group">
            <a-select ref="select" v-model:value="creature.race">
              <a-select-option v-for="race in races" :value="race">{{ $t("ENUMS.CREATURE_RACE." + race) }}</a-select-option>
            </a-select>
            <FormError :messages="errors?.race" />
          </div>
        </div>
        <div class="form-upload">
          <div class="flex items-center justify-center w-full">
            <label for="dropzone-file"
              class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
              <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <img v-if="creature.avatar" class="w-[70%] mb-5" :src="'http://localhost:8000/images/uploads/' + creature.avatar" />
                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Cliquez pour télé-verser une image</span></p>
                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
              </div>
              <input id="dropzone-file" type="file" class="hidden" ref="inputFile" @change="handleFileUpload($event)" />
            </label>
          </div>
        </div>
        <FormError :messages="errors?.avatar" />
      </div>
      <div class="form-group">
        <button type="submit" class="button">{{ props.id ? 'Editer' : 'Créer' }}</button>
      </div>
    </form>
  </div>
</template>