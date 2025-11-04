<template>
  <MainLayout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-white to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="relative max-w-md w-full space-y-8">
        <!-- Header Section -->
        <div class="text-center">
          <div class="mx-auto h-16 w-16 bg-gradient-to-br from-slate-700 to-slate-900 rounded-2xl flex items-center justify-center shadow-lg">
            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
          </div>
          <h2 class="mt-6 text-3xl font-bold text-slate-900">
            Join Pkmart
          </h2>
          <p class="mt-2 text-sm text-slate-600">
            Create your account to start shopping
          </p>
          <p class="mt-2 text-sm text-slate-600">
            Already have an account?
            <router-link to="/login" class="font-semibold text-slate-900 hover:text-slate-700 transition-colors">
              Sign in here
            </router-link>
          </p>
        </div>
        
        <!-- Registration Form -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200">
          <form class="space-y-6" @submit.prevent="handleRegister">
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
            
            <!-- Full Name Field -->
            <div class="space-y-2">
              <label for="name" class="block text-sm font-semibold text-slate-700">
                Full Name
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                </div>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  required
                  class="w-full px-4 py-3 pl-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-colors"
                  placeholder="Enter your full name"
                />
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
                  placeholder="Create a strong password"
                />
              </div>
            </div>
            
            <!-- Confirm Password Field -->
            <div class="space-y-2">
              <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">
                Confirm Password
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <input
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  type="password"
                  required
                  class="w-full px-4 py-3 pl-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-colors"
                  placeholder="Confirm your password"
                />
              </div>
            </div>

            <!-- Referral Code Field -->
            <div class="space-y-2">
              <label for="referral_code" class="block text-sm font-semibold text-slate-700">
                Referral Code <span class="text-slate-400">(Optional)</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"></path>
                  </svg>
                </div>
                <input
                  id="referral_code"
                  v-model="form.referral_code"
                  type="text"
                  class="w-full px-4 py-3 pl-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-colors"
                  placeholder="Enter referral code"
                  maxlength="8"
                />
              </div>
              <p class="text-xs text-slate-500">
                Have a referral code? Enter it here to start earning commissions!
              </p>
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input
                  id="terms"
                  v-model="form.terms"
                  type="checkbox"
                  required
                  class="h-4 w-4 text-slate-600 focus:ring-slate-500 border-slate-300 rounded"
                />
              </div>
              <div class="ml-3 text-sm">
                <label for="terms" class="text-slate-700">
                  I agree to the
                  <a href="#" class="font-semibold text-slate-900 hover:text-slate-700 transition-colors">Terms of Service</a>
                  and
                  <a href="#" class="font-semibold text-slate-900 hover:text-slate-700 transition-colors">Privacy Policy</a>
                </label>
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
                {{ loading ? 'Creating account...' : 'Create Account' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import MainLayout from '../../components/layout/MainLayout.vue';
import { useAuthStore } from '../../stores/auth';

export default {
  name: 'Register',
  components: {
    MainLayout,
  },
  setup() {
    const router = useRouter();
    const route = useRoute();
    const authStore = useAuthStore();
    
    const loading = ref(false);
    const error = ref('');
    
    const form = reactive({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      referral_code: '',
      terms: false,
    });

    // Auto-populate referral code from URL query parameter
    onMounted(() => {
      const refCode = route.query.ref;
      if (refCode) {
        form.referral_code = refCode;
        // Show a friendly message that referral code was applied
        if (window.$notify) {
          window.$notify.success('Referral Applied', `Referral code "${refCode}" has been applied to your registration.`);
        }
      }
    });

    const handleRegister = async () => {
      try {
        loading.value = true;
        error.value = '';
        
        if (form.password !== form.password_confirmation) {
          error.value = 'Passwords do not match.';
          return;
        }
        
        const result =         await authStore.register({
          name: form.name,
          email: form.email,
          password: form.password,
          password_confirmation: form.password_confirmation,
          referral_code: form.referral_code,
        });
        
        if (result.success) {
          router.push('/');
        } else {
          error.value = result.message;
        }
      } catch (err) {
        error.value = 'An error occurred during registration. Please try again.';
      } finally {
        loading.value = false;
      }
    };

    return {
      form,
      loading,
      error,
      handleRegister,
    };
  },
};
</script>
