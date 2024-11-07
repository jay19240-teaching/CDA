import Axios from './CallerService'
import type { User } from '@/_models/User';

export async function getUsers(): Promise<Array<User>> {
  const res = await Axios.get('/users');
  return res.data;
}

export async function getUser(id: number): Promise<User> {
  const res = await Axios.get('/users/' + id);
  return res.data;
}

export async function updateUser(user: Partial<User>): Promise<any> {
  return await Axios.patch('/users/' + user.id, user);
}

export async function createUser(user: User): Promise<User> {
  const res = await Axios.post('/users', user);
  return res.data;
}

export async function deleteUser(id: number): Promise<any> {
  return await Axios.delete('/users/' + id);
}