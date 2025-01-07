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
import { imagesPath } from '@/env';
import { handleError } from '@/_utils/errors-handler';

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
const imageUploaded = ref<string>('');

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

  const reader = new FileReader();
  reader.onload = function (e: any) {
    imageUploaded.value = e.target.result;
  };

  if (event.target.files[0] instanceof Blob) {
    reader.readAsDataURL(event.target.files[0]);
  }
}

async function create() {
  try {
    await CreatureService.createCreature(creature.value);
    notifStore.pushMessage('Créature ajoutée !');
    errors.value = {};
    router.push('/');
  } catch(axiosError: any) {
    notifStore.pushMessage('Echec de soumission !');
    errors.value = handleError(axiosError);
  }
}

async function edit() {
  try {
    await CreatureService.updateCreature(creature.value);
    notifStore.pushMessage('Créature éditée !');
    errors.value = {};
    router.push('/creatures-show/' + creature.value.id);
  } catch(axiosError: any) {
    notifStore.pushMessage('Echec de soumission !');
    errors.value = handleError(axiosError);
  }
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
            <FormError :errors="errors?.name" />
          </div>
          <div class="form-group">
            <input type="number" class="input" id="creature_pv" v-model="creature.pv" placeholder="Point de vie" />
            <FormError :errors="errors?.pv" />
          </div>
          <div class="form-group">
            <input type="number" class="input" id="creature_atk" v-model="creature.atk" placeholder="ATK" />
            <FormError :errors="errors?.atk" />
          </div>
          <div class="form-group">
            <input type="number" class="input" id="creature_def" v-model="creature.def" placeholder="DEF" />
            <FormError :errors="errors?.def" />
          </div>
          <div class="form-group">
            <input type="number" class="input" id="creature_speed" v-model="creature.speed" placeholder="Vitesse" />
            <FormError :errors="errors?.speed" />
          </div>
          <div class="form-group">
            <input type="number" class="input" id="creature_capture_rate" v-model="creature.capture_rate" placeholder="Taux de capture" />
            <FormError :errors="errors?.capture_rate" />
          </div>
          <div class="form-group">
            <a-select ref="select" v-model:value="creature.type">
              <a-select-option v-for="type in types" :value="type">{{ $t("ENUMS.CREATURE_TYPE." + type) }}</a-select-option>
            </a-select>
            <FormError :errors="errors?.type" />
          </div>
          <div class="form-group">
            <a-select ref="select" v-model:value="creature.race">
              <a-select-option v-for="race in races" :value="race">{{ $t("ENUMS.CREATURE_RACE." + race) }}</a-select-option>
            </a-select>
            <FormError :errors="errors?.race" />
          </div>
        </div>
        <div class="form-upload">
          <div class="flex items-center justify-center w-full">
            <label for="dropzone-file"
              class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
              <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <img v-if="imageUploaded" class="max-w-[70%] max-h-[80%]" :src="imageUploaded"/>
                <img v-if="creature.avatar && !imageUploaded" class="max-w-[70%] max-h-[80%]" :src="imagesPath + creature.avatar" />
                <div v-if="!creature?.avatar && !imageUploaded" class="flex flex-col items-center justify-center">
                  <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Cliquez pour télé-verser une image</span></p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                </div>
              </div>
              <input id="dropzone-file" type="file" class="hidden" ref="inputFile" @change="handleFileUpload($event)" />
            </label>
          </div>
        </div>
        <FormError :errors="errors?.avatar" />
      </div>
      <div class="form-group">
        <button type="submit" class="button">{{ props.id ? 'Editer' : 'Créer' }}</button>
      </div>
    </form>
  </div>
</template>