import './bootstrap';
import '../sass/app.scss'
import Router from '@/router'

import { createApp } from 'vue';
import i18n from './src/i18n'

const app = createApp({});

app.use(Router);
app.use(i18n).mount('#app');