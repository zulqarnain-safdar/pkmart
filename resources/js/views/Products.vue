<template>
  <MainLayout>
    <div class="min-h-screen bg-gradient-to-b from-slate-50 to-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
          <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-slate-700 to-slate-900 rounded-xl mb-6 shadow-lg">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
          </div>
          <h1 class="text-4xl font-bold text-slate-900 mb-6">Educational Toys Collection</h1>
          <p class="text-lg text-slate-600 max-w-3xl mx-auto leading-relaxed">
            Explore our comprehensive collection of premium educational toys, 
            carefully selected to inspire learning and development in children of all ages.
          </p>
        </div>

        <!-- Filters -->
        <div class="mb-12 bg-white rounded-xl shadow-lg p-8 border border-slate-200">
          <h3 class="text-xl font-bold text-slate-900 mb-6">Filter Products</h3>
          <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Search -->
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-3">Search Products</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                  </svg>
                </div>
                <input
                  v-model="filters.search"
                  type="text"
                  placeholder="Search products..."
                  class="w-full px-4 py-3 pl-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-colors"
                  @input="debouncedSearch"
                />
              </div>
            </div>

            <!-- Category Filter -->
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-3">Category</label>
              <select
                v-model="filters.category_id"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-colors"
                @change="fetchProducts"
              >
                <option value="">All Categories</option>
                <option v-for="(category, index) in categories" :key="category?.id || index" :value="category?.id || ''">
                  {{ category?.name || 'Unnamed Category' }}
                </option>
              </select>
            </div>

            <!-- Sort -->
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-3">Sort By</label>
              <select
                v-model="filters.sort"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-colors"
                @change="fetchProducts"
              >
                <option value="">Default</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
                <option value="newest">Newest First</option>
              </select>
            </div>

            <!-- Clear Filters -->
            <div class="flex items-end">
              <button
                @click="clearFilters"
                class="w-full px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-colors"
              >
                Clear Filters
              </button>
            </div>
          </div>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="flex justify-center py-20">
          <div class="flex flex-col items-center">
            <div class="spinner h-16 w-16 mb-4"></div>
            <p class="text-slate-600 font-medium">Loading educational toys...</p>
          </div>
        </div>

        <!-- Products Grid -->
        <div v-else-if="products.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 items-stretch">
          <div
            v-for="(product, index) in products"
            :key="product?.id || index"
            class="group cursor-pointer"
            @click="product?.id && $router.push(`/product/${product.id}`)"
          >
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-200 group-hover:border-slate-300 group-hover:-translate-y-1 h-full flex flex-col">
              <!-- Product Image Container -->
              <div class="relative overflow-hidden">
                <div class="aspect-w-1 aspect-h-1 bg-slate-100">
                  <img
                    :src="product?.image || '/images/placeholder.jpg'"
                    :alt="product?.name || 'Product'"
                    class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                </div>
              </div>
              
              <!-- Product Info -->
              <div class="p-5 flex flex-col flex-grow">
                <div class="mb-4 flex-grow">
                  <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-slate-700 transition-colors duration-300 line-clamp-1">
                    {{ product?.name || 'Unnamed Product' }}
                  </h3>
                  <p class="text-slate-600 text-sm leading-relaxed line-clamp-2">{{ product?.description || 'No description available' }}</p>
                </div>
                
                <!-- Price -->
                <div class="flex items-center justify-between mb-4">
                  <div class="flex items-center space-x-2">
                    <span class="text-xl font-bold text-slate-900">
                      PKR {{ product?.sale_price || product?.price || 0 }}
                    </span>
                    
                  </div>
                  
                </div>
                
                <!-- Add to Cart Button -->
                <button
                  @click.stop="addToCart(product)"
                  class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed mt-auto"
                  :disabled="(product?.stock_quantity || 0) === 0 || authStore.isAdmin"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                  </svg>
                  <span>{{ authStore.isAdmin ? 'Admin - Cannot Add' : ((product?.stock_quantity || 0) === 0 ? 'Out of Stock' : 'Add to Cart') }}</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-20">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-100 rounded-full mb-6">
            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-slate-900 mb-4">No products found</h3>
          <p class="text-lg text-slate-600 mb-8">Try adjusting your search or filter criteria to find what you're looking for.</p>
          <button
            @click="clearFilters"
            class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg transition-colors"
          >
            Clear All Filters
          </button>
        </div>

        <!-- Pagination -->
        <div v-if="pagination && pagination.last_page > 1" class="mt-12">
          <div class="flex flex-col items-center space-y-4">
            <!-- Page Info -->
            <div class="text-center">
              <p class="text-sm text-slate-600">
                Showing <span class="font-semibold text-slate-900">{{ ((pagination.current_page - 1) * pagination.per_page) + 1 }}</span> to 
                <span class="font-semibold text-slate-900">{{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }}</span> of 
                <span class="font-semibold text-slate-900">{{ pagination.total }}</span> products
              </p>
            </div>
            
            <!-- Pagination Controls -->
            <nav class="flex items-center space-x-1">
              <!-- Previous Button -->
              <button
                @click="changePage(pagination.current_page - 1)"
                :disabled="pagination.current_page === 1"
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-l-lg hover:bg-slate-50 hover:text-slate-900 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400 transition-all duration-200"
              >
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Previous
              </button>
              
              <!-- Page Numbers -->
              <div class="flex items-center space-x-1">
                <!-- First page -->
                <button
                  v-if="pagination.current_page > 3"
                  @click="changePage(1)"
                  class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 transition-all duration-200"
                >
                  1
                </button>
                
                <!-- Ellipsis for start -->
                <span v-if="pagination.current_page > 4" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300">
                  ...
                </span>
                
                <!-- Pages around current page -->
                <template v-for="page in getVisiblePages()" :key="page">
                  <button
                    @click="changePage(page)"
                    :class="[
                      'relative inline-flex items-center px-3 py-2 text-sm font-medium transition-all duration-200',
                      page === pagination.current_page
                        ? 'z-10 bg-slate-900 border-slate-900 text-white shadow-lg'
                        : 'text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900'
                    ]"
                  >
                    {{ page }}
                  </button>
                </template>
                
                <!-- Ellipsis for end -->
                <span v-if="pagination.current_page < pagination.last_page - 3" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300">
                  ...
                </span>
                
                <!-- Last page -->
                <button
                  v-if="pagination.current_page < pagination.last_page - 2"
                  @click="changePage(pagination.last_page)"
                  class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 transition-all duration-200"
                >
                  {{ pagination.last_page }}
                </button>
              </div>
              
              <!-- Next Button -->
              <button
                @click="changePage(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page"
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-r-lg hover:bg-slate-50 hover:text-slate-900 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400 transition-all duration-200"
              >
                Next
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </button>
            </nav>
          </div>
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
import { ref, onMounted, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import MainLayout from '../components/layout/MainLayout.vue';
import LoginPopup from '../components/LoginPopup.vue';
import { useCartStore } from '../stores/cart';
import { useAuthStore } from '../stores/auth';
import api from '../services/api';

export default {
  name: 'Products',
  components: {
    MainLayout,
    LoginPopup,
  },
  setup() {
    const router = useRouter();
    const route = useRoute();
    const cartStore = useCartStore();
    const authStore = useAuthStore();
    
    const products = ref([]);
    const categories = ref([]);
    const loading = ref(true);
    const pagination = ref(null);
    const showLoginPopup = ref(false);
    
    const filters = ref({
      search: '',
      category_id: '',
      sort: '',
    });

    let searchTimeout = null;

    const fetchProducts = async (page = 1) => {
      try {
        loading.value = true;
        const params = {
          page,
          ...filters.value,
        };
        
        // Remove empty filters
        Object.keys(params).forEach(key => {
          if (params[key] === '' || params[key] === null) {
            delete params[key];
          }
        });

        const response = await api.get('/products', { params });
        products.value = response.data?.data?.data || [];
        pagination.value = {
          current_page: response.data?.data?.current_page || 1,
          last_page: response.data?.data?.last_page || 1,
          per_page: response.data?.data?.per_page || 20,
          total: response.data?.data?.total || 0,
        };
      } catch (error) {
        console.error('Error fetching products:', error);
        if (window.$notify) {
          window.$notify.error('Error', 'Failed to load products. Please try again.');
        }
      } finally {
        loading.value = false;
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

    const debouncedSearch = () => {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        fetchProducts();
      }, 500);
    };

    const clearFilters = () => {
      filters.value = {
        search: '',
        category_id: '',
        sort: '',
      };
      fetchProducts();
    };

    const changePage = (page) => {
      if (page >= 1 && page <= pagination.value.last_page) {
        fetchProducts(page);
      }
    };

    const getVisiblePages = () => {
      if (!pagination.value) return [];
      
      const current = pagination.value.current_page;
      const last = pagination.value.last_page;
      const delta = 2; // Number of pages to show on each side of current page
      
      let start = Math.max(1, current - delta);
      let end = Math.min(last, current + delta);
      
      // Adjust if we're near the beginning or end
      if (current <= delta) {
        end = Math.min(last, 2 * delta + 1);
      }
      if (current >= last - delta) {
        start = Math.max(1, last - 2 * delta);
      }
      
      const pages = [];
      for (let i = start; i <= end; i++) {
        pages.push(i);
      }
      return pages;
    };

    const addToCart = (product) => {
      if (!authStore.isAuthenticated) {
        showLoginPopup.value = true;
        return;
      }
      
      if (authStore.isAdmin) {
        if (window.$notify) {
          window.$notify.error('Admin Restriction', 'Admin users cannot add items to cart');
        }
        return;
      }
      
      try {
        cartStore.addToCart(product);
        if (window.$notify) {
          window.$notify.success('Added to Cart', `${product.name} has been added to your cart!`);
        }
      } catch (error) {
        if (window.$notify) {
          window.$notify.error('Error', error.message);
        }
      }
    };

    // Handle URL parameters
    const initializeFilters = () => {
      if (route.query.category) {
        filters.value.category_id = route.query.category;
      }
      if (route.query.search) {
        filters.value.search = route.query.search;
      }
    };

    onMounted(() => {
      initializeFilters();
      fetchProducts();
      fetchCategories();
    });

    return {
      products,
      categories,
      loading,
      pagination,
      filters,
      showLoginPopup,
      fetchProducts,
      debouncedSearch,
      clearFilters,
      changePage,
      getVisiblePages,
      addToCart,
      authStore,
    };
  },
};
</script>
