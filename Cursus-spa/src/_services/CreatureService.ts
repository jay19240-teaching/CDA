import Axios from './CallerService'
import type { Creature } from '@/_models/Creature';

export interface CreaturePagination {
  creatures: Array<Creature>,
  maxPages: number,
  page: number
};

export interface PaginateParams {
  page: number;
  name?: string;
  minPv?: number;
  maxPv?: number;
};

export async function getCreatures(): Promise<Creature[]> {
  const res = await Axios.get('/creatures');
  return res.data;
}

export async function paginateCreatures(params: PaginateParams): Promise<CreaturePagination> {
  const res = await Axios.get('/creatures-paginate', { params: params });
  return res.data;
}

export async function getCreature(id: number): Promise<Creature> {
  const res = await Axios.get('/creatures/' + id);
  return res.data;
}

export async function createCreature(creature: Creature): Promise<Creature> {
  const res = await Axios.post('/creatures', creature, {
    headers: { 'Content-Type': 'multipart/form-data' }
  });

  return res.data;
}

export async function updateCreature(creature: Creature): Promise<any> {
  const res = await Axios.post('/creatures/' + creature.id, { ...creature, _method: 'PUT' }, {
    headers: { 'Content-Type': 'multipart/form-data' }
  });

  return res.data;
}

export async function deleteCreature(id: number): Promise<any> {
  return await Axios.delete('/creatures/' + id);
}