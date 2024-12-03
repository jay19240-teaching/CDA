import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

const EchoInstance = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

export default EchoInstance;