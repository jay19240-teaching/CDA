<script setup lang="ts">
import { ref } from 'vue';
import { onMounted, defineProps } from 'vue';
import { CreatureType, CreatureRace } from '@/_models/Enums';
import type { Creature } from '@/_models/Creature';
import * as CreatureService from '@/_services/CreatureService';
import { useNotifStore } from '@/stores/Notif';

const props = defineProps(['id']);
const notifStore = useNotifStore();
const types = Object.values(CreatureType);
const races = Object.values(CreatureRace);

const creature = ref<Creature>({
  id: -1,
  name: '',
  pv: 0,
  atk: 0,
  def: 0,
  speed: 0,
  capture_rate: 0,
  type: types[0],
  race: races[0],
  user_id: 0
});

const errors = ref<any>({});

onMounted(async () => {
  creature.value = await CreatureService.getCreature(props.id);
});

function handleFileUpload (event: any) {
  creature.value.avatar_blob = event.target.files[0];
}

function update() {
  errors.value = {};
  CreatureService.updateCreature(creature.value).then((res) => {
    notifStore.setMessage('Créature éditée avec succès');
  }).catch(error => {
    notifStore.setMessage('Données invalides');
    errors.value = error.response.data.errors;
  });
}
</script>

<template>
  <div>
    <form @submit.prevent="update">
      <h2 class="form-title">{{ $t("CREATURE.EDIT") }}</h2>
      <div class="form-group">
        <label for="creature_name">Name</label>
        <input type="text" id="creature_name" v-model="creature.name" />
      </div>
      <div class="form-error">{{ errors?.name }}</div>
      <div class="form-group">
        <label for="creature_pv">PV</label>
        <input type="number" id="creature_pv" v-model="creature.pv" />
      </div>
      <div class="form-error">{{ errors?.pv }}</div>
      <div class="form-group">
        <label for="creature_atk">ATK</label>
        <input type="number" id="creature_atk" v-model="creature.atk" />
      </div>
      <div class="form-error">{{ errors?.atk }}</div>
      <div class="form-group">
        <label for="creature_def">DEF</label>
        <input type="number" id="creature_def" v-model="creature.def" />
      </div>
      <div class="form-error">{{ errors?.def }}</div>
      <div class="form-group">
        <label for="creature_speed">Speed</label>
        <input type="number" id="creature_speed" v-model="creature.speed" />
      </div>
      <div class="form-error">{{ errors?.speed }}</div>
      <div class="form-group">
        <label for="creature_capture_rate">Capture Rate</label>
        <input type="number" id="creature_capture_rate" v-model="creature.capture_rate" />
      </div>
      <div class="form-error">{{ errors?.capture_rate }}</div>
      <div class="form-group">
        <label for="creature_type">Type</label>
        <select id="creature_type" v-model="creature.type">
            <option v-for="type in types" :value="type">{{ $t("ENUMS.CREATURE_TYPE." + type) }}</option>
        </select>
      </div>
      <div class="form-error">{{ errors?.type }}</div>
      <div class="form-group">
        <label for="creature_race">Race</label>
        <select id="creature_race" v-model="creature.race">
            <option v-for="race in races" :value="race">{{ $t("ENUMS.CREATURE_RACE." + race) }}</option>
        </select>
      </div>
      <div class="form-error">{{ errors?.race }}</div>
      <div class="form-group">
        <label>File
          <input type="file" id="file" ref="inputFile" @change="handleFileUpload($event)"/>
        </label>
      </div>
      <div class="form-error">{{ errors?.avatar }}</div>
      <div class="form-group">
        <button type="submit" class="button">Mettre à jour</button>
      </div>
    </form>
  </div>
</template>

<style>
form {
  max-width: 300px;
  margin: 0 auto;
}
.form-title {
  text-align: center;
  border-bottom: 1px black solid;
  margin-bottom:10px;
}
.form-group {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
}

.form-error {
  color: red;
  font-size:12px;
  margin-bottom:10px;
}
</style>