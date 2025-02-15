import { useAuthStore } from '@/stores/authStore';
import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api/',
  timeout: 10000,
});

// Global request interceptor
api.interceptors.request.use(
  config => {
    const authStore = useAuthStore();
    const token = authStore.token;
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

// Global response interceptor (401 hatası yakalama)
api.interceptors.response.use(
  response => response,
  error => {
    if (error.response && error.response.status === 401) {
      window.location.assign('/login');

    }
    return Promise.reject(error);
  }
);

export default api;
