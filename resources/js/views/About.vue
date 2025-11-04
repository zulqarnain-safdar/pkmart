<template>
  <MainLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Hero Section -->
      <div class="text-center mb-16">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">About Pkmart</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Your trusted partner for quality products and exceptional service. 
          We're committed to bringing you the best shopping experience online.
        </p>
      </div>

      <!-- Mission & Vision -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
          <div class="flex items-center mb-6">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <h2 class="ml-3 text-2xl font-bold text-gray-900">Our Mission</h2>
          </div>
          <p class="text-gray-600 leading-relaxed">
            To provide our customers with high-quality products at competitive prices, 
            delivered with exceptional service and support. We believe in making 
            online shopping simple, secure, and satisfying.
          </p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
          <div class="flex items-center mb-6">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
            </div>
            <h2 class="ml-3 text-2xl font-bold text-gray-900">Our Vision</h2>
          </div>
          <p class="text-gray-600 leading-relaxed">
            To become the leading e-commerce platform that customers trust and 
            choose first for their shopping needs. We envision a future where 
            shopping is seamless, enjoyable, and accessible to everyone.
          </p>
        </div>
      </div>

      <!-- Values -->
      <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Our Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Quality</h3>
            <p class="text-gray-600">We ensure every product meets our high standards of quality and reliability.</p>
          </div>

          <div class="text-center">
            <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Customer First</h3>
            <p class="text-gray-600">Our customers are at the heart of everything we do. Their satisfaction is our priority.</p>
          </div>

          <div class="text-center">
            <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Innovation</h3>
            <p class="text-gray-600">We continuously improve and innovate to provide the best shopping experience.</p>
          </div>
        </div>
      </div>

      <!-- Team Section -->
      <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Meet Our Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="bg-gray-200 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
              <span class="text-2xl font-bold text-gray-600">JD</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-1">John Doe</h3>
            <p class="text-gray-600 mb-2">CEO & Founder</p>
            <p class="text-sm text-gray-500">Leading the company with 10+ years of e-commerce experience.</p>
          </div>

          <div class="text-center">
            <div class="bg-gray-200 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
              <span class="text-2xl font-bold text-gray-600">JS</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-1">Jane Smith</h3>
            <p class="text-gray-600 mb-2">CTO</p>
            <p class="text-sm text-gray-500">Overseeing technology and innovation initiatives.</p>
          </div>

          <div class="text-center">
            <div class="bg-gray-200 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
              <span class="text-2xl font-bold text-gray-600">MJ</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-1">Mike Johnson</h3>
            <p class="text-gray-600 mb-2">Head of Operations</p>
            <p class="text-sm text-gray-500">Ensuring smooth operations and customer satisfaction.</p>
          </div>
        </div>
      </div>

      <!-- Stats -->
      <div class="bg-blue-600 rounded-lg p-8 text-white">
        <h2 class="text-3xl font-bold text-center mb-8">Our Impact</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
          <div>
            <div class="text-4xl font-bold mb-2">10K+</div>
            <div class="text-blue-200">Happy Customers</div>
          </div>
          <div>
            <div class="text-4xl font-bold mb-2">50K+</div>
            <div class="text-blue-200">Products Sold</div>
          </div>
          <div>
            <div class="text-4xl font-bold mb-2">99%</div>
            <div class="text-blue-200">Customer Satisfaction</div>
          </div>
          <div>
            <div class="text-4xl font-bold mb-2">24/7</div>
            <div class="text-blue-200">Customer Support</div>
          </div>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import MainLayout from '../components/layout/MainLayout.vue';

export default {
  name: 'About',
  components: {
    MainLayout,
  },
};
</script>
