<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out" :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
      <div class="flex items-center justify-center h-16 px-4 bg-primary-600">
        <div class="flex items-center space-x-3">
          <div class="relative">
            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
              <span class="text-white font-bold text-lg">P</span>
            </div>
            <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full flex items-center justify-center">
              <span class="text-yellow-800 font-bold text-xs">K</span>
            </div>
          </div>
          <div>
            <h1 class="text-xl font-bold text-white tracking-tight">Pkmart Admin</h1>
            <p class="text-xs text-blue-100 -mt-1">Management Panel</p>
          </div>
        </div>
      </div>
      
      <nav class="mt-8">
        <div class="px-4 space-y-2">
          <router-link
            to="/admin"
            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900"
            :class="{ 'bg-gray-100 text-gray-900': $route.name === 'AdminDashboard' }"
          >
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
            </svg>
            Dashboard
          </router-link>
          
          <router-link
            to="/admin/products"
            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900"
            :class="{ 'bg-gray-100 text-gray-900': $route.name === 'AdminProducts' }"
          >
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            Products
          </router-link>
          
          <router-link
            to="/admin/orders"
            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900"
            :class="{ 'bg-gray-100 text-gray-900': $route.name === 'AdminOrders' }"
          >
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Orders
          </router-link>
          
          <router-link
            to="/admin/categories"
            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900"
            :class="{ 'bg-gray-100 text-gray-900': $route.name === 'AdminCategories' }"
          >
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            Categories
          </router-link>
          
          <router-link
            to="/admin/referrals"
            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900"
            :class="{ 'bg-gray-100 text-gray-900': $route.name === 'AdminReferrals' }"
          >
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"></path>
            </svg>
            Referrals
          </router-link>
          
          <router-link
            to="/admin/commissions"
            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900"
            :class="{ 'bg-gray-100 text-gray-900': $route.name === 'AdminCommissions' }"
          >
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
            Commissions
          </router-link>
        </div>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col" :class="{ 'ml-64': sidebarOpen }">
      <!-- Top Navigation -->
      <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between h-16 px-4">
          <div class="flex items-center">
            <button
              @click="sidebarOpen = !sidebarOpen"
              class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
            >
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>
            
            <h2 class="ml-4 text-xl font-semibold text-gray-900">{{ pageTitle }}</h2>
          </div>
          
          <div class="flex items-center space-x-4">
            <!-- User Menu -->
            <div class="relative">
              <button
                @click="showUserMenu = !showUserMenu"
                class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
              >
                <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center">
                  <span class="text-white font-medium text-sm">
                    {{ authStore.user.name?.charAt(0).toUpperCase() }}
                  </span>
                </div>
              </button>

              <!-- Dropdown menu -->
              <div
                v-if="showUserMenu"
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
              >
                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                  {{ authStore.user.name }}
                </div>
                <router-link
                  to="/"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  @click="showUserMenu = false"
                >
                  View Store
                </router-link>
                <button
                  @click="logout"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Sign out
                </button>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>

    <!-- Mobile sidebar overlay -->
    <div
      v-if="sidebarOpen"
      class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
      @click="sidebarOpen = false"
    ></div>
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';

export default {
  name: 'AdminLayout',
  setup() {
    const route = useRoute();
    const router = useRouter();
    const authStore = useAuthStore();
    
    const sidebarOpen = ref(false);
    const showUserMenu = ref(false);

    const pageTitle = computed(() => {
      switch (route.name) {
        case 'AdminDashboard':
          return 'Dashboard';
        case 'AdminProducts':
          return 'Products';
        case 'AdminOrders':
          return 'Orders';
        case 'AdminCategories':
          return 'Categories';
        case 'AdminReferrals':
          return 'Referrals';
        case 'AdminCommissions':
          return 'Commissions';
        default:
          return 'Admin Panel';
      }
    });

    const logout = () => {
      authStore.logout();
      showUserMenu.value = false;
      // Show success notification
      if (window.$notify) {
        window.$notify.success('Logged Out', 'You have been successfully logged out.');
      }
      // Redirect to login page after logout
      router.push('/login');
    };

    return {
      authStore,
      sidebarOpen,
      showUserMenu,
      pageTitle,
      logout,
    };
  },
};
</script>
