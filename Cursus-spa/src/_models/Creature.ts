import { CreatureType, CreatureRace } from './Enums';

export interface Creature {
    id: number;
    name:string;
    pv: number;
    atk: number;
    def: number;
    speed: number;
    capture_rate: number;
    type: CreatureType;
    race: CreatureRace;
    avatar?: string;
    avatar_blob?: File;
    user_id?: number;
};