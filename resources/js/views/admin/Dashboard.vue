<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Products</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.products || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Orders</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.orders || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Customers</p>
              <p class="text-2xl font-semibold text-gray-900">{{ stats.customers || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500">Total Revenue</p>
              <p class="text-2xl font-semibold text-gray-900">PKR {{ stats.revenue || 0 }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Recent Orders</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="order in recentOrders" :key="order.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ order.order_number }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ order.user?.name || 'Guest' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full" :class="getStatusClass(order.status)">
                    {{ order.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  PKR {{ order.total_amount }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(order.created_at) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
          <div class="space-y-3">
            <router-link to="/admin/products" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
              Add New Product
            </router-link>
            <router-link to="/admin/categories" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
              Manage Categories
            </router-link>
            <router-link to="/admin/orders" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
              View All Orders
            </router-link>
            <router-link to="/admin/referrals" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
              Manage Referrals
            </router-link>
            <router-link to="/admin/commissions" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
              Manage Commissions
            </router-link>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">System Status</h3>
          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-sm text-gray-600">Database</span>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                Online
              </span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-sm text-gray-600">API</span>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                Online
              </span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-sm text-gray-600">Storage</span>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                Online
              </span>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
          <div class="space-y-3">
            <div class="text-sm text-gray-600">
              <p>New order #ORD-123 received</p>
              <p class="text-xs text-gray-400">2 minutes ago</p>
            </div>
            <div class="text-sm text-gray-600">
              <p>Product "iPhone 15 Pro" updated</p>
              <p class="text-xs text-gray-400">1 hour ago</p>
            </div>
            <div class="text-sm text-gray-600">
              <p>New category "Electronics" added</p>
              <p class="text-xs text-gray-400">3 hours ago</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import AdminLayout from '../../components/layout/AdminLayout.vue';
import api from '../../services/api';

export default {
  name: 'AdminDashboard',
  components: {
    AdminLayout,
  },
  setup() {
    const stats = ref({
      products: 0,
      orders: 0,
      customers: 0,
      revenue: 0,
    });
    
    const recentOrders = ref([]);

    const fetchStats = async () => {
      try {
        // Mock data for now - in real app, you'd fetch from API
        stats.value = {
          products: 12,
          orders: 45,
          customers: 128,
          revenue: 12500.50,
        };
      } catch (error) {
        console.error('Error fetching stats:', error);
      }
    };

    const fetchRecentOrders = async () => {
      try {
        const response = await api.get('/admin/orders');
        recentOrders.value = response.data.data.slice(0, 5);
      } catch (error) {
        console.error('Error fetching recent orders:', error);
      }
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

    const formatDate = (date) => {
      return new Date(date).toLocaleDateString();
    };

    onMounted(() => {
      fetchStats();
      fetchRecentOrders();
    });

    return {
      stats,
      recentOrders,
      getStatusClass,
      formatDate,
    };
  },
};
</script>
