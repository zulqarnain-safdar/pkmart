<template>
  <MainLayout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div v-if="loading" class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <div v-else-if="order" class="text-center">
        <!-- Success Icon -->
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-6">
          <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>

        <!-- Success Message -->
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h1>
        <p class="text-lg text-gray-600 mb-8">
          Thank you for your order. We've received your payment and will process your order shortly.
        </p>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8 text-left">
          <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Details</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <p class="text-sm text-gray-600">Order Number</p>
              <p class="font-medium text-gray-900">{{ order.order_number }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Order Date</p>
              <p class="font-medium text-gray-900">{{ formatDate(order.created_at) }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Total Amount</p>
              <p class="font-medium text-gray-900">PKR {{ order.total_amount }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Payment Status</p>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                    :class="getPaymentStatusClass(order.payment_status)">
                {{ order.payment_status }}
              </span>
            </div>
          </div>

          <!-- Order Items -->
          <div class="border-t border-gray-200 pt-4">
            <h3 class="text-md font-medium text-gray-900 mb-3">Order Items</h3>
            <div class="space-y-3">
              <div
                v-for="item in order.items"
                :key="item.id"
                class="flex items-center space-x-3"
              >
                <img
                  :src="item.product?.image || '/placeholder-image.jpg'"
                  :alt="item.product_name"
                  class="w-12 h-12 object-cover rounded"
                />
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900">{{ item.product_name }}</p>
                  <p class="text-sm text-gray-500">Quantity: {{ item.quantity }}</p>
                </div>
                <p class="text-sm font-medium text-gray-900">
                  PKR {{ item.total }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <router-link to="/orders" class="btn-secondary">
            View All Orders
          </router-link>
          <router-link to="/products" class="btn-primary">
            Continue Shopping
          </router-link>
        </div>
      </div>

      <!-- Error State -->
      <div v-else class="text-center">
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-6">
          <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Not Found</h1>
        <p class="text-lg text-gray-600 mb-8">
          We couldn't find the order you're looking for.
        </p>
        <router-link to="/products" class="btn-primary">
          Continue Shopping
        </router-link>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import MainLayout from '../components/layout/MainLayout.vue';
import { useAuthStore } from '../stores/auth';
import api from '../services/api';

export default {
  name: 'OrderSuccess',
  components: {
    MainLayout,
  },
  setup() {
    const route = useRoute();
    const authStore = useAuthStore();
    const order = ref(null);
    const loading = ref(true);

    const fetchOrder = async () => {
      try {
        const orderId = route.params.id;
        const response = await api.get(`/orders/${orderId}`);
        
        if (response.data.success) {
          order.value = response.data.data;
        }
      } catch (error) {
        console.error('Error fetching order:', error);
        if (error.response?.status === 401) {
          window.location.href = '/login';
        }
      } finally {
        loading.value = false;
      }
    };

    const formatDate = (date) => {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
      });
    };

    const getPaymentStatusClass = (status) => {
      switch (status) {
        case 'paid':
          return 'bg-green-100 text-green-800';
        case 'pending':
          return 'bg-yellow-100 text-yellow-800';
        case 'failed':
          return 'bg-red-100 text-red-800';
        default:
          return 'bg-gray-100 text-gray-800';
      }
    };

    onMounted(() => {
      if (authStore.isAuthenticated) {
        fetchOrder();
      } else {
        window.location.href = '/login';
      }
    });

    return {
      order,
      loading,
      formatDate,
      getPaymentStatusClass,
    };
  },
};
</script>