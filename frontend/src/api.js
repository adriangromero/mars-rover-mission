import axios from 'axios';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost/api/',
  timeout: 10000
});

api.interceptors.response.use(
  response => response,
  error => {
    if (error.code === 'ECONNABORTED') {
      console.error('Timeout: El servidor no responde');
      return Promise.resolve({ data: { error: 'Timeout: El servidor no responde' } });
    }
    if (!error.response) {
      console.error('El servidor de la API REST no está disponible');
      return Promise.resolve({ data: { error: 'El servidor de la API REST no está disponible' } });
    }
    return Promise.reject(error);
  }
);

export default api;