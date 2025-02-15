import App from '@/App.vue';
import { registerPlugins } from '@core/utils/plugins';
import '@mdi/font/css/materialdesignicons.css'; // MDI Iconları ekle
import { createApp } from 'vue';

// Pinia store'u import et
import { createPinia } from 'pinia';

// Axios yapılandırmasını import et
import api from '@/axios'; // axios.js dosyanızın yolu

// Styles
import '@core/scss/template/index.scss';
import '@styles/styles.scss';

// Create vue app
const app = createApp(App)

// Pinia store'u Vue app'e ekle
app.use(createPinia())  // Pinia'yı kullanmak için

// Global olarak axios'u app'e tanımla
app.config.globalProperties.$api = api  // Artık her bileşende this.$api kullanılabilir

// Register plugins
registerPlugins(app)

// Mount vue app
app.mount('#app')
