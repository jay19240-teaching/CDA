import Echo from 'laravel-echo';
import { useUserStore } from '@/stores/User';
import { useNotifStore } from '@/stores/Notif';
import Pusher from 'pusher-js';

export const EchoInstance = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

export function subscribeNotifications() {
    const userStore = useUserStore();
    const notifStore = useNotifStore();

    if (!userStore.isLogged) {
        return;
    }

    EchoInstance.channel('notification.' + userStore.user.id)
    .listen('.admin-notified', (e: string) => {
        notifStore.pushMessage('Un utilisateur vient d\'ajouter un pokemon à ta collection !');
    });
}