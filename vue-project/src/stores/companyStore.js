import api from '@/axios'; // Merkezi api yapılandırmasını import et
import { defineStore } from 'pinia';

export const useCompanyStore = defineStore('companyStore', {
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
    async createCompany(newCompany) {
      try {
        const formData = new FormData();
        formData.append('name', newCompany.name);
        formData.append('email', newCompany.email);
        formData.append('website', newCompany.website);
        if (newCompany.logo) {
          formData.append('logo', newCompany.logo); 
        }
       
        const response = await api.post('companies', newCompany);
        
        
        return response.data;
      } catch (error) {
      
        if (error.response && error.response.status === 422) {
          console.log('bua')
          this.errors = error.response.data.errors; // Laravel'den gelen validation hatalarını al
        } else {
          console.error("Çalışan eklenirken hata oluştu:", error);
        }
      
      }
    },
    async fetchData(page=1) {
      this.loading = true;
      try {
        const response = await api.get(`companies?page=${page}`); 

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
  },
});
