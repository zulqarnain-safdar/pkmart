<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Products</h1>
        <button
          @click="showProductModal = true"
          class="btn-primary"
        >
          Add Product
        </button>
      </div>

      <!-- Products Table -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="product in products" :key="product.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <img class="h-12 w-12 rounded-lg object-cover" :src="product.image" :alt="product.name" />
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                      <div class="text-sm text-gray-500">{{ product.sku }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ product.category?.name || 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  <div>
                    <span class="font-medium">PKR {{ product.sale_price || product.price }}</span>
                    <span v-if="product.sale_price" class="ml-2 text-sm text-gray-500 line-through">
                      PKR {{ product.price }}
                    </span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ product.stock_quantity }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full" :class="product.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                    {{ product.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                  <button
                    @click="editProduct(product)"
                    class="text-indigo-600 hover:text-indigo-900"
                  >
                    Edit
                  </button>
                  <button
                    @click="deleteProduct(product.id)"
                    class="text-red-600 hover:text-red-900"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Product Modal -->
      <div v-if="showProductModal" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>

          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form @submit.prevent="saveProduct">
              <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                  {{ editingProduct ? 'Edit Product' : 'Add New Product' }}
                </h3>
                
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input
                      v-model="productForm.name"
                      type="text"
                      required
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                  
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                      v-model="productForm.description"
                      rows="3"
                      required
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    ></textarea>
                  </div>
                  
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label class="block text-sm font-medium text-gray-700">Price</label>
                      <input
                        v-model.number="productForm.price"
                        type="number"
                        step="0.01"
                        required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                      />
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700">Sale Price</label>
                      <input
                        v-model.number="productForm.sale_price"
                        type="number"
                        step="0.01"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                      />
                    </div>
                  </div>
                  
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label class="block text-sm font-medium text-gray-700">SKU</label>
                      <input
                        v-model="productForm.sku"
                        type="text"
                        required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                      />
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                      <input
                        v-model.number="productForm.stock_quantity"
                        type="number"
                        required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                      />
                    </div>
                  </div>
                  
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select
                      v-model="productForm.category_id"
                      required
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                      <option value="">Select Category</option>
                      <option v-for="(category, index) in categories" :key="category?.id || index" :value="category?.id || ''">
                        {{ category?.name || 'Unnamed Category' }}
                      </option>
                    </select>
                  </div>
                  
                  <div>
                    <label class="block text-sm font-medium text-gray-700">
                      Product Image
                      <span v-if="!editingProduct" class="text-red-500">*</span>
                    </label>
                    <div v-if="imagePreview" class="mt-2 mb-4">
                      <img :src="imagePreview" alt="Preview" class="h-32 w-32 object-cover rounded-lg border border-gray-300" />
                    </div>
                    <input
                      @change="handleImageChange"
                      type="file"
                      accept="image/*"
                      :required="!editingProduct"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    <p class="mt-1 text-xs text-gray-500">Upload a product image (JPG, PNG, etc.)</p>
                  </div>
                  
                  <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                      <input
                        v-model="productForm.is_featured"
                        type="checkbox"
                        class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                      />
                      <span class="ml-2 text-sm text-gray-700">Featured Product</span>
                    </label>
                    
                    <label class="flex items-center">
                      <input
                        v-model="productForm.is_active"
                        type="checkbox"
                        class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                      />
                      <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                  </div>
                </div>
              </div>
              
              <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button
                  type="submit"
                  class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm"
                >
                  {{ editingProduct ? 'Update' : 'Create' }}
                </button>
                <button
                  type="button"
                  @click="closeModal"
                  class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                >
                  Cancel
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import { ref, onMounted, reactive } from 'vue';
import AdminLayout from '../../components/layout/AdminLayout.vue';
import api from '../../services/api';

export default {
  name: 'AdminProducts',
  components: {
    AdminLayout,
  },
  setup() {
    const products = ref([]);
    const categories = ref([]);
    const showProductModal = ref(false);
    const editingProduct = ref(null);
    const selectedImageFile = ref(null);
    const imagePreview = ref(null);
    
    const productForm = reactive({
      name: '',
      description: '',
      price: 0,
      sale_price: null,
      sku: '',
      stock_quantity: 0,
      category_id: '',
      image: '',
      is_featured: false,
      is_active: true,
    });

    const fetchProducts = async () => {
      try {
        const response = await api.get('/admin/products');
        products.value = response.data.data.data || response.data.data;
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    };

    const fetchCategories = async () => {
      try {
        const response = await api.get('/categories');
        // Handle paginated response - categories are in data.data.data
        categories.value = response.data?.data?.data || response.data?.data || [];
      } catch (error) {
        console.error('Error fetching categories:', error);
        categories.value = [];
      }
    };

    const handleImageChange = (event) => {
      const file = event.target.files[0];
      if (file) {
        selectedImageFile.value = file;
        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
          imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    };

    const editProduct = (product) => {
      editingProduct.value = product;
      Object.assign(productForm, product);
      // Set preview for existing image
      imagePreview.value = product.image;
      selectedImageFile.value = null;
      showProductModal.value = true;
    };

    const closeModal = () => {
      showProductModal.value = false;
      editingProduct.value = null;
      selectedImageFile.value = null;
      imagePreview.value = null;
      Object.assign(productForm, {
        name: '',
        description: '',
        price: 0,
        sale_price: null,
        sku: '',
        stock_quantity: 0,
        category_id: '',
        image: '',
        is_featured: false,
        is_active: true,
      });
    };

    const saveProduct = async () => {
      try {
        const formData = new FormData();
        
        // Add all form fields
        formData.append('name', productForm.name);
        formData.append('description', productForm.description);
        formData.append('price', productForm.price);
        if (productForm.sale_price) {
          formData.append('sale_price', productForm.sale_price);
        }
        formData.append('sku', productForm.sku);
        formData.append('stock_quantity', productForm.stock_quantity);
        formData.append('category_id', productForm.category_id);
        formData.append('is_featured', productForm.is_featured ? '1' : '0');
        formData.append('is_active', productForm.is_active ? '1' : '0');
        
        // Add image if a new file is selected, otherwise send existing image path when editing
        if (selectedImageFile.value) {
          formData.append('image', selectedImageFile.value);
        } else if (editingProduct.value && productForm.image) {
          // When editing without selecting new image, we need to send the existing path
          // to keep the current image. Laravel will handle updating without changing the image.
          formData.append('current_image', productForm.image);
        }
        
        if (editingProduct.value) {
          // Use POST with _method override to handle FormData properly
          formData.append('_method', 'PUT');
          await api.post(`/products/${editingProduct.value.id}`, formData);
          if (window.$notify) {
            window.$notify.success('Product Updated', 'Product has been updated successfully!');
          }
        } else {
          await api.post('/products', formData);
          if (window.$notify) {
            window.$notify.success('Product Created', 'Product has been created successfully!');
          }
        }
        
        await fetchProducts();
        closeModal();
      } catch (error) {
        console.error('Error saving product:', error);
        console.error('Error response:', error.response);
        alert('Error saving product: ' + (error.response?.data?.message || error.message));
      }
    };

    const deleteProduct = async (productId) => {
      if (confirm('Are you sure you want to delete this product?')) {
        try {
          await api.delete(`/products/${productId}`);
          if (window.$notify) {
            window.$notify.success('Product Deleted', 'Product has been deleted successfully!');
          }
          await fetchProducts();
        } catch (error) {
          console.error('Error deleting product:', error);
          if (window.$notify) {
            window.$notify.error('Error', 'Failed to delete product.');
          }
        }
      }
    };

    onMounted(() => {
      fetchProducts();
      fetchCategories();
    });

    return {
      products,
      categories,
      showProductModal,
      editingProduct,
      productForm,
      imagePreview,
      handleImageChange,
      editProduct,
      closeModal,
      saveProduct,
      deleteProduct,
    };
  },
};
</script>
