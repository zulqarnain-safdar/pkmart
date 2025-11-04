import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [],
  }),

  getters: {
    itemCount: (state) => state.items.reduce((total, item) => total + item.quantity, 0),
    totalPrice: (state) => state.items.reduce((total, item) => total + (item.price * item.quantity), 0),
  },

  actions: {
    // Initialize cart - load from localStorage only if user is authenticated
    initializeCart() {
      const token = localStorage.getItem('token');
      const user = JSON.parse(localStorage.getItem('user') || '{}');
      
      if (token && user.id && user.role !== 'admin') {
        // Load cart for authenticated non-admin users
        this.items = JSON.parse(localStorage.getItem('cart') || '[]');
      } else {
        // Clear cart for non-authenticated users or admins
        this.items = [];
        localStorage.removeItem('cart');
      }
    },

    addToCart(product, quantity = 1) {
      // Check if user is authenticated
      const user = JSON.parse(localStorage.getItem('user') || '{}');
      const token = localStorage.getItem('token');
      
      if (!token || !user.id) {
        throw new Error('Please login to add items to cart');
      }
      
      // Check if user is admin
      if (user.role === 'admin') {
        throw new Error('Admin users cannot add items to cart');
      }

      const existingItem = this.items.find(item => item.id === product.id);
      
      if (existingItem) {
        existingItem.quantity += quantity;
      } else {
        this.items.push({
          id: product.id,
          name: product.name,
          price: product.price,
          image: product.image,
          quantity: quantity,
        });
      }
      
      this.saveCart();
    },

    removeFromCart(productId) {
      this.items = this.items.filter(item => item.id !== productId);
      this.saveCart();
    },

    updateQuantity(productId, quantity) {
      const item = this.items.find(item => item.id === productId);
      if (item) {
        if (quantity <= 0) {
          this.removeFromCart(productId);
        } else {
          item.quantity = quantity;
          this.saveCart();
        }
      }
    },

    clearCart() {
      this.items = [];
      this.saveCart();
    },

    saveCart() {
      const token = localStorage.getItem('token');
      const user = JSON.parse(localStorage.getItem('user') || '{}');
      
      // Only save cart if user is authenticated and not admin
      if (token && user.id && user.role !== 'admin') {
        localStorage.setItem('cart', JSON.stringify(this.items));
      }
    },

    // Clear cart and localStorage - called on logout
    clearCartOnLogout() {
      this.items = [];
      localStorage.removeItem('cart');
    },
  },
});
