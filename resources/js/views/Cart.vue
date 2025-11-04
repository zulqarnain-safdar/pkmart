<template>
  <MainLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <h1 class="text-3xl font-bold text-slate-900 mb-8">Shopping Cart</h1>

      <div v-if="cartStore.items.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
        </svg>
        <h3 class="mt-2 text-lg font-medium text-slate-900">Your cart is empty</h3>
        <p class="mt-1 text-sm text-slate-500">Start adding some items to your cart.</p>
        <div class="mt-6">
          <router-link to="/products" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg transition-colors">
            Continue Shopping
          </router-link>
        </div>
      </div>

      <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Admin Notice -->
        <div v-if="authStore.isAdmin" class="lg:col-span-3 mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
          <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            Admin users cannot place orders. You can view the cart but checkout is disabled.
          </div>
        </div>

        <!-- Cart Items -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-xl shadow-lg border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
              <h2 class="text-lg font-semibold text-slate-900">Cart Items ({{ cartStore.itemCount }})</h2>
            </div>
            
            <div class="divide-y divide-slate-200">
              <div
                v-for="item in cartStore.items"
                :key="item.id"
                class="p-6 flex items-center space-x-4"
              >
                <img
                  :src="item.image"
                  :alt="item.name"
                  class="w-20 h-20 object-cover rounded-lg"
                />
                
                <div class="flex-1 min-w-0">
                  <h3 class="text-lg font-medium text-slate-900">{{ item.name }}</h3>
                  <p class="text-sm text-slate-500">SKU: {{ item.sku || 'N/A' }}</p>
                </div>
                
                <div class="flex items-center space-x-4">
                  <!-- Quantity Controls -->
                  <div class="flex items-center border border-slate-300 rounded-lg">
                    <button
                      @click="updateQuantity(item.id, item.quantity - 1)"
                      class="px-3 py-2 text-slate-600 hover:text-slate-900"
                    >
                      -
                    </button>
                    <span class="px-4 py-2 text-slate-900">{{ item.quantity }}</span>
                    <button
                      @click="updateQuantity(item.id, item.quantity + 1)"
                      class="px-3 py-2 text-slate-600 hover:text-slate-900"
                    >
                      +
                    </button>
                  </div>
                  
                  <!-- Price -->
                  <div class="text-right">
                    <p class="text-lg font-semibold text-slate-900">
                      PKR {{ (item.price * item.quantity).toFixed(2) }}
                    </p>
                    <p class="text-sm text-slate-500">
                      PKR {{ item.price }} each
                    </p>
                  </div>
                  
                  <!-- Remove Button -->
                  <button
                    @click="removeItem(item.id)"
                    class="text-red-600 hover:text-red-800 p-2"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6 sticky top-8">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Order Summary</h2>
            
            <div class="space-y-3 mb-6">
              <div class="flex justify-between text-sm">
                <span class="text-slate-600">Subtotal</span>
                <span class="text-slate-900">PKR {{ cartStore.totalPrice.toFixed(2) }}</span>
              </div>
              
              <div class="flex justify-between text-sm">
                <span class="text-slate-600">Shipping</span>
                <span class="text-slate-900">
                  {{ cartStore.totalPrice >= 50 ? 'Free' : 'PKR 9.99' }}
                </span>
              </div>
              
              <div class="flex justify-between text-sm">
                <span class="text-slate-600">Tax</span>
                <span class="text-slate-900">PKR {{ (cartStore.totalPrice * 0.08).toFixed(2) }}</span>
              </div>
              
              <div class="border-t border-slate-200 pt-3">
                <div class="flex justify-between text-lg font-semibold">
                  <span class="text-slate-900">Total</span>
                  <span class="text-slate-900">
                    PKR {{ (cartStore.totalPrice + (cartStore.totalPrice >= 50 ? 0 : 9.99) + (cartStore.totalPrice * 0.08)).toFixed(2) }}
                  </span>
                </div>
              </div>
            </div>

            <div class="space-y-3">
              <button
                @click="handleCheckout"
                :disabled="authStore.isAdmin"
                class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-4 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {{ authStore.isAdmin ? 'Admin - Checkout Disabled' : 'Proceed to Checkout' }}
              </button>
              
              <router-link
                to="/products"
                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 px-4 rounded-lg transition-colors text-center block"
              >
                Continue Shopping
              </router-link>
            </div>

            <!-- Promo Code -->
            <div class="mt-6 pt-6 border-t border-slate-200">
              <h3 class="text-sm font-medium text-slate-900 mb-2">Promo Code</h3>
              <div class="flex space-x-2">
                <input
                  v-model="promoCode"
                  type="text"
                  placeholder="Enter code"
                  class="flex-1 px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"
                />
                <button
                  @click="applyPromoCode"
                  class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors"
                >
                  Apply
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Login Popup -->
    <LoginPopup
      :isOpen="showLoginPopup"
      title="Login Required"
      message="Please login to proceed with checkout and place your order."
      @close="showLoginPopup = false"
    />
  </MainLayout>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import MainLayout from '../components/layout/MainLayout.vue';
import LoginPopup from '../components/LoginPopup.vue';
import { useCartStore } from '../stores/cart';
import { useAuthStore } from '../stores/auth';

export default {
  name: 'Cart',
  components: {
    MainLayout,
    LoginPopup,
  },
  setup() {
    const router = useRouter();
    const cartStore = useCartStore();
    const authStore = useAuthStore();
    const promoCode = ref('');
    const showLoginPopup = ref(false);

    const updateQuantity = (productId, newQuantity) => {
      cartStore.updateQuantity(productId, newQuantity);
    };

    const removeItem = (productId) => {
      cartStore.removeFromCart(productId);
    };

    const applyPromoCode = () => {
      // TODO: Implement promo code logic
      console.log('Applying promo code:', promoCode.value);
    };

    const handleCheckout = () => {
      if (!authStore.isAuthenticated) {
        showLoginPopup.value = true;
        return;
      }
      
      if (authStore.isAdmin) {
        if (window.$notify) {
          window.$notify.error('Admin Restriction', 'Admin users cannot place orders');
        }
        return;
      }
      
      router.push('/checkout');
    };

    return {
      cartStore,
      promoCode,
      showLoginPopup,
      updateQuantity,
      removeItem,
      applyPromoCode,
      handleCheckout,
      authStore,
    };
  },
};
</script>
