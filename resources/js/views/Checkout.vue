<template>
  <MainLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

      <div v-if="cartStore.items.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">Your cart is empty</h3>
        <p class="mt-1 text-sm text-gray-500">Add some items to your cart before checkout.</p>
        <div class="mt-6">
          <router-link to="/products" class="btn-primary">
            Continue Shopping
          </router-link>
        </div>
      </div>

      <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Checkout Form -->
        <div>
          <form @submit.prevent="handleCheckout">
            <!-- Shipping Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
              <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information</h2>
              
              <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input
                      v-model="form.shipping.first_name"
                      type="text"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input
                      v-model="form.shipping.last_name"
                      type="text"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                  </div>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                  <input
                    v-model="form.shipping.address"
                    type="text"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Street address"
                  />
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input
                      v-model="form.shipping.city"
                      type="text"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                    <input
                      v-model="form.shipping.state"
                      type="text"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ZIP Code</label>
                    <input
                      v-model="form.shipping.zip"
                      type="text"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                  </div>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                  <input
                    v-model="form.shipping.phone"
                    type="tel"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>
              </div>
            </div>

            <!-- Referral Code Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
              <h2 class="text-lg font-semibold text-gray-900 mb-4">Referral Code</h2>
              
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Have a referral code?
                  </label>
                  <input
                    v-model="form.referral_code"
                    type="text"
                    class="input"
                    placeholder="Enter referral code (optional)"
                    maxlength="8"
                  />
                  <p class="text-xs text-gray-500 mt-1">
                    Enter a referral code to earn commissions on your purchase
                  </p>
                </div>
              </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
              <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h2>
              
              <!-- Payment Method Selection -->
              <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method</label>
                <div class="flex items-center p-4 border border-blue-500 rounded-lg bg-blue-50">
                  <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                      <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                    <div>
                      <div class="text-sm font-medium text-gray-900">JazzCash</div>
                      <div class="text-sm text-gray-500">Pay securely with JazzCash wallet</div>
                    </div>
                  </div>
                </div>
              </div>
              
              
              <!-- JazzCash Payment Info -->
              <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                  <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                  </svg>
                  <div class="text-sm text-blue-700">
                    <p class="font-medium">JazzCash Payment</p>
                    <p>You will be redirected to JazzCash to complete your payment securely.</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Order Notes -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
              <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Notes (Optional)</h2>
              <textarea
                v-model="form.notes"
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Any special instructions for your order..."
              ></textarea>
            </div>

            <button
              type="submit"
              :disabled="loading"
              class="w-full btn-primary"
            >
              {{ loading ? 'Processing...' : 'Complete Order' }}
            </button>
          </form>
        </div>

        <!-- Order Summary -->
        <div>
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
            
            <!-- Cart Items -->
            <div class="space-y-4 mb-6">
              <div
                v-for="item in cartStore.items"
                :key="item.id"
                class="flex items-center space-x-3"
              >
                <img
                  :src="item.image"
                  :alt="item.name"
                  class="w-12 h-12 object-cover rounded"
                />
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900 truncate">{{ item.name }}</p>
                  <p class="text-sm text-gray-500">Qty: {{ item.quantity }}</p>
                </div>
                <p class="text-sm font-medium text-gray-900">
                  PKR {{ (item.price * item.quantity).toFixed(2) }}
                </p>
              </div>
            </div>
            
            <!-- Totals -->
            <div class="space-y-3 border-t border-gray-200 pt-4">
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Subtotal</span>
                <span class="text-gray-900">PKR {{ cartStore.totalPrice.toFixed(2) }}</span>
              </div>
              
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Shipping</span>
                <span class="text-gray-900">
                  {{ cartStore.totalPrice >= 50 ? 'Free' : 'PKR 9.99' }}
                </span>
              </div>
              
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Tax</span>
                <span class="text-gray-900">PKR {{ (cartStore.totalPrice * 0.08).toFixed(2) }}</span>
              </div>
              
              <div class="border-t border-gray-200 pt-3">
                <div class="flex justify-between text-lg font-semibold">
                  <span class="text-gray-900">Total</span>
                  <span class="text-gray-900">
                    PKR {{ (cartStore.totalPrice + (cartStore.totalPrice >= 50 ? 0 : 9.99) + (cartStore.totalPrice * 0.08)).toFixed(2) }}
                  </span>
                </div>
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
      message="Please login to complete your order and proceed with payment."
      @close="showLoginPopup = false"
    />
  </MainLayout>
</template>

<script>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import MainLayout from '../components/layout/MainLayout.vue';
import LoginPopup from '../components/LoginPopup.vue';
import { useCartStore } from '../stores/cart';
import { useAuthStore } from '../stores/auth';
import api from '../services/api';

export default {
  name: 'Checkout',
  components: {
    MainLayout,
    LoginPopup,
  },
  setup() {
    const router = useRouter();
    const cartStore = useCartStore();
    const authStore = useAuthStore();
    
    const loading = ref(false);
    const showLoginPopup = ref(false);
    
    const form = reactive({
      shipping: {
        first_name: '',
        last_name: '',
        address: '',
        city: '',
        state: '',
        zip: '',
        phone: '',
      },
      payment: {
        method: 'jazzcash', // Only JazzCash payment
      },
      referral_code: '',
      notes: '',
    });

    const handleCheckout = async () => {
      if (!authStore.isAuthenticated) {
        showLoginPopup.value = true;
        return;
      }

      try {
        loading.value = true;
        
        // Calculate totals
        const subtotal = cartStore.totalPrice;
        const shipping = subtotal >= 50 ? 0 : 9.99;
        const tax = subtotal * 0.08;
        const total = subtotal + shipping + tax;
        
        // Prepare order data
        const orderData = {
          items: cartStore.items.map(item => ({
            product_id: item.id,
            product_name: item.name,
            price: item.price,
            quantity: item.quantity,
            total: item.price * item.quantity,
          })),
          total_amount: total,
          tax_amount: tax,
          shipping_amount: shipping,
          shipping_address: `${form.shipping.first_name} ${form.shipping.last_name}, ${form.shipping.address}, ${form.shipping.city}, ${form.shipping.state} ${form.shipping.zip}`,
          billing_address: `${form.shipping.first_name} ${form.shipping.last_name}, ${form.shipping.address}, ${form.shipping.city}, ${form.shipping.state} ${form.shipping.zip}`,
          phone: form.shipping.phone,
          notes: form.notes,
          payment_method: form.payment.method,
          referral_code_used: form.referral_code,
        };

        console.log('Creating order:', orderData);
        
        // Create order via API
        const response = await api.post('/orders', orderData);
        
        if (response.data.success) {
          const order = response.data.data;
          
          // Initiate EasyPaisa payment
          await handleEasyPaisaPayment(order.id);
        } else {
          throw new Error(response.data.message || 'Failed to create order');
        }
        
      } catch (error) {
        console.error('Checkout error:', error);
        alert('Failed to process order. Please try again.');
      } finally {
        loading.value = false;
      }
    };

    const handleEasyPaisaPayment = async (orderId) => {
      try {
        // Initiate EasyPaisa payment
        const response = await api.post('/payments/easypaisa/initiate', {
          order_id: orderId
        });
        
        if (response.data.success) {
          // Redirect to EasyPaisa payment page
          window.location.href = response.data.data.payment_url;
        } else {
          throw new Error(response.data.message || 'Failed to initiate EasyPaisa payment');
        }
      } catch (error) {
        console.error('EasyPaisa payment error:', error);
        alert('Failed to initiate EasyPaisa payment. Please try again.');
      }
    };

    return {
      cartStore,
      form,
      loading,
      showLoginPopup,
      handleCheckout,
      handleEasyPaisaPayment,
    };
  },
};
</script>
