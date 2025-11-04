<template>
  <MainLayout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-50 via-white to-green-50 overflow-hidden">
      <!-- Background Elements -->
      <div class="absolute inset-0">
        <!-- Toy Icons -->
        <div class="absolute top-20 left-10 text-6xl opacity-10 animate-bounce" style="animation-delay: 0s;">🧸</div>
        <div class="absolute top-32 right-20 text-5xl opacity-10 animate-bounce" style="animation-delay: 1s;">🚗</div>
        <div class="absolute bottom-40 left-20 text-4xl opacity-10 animate-bounce" style="animation-delay: 2s;">🎨</div>
        <div class="absolute bottom-20 right-10 text-5xl opacity-10 animate-bounce" style="animation-delay: 3s;">🎮</div>
        <div class="absolute top-1/2 left-1/4 text-4xl opacity-10 animate-bounce" style="animation-delay: 4s;">🧩</div>
        <div class="absolute top-1/3 right-1/3 text-3xl opacity-10 animate-bounce" style="animation-delay: 5s;">⚽</div>
        
        <!-- Geometric Shapes -->
        <div class="absolute top-10 right-10 w-20 h-20 bg-yellow-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute bottom-10 left-10 w-16 h-16 bg-pink-200 rounded-full opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 right-1/4 w-12 h-12 bg-blue-200 rounded-full opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
      </div>
      
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
          <!-- Professional Header -->
          <div class="mb-16">
            <!-- Logo -->
            <div class="inline-flex items-center justify-center space-x-3 mb-8">
              <div class="w-16 h-16 bg-gradient-to-br from-slate-700 to-slate-900 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-2xl">P</span>
              </div>
              <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">K</span>
              </div>
            </div>
            
            <!-- Main Title -->
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-4 tracking-tight">
                Pkmart
              </h1>
            
            <!-- Subtitle -->
            <h2 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-6">
              Premium Educational Toys & Learning Solutions
            </h2>
            
            <!-- Description -->
            <p class="text-lg md:text-xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed font-light">
              Empowering young minds through carefully curated educational toys, 
              designed to foster creativity, learning, and development in children of all ages.
            </p>
          </div>
          
          <!-- CTA Buttons -->
          <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-20">
            <router-link 
              to="/products" 
              class="px-8 py-4 bg-slate-900 text-white font-semibold text-lg rounded-lg shadow-lg hover:shadow-xl hover:bg-slate-800 transition-all duration-300 flex items-center justify-center min-w-[200px]"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
              Browse Products
            </router-link>
            <router-link 
              to="/categories" 
              class="px-8 py-4 border-2 border-slate-300 text-slate-700 font-semibold text-lg rounded-lg hover:bg-slate-50 hover:border-slate-400 transition-all duration-300 flex items-center justify-center min-w-[200px]"
            >
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
              View Categories
            </router-link>
          </div>
          
          <!-- Professional Stats -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
            <div class="text-center">
              <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
              </div>
              <div class="text-2xl font-bold text-slate-900 mb-1">30+</div>
              <div class="text-sm text-slate-600 font-medium">Quality Products</div>
            </div>
            
            <div class="text-center">
              <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="text-2xl font-bold text-slate-900 mb-1">100%</div>
              <div class="text-sm text-slate-600 font-medium">Safety Tested</div>
            </div>
            
            <div class="text-center">
              <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="text-2xl font-bold text-slate-900 mb-1">24/7</div>
              <div class="text-sm text-slate-600 font-medium">Support</div>
            </div>
            
            <div class="text-center">
              <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
              </div>
              <div class="text-2xl font-bold text-slate-900 mb-1">Free</div>
              <div class="text-sm text-slate-600 font-medium">Delivery</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="section-padding bg-gradient-to-b from-slate-50 to-white relative overflow-hidden">
      <div class="container-custom relative">
        <div class="text-center mb-16">
          <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-slate-700 to-slate-900 rounded-xl mb-6 shadow-lg">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
          </div>
          <h2 class="text-4xl font-bold text-slate-900 mb-6">Featured Educational Toys</h2>
          <p class="text-lg text-slate-600 max-w-3xl mx-auto leading-relaxed">
            Discover our carefully curated collection of premium educational toys, 
            designed to inspire learning and creativity in children of all ages.
          </p>
        </div>

        <div v-if="loading" class="flex justify-center py-20">
          <div class="flex flex-col items-center">
            <div class="spinner h-16 w-16 mb-4"></div>
            <p class="text-gray-600 font-medium">Loading amazing products...</p>
          </div>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 items-stretch">
          <div 
            v-for="(product, index) in featuredProducts" 
            :key="product?.id || index"
            class="group cursor-pointer"
            @click="product?.id && $router.push(`/product/${product.id}`)"
          >
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-200 group-hover:border-slate-300 group-hover:-translate-y-1 h-full flex flex-col">
              <!-- Product Image Container -->
              <div class="relative overflow-hidden">
                <div class="aspect-w-1 aspect-h-1 bg-slate-100">
                  <img 
                    :src="product.image" 
                    :alt="product.name"
                    class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                </div>
                
                <!-- Quick View Button -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 translate-y-12 group-hover:translate-y-0 transition-transform duration-300">
                  <button class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-lg font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-300">
                    Quick View
                  </button>
                </div>
              </div>
              
              <!-- Product Info -->
              <div class="p-5 flex flex-col flex-grow">
                <div class="mb-4 flex-grow">
                  <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-slate-700 transition-colors duration-300 line-clamp-1">{{ product.name }}</h3>
                  <p class="text-slate-600 text-sm leading-relaxed line-clamp-2">{{ product.description }}</p>
                </div>
                
                <!-- Price -->
                <div class="flex items-center justify-between mb-4">
                  <div class="flex items-center space-x-2">
                    <span class="text-xl font-bold text-slate-900">PKR {{ product.price }}</span>
                  </div>
                </div>
                
                <!-- Add to Cart Button -->
                <button 
                  @click.stop="addToCart(product)"
                  :disabled="authStore.isAdmin"
                  class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 flex items-center justify-center space-x-2 mt-auto disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                  </svg>
                  <span>{{ authStore.isAdmin ? 'Admin - Cannot Add' : 'Add to Cart' }}</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination for Featured Products -->
        <div v-if="pagination && pagination.last_page > 1" class="mt-12">
          <div class="flex flex-col items-center space-y-4">
            <!-- Page Info -->
            <div class="text-center">
              <p class="text-sm text-slate-600">
                Showing <span class="font-semibold text-slate-900">{{ ((pagination.current_page - 1) * pagination.per_page) + 1 }}</span> to 
                <span class="font-semibold text-slate-900">{{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }}</span> of 
                <span class="font-semibold text-slate-900">{{ pagination.total }}</span> products
              </p>
            </div>
            
            <!-- Pagination Controls -->
            <nav class="flex items-center space-x-1">
              <!-- Previous Button -->
              <button
                @click="changePage(pagination.current_page - 1)"
                :disabled="pagination.current_page === 1"
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-l-lg hover:bg-slate-50 hover:text-slate-900 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400 transition-all duration-200"
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
                  class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 transition-all duration-200"
                >
                  1
                </button>
                
                <!-- Ellipsis for start -->
                <span v-if="pagination.current_page > 4" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300">
                  ...
                </span>
                
                <!-- Pages around current page -->
                <template v-for="page in getVisiblePages()" :key="page">
                  <button
                    @click="changePage(page)"
                    :class="[
                      'relative inline-flex items-center px-3 py-2 text-sm font-medium transition-all duration-200',
                      page === pagination.current_page
                        ? 'z-10 bg-slate-900 border-slate-900 text-white shadow-lg'
                        : 'text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900'
                    ]"
                  >
                    {{ page }}
                  </button>
                </template>
                
                <!-- Ellipsis for end -->
                <span v-if="pagination.current_page < pagination.last_page - 3" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300">
                  ...
                </span>
                
                <!-- Last page -->
                <button
                  v-if="pagination.current_page < pagination.last_page - 2"
                  @click="changePage(pagination.last_page)"
                  class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 transition-all duration-200"
                >
                  {{ pagination.last_page }}
                </button>
              </div>
              
              <!-- Next Button -->
              <button
                @click="changePage(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page"
                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-r-lg hover:bg-slate-50 hover:text-slate-900 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400 transition-all duration-200"
              >
                Next
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </button>
            </nav>
          </div>
        </div>
        
        <!-- View All Products Button -->
        <div class="text-center mt-12">
          <router-link 
            to="/products" 
            class="inline-flex items-center px-8 py-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl"
          >
            <span>View All Products</span>
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="section-padding bg-gradient-to-br from-slate-50 to-blue-50">
      <div class="container-custom">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-slate-900 mb-6">Why Choose Pkmart?</h2>
          <p class="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
            We're dedicated to providing exceptional educational toys that inspire learning, 
            creativity, and development in every child.
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Educational Excellence -->
          <div class="text-center group">
            <div class="relative mb-6">
              <div class="w-16 h-16 bg-gradient-to-br from-slate-700 to-slate-900 rounded-xl flex items-center justify-center mx-auto shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
              <div class="absolute -top-1 -right-1 w-5 h-5 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
              </div>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-4 group-hover:text-slate-700 transition-colors">Educational Excellence</h3>
            <p class="text-slate-600 leading-relaxed">Carefully curated toys that promote learning, creativity, and cognitive development in children of all ages</p>
          </div>

          <!-- Safety First -->
          <div class="text-center group">
            <div class="relative mb-6">
              <div class="w-16 h-16 bg-gradient-to-br from-slate-700 to-slate-900 rounded-xl flex items-center justify-center mx-auto shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="absolute -top-1 -right-1 w-5 h-5 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
              </div>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-4 group-hover:text-slate-700 transition-colors">Safety First</h3>
            <p class="text-slate-600 leading-relaxed">All products meet the highest safety standards with non-toxic materials and child-safe certifications</p>
          </div>

          <!-- Expert Guidance -->
          <div class="text-center group">
            <div class="relative mb-6">
              <div class="w-16 h-16 bg-gradient-to-br from-slate-700 to-slate-900 rounded-xl flex items-center justify-center mx-auto shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="absolute -top-1 -right-1 w-5 h-5 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
              </div>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-4 group-hover:text-slate-700 transition-colors">Expert Guidance</h3>
            <p class="text-slate-600 leading-relaxed">Professional recommendations and age-appropriate selections to ensure optimal learning experiences</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding bg-gradient-to-br from-slate-900 to-slate-800 text-white relative overflow-hidden">
      <!-- Background decoration -->
      <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-32 h-32 bg-blue-600/20 rounded-full mix-blend-multiply filter blur-xl animate-float"></div>
        <div class="absolute bottom-10 right-10 w-40 h-40 bg-blue-500/20 rounded-full mix-blend-multiply filter blur-xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-slate-700/10 rounded-full mix-blend-multiply filter blur-2xl animate-float" style="animation-delay: 4s;"></div>
      </div>
      
      <div class="container-custom text-center relative">
        <div class="max-w-4xl mx-auto">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl mb-8 shadow-lg">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          
          <h2 class="text-5xl font-bold mb-6 text-white">Ready to Start Shopping?</h2>
          <p class="text-xl text-slate-200 mb-12 max-w-3xl mx-auto leading-relaxed">
            Join thousands of satisfied customers and discover our premium collection of 
            educational toys designed to inspire learning and creativity in every child.
          </p>
          
          <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <router-link 
              to="/register" 
              class="inline-flex items-center px-8 py-4 bg-white text-slate-900 font-semibold rounded-lg hover:bg-slate-50 transition-all duration-300 shadow-lg hover:shadow-xl"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
              </svg>
              Create Account
            </router-link>
            <router-link 
              to="/products" 
              class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-slate-900 transition-all duration-300"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
              </svg>
              Browse Products
            </router-link>
          </div>
          
          <!-- Trust indicators -->
          <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
              <div class="text-3xl font-bold text-white mb-2">10K+</div>
              <div class="text-slate-300">Happy Customers</div>
            </div>
            <div class="text-center">
              <div class="text-3xl font-bold text-white mb-2">500+</div>
              <div class="text-slate-300">Educational Toys</div>
            </div>
            <div class="text-center">
              <div class="text-3xl font-bold text-white mb-2">99%</div>
              <div class="text-slate-300">Satisfaction Rate</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Login Popup -->
    <LoginPopup
      :isOpen="showLoginPopup"
      title="Login Required"
      message="Please login to add items to your cart and continue shopping."
      @close="showLoginPopup = false"
    />
  </MainLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import MainLayout from '../components/layout/MainLayout.vue';
import LoginPopup from '../components/LoginPopup.vue';
import { useCartStore } from '../stores/cart';
import { useAuthStore } from '../stores/auth';
import api from '../services/api';


export default {
  name: 'Home',
  components: {
    MainLayout,
    LoginPopup,
  },
  setup() {
    const cartStore = useCartStore();
    const authStore = useAuthStore();
    const featuredProducts = ref([]);
    const loading = ref(true);
    const showLoginPopup = ref(false);
    const pagination = ref(null);
    const currentPage = ref(1);


    const fetchFeaturedProducts = async (page = 1) => {
      try {
        loading.value = true;
        const response = await api.get('/products/featured', {
          params: { page, per_page: 20 }
        });
        
        if (response.data.data.data) {
          // Paginated response
          featuredProducts.value = response.data.data.data;
          pagination.value = {
            current_page: response.data.data.current_page,
            last_page: response.data.data.last_page,
            per_page: response.data.data.per_page,
            total: response.data.data.total,
          };
        } else {
          // Non-paginated response (fallback)
          featuredProducts.value = response.data.data || response.data;
          pagination.value = null;
        }
      } catch (error) {
        console.error('Error fetching featured products:', error);
        if (window.$notify) {
          window.$notify.error('Error', 'Failed to load featured products. Please try again.');
        }
      } finally {
        loading.value = false;
      }
    };

    const addToCart = (product) => {
      if (!authStore.isAuthenticated) {
        showLoginPopup.value = true;
        return;
      }
      
      if (authStore.isAdmin) {
        if (window.$notify) {
          window.$notify.error('Admin Restriction', 'Admin users cannot add items to cart');
        }
        return;
      }
      
      try {
        cartStore.addToCart(product);
        if (window.$notify) {
          window.$notify.success('Added to Cart', `${product.name} has been added to your cart!`);
        }
      } catch (error) {
        if (window.$notify) {
          window.$notify.error('Error', error.message);
        }
      }
    };

    const changePage = (page) => {
      if (page >= 1 && page <= pagination.value?.last_page) {
        currentPage.value = page;
        fetchFeaturedProducts(page);
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
      fetchFeaturedProducts();
    });

    return {
      featuredProducts,
      loading,
      showLoginPopup,
      addToCart,
      pagination,
      currentPage,
      changePage,
      getVisiblePages,
      authStore,
    };
  },
};
</script>

<style scoped>
@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes fade-in {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes bounce-in {
  0% { transform: scale(0.3) rotate(-10deg); opacity: 0; }
  50% { transform: scale(1.05) rotate(5deg); }
  70% { transform: scale(0.9) rotate(-2deg); }
  100% { transform: scale(1) rotate(0deg); opacity: 1; }
}

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-fade-in {
  animation: fade-in 0.8s ease-out forwards;
}

.animate-bounce-in {
  animation: bounce-in 1s ease-out forwards;
}

.bg-grid-pattern {
  background-image: 
    linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);
  background-size: 50px 50px;
}

.bg-stars {
  background-image: 
    radial-gradient(2px 2px at 20px 30px, rgba(255,255,255,0.8), transparent),
    radial-gradient(2px 2px at 40px 70px, rgba(255,255,255,0.6), transparent),
    radial-gradient(1px 1px at 90px 40px, rgba(255,255,255,0.9), transparent),
    radial-gradient(1px 1px at 130px 80px, rgba(255,255,255,0.7), transparent),
    radial-gradient(2px 2px at 160px 30px, rgba(255,255,255,0.5), transparent);
  background-repeat: repeat;
  background-size: 200px 100px;
}

.text-shadow {
  text-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

.shadow-glow-lg {
  box-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
