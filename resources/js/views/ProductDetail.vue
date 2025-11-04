<template>
  <MainLayout>
    <div v-if="loading" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex justify-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-slate-600"></div>
      </div>
    </div>

    <div v-else-if="product" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Breadcrumb -->
      <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm">
          <li>
            <router-link to="/" class="text-slate-500 hover:text-slate-900">Home</router-link>
          </li>
          <li class="text-slate-400">/</li>
          <li>
            <router-link to="/products" class="text-slate-500 hover:text-slate-900">Products</router-link>
          </li>
          <li class="text-slate-400">/</li>
          <li class="text-slate-900 font-medium">{{ product.name }}</li>
        </ol>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div>
          <div class="aspect-w-1 aspect-h-1 mb-4">
            <img
              :src="product.image"
              :alt="product.name"
              class="w-full h-96 object-cover rounded-lg"
            />
          </div>
          
          <!-- Gallery -->
          <div v-if="product.gallery && product.gallery.length > 0" class="grid grid-cols-4 gap-2">
            <img
              v-for="(image, index) in product.gallery"
              :key="index"
              :src="image"
              :alt="product.name"
              class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75"
              @click="product.image = image"
            />
          </div>
        </div>

        <!-- Product Info -->
        <div>
          <div class="mb-4">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ product.name }}</h1>
            <p class="text-lg text-slate-600">{{ product.category?.name }}</p>
          </div>

          <div class="mb-6">
            <div class="flex items-center space-x-4 mb-4">
              <div class="flex items-center space-x-2">
                <span class="text-3xl font-bold text-slate-900">
                  PKR {{ product.sale_price || product.price }}
                </span>
                <span v-if="product.sale_price" class="text-xl text-slate-500 line-through">
                  PKR {{ product.price }}
                </span>
              </div>
              <div v-if="product.sale_price" class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                {{ product.discount_percentage }}% OFF
              </div>
            </div>
            
            <div class="flex items-center space-x-4 text-sm text-slate-600">
              <span>SKU: {{ product.sku }}</span>
              <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ product.stock_quantity }} in stock
              </span>
            </div>
          </div>

          <div class="mb-8">
            <h3 class="text-lg font-semibold text-slate-900 mb-3">Description</h3>
            <p class="text-slate-600 leading-relaxed">{{ product.description }}</p>
          </div>

          <!-- Add to Cart -->
          <div class="mb-8">
            <!-- Error Message -->
            <div v-if="errorMessage" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
              {{ errorMessage }}
            </div>

            <!-- Admin Notice -->
            <div v-if="authStore.isAdmin" class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                Admin users cannot add items to cart or place orders.
              </div>
            </div>

            <div class="flex items-center space-x-4 mb-4">
              <label class="text-sm font-medium text-slate-700">Quantity:</label>
              <div class="flex items-center border border-slate-300 rounded-lg">
                <button
                  @click="quantity > 1 ? quantity-- : null"
                  class="px-3 py-2 text-slate-600 hover:text-slate-900"
                  :disabled="quantity <= 1 || authStore.isAdmin"
                >
                  -
                </button>
                <input
                  v-model.number="quantity"
                  type="number"
                  min="1"
                  :max="product.stock_quantity"
                  :disabled="authStore.isAdmin"
                  class="w-16 px-2 py-2 text-center border-0 focus:ring-0 focus:outline-none disabled:bg-slate-100"
                />
                <button
                  @click="quantity < product.stock_quantity ? quantity++ : null"
                  class="px-3 py-2 text-slate-600 hover:text-slate-900"
                  :disabled="quantity >= product.stock_quantity || authStore.isAdmin"
                >
                  +
                </button>
              </div>
            </div>

            <div class="flex space-x-4">
              <button
                @click="addToCart"
                class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-6 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="product.stock_quantity === 0 || authStore.isAdmin"
              >
                {{ authStore.isAdmin ? 'Admin - Cannot Add to Cart' : (product.stock_quantity === 0 ? 'Out of Stock' : 'Add to Cart') }}
              </button>
              <button
                @click="addToCart"
                class="px-6 py-3 border border-slate-300 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="product.stock_quantity === 0 || authStore.isAdmin"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
              </button>
            </div>
          </div>

          <!-- Features -->
          <div class="border-t border-slate-200 pt-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Features</h3>
            <ul class="space-y-2 text-sm text-slate-600">
              <li class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                Free shipping on orders over PKR 50
              </li>
              <li class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                30-day return policy
              </li>
              <li class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                24/7 customer support
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Product Not Found -->
    <div v-else class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="text-center">
        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.709M15 6.291A7.962 7.962 0 0012 4c-2.34 0-4.29 1.009-5.824 2.709"></path>
        </svg>
        <h3 class="mt-2 text-lg font-medium text-slate-900">Product not found</h3>
        <p class="mt-1 text-sm text-slate-500">The product you're looking for doesn't exist.</p>
        <div class="mt-6">
          <router-link to="/products" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg transition-colors">
            View All Products
          </router-link>
        </div>
      </div>
    </div>

    <!-- Login Popup -->
    <LoginPopup
      :isOpen="showLoginPopup"
      title="Login Required"
      message="Please login to add items to your cart and continue shopping."
      @close="showLoginPopup = false"
    />
  </MainLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import MainLayout from '../components/layout/MainLayout.vue';
import LoginPopup from '../components/LoginPopup.vue';
import { useCartStore } from '../stores/cart';
import { useAuthStore } from '../stores/auth';
import api from '../services/api';

export default {
  name: 'ProductDetail',
  components: {
    MainLayout,
    LoginPopup,
  },
  setup() {
    const route = useRoute();
    const cartStore = useCartStore();
    const authStore = useAuthStore();
    
    const product = ref(null);
    const loading = ref(true);
    const quantity = ref(1);
    const errorMessage = ref('');
    const showLoginPopup = ref(false);

    const fetchProduct = async () => {
      try {
        loading.value = true;
        const response = await api.get(`/products/${route.params.id}`);
        product.value = response.data.data;
      } catch (error) {
        console.error('Error fetching product:', error);
        product.value = null;
      } finally {
        loading.value = false;
      }
    };

    const addToCart = () => {
      if (product.value) {
        try {
          cartStore.addToCart(product.value, quantity.value);
          // Reset quantity to 1 after adding
          quantity.value = 1;
          errorMessage.value = '';
        } catch (error) {
          if (error.message === 'Please login to add items to cart') {
            // Show login modal
            showLoginPopup.value = true;
          } else {
            errorMessage.value = error.message;
          }
        }
      }
    };

    onMounted(() => {
      fetchProduct();
    });

    return {
      product,
      loading,
      quantity,
      addToCart,
      errorMessage,
      authStore,
      showLoginPopup,
    };
  },
};
</script>
