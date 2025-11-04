<template>
  <div class="fixed top-4 right-4 z-50 space-y-2 w-80 max-w-[calc(100vw-2rem)]">
    <TransitionGroup
      name="notification"
      tag="div"
      class="space-y-2"
    >
      <div
        v-for="notification in notifications"
        :key="notification.id"
        :class="[
          'w-full bg-white shadow-soft rounded-xl pointer-events-auto ring-1 ring-gray-200 overflow-hidden border border-gray-100',
          notification.type === 'success' ? 'border-l-4 border-success-500' : '',
          notification.type === 'error' ? 'border-l-4 border-danger-500' : '',
          notification.type === 'warning' ? 'border-l-4 border-warning-500' : '',
          notification.type === 'info' ? 'border-l-4 border-primary-500' : '',
        ]"
      >
        <div class="p-4">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <!-- Success Icon -->
              <svg
                v-if="notification.type === 'success'"
                class="h-6 w-6 text-success-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              <!-- Error Icon -->
              <svg
                v-else-if="notification.type === 'error'"
                class="h-6 w-6 text-danger-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              <!-- Warning Icon -->
              <svg
                v-else-if="notification.type === 'warning'"
                class="h-6 w-6 text-warning-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                />
              </svg>
              <!-- Info Icon -->
              <svg
                v-else
                class="h-6 w-6 text-primary-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <p class="text-sm font-medium text-gray-900">
                {{ notification.title }}
              </p>
              <p class="mt-1 text-sm text-gray-500">
                {{ notification.message }}
              </p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
              <button
                @click="removeNotification(notification.id)"
                class="bg-gray-50 hover:bg-gray-100 rounded-lg inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 p-1 transition-colors duration-200"
              >
                <span class="sr-only">Close</span>
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                  <path
                    fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </TransitionGroup>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'

export default {
  name: 'NotificationSystem',
  setup() {
    const notifications = ref([])
    let notificationId = 0

    const addNotification = (notification) => {
      const id = ++notificationId
      const newNotification = {
        id,
        type: notification.type || 'info',
        title: notification.title || 'Notification',
        message: notification.message || '',
        duration: notification.duration || 5000,
        ...notification
      }
      
      notifications.value.push(newNotification)

      // Auto remove after duration
      if (newNotification.duration > 0) {
        setTimeout(() => {
          removeNotification(id)
        }, newNotification.duration)
      }
    }

    const removeNotification = (id) => {
      const index = notifications.value.findIndex(n => n.id === id)
      if (index > -1) {
        notifications.value.splice(index, 1)
      }
    }

    // Global notification methods
    const showSuccess = (title, message, duration = 5000) => {
      addNotification({ type: 'success', title, message, duration })
    }

    const showError = (title, message, duration = 5000) => {
      addNotification({ type: 'error', title, message, duration })
    }

    const showWarning = (title, message, duration = 5000) => {
      addNotification({ type: 'warning', title, message, duration })
    }

    const showInfo = (title, message, duration = 5000) => {
      addNotification({ type: 'info', title, message, duration })
    }

    // Make methods available globally
    onMounted(() => {
      window.$notify = {
        success: showSuccess,
        error: showError,
        warning: showWarning,
        info: showInfo,
        add: addNotification
      }
    })

    onUnmounted(() => {
      delete window.$notify
    })

    return {
      notifications,
      removeNotification
    }
  }
}
</script>

<style scoped>
.notification-enter-active {
  transition: all 0.3s ease-out;
}

.notification-leave-active {
  transition: all 0.3s ease-in;
}

.notification-enter-from {
  transform: translateX(100%);
  opacity: 0;
}

.notification-leave-to {
  transform: translateX(100%);
  opacity: 0;
}

.notification-move {
  transition: transform 0.3s ease;
}
</style>
