import { type RouteLocationNormalized, type NavigationGuardNext } from 'vue-router';
import * as CreatureService from '@/_services/CreatureService';

export const creatureResolver = async (to: RouteLocationNormalized, from: RouteLocationNormalized, next: NavigationGuardNext) => {
    to.meta['data'] = await CreatureService.getCreature(to.params['id'] as string);
    next();
}