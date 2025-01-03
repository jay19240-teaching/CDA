<script setup lang="ts">
import { ref, onMounted } from 'vue';
import router from '@/router';
import { useRoute } from 'vue-router';
import { useGuiStore } from '@/stores/Gui';
import { type Creature } from '@/_models/Creature';
import { CreatureRace, CreatureType } from '@/_models/Enums';
import * as CreatureService from '@/_services/CreatureService';
import { useNotifStore } from '@/stores/Notif';
import { useUserStore } from '@/stores/User';
import Image from '@/components/Image.vue';
import { imagesPath } from '@/env';

const actions = [{
  mode: 'DESCRIPTION',
  icon: 'info'
}, {
  mode: 'BADGES',
  icon: 'public'
}, {
  mode: 'STATS',
  icon: 'sleep_score'
}];

const route = useRoute();
const notifStore = useNotifStore();
const userStore = useUserStore();
const currentAction = ref(actions[2]);
const creature = ref<Creature>({
  id: -1,
  name: '',
  pv: 0,
  atk: 0,
  def: 0,
  speed: 0,
  capture_rate: 0,
  type: CreatureType.ELECTRIK,
  race: CreatureRace.DRAGON
});

onMounted(async () => {
  creature.value = route.meta.data as Creature;
  const guiStore = useGuiStore();
  guiStore.gui.title = 'Detail';
  guiStore.gui.titleHasBack = true;
});

function changeAction(action: any) {
  currentAction.value = action;
}

async function destroy() {
  if (creature.value.id) {
    await CreatureService.deleteCreature(creature.value.id);
    notifStore.setMessage('Créature supprimée !');
    router.push('/');
  }
}
</script>

<template>
  <div class="top-container">
    <Image :src="creature.avatar" default-src="default.jpg" :path="imagesPath"
      class="detail-picture" />
    <div class="detail-info flex-col sm:flex-row">
      <div class="detail-info-name">
        <span class="detail-info-name-text">
          {{ creature.name }}
          <div class="detail-info-name-id">#{{ creature.id }}</div>
        </span>
      </div>

      <div class="detail-info-nav" v-if="userStore.isLogged && userStore.user.id == creature.user?.id">
        <router-link class="detail-info-nav-item" :to="{ name: 'edit', params: { id: creature.id } }">Editer</router-link>
        <div class="detail-info-nav-item" @click="destroy">Supprimer</div>
      </div>
    </div>
    <div class="detail-body">
      <div class="detail-body-description" v-if="currentAction.mode == 'DESCRIPTION'">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
        pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
        laborum
      </div>
      <div class="detail-body-badges" v-if="currentAction.mode == 'BADGES'">
        <!--to fill in the futur-->
      </div>
      <div class="detail-body-stats" v-if="currentAction.mode == 'STATS'">
        <div class="detail-body-stats-item">
          <div class="detail-body-stats-item-name">Race</div>
          <div class="detail-body-stats-item-value">{{ creature.race }}</div>
        </div>
        <div class="detail-body-stats-item">
          <div class="detail-body-stats-item-name">Type</div>
          <div class="detail-body-stats-item-value">{{ creature.type }}</div>
        </div>
        <div class="detail-body-stats-item">
          <div class="detail-body-stats-item-name">ATK</div>
          <div class="detail-body-stats-item-value">{{ creature.atk }}</div>
        </div>
        <div class="detail-body-stats-item">
          <div class="detail-body-stats-item-name">DEF</div>
          <div class="detail-body-stats-item-value">{{ creature.def }}</div>
        </div>
        <div class="detail-body-stats-item">
          <div class="detail-body-stats-item-name">Vitesse</div>
          <div class="detail-body-stats-item-value">{{ creature.speed }}</div>
        </div>
        <div class="detail-body-stats-item">
          <div class="detail-body-stats-item-name">Taux de captures</div>
          <div class="detail-body-stats-item-value">{{ creature.capture_rate }}</div>
        </div>
        <div class="detail-body-stats-item">
          <div class="detail-body-stats-item-name">Auteur</div>
          <div class="detail-body-stats-item-value">{{ creature.user?.name }}</div>
        </div>
      </div>
      <div class="detail-body-actions">
        <span class="detail-body-action material-symbols-outlined" v-for="action in actions"
          @click="changeAction(action)" :class="{ active: currentAction.mode == action.mode }">{{ action.icon }}</span>
      </div>
    </div>
  </div>
</template>