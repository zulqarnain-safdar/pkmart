<template>
  <MainLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Contact Us</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          We'd love to hear from you. Send us a message and we'll respond as soon as possible.
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Contact Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a message</h2>
          
          <form @submit.prevent="handleSubmit" class="space-y-6">
            <div v-if="successMessage" class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-md">
              {{ successMessage }}
            </div>
            
            <div v-if="errorMessage" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-md">
              {{ errorMessage }}
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                <input
                  v-model="form.firstName"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                <input
                  v-model="form.lastName"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
              <input
                v-model="form.email"
                type="email"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
              <input
                v-model="form.subject"
                type="text"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
              <textarea
                v-model="form.message"
                rows="6"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Tell us how we can help you..."
              ></textarea>
            </div>

            <button
              type="submit"
              :disabled="loading"
              class="w-full btn-primary"
            >
              {{ loading ? 'Sending...' : 'Send Message' }}
            </button>
          </form>
        </div>

        <!-- Contact Information -->
        <div class="space-y-8">
          <!-- Contact Details -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in touch</h2>
            
            <div class="space-y-6">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                  <p class="text-gray-600">support@pkmart.com</p>
                  <p class="text-gray-600">info@pkmart.com</p>
                </div>
              </div>

              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                  </svg>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-semibold text-gray-900">Phone</h3>
                  <p class="text-gray-600">+1 (555) 123-4567</p>
                  <p class="text-gray-600">+1 (555) 987-6543</p>
                </div>
              </div>

              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-semibold text-gray-900">Address</h3>
                  <p class="text-gray-600">123 Business Street</p>
                  <p class="text-gray-600">Suite 100</p>
                  <p class="text-gray-600">New York, NY 10001</p>
                </div>
              </div>

              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-semibold text-gray-900">Business Hours</h3>
                  <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM</p>
                  <p class="text-gray-600">Saturday: 10:00 AM - 4:00 PM</p>
                  <p class="text-gray-600">Sunday: Closed</p>
                </div>
              </div>
            </div>
          </div>

          <!-- FAQ -->
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">How can I track my order?</h3>
                <p class="text-gray-600">You can track your order by logging into your account and visiting the "My Orders" section.</p>
              </div>
              
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">What is your return policy?</h3>
                <p class="text-gray-600">We offer a 30-day return policy for most items. Please check the product page for specific return conditions.</p>
              </div>
              
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you offer free shipping?</h3>
                <p class="text-gray-600">Yes! We offer free shipping on orders over PKR 50. Standard shipping rates apply for smaller orders.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import { ref, reactive } from 'vue';
import MainLayout from '../components/layout/MainLayout.vue';

export default {
  name: 'Contact',
  components: {
    MainLayout,
  },
  setup() {
    const loading = ref(false);
    const successMessage = ref('');
    const errorMessage = ref('');
    
    const form = reactive({
      firstName: '',
      lastName: '',
      email: '',
      subject: '',
      message: '',
    });

    const handleSubmit = async () => {
      try {
        loading.value = true;
        errorMessage.value = '';
        successMessage.value = '';
        
        // Simulate form submission
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        successMessage.value = 'Thank you for your message! We\'ll get back to you soon.';
        
        // Reset form
        Object.keys(form).forEach(key => {
          form[key] = '';
        });
        
      } catch (error) {
        errorMessage.value = 'Failed to send message. Please try again.';
      } finally {
        loading.value = false;
      }
    };

    return {
      form,
      loading,
      successMessage,
      errorMessage,
      handleSubmit,
    };
  },
};
</script>
