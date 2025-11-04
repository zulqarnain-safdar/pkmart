<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Orders</h1>
        <div v-if="!isAuthenticated" class="flex space-x-2">
          <button
            @click="quickAdminLogin"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium"
          >
            Quick Admin Login
          </button>
        </div>
      </div>

      <!-- Not Authenticated State -->
      <div v-if="!isAuthenticated && !loading" class="bg-white rounded-lg shadow p-8 text-center">
        <div class="text-gray-400 mb-4">
          <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Authentication Required</h3>
        <p class="text-gray-500 mb-4">Please log in as an admin to view orders.</p>
        <button
          @click="quickAdminLogin"
          class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium"
        >
          Login as Admin
        </button>
      </div>

      <!-- Loading State -->
      <div v-else-if="loading" class="bg-white rounded-lg shadow p-8 text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
        <p class="mt-4 text-gray-600">Loading orders...</p>
      </div>

      <!-- Empty State -->
      <div v-else-if="orders.length === 0" class="bg-white rounded-lg shadow p-8 text-center">
        <div class="text-gray-400 mb-4">
          <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
        <p class="text-gray-500">There are no orders to display at the moment.</p>
      </div>

      <!-- Orders Table -->
      <div v-else class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(order, index) in orders" :key="order?.id || index" v-if="orders">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ order?.order_number || 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  <div>
                    <div class="font-medium">{{ order?.user?.name || 'Guest' }}</div>
                    <div class="text-gray-500">{{ order?.user?.email || order?.phone || 'N/A' }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ order?.items?.length || 0 }} items
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  PKR {{ order?.total_amount || '0.00' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <select
                    :value="order?.status || 'pending'"
                    @change="updateOrderStatus(order?.id, $event.target.value, 'status')"
                    class="text-xs font-semibold rounded-full px-2 py-1 border-0 focus:ring-2 focus:ring-blue-500"
                    :class="getStatusClass(order?.status)"
                  >
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                  </select>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <select
                    :value="order?.payment_status || 'pending'"
                    @change="updateOrderStatus(order?.id, $event.target.value, 'payment_status')"
                    class="text-xs font-semibold rounded-full px-2 py-1 border-0 focus:ring-2 focus:ring-blue-500"
                    :class="getPaymentStatusClass(order?.payment_status)"
                  >
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                  </select>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ order?.created_at ? formatDate(order.created_at) : 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button
                    @click="viewOrder(order)"
                    class="text-indigo-600 hover:text-indigo-900 mr-3"
                    :disabled="!order?.id"
                  >
                    View
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Order Details Modal -->
      <div v-if="selectedOrder" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="selectedOrder = null"></div>

          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <h3 class="text-lg font-medium text-gray-900 mb-4">
                Order Details - {{ selectedOrder.order_number }}
              </h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Information -->
                <div>
                  <h4 class="text-md font-semibold text-gray-900 mb-3">Customer Information</h4>
                  <div class="space-y-2 text-sm">
                    <p><span class="font-medium">Name:</span> {{ selectedOrder.user?.name || 'Guest' }}</p>
                    <p><span class="font-medium">Email:</span> {{ selectedOrder.user?.email || 'N/A' }}</p>
                    <p><span class="font-medium">Phone:</span> {{ selectedOrder.phone }}</p>
                  </div>
                </div>

                <!-- Order Information -->
                <div>
                  <h4 class="text-md font-semibold text-gray-900 mb-3">Order Information</h4>
                  <div class="space-y-2 text-sm">
                    <p><span class="font-medium">Order Date:</span> {{ formatDate(selectedOrder.created_at) }}</p>
                    <p><span class="font-medium">Status:</span> 
                      <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full" :class="getStatusClass(selectedOrder.status)">
                        {{ selectedOrder.status }}
                      </span>
                    </p>
                    <p><span class="font-medium">Payment Status:</span> 
                      <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full" :class="getPaymentStatusClass(selectedOrder.payment_status)">
                        {{ selectedOrder.payment_status }}
                      </span>
                    </p>
                  </div>
                </div>
              </div>

              <!-- Order Items -->
              <div class="mt-6">
                <h4 class="text-md font-semibold text-gray-900 mb-3">Order Items</h4>
                <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="item in selectedOrder.items" :key="item.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                          {{ item.product_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                          PKR {{ item.price }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                          {{ item.quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                          PKR {{ item.total }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Order Totals -->
              <div class="mt-6 border-t border-gray-200 pt-4">
                <div class="flex justify-between text-sm">
                  <span class="text-gray-600">Subtotal</span>
                  <span class="text-gray-900">PKR {{ selectedOrder.total_amount }}</span>
                </div>
                <div class="flex justify-between text-sm">
                  <span class="text-gray-600">Tax</span>
                  <span class="text-gray-900">PKR {{ selectedOrder.tax_amount }}</span>
                </div>
                <div class="flex justify-between text-sm">
                  <span class="text-gray-600">Shipping</span>
                  <span class="text-gray-900">PKR {{ selectedOrder.shipping_amount }}</span>
                </div>
                <div class="flex justify-between text-lg font-semibold border-t border-gray-200 pt-2">
                  <span class="text-gray-900">Total</span>
                  <span class="text-gray-900">PKR {{ selectedOrder.total_amount }}</span>
                </div>
              </div>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button
                @click="selectedOrder = null"
                class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import AdminLayout from '../../components/layout/AdminLayout.vue';
import api from '../../services/api';
import { useAuthStore } from '../../stores/auth';

export default {
  name: 'AdminOrders',
  components: {
    AdminLayout,
  },
  setup() {
    const orders = ref([]);
    const selectedOrder = ref(null);
    const loading = ref(true);
    const authStore = useAuthStore();
    const isFetching = ref(false);
    
    const isAuthenticated = computed(() => authStore.isAuthenticated);

    const fetchOrders = async () => {
      // Prevent duplicate calls
      if (isFetching.value) {
        console.log('Already fetching orders, skipping duplicate call');
        return;
      }
      
      try {
        isFetching.value = true;
        loading.value = true;
        console.log('Fetching orders...');
        const response = await api.get('/admin/orders');
        console.log('Orders response status:', response.status);
        console.log('Orders response data:', response.data);
        
        // Only process 200 responses
        if (response.status === 200 && response.data && response.data.success && response.data.data) {
          // The data is paginated, so we need response.data.data.data for the actual orders array
          const ordersData = response.data.data.data || response.data.data;
          console.log('Orders data type:', typeof ordersData, 'Is array:', Array.isArray(ordersData));
          
          if (Array.isArray(ordersData)) {
            // Filter out any null/undefined orders
            const validOrders = ordersData.filter(order => order && order.id);
            orders.value = validOrders;
            console.log('Valid orders loaded:', validOrders.length);
          } else {
            console.warn('Orders data is not an array:', ordersData);
            orders.value = [];
          }
        } else {
          console.warn('Invalid response - Status:', response.status, 'Success:', response.data?.success);
          orders.value = [];
        }
      } catch (error) {
        console.error('Error fetching orders:', error);
        console.error('Error details:', error.response?.data);
        console.error('Error status:', error.response?.status);
        
        // Only show error for actual errors, not 204 responses
        if (error.response?.status === 401) {
          alert('Authentication required. Please log in as an admin.');
        } else if (error.response?.status === 403) {
          alert('Access denied. Admin privileges required.');
        } else if (error.response?.status !== 204) {
          alert('Failed to load orders. Please try again.');
        }
        
        // Reset orders on error (but not for 204)
        if (error.response?.status !== 204) {
          orders.value = [];
        }
      } finally {
        loading.value = false;
        isFetching.value = false;
      }
    };

    const updateOrderStatus = async (orderId, newStatus, type) => {
      if (!orderId) {
        console.error('Cannot update order status: orderId is required');
        return;
      }
      
      try {
        await api.put(`/orders/${orderId}/status`, {
          [type]: newStatus,
        });
        
        // Update local state
        const order = orders.value.find(o => o && o.id === orderId);
        if (order) {
          order[type] = newStatus;
        }
      } catch (error) {
        console.error('Error updating order status:', error);
        alert('Failed to update order status. Please try again.');
      }
    };

    const viewOrder = (order) => {
      selectedOrder.value = order;
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

    const getPaymentStatusClass = (status) => {
      switch (status) {
        case 'pending':
          return 'bg-yellow-100 text-yellow-800';
        case 'paid':
          return 'bg-green-100 text-green-800';
        case 'failed':
          return 'bg-red-100 text-red-800';
        case 'refunded':
          return 'bg-gray-100 text-gray-800';
        default:
          return 'bg-gray-100 text-gray-800';
      }
    };

    const formatDate = (date) => {
      return new Date(date).toLocaleDateString();
    };

    const quickAdminLogin = async () => {
      try {
        loading.value = true;
        isFetching.value = false; // Reset fetching flag
        const result = await authStore.login({
          email: 'admin@ecomstore.com',
          password: 'password'
        });
        
        if (result.success) {
          console.log('Admin login successful');
          await fetchOrders();
        } else {
          alert('Admin login failed: ' + result.message);
        }
      } catch (error) {
        console.error('Quick admin login error:', error);
        alert('Admin login failed. Please try again.');
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => {
      if (isAuthenticated.value) {
        fetchOrders();
      }
    });

    return {
      orders,
      selectedOrder,
      loading,
      isAuthenticated,
      quickAdminLogin,
      updateOrderStatus,
      viewOrder,
      getStatusClass,
      getPaymentStatusClass,
      formatDate,
    };
  },
};
</script>
