<template>
  <MainLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
        <router-link to="/products" class="btn-secondary">
          Continue Shopping
        </router-link>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <!-- Empty State -->
      <div v-else-if="orders.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">No orders found</h3>
        <p class="mt-1 text-sm text-gray-500">You haven't placed any orders yet.</p>
        <div class="mt-6">
          <router-link to="/products" class="btn-primary">
            Start Shopping
          </router-link>
        </div>
      </div>

      <!-- Orders List -->
      <div v-else class="space-y-6">
        <div
          v-for="order in orders"
          :key="order.id"
          class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden"
        >
          <!-- Order Header -->
          <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">
                  Order #{{ order.order_number }}
                </h3>
                <p class="text-sm text-gray-500">
                  Placed on {{ formatDate(order.created_at) }}
                </p>
              </div>
              <div class="mt-2 sm:mt-0 flex items-center space-x-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="getStatusClass(order.status)">
                  {{ order.status }}
                </span>
                <span class="text-lg font-semibold text-gray-900">
                  PKR {{ order.total_amount }}
                </span>
              </div>
            </div>
          </div>

          <!-- Order Items -->
          <div class="px-6 py-4">
            <div class="space-y-4">
              <div
                v-for="item in order.items"
                :key="item.id"
                class="flex items-center space-x-4"
              >
                <img
                  :src="item.product?.image || '/placeholder-image.jpg'"
                  :alt="item.product_name"
                  class="w-16 h-16 object-cover rounded-lg"
                />
                <div class="flex-1 min-w-0">
                  <h4 class="text-sm font-medium text-gray-900 truncate">
                    {{ item.product_name }}
                  </h4>
                  <p class="text-sm text-gray-500">Quantity: {{ item.quantity }}</p>
                </div>
                <div class="text-right">
                  <p class="text-sm font-medium text-gray-900">
                    PKR {{ item.total }}
                  </p>
                  <p class="text-xs text-gray-500">
                    PKR {{ item.price }} each
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Order Footer -->
          <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
              <div class="text-sm text-gray-600">
                <p>Shipping to: {{ order.shipping_address }}</p>
                <p v-if="order.phone">Phone: {{ order.phone }}</p>
              </div>
              <div class="mt-2 sm:mt-0">
                <button
                  @click="viewOrderDetails(order)"
                  class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                >
                  View Details
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import MainLayout from '../components/layout/MainLayout.vue';
import { useAuthStore } from '../stores/auth';
import api from '../services/api';

export default {
  name: 'CustomerOrders',
  components: {
    MainLayout,
  },
  setup() {
    const authStore = useAuthStore();
    const orders = ref([]);
    const loading = ref(true);

    const fetchOrders = async () => {
      try {
        loading.value = true;
        const response = await api.get('/orders');
        if (response.data.success) {
          orders.value = response.data.data.data || response.data.data;
        }
      } catch (error) {
        console.error('Error fetching orders:', error);
        if (error.response?.status === 401) {
          // Redirect to login if not authenticated
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
      });
    };

    const getStatusClass = (status) => {
      switch (status) {
        case 'pending':
          return 'bg-yellow-100 text-yellow-800';
        case 'processing':
          return 'bg-blue-100 text-blue-800';
        case 'shipped':
          return 'bg-purple-100 text-purple-800';
        case 'delivered':
          return 'bg-green-100 text-green-800';
        case 'cancelled':
          return 'bg-red-100 text-red-800';
        default:
          return 'bg-gray-100 text-gray-800';
      }
    };

    const viewOrderDetails = (order) => {
      // For now, just show an alert with order details
      alert(`Order Details:\nOrder #: ${order.order_number}\nStatus: ${order.status}\nTotal: $${order.total_amount}`);
    };

    onMounted(() => {
      if (authStore.isAuthenticated) {
        fetchOrders();
      } else {
        window.location.href = '/login';
      }
    });

    return {
      orders,
      loading,
      formatDate,
      getStatusClass,
      viewOrderDetails,
    };
  },
};
</script>
