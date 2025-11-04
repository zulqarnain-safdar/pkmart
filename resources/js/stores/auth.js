import { defineStore } from 'pinia';
import api from '../services/api';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('user') || '{}'),
    token: localStorage.getItem('token'),
    isAuthenticated: !!localStorage.getItem('token'),
  }),

  getters: {
    isAdmin: (state) => state.user.role === 'admin',
  },

  actions: {
    async login(credentials) {
      try {
        const response = await api.post('/auth/login', credentials);
        const { user, token } = response.data;
        
        this.user = user;
        this.token = token;
        this.isAuthenticated = true;
        
        localStorage.setItem('user', JSON.stringify(user));
        localStorage.setItem('token', token);
        
        // Initialize cart after login
        import('./cart').then(({ useCartStore }) => {
          const cartStore = useCartStore();
          cartStore.initializeCart();
        });
        
        return { success: true };
      } catch (error) {
        return { 
          success: false, 
          message: error.response?.data?.message || 'Login failed' 
        };
      }
    },

    async register(userData) {
      try {
        const response = await api.post('/auth/register', userData);
        const { user, token } = response.data;
        
        this.user = user;
        this.token = token;
        this.isAuthenticated = true;
        
        localStorage.setItem('user', JSON.stringify(user));
        localStorage.setItem('token', token);
        
        // Initialize cart after registration
        import('./cart').then(({ useCartStore }) => {
          const cartStore = useCartStore();
          cartStore.initializeCart();
        });
        
        return { success: true };
      } catch (error) {
        return { 
          success: false, 
          message: error.response?.data?.message || 'Registration failed' 
        };
      }
    },

    logout() {
      this.user = {};
      this.token = null;
      this.isAuthenticated = false;
      
      localStorage.removeItem('user');
      localStorage.removeItem('token');
      
      // Clear cart on logout
      import('./cart').then(({ useCartStore }) => {
        const cartStore = useCartStore();
        cartStore.clearCartOnLogout();
      });
    },
  },
});
