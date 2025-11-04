<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <router-view />
    <NotificationSystem />
  </div>
</template>

<script>
import { onMounted } from 'vue'
import NotificationSystem from './components/NotificationSystem.vue'
import { useCartStore } from './stores/cart'

export default {
  name: 'App',
  components: {
    NotificationSystem
  },
  setup() {
    const cartStore = useCartStore()

    onMounted(() => {
      // Initialize cart based on authentication status
      cartStore.initializeCart()
    })
  }
}
</script>

<style>
@import 'animate.css';

#app {
  min-height: 100vh;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Smooth transitions for all interactive elements */
* {
  transition: all 0.2s ease-in-out;
}

/* Custom focus styles */
.focus-ring {
  @apply focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2;
}

/* Button hover effects */
.btn-hover {
  @apply transform hover:scale-105 active:scale-95;
}

/* Card hover effects */
.card-hover {
  @apply transform hover:scale-105 hover:shadow-xl transition-all duration-300;
}

/* Fade in animation */
.fade-in {
  animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Slide in from right */
.slide-in-right {
  animation: slideInRight 0.5s ease-out;
}

@keyframes slideInRight {
  from {
    opacity: 0;
    transform: translateX(100px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

/* Pulse animation for loading states */
.pulse-slow {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Bounce animation for success states */
.bounce-in {
  animation: bounceIn 0.6s ease-out;
}

@keyframes bounceIn {
  0% {
    opacity: 0;
    transform: scale(0.3);
  }
  50% {
    opacity: 1;
    transform: scale(1.05);
  }
  70% {
    transform: scale(0.9);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
