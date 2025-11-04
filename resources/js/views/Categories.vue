<template>
  <MainLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Product Categories</h1>
        <p class="text-gray-600">Browse our products by category</p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <!-- Categories Grid -->
      <div v-else-if="categories.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="(category, index) in categories"
          :key="category?.id || index"
          class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200"
        >
          <div class="aspect-w-16 aspect-h-9">
            <img
              :src="category.image || '/placeholder-category.jpg'"
              :alt="category?.name || 'Category'"
              class="w-full h-48 object-cover"
            />
          </div>
          
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ category?.name || 'Unnamed Category' }}</h3>
            <p class="text-gray-600 mb-4 line-clamp-3">{{ category.description }}</p>
            
            <div class="flex items-center justify-between">
              <span class="text-sm text-gray-500">
                {{ category.products_count || 0 }} products
              </span>
              <router-link
                :to="category?.id ? `/products?category=${category.id}` : '/products'"
                class="text-blue-600 hover:text-blue-800 font-medium text-sm"
              >
                View Products →
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination for Categories -->
      <div v-if="pagination && pagination.last_page > 1" class="mt-16">
        <div class="flex flex-col items-center space-y-4">
          <!-- Page Info -->
          <div class="text-center">
            <p class="text-sm text-gray-600">
              Showing <span class="font-semibold text-primary-600">{{ ((pagination.current_page - 1) * pagination.per_page) + 1 }}</span> to 
              <span class="font-semibold text-primary-600">{{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }}</span> of 
              <span class="font-semibold text-primary-600">{{ pagination.total }}</span> categories
            </p>
          </div>
          
          <!-- Pagination Controls -->
          <nav class="flex items-center space-x-1">
            <!-- Previous Button -->
            <button
              @click="changePage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400 transition-all duration-200"
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
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 transition-all duration-200"
              >
                1
              </button>
              
              <!-- Ellipsis for start -->
              <span v-if="pagination.current_page > 4" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">
                ...
              </span>
              
              <!-- Pages around current page -->
              <template v-for="page in getVisiblePages()" :key="page">
                <button
                  @click="changePage(page)"
                  :class="[
                    'relative inline-flex items-center px-3 py-2 text-sm font-medium transition-all duration-200',
                    page === pagination.current_page
                      ? 'z-10 bg-primary-600 border-primary-600 text-white shadow-lg'
                      : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700'
                  ]"
                >
                  {{ page }}
                </button>
              </template>
              
              <!-- Ellipsis for end -->
              <span v-if="pagination.current_page < pagination.last_page - 3" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">
                ...
              </span>
              
              <!-- Last page -->
              <button
                v-if="pagination.current_page < pagination.last_page - 2"
                @click="changePage(pagination.last_page)"
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 transition-all duration-200"
              >
                {{ pagination.last_page }}
              </button>
            </div>
            
            <!-- Next Button -->
            <button
              @click="changePage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400 transition-all duration-200"
            >
              Next
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </button>
          </nav>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">No categories found</h3>
        <p class="mt-1 text-sm text-gray-500">There are no categories available at the moment.</p>
      </div>

      <!-- Featured Categories -->
      <div v-if="featuredCategories.length > 0" class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Featured Categories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            v-for="(category, index) in featuredCategories"
            :key="category?.id || index"
            class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-6 text-center hover:shadow-md transition-shadow duration-200"
          >
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ category?.name || 'Unnamed Category' }}</h3>
            <p class="text-sm text-gray-600 mb-4">{{ category.products_count || 0 }} products</p>
            <router-link
              :to="category?.id ? `/products?category=${category.id}` : '/products'"
              class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm"
            >
              Explore
              <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import MainLayout from '../components/layout/MainLayout.vue';
import api from '../services/api';

export default {
  name: 'Categories',
  components: {
    MainLayout,
  },
  setup() {
    const categories = ref([]);
    const featuredCategories = ref([]);
    const loading = ref(true);
    const pagination = ref(null);
    const currentPage = ref(1);

    const fetchCategories = async (page = 1) => {
      try {
        loading.value = true;
        const response = await api.get('/categories', {
          params: { page, per_page: 25 }
        });
        
        if (response.data.success) {
          if (response.data.data.data) {
            // Paginated response
            categories.value = response.data.data.data;
            pagination.value = {
              current_page: response.data.data.current_page,
              last_page: response.data.data.last_page,
              per_page: response.data.data.per_page,
              total: response.data.data.total,
            };
          } else {
            // Non-paginated response (fallback)
            categories.value = response.data.data;
            pagination.value = null;
          }
          // Set first 4 categories as featured
          featuredCategories.value = categories.value.slice(0, 4);
        }
      } catch (error) {
        console.error('Error fetching categories:', error);
      } finally {
        loading.value = false;
      }
    };

    const changePage = (page) => {
      if (page >= 1 && page <= pagination.value?.last_page) {
        currentPage.value = page;
        fetchCategories(page);
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

    onMounted(() => {
      fetchCategories();
    });

    return {
      categories,
      featuredCategories,
      loading,
      pagination,
      currentPage,
      changePage,
      getVisiblePages,
    };
  },
};
</script>
