<template>
  <!-- Modal Backdrop -->
  <div
    v-if="isOpen"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
    @click="closeModal"
  >
    <!-- Modal Content -->
    <div
      class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-100"
      @click.stop
    >
      <!-- Header -->
      <div class="flex items-center justify-between p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900">Login Required</h3>
            <p class="text-sm text-gray-600">Please login to continue</p>
          </div>
        </div>
        <button
          @click="closeModal"
          class="text-gray-400 hover:text-gray-600 transition-colors"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- Content -->
      <div class="p-6">
        <div class="text-center mb-6">
          <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
          </div>
          <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ title }}</h4>
          <p class="text-gray-600">{{ message }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
          <button
            @click="goToLogin"
            class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            <span>Login to Continue</span>
          </button>
          
          <button
            @click="goToRegister"
            class="w-full bg-white border-2 border-primary-600 text-primary-600 hover:bg-primary-50 font-semibold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center space-x-2"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            <span>Create Account</span>
          </button>
          
          <button
            @click="closeModal"
            class="w-full text-gray-600 hover:text-gray-800 font-medium py-2 transition-colors"
          >
            Continue Shopping
          </button>
        </div>

        <!-- Benefits -->
        <div class="mt-6 pt-6 border-t border-gray-200">
          <h5 class="text-sm font-semibold text-gray-900 mb-3">Why create an account?</h5>
          <div class="space-y-2">
            <div class="flex items-center space-x-2 text-sm text-gray-600">
              <svg class="w-4 h-4 text-success-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span>Track your orders</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
              <svg class="w-4 h-4 text-success-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span>Save your cart</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
              <svg class="w-4 h-4 text-success-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
              <span>Faster checkout</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router';

export default {
  name: 'LoginPopup',
  props: {
    isOpen: {
      type: Boolean,
      default: false
    },
    title: {
      type: String,
      default: 'Login Required'
    },
    message: {
      type: String,
      default: 'You need to be logged in to place an order.'
    }
  },
  emits: ['close'],
  setup(props, { emit }) {
    const router = useRouter();

    const closeModal = () => {
      emit('close');
    };

    const goToLogin = () => {
      router.push('/login');
      closeModal();
    };

    const goToRegister = () => {
      router.push('/register');
      closeModal();
    };

    return {
      closeModal,
      goToLogin,
      goToRegister
    };
  }
};
</script>
