import api from '@/axios';
import { defineStore } from 'pinia';
export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null, // Sayfa yenilenince token kaybolmasın diye localStorage kullanıyoruz
  }),

  actions: {
    async login(credentials) {
      try {
        const response = await api.post('auth/login', credentials)
        
        this.token = response.data.token // Backend JWT'yi burada döndürmeli
      

        localStorage.setItem('token', this.token) // Token'ı sakla
        api.defaults.headers.common['Authorization'] = `Bearer ${this.token}` // Axios’a default header ekle
        return true
      } catch (error) {
        console.error('Giriş başarısız:', error.response?.data || error.message)
        return false
      }
    },

    async logout() {
        try {
            // Backend'de logout API'sine istek gönder
            await axios.post('auth/logout', {}, {
              headers: {
                Authorization: `Bearer ${this.token}`,
              },
            })
          
           
            this.token = null
            localStorage.removeItem('token') 
    
          } catch (error) {
            console.error('Logout sırasında hata:', error)
          }
    },
  },
})
