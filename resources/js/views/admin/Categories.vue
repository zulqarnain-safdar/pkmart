<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
        <button
          @click="showCategoryModal = true"
          class="btn-primary"
        >
          Add Category
        </button>
      </div>

      <!-- Categories Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="(category, index) in categories"
          :key="category?.id || index"
          class="bg-white rounded-lg shadow overflow-hidden"
        >
          <div class="aspect-w-16 aspect-h-9">
            <img
              :src="category?.image || '/images/placeholder.jpg'"
              :alt="category?.name || 'Category'"
              class="w-full h-48 object-cover"
            />
          </div>
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ category?.name || 'Unnamed Category' }}</h3>
            <p class="text-gray-600 text-sm mb-4">{{ category?.description || 'No description available' }}</p>
            <div class="flex items-center justify-between">
              <span class="text-sm text-gray-500">{{ category?.products_count || 0 }} products</span>
              <div class="flex space-x-2">
                <button
                  @click="editCategory(category)"
                  class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                >
                  Edit
                </button>
                <button
                  @click="category?.id && deleteCategory(category.id)"
                  class="text-red-600 hover:text-red-900 text-sm font-medium"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Category Modal -->
      <div v-if="showCategoryModal" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>

          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form @submit.prevent="saveCategory">
              <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                  {{ editingCategory ? 'Edit Category' : 'Add New Category' }}
                </h3>
                
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input
                      v-model="categoryForm.name"
                      type="text"
                      required
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                    />
                  </div>
                  
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                      v-model="categoryForm.description"
                      rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                    ></textarea>
                  </div>
                  
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Image URL</label>
                    <input
                      v-model="categoryForm.image"
                      type="url"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                    />
                  </div>
                  
                  <div class="flex items-center">
                    <input
                      v-model="categoryForm.is_active"
                      type="checkbox"
                      class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                    />
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                  </div>
                </div>
              </div>
              
              <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button
                  type="submit"
                  class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm"
                >
                  {{ editingCategory ? 'Update' : 'Create' }}
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
  name: 'AdminCategories',
  components: {
    AdminLayout,
  },
  setup() {
    const categories = ref([]);
    const showCategoryModal = ref(false);
    const editingCategory = ref(null);
    
    const categoryForm = reactive({
      name: '',
      description: '',
      image: '',
      is_active: true,
    });

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

    const editCategory = (category) => {
      editingCategory.value = category;
      Object.assign(categoryForm, category);
      showCategoryModal.value = true;
    };

    const closeModal = () => {
      showCategoryModal.value = false;
      editingCategory.value = null;
      Object.assign(categoryForm, {
        name: '',
        description: '',
        image: '',
        is_active: true,
      });
    };

    const saveCategory = async () => {
      try {
        if (editingCategory.value) {
          await api.put(`/categories/${editingCategory.value.id}`, categoryForm);
          if (window.$notify) {
            window.$notify.success('Category Updated', 'Category has been updated successfully!');
          }
        } else {
          await api.post('/categories', categoryForm);
          if (window.$notify) {
            window.$notify.success('Category Created', 'Category has been created successfully!');
          }
        }
        
        await fetchCategories();
        closeModal();
      } catch (error) {
        console.error('Error saving category:', error);
        if (window.$notify) {
          window.$notify.error('Error', 'Failed to save category.');
        }
      }
    };

    const deleteCategory = async (categoryId) => {
      if (confirm('Are you sure you want to delete this category?')) {
        try {
          await api.delete(`/categories/${categoryId}`);
          if (window.$notify) {
            window.$notify.success('Category Deleted', 'Category has been deleted successfully!');
          }
          await fetchCategories();
        } catch (error) {
          console.error('Error deleting category:', error);
          if (window.$notify) {
            window.$notify.error('Error', 'Failed to delete category.');
          }
        }
      }
    };

    onMounted(() => {
      fetchCategories();
    });

    return {
      categories,
      showCategoryModal,
      editingCategory,
      categoryForm,
      editCategory,
      closeModal,
      saveCategory,
      deleteCategory,
    };
  },
};
</script>
