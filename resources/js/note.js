import { createApp } from 'vue';
import '@mdi/font/css/materialdesignicons.css'
import NotePage from './pages/NotePage.vue'

// Импорт Vuetify и стилей
import { createVuetify } from 'vuetify';

const vuetify = createVuetify({});

const app = createApp(NotePage);
app.use(vuetify);
app.mount('#app');
