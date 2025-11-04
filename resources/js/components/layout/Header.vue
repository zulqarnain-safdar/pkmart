<template>
  <header class="bg-white/95 backdrop-blur-sm shadow-lg border-b border-slate-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <div class="flex items-center">
          <router-link to="/" class="flex items-center group">
            <div class="flex items-center space-x-3">
              <div class="relative group-hover:scale-105 transition-transform duration-300">
                <div class="w-12 h-12 bg-gradient-to-br from-slate-700 to-slate-900 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                  <span class="text-white font-bold text-xl">P</span>
                </div>
                <div class="absolute -top-1 -right-1 w-5 h-5 bg-blue-600 rounded-lg flex items-center justify-center">
                  <span class="text-white font-bold text-xs">K</span>
                </div>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight group-hover:scale-105 transition-transform duration-300">Pkmart</h1>
                <p class="text-xs text-slate-600 -mt-1 font-medium">Educational Toys</p>
              </div>
            </div>
          </router-link>
        </div>

        <!-- Navigation -->
        <nav class="hidden md:flex space-x-1">
          <router-link 
            to="/" 
            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 hover:bg-slate-100 hover:text-slate-900"
            :class="{ 
              'text-slate-900 bg-slate-100': $route.name === 'Home',
              'text-slate-600 hover:text-slate-900': $route.name !== 'Home'
            }"
          >
            Home
          </router-link>
          <router-link 
            to="/products" 
            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 hover:bg-slate-100 hover:text-slate-900"
            :class="{ 
              'text-slate-900 bg-slate-100': $route.name === 'Products',
              'text-slate-600 hover:text-slate-900': $route.name !== 'Products'
            }"
          >
            Products
          </router-link>
          <router-link 
            to="/categories" 
            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 hover:bg-slate-100 hover:text-slate-900"
            :class="{ 
              'text-slate-900 bg-slate-100': $route.name === 'Categories',
              'text-slate-600 hover:text-slate-900': $route.name !== 'Categories'
            }"
          >
            Categories
          </router-link>
          <router-link 
            to="/about" 
            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 hover:bg-slate-100 hover:text-slate-900"
            :class="{ 
              'text-slate-900 bg-slate-100': $route.name === 'About',
              'text-slate-600 hover:text-slate-900': $route.name !== 'About'
            }"
          >
            About
          </router-link>
          <router-link 
            to="/contact" 
            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 hover:bg-slate-100 hover:text-slate-900"
            :class="{ 
              'text-slate-900 bg-slate-100': $route.name === 'Contact',
              'text-slate-600 hover:text-slate-900': $route.name !== 'Contact'
            }"
          >
            Contact
          </router-link>
        </nav>

        <!-- Mobile menu button -->
        <div class="md:hidden">
          <button
            @click="showMobileMenu = !showMobileMenu"
            class="p-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>

        <!-- Right side -->
        <div class="flex items-center space-x-4">
          <!-- Cart -->
          <router-link to="/cart" class="relative p-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300 group">
            <svg class="h-6 w-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
            </svg>
            <span 
              v-if="cartStore.itemCount > 0"
              class="absolute -top-1 -right-1 bg-slate-900 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold shadow-lg"
            >
              {{ cartStore.itemCount }}
            </span>
          </router-link>

          <!-- User menu -->
          <div v-if="authStore.isAuthenticated" class="relative">
            <button 
              @click="showUserMenu = !showUserMenu"
              class="flex items-center text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 hover:bg-slate-100 p-2 transition-all duration-300"
            >
              <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300">
                <span class="text-white font-bold text-sm">
                  {{ authStore.user.name?.charAt(0).toUpperCase() }}
                </span>
              </div>
            </button>

            <!-- Dropdown menu -->
            <Transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <div 
                v-if="showUserMenu"
                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 z-50 border border-slate-200"
              >
                <div class="px-4 py-3 text-sm font-semibold text-slate-900 border-b border-slate-200">
                  {{ authStore.user.name }}
                </div>
                <router-link 
                  v-if="authStore.isAdmin"
                  to="/admin" 
                  class="flex items-center px-4 py-3 text-sm text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-200"
                  @click="showUserMenu = false"
                >
                  <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                  </svg>
                  Admin Panel
                </router-link>
                <!-- Customer Navigation (only show to non-admin users) -->
                <template v-if="!authStore.isAdmin">
                  <router-link 
                    to="/dashboard" 
                    class="flex items-center px-4 py-3 text-sm text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-200"
                    @click="showUserMenu = false"
                  >
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    Dashboard
                  </router-link>
                  <router-link 
                    to="/referrals" 
                    class="flex items-center px-4 py-3 text-sm text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-200"
                    @click="showUserMenu = false"
                  >
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"></path>
                    </svg>
                    Referrals
                  </router-link>
                  <router-link 
                    to="/orders" 
                    class="flex items-center px-4 py-3 text-sm text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-200"
                    @click="showUserMenu = false"
                  >
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    My Orders
                  </router-link>
                </template>
                <div class="border-t border-slate-200 mt-2 pt-2">
                  <button 
                    @click="logout"
                    class="flex items-center w-full px-4 py-3 text-sm text-slate-600 hover:bg-red-50 hover:text-red-600 transition-colors duration-200"
                  >
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Sign out
                  </button>
                </div>
              </div>
            </Transition>
          </div>

          <!-- Login/Register buttons -->
          <div v-else class="flex space-x-3">
            <router-link 
              to="/login" 
              class="text-slate-600 hover:text-slate-900 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-100 transition-all duration-300"
            >
              Login
            </router-link>
            <router-link 
              to="/register" 
              class="bg-slate-900 text-white text-sm px-6 py-2 rounded-lg hover:bg-slate-800 transition-all duration-300"
            >
              Register
            </router-link>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <Transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="transform opacity-0 scale-95"
        enter-to-class="transform opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="transform opacity-100 scale-100"
        leave-to-class="transform opacity-0 scale-95"
      >
        <div v-if="showMobileMenu" class="md:hidden border-t border-slate-200 bg-white/95 backdrop-blur-sm">
          <div class="px-4 pt-4 pb-6 space-y-2">
            <router-link 
              to="/" 
              class="flex items-center px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg text-base font-semibold transition-all duration-300"
              @click="showMobileMenu = false"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              Home
            </router-link>
            <router-link 
              to="/products" 
              class="flex items-center px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg text-base font-semibold transition-all duration-300"
              @click="showMobileMenu = false"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
              </svg>
              Products
            </router-link>
            <router-link 
              to="/categories" 
              class="flex items-center px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg text-base font-semibold transition-all duration-300"
              @click="showMobileMenu = false"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
              Categories
            </router-link>
            <router-link 
              to="/about" 
              class="flex items-center px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg text-base font-semibold transition-all duration-300"
              @click="showMobileMenu = false"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              About
            </router-link>
            <router-link 
              to="/contact" 
              class="flex items-center px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg text-base font-semibold transition-all duration-300"
              @click="showMobileMenu = false"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              Contact
            </router-link>
            
            <!-- Mobile user menu -->
            <div v-if="authStore.isAuthenticated" class="border-t border-slate-200 pt-4 mt-4">
              <div class="px-4 py-3 text-sm font-semibold text-slate-900 bg-slate-100 rounded-lg">
                {{ authStore.user.name }}
              </div>
              <router-link 
                v-if="authStore.isAdmin"
                to="/admin" 
                class="flex items-center px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg text-base font-semibold transition-all duration-300"
                @click="showMobileMenu = false"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Admin Panel
              </router-link>
              <router-link 
                to="/dashboard" 
                class="flex items-center px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg text-base font-semibold transition-all duration-300"
                @click="showMobileMenu = false"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                Dashboard
              </router-link>
              <router-link 
                to="/orders" 
                class="flex items-center px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg text-base font-semibold transition-all duration-300"
                @click="showMobileMenu = false"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                My Orders
              </router-link>
              <button 
                @click="logout"
                class="flex items-center w-full px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-lg text-base font-semibold transition-all duration-300"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Sign out
              </button>
            </div>
            
            <!-- Mobile login/register -->
            <div v-else class="border-t border-slate-200 pt-4 mt-4 space-y-2">
              <router-link 
                to="/login" 
                class="flex items-center px-4 py-3 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg text-base font-semibold transition-all duration-300"
                @click="showMobileMenu = false"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Login
              </router-link>
              <router-link 
                to="/register" 
                class="flex items-center px-4 py-3 text-white bg-slate-900 hover:bg-slate-800 rounded-lg text-base font-semibold transition-all duration-300"
                @click="showMobileMenu = false"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Register
              </router-link>
            </div>
          </div>
        </div>
      </Transition>
    </div>
  </header>
</template>

<script>
import { ref } from 'vue';
import { useAuthStore } from '../../stores/auth';
import { useCartStore } from '../../stores/cart';

export default {
  name: 'Header',
  setup() {
    const authStore = useAuthStore();
    const cartStore = useCartStore();
    const showUserMenu = ref(false);
    const showMobileMenu = ref(false);

    const logout = () => {
      authStore.logout();
      showUserMenu.value = false;
      showMobileMenu.value = false;
      if (window.$notify) {
        window.$notify.success('Logged Out', 'You have been successfully logged out.');
      }
    };

    return {
      authStore,
      cartStore,
      showUserMenu,
      showMobileMenu,
      logout,
    };
  },
};
</script>
