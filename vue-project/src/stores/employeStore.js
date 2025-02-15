import api from '@/axios'; // Merkezi api yapılandırmasını import et
import { defineStore } from 'pinia';

export const useEmployeStore = defineStore('employeStore', {
  state: () => ({
    data: [],
    currentPage: 1,
    perPage: 1,
    totalPages: 0,
    loading: false,
    total: 0,
    errors:{}
  }),
  actions: {
    async fetchData(page) {
      this.loading = true;
      try {
        const response = await api.get(`employes?page=${page}`); 

        this.data = response.data.data;
        this.currentPage = response.data.current_page;
        this.perPage = response.data.per_page;
        this.total = response.data.total;
        this.totalPages = response.data.last_page;

      } catch (error) {
        console.error('API Error:', error);
      } finally {
        this.loading = false; 
      }
    },
    async createEmploye(employee) {
      this.errors = {}; // Hata mesajlarını sıfırla
      try {
        const response = await api.post("employes", employee);
        if (response.status === 201) {
          this.fetchData(this.currentPage); // Mevcut sayfadaki verileri güncelle
        }
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors; // Laravel'den gelen validation hatalarını al
        } else {
          console.error("Çalışan eklenirken hata oluştu:", error);
        }
      }
    },
  },
});
