import { createApp } from 'vue';
import './style.css';
import App from './App.vue';
import api from './api'; // Importa la instancia de Axios configurada

const app = createApp(App);

app.config.globalProperties.$api = api; // Hace que la instancia de Axios esté disponible globalmente

app.mount('#app');
