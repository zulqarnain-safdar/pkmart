<template>
  <MainLayout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-white to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="relative max-w-md w-full space-y-8">
        <!-- Header Section -->
        <div class="text-center">
          <div class="mx-auto h-16 w-16 bg-gradient-to-br from-slate-700 to-slate-900 rounded-2xl flex items-center justify-center shadow-lg">
            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </div>
          <h2 class="mt-6 text-3xl font-bold text-slate-900">
            Welcome Back
          </h2>
          <p class="mt-2 text-sm text-slate-600">
            Sign in to your account to continue
          </p>
          <p class="mt-2 text-sm text-slate-600">
            Don't have an account?
            <router-link to="/register" class="font-semibold text-slate-900 hover:text-slate-700 transition-colors">
              Create one here
            </router-link>
          </p>
        </div>

        <!-- Demo Credentials Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200">
          <div class="flex items-center mb-4">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="ml-2 text-sm font-semibold text-slate-800">Demo Credentials</h3>
          </div>
          <div class="grid grid-cols-1 gap-4">
            <div class="bg-slate-50 rounded-lg p-4">
              <p class="text-sm font-medium text-slate-800 mb-2">Customer Account</p>
              <p class="text-xs text-slate-600 mb-1">Email: customer@test.com</p>
              <p class="text-xs text-slate-600 mb-3">Password: password123</p>
              <button
                @click="fillCredentials('customer@test.com', 'password123')"
                class="bg-slate-900 hover:bg-slate-800 text-white text-xs py-2 px-3 rounded-lg transition-colors"
              >
                Fill Form
              </button>
            </div>
            <div class="bg-blue-50 rounded-lg p-4">
              <p class="text-sm font-medium text-blue-800 mb-2">Admin Account</p>
              <p class="text-xs text-blue-600 mb-1">Email: admin@test.com</p>
              <p class="text-xs text-blue-600 mb-3">Password: password123</p>
              <button
                @click="fillCredentials('admin@test.com', 'password123')"
                class="bg-blue-600 hover:bg-blue-700 text-white text-xs py-2 px-3 rounded-lg transition-colors"
              >
                Fill Form
              </button>
            </div>
          </div>
        </div>
        
        <!-- Login Form -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
          <form class="space-y-6" @submit.prevent="handleLogin">
            <!-- Error Message -->
            <div v-if="error" class="bg-danger-50 border border-danger-200 text-danger-600 px-4 py-3 rounded-xl animate-slide-in-down">
              <div class="flex">
                <div class="flex-shrink-0">
                  <svg class="h-5 w-5 text-danger-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium">{{ error }}</p>
                </div>
              </div>
            </div>
            
            <!-- Email Field -->
            <div class="space-y-2">
              <label for="email" class="block text-sm font-semibold text-slate-700">
                Email Address
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                  </svg>
                </div>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  required
                  class="w-full px-4 py-3 pl-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-colors"
                  placeholder="Enter your email address"
                />
              </div>
            </div>
            
            <!-- Password Field -->
            <div class="space-y-2">
              <label for="password" class="block text-sm font-semibold text-slate-700">
                Password
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                  </svg>
                </div>
                <input
                  id="password"
                  v-model="form.password"
                  type="password"
                  required
                  class="w-full px-4 py-3 pl-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-colors"
                  placeholder="Enter your password"
                />
              </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <input
                  id="remember-me"
                  v-model="form.remember"
                  type="checkbox"
                  class="h-4 w-4 text-slate-600 focus:ring-slate-500 border-slate-300 rounded"
                />
                <label for="remember-me" class="ml-2 block text-sm text-slate-700 font-medium">
                  Remember me
                </label>
              </div>

              <div class="text-sm">
                <a href="#" class="font-semibold text-slate-900 hover:text-slate-700 transition-colors">
                  Forgot password?
                </a>
              </div>
            </div>

            <!-- Submit Button -->
            <div>
              <button
                type="submit"
                :disabled="loading"
                class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-4 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed relative"
              >
                <span v-if="loading" class="absolute left-0 inset-y-0 flex items-center pl-3">
                  <div class="spinner h-5 w-5"></div>
                </span>
                {{ loading ? 'Signing in...' : 'Sign In' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import MainLayout from '../../components/layout/MainLayout.vue';
import { useAuthStore } from '../../stores/auth';

export default {
  name: 'Login',
  components: {
    MainLayout,
  },
  setup() {
    const router = useRouter();
    const authStore = useAuthStore();
    
    const loading = ref(false);
    const error = ref('');
    
    const form = reactive({
      email: '',
      password: '',
      remember: false,
    });

    const handleLogin = async () => {
      try {
        loading.value = true;
        error.value = '';
        
        const result = await authStore.login({
          email: form.email,
          password: form.password,
        });
        
        if (result.success) {
          // Redirect admin users to admin panel, customers to home
          if (authStore.isAdmin) {
            router.push('/admin');
          } else {
            router.push('/');
          }
        } else {
          error.value = result.message;
        }
      } catch (err) {
        error.value = 'An error occurred during login. Please try again.';
      } finally {
        loading.value = false;
      }
    };

    const fillCredentials = (email, password) => {
      form.email = email;
      form.password = password;
    };

    return {
      form,
      loading,
      error,
      handleLogin,
      fillCredentials,
    };
  },
};
</script>
