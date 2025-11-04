<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Commission Management</h1>
        <p class="mt-2 text-gray-600">Set commission percentages for products</p>
      </div>

      <!-- Search and Filter -->
      <div class="bg-white rounded-xl shadow-soft p-6 mb-8">
        <div class="flex flex-col sm:flex-row gap-4">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search products..."
            class="flex-1 input"
          />
          <select v-model="categoryFilter" class="input">
            <option value="">All Categories</option>
            <option v-for="(category, index) in categories" :key="category?.id || index" :value="category?.id || ''">
              {{ category?.name || 'Unnamed Category' }}
            </option>
          </select>
          <select v-model="commissionFilter" class="input">
            <option value="">All Products</option>
            <option value="has_commission">Has Commission</option>
            <option value="no_commission">No Commission</option>
          </select>
        </div>
      </div>

      <!-- Products Table -->
      <div class="bg-white rounded-xl shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission Rates</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(product, index) in filteredProducts" :key="product?.id || index">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <img
                      :src="product?.image || '/images/placeholder.jpg'"
                      :alt="product?.name || 'Product'"
                      class="w-12 h-12 rounded-lg object-cover mr-4"
                    />
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ product?.name || 'Unnamed Product' }}</div>
                      <div class="text-sm text-gray-500">{{ product?.sku || 'N/A' }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ product.category?.name || 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  PKR {{ parseFloat(product?.price || 0).toFixed(2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                    product?.has_referral_commission
                      ? 'bg-success-100 text-success-800'
                      : 'bg-gray-100 text-gray-800'
                  ]">
                    {{ product?.has_referral_commission ? 'Enabled' : 'Disabled' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  <div v-if="product?.has_referral_commission" class="space-y-1">
                    <div class="text-xs">
                      <span class="font-medium">1st Level:</span> {{ product?.referral_commission_percentage || 0 }}%
                    </div>
                    <div class="text-xs">
                      <span class="font-medium">Buyer:</span> {{ product?.buyer_commission_percentage || 0 }}%
                    </div>
                  </div>
                  <span v-else class="text-gray-500">No commission set</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button
                    @click="openCommissionModal(product)"
                    class="text-primary-600 hover:text-primary-900 mr-4"
                  >
                    {{ product?.has_referral_commission ? 'Edit' : 'Set' }} Commission
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Commission Modal -->
      <div
        v-if="showCommissionModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        @click="closeCommissionModal"
      >
        <div
          class="bg-white rounded-2xl shadow-2xl w-full max-w-md"
          @click.stop
        >
          <div class="p-6">
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-xl font-bold text-gray-900">
                Set Commission for {{ selectedProduct?.name || 'Product' }}
              </h3>
              <button
                @click="closeCommissionModal"
                class="text-gray-400 hover:text-gray-600"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>

            <form @submit.prevent="saveCommission">
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    First Level Referral Commission (%)
                  </label>
                  <input
                    v-model="commissionForm.first_level_percentage"
                    type="number"
                    step="0.01"
                    min="0"
                    max="100"
                    class="input"
                    placeholder="0.00"
                  />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Second Level Referral Commission (%)
                  </label>
                  <input
                    v-model="commissionForm.second_level_percentage"
                    type="number"
                    step="0.01"
                    min="0"
                    max="100"
                    class="input"
                    placeholder="0.00"
                  />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Buyer Commission (%)
                  </label>
                  <input
                    v-model="commissionForm.buyer_percentage"
                    type="number"
                    step="0.01"
                    min="0"
                    max="100"
                    class="input"
                    placeholder="0.00"
                  />
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                  <div class="flex">
                    <svg class="w-5 h-5 text-yellow-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                      <h4 class="text-sm font-medium text-yellow-800">Total Commission</h4>
                      <p class="text-sm text-yellow-700 mt-1">
                        {{ totalCommissionPercentage }}% (Maximum: 100%)
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="flex justify-end space-x-3 mt-6">
                <button
                  type="button"
                  @click="closeCommissionModal"
                  class="btn-secondary"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  :disabled="savingCommission || totalCommissionPercentage > 100"
                  class="btn-primary"
                >
                  <span v-if="savingCommission">Saving...</span>
                  <span v-else>Save Commission</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import AdminLayout from '../../components/layout/AdminLayout.vue';
import api from '../../services/api';

export default {
  name: 'AdminCommissions',
  components: {
    AdminLayout,
  },
  setup() {
    const products = ref([]);
    const categories = ref([]);
    const searchQuery = ref('');
    const categoryFilter = ref('');
    const commissionFilter = ref('');
    const showCommissionModal = ref(false);
    const selectedProduct = ref(null);
    const savingCommission = ref(false);

    const commissionForm = ref({
      first_level_percentage: 0,
      second_level_percentage: 0,
      buyer_percentage: 0,
    });

    const totalCommissionPercentage = computed(() => {
      return (
        parseFloat(commissionForm.value.first_level_percentage || 0) +
        parseFloat(commissionForm.value.second_level_percentage || 0) +
        parseFloat(commissionForm.value.buyer_percentage || 0)
      ).toFixed(2);
    });

    const filteredProducts = computed(() => {
      let filtered = products.value;

      if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(product =>
          (product?.name || '').toLowerCase().includes(query) ||
          (product?.sku || '').toLowerCase().includes(query)
        );
      }

      if (categoryFilter.value) {
        filtered = filtered.filter(product => product?.category_id == categoryFilter.value);
      }

      if (commissionFilter.value) {
        if (commissionFilter.value === 'has_commission') {
          filtered = filtered.filter(product => product?.has_referral_commission);
        } else if (commissionFilter.value === 'no_commission') {
          filtered = filtered.filter(product => !product?.has_referral_commission);
        }
      }

      return filtered;
    });

    const fetchProducts = async () => {
      try {
        const response = await api.get('/admin/products');
        products.value = response.data?.data?.data || [];
      } catch (error) {
        console.error('Error fetching products:', error);
        products.value = [];
      }
    };

    const fetchCategories = async () => {
      try {
        const response = await api.get('/categories');
        // Handle paginated response - categories are in data.data.data
        categories.value = response.data?.data?.data || response.data?.data || [];
      } catch (error) {
        console.error('Error fetching categories:', error);
        categories.value = [];
      }
    };

    const fetchProductCommission = async (productId) => {
      try {
        const response = await api.get(`/admin/commissions/products/${productId}`);
        if (response.data?.success && response.data?.data) {
          const commission = response.data.data;
          commissionForm.value = {
            first_level_percentage: commission?.first_level_percentage || 0,
            second_level_percentage: commission?.second_level_percentage || 0,
            buyer_percentage: commission?.buyer_percentage || 0,
          };
        } else {
          commissionForm.value = {
            first_level_percentage: 0,
            second_level_percentage: 0,
            buyer_percentage: 0,
          };
        }
      } catch (error) {
        console.error('Error fetching commission:', error);
        commissionForm.value = {
          first_level_percentage: 0,
          second_level_percentage: 0,
          buyer_percentage: 0,
        };
      }
    };

    const openCommissionModal = async (product) => {
      selectedProduct.value = product;
      if (product?.id) {
        await fetchProductCommission(product.id);
      }
      showCommissionModal.value = true;
    };

    const closeCommissionModal = () => {
      showCommissionModal.value = false;
      selectedProduct.value = null;
      commissionForm.value = {
        first_level_percentage: 0,
        second_level_percentage: 0,
        buyer_percentage: 0,
      };
    };

    const saveCommission = async () => {
      if (totalCommissionPercentage.value > 100) {
        if (window.$notify) {
          window.$notify.error('Error', 'Total commission cannot exceed 100%');
        }
        return;
      }

      savingCommission.value = true;
      try {
        await api.post(`/admin/commissions/products/${selectedProduct.value?.id}/set`, {
          first_level_percentage: commissionForm.value.first_level_percentage,
          second_level_percentage: commissionForm.value.second_level_percentage,
          buyer_percentage: commissionForm.value.buyer_percentage,
        });

        if (window.$notify) {
          window.$notify.success('Success', 'Commission saved successfully');
        }

        closeCommissionModal();
        fetchProducts();
      } catch (error) {
        console.error('Error saving commission:', error);
        if (window.$notify) {
          window.$notify.error('Error', 'Failed to save commission');
        }
      } finally {
        savingCommission.value = false;
      }
    };

    onMounted(() => {
      fetchProducts();
      fetchCategories();
    });

    return {
      products,
      categories,
      searchQuery,
      categoryFilter,
      commissionFilter,
      filteredProducts,
      showCommissionModal,
      selectedProduct,
      savingCommission,
      commissionForm,
      totalCommissionPercentage,
      openCommissionModal,
      closeCommissionModal,
      saveCommission,
    };
  },
};
</script>
