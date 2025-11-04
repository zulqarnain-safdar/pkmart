<template>
  <MainLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ user.name }}!</h1>
        <p class="text-gray-600">Manage your account and view your orders</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Orders</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.totalOrders }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Spent</p>
              <p class="text-2xl font-semibold text-gray-900">PKR {{ stats.totalSpent }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Cart Items</p>
              <p class="text-2xl font-semibold text-gray-900">{{ cartStore.itemCount }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
              <router-link to="/orders" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View all
              </router-link>
            </div>
          </div>
          
          <div class="p-6">
            <div v-if="recentOrders.length === 0" class="text-center py-8">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900">No orders yet</h3>
              <p class="mt-1 text-sm text-gray-500">Start shopping to see your orders here.</p>
            </div>
            
            <div v-else class="space-y-4">
              <div
                v-for="order in recentOrders"
                :key="order.id"
                class="flex items-center justify-between py-3 border-b border-gray-200 last:border-b-0"
              >
                <div>
                  <p class="text-sm font-medium text-gray-900">Order #{{ order.order_number }}</p>
                  <p class="text-sm text-gray-500">{{ formatDate(order.created_at) }}</p>
                </div>
                <div class="text-right">
                  <p class="text-sm font-medium text-gray-900">PKR {{ order.total_amount }}</p>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="getStatusClass(order.status)">
                    {{ order.status }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
          </div>
          
          <div class="p-6">
            <div class="space-y-4">
              <router-link
                to="/products"
                class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors"
              >
                <svg class="h-6 w-6 text-blue-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <div>
                  <p class="text-sm font-medium text-gray-900">Browse Products</p>
                  <p class="text-sm text-gray-500">Discover new items</p>
                </div>
              </router-link>

              <router-link
                to="/cart"
                class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors"
              >
                <svg class="h-6 w-6 text-blue-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                </svg>
                <div>
                  <p class="text-sm font-medium text-gray-900">View Cart</p>
                  <p class="text-sm text-gray-500">{{ cartStore.itemCount }} items</p>
                </div>
              </router-link>

              <router-link
                to="/orders"
                class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors"
              >
                <svg class="h-6 w-6 text-blue-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                  <p class="text-sm font-medium text-gray-900">My Orders</p>
                  <p class="text-sm text-gray-500">Track your orders</p>
                </div>
              </router-link>

              <button
                @click="logout"
                class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors w-full text-left"
              >
                <svg class="h-6 w-6 text-red-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <div>
                  <p class="text-sm font-medium text-gray-900">Logout</p>
                  <p class="text-sm text-gray-500">Sign out of your account</p>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import MainLayout from '../components/layout/MainLayout.vue';
import { useAuthStore } from '../stores/auth';
import { useCartStore } from '../stores/cart';
import api from '../services/api';

export default {
  name: 'CustomerDashboard',
  components: {
    MainLayout,
  },
  setup() {
    const router = useRouter();
    const authStore = useAuthStore();
    const cartStore = useCartStore();
    
    const user = ref(authStore.user);
    const stats = ref({
      totalOrders: 0,
      totalSpent: 0,
    });
    const recentOrders = ref([]);

    const fetchStats = async () => {
      try {
        const response = await api.get('/orders');
        if (response.data.success) {
          const orders = response.data.data.data || response.data.data;
          recentOrders.value = orders.slice(0, 3);
          stats.value.totalOrders = orders.length;
          stats.value.totalSpent = orders.reduce((total, order) => total + parseFloat(order.total_amount), 0).toFixed(2);
        }
      } catch (error) {
        console.error('Error fetching stats:', error);
      }
    };

    const formatDate = (date) => {
      return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
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

    const logout = () => {
      authStore.logout();
      router.push('/');
    };

    onMounted(() => {
      if (authStore.isAuthenticated) {
        fetchStats();
      } else {
        router.push('/login');
      }
    });

    return {
      user,
      stats,
      recentOrders,
      cartStore,
      formatDate,
      getStatusClass,
      logout,
    };
  },
};
</script>
