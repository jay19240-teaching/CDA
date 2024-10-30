import './index.css';
import 'animate.css';
import 'ant-design-vue/dist/reset.css';
import 'placeholder-loading/dist/css/placeholder-loading.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import Antd from 'ant-design-vue';
import App from './App.vue';
import router from './router';
import { createI18n } from 'vue-i18n';
import fr from './locales/fr.json';
import en from './locales/en.json';

// configure i18n
const i18n = createI18n({
  locale: 'fr',
  fallbackLocale: 'fr',
  messages: { fr, en }
});

const app = createApp(App);
app.use(Antd);
app.use(i18n);
app.use(createPinia());
app.use(router);
app.mount('#app');