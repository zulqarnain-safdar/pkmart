<template>
  <AdminLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Referral System Management</h1>
        <p class="mt-2 text-gray-600">Manage referral codes, relationships, and commission settings</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-soft p-6">
          <div class="flex items-center">
            <div class="p-3 bg-primary-100 rounded-xl">
              <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-900">{{ stats.total_referral_codes || 0 }}</h3>
              <p class="text-sm text-gray-600">Total Referral Codes</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft p-6">
          <div class="flex items-center">
            <div class="p-3 bg-success-100 rounded-xl">
              <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-900">{{ stats.active_referral_codes || 0 }}</h3>
              <p class="text-sm text-gray-600">Active Codes</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft p-6">
          <div class="flex items-center">
            <div class="p-3 bg-warning-100 rounded-xl">
              <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-900">PKR {{ (stats.total_referral_earnings || 0).toFixed(2) }}</h3>
              <p class="text-sm text-gray-600">Total Earnings</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft p-6">
          <div class="flex items-center">
            <div class="p-3 bg-danger-100 rounded-xl">
              <svg class="w-6 h-6 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-900">PKR {{ (stats.pending_referral_earnings || 0).toFixed(2) }}</h3>
              <p class="text-sm text-gray-600">Pending Earnings</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabs -->
      <div class="bg-white rounded-xl shadow-soft">
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex space-x-8 px-6">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              :class="[
                'py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                activeTab === tab.id
                  ? 'border-primary-500 text-primary-600'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
              ]"
            >
              {{ tab.name }}
            </button>
          </nav>
        </div>

        <div class="p-6">
          <!-- Referral Codes Tab -->
          <div v-if="activeTab === 'codes'" class="space-y-6">
            <div class="flex justify-between items-center">
              <h2 class="text-xl font-semibold text-gray-900">Referral Codes</h2>
              <button
                @click="processMonthlyRenewals"
                :disabled="processingRenewals"
                class="btn-primary"
              >
                <span v-if="processingRenewals">Processing...</span>
                <span v-else>Process Monthly Renewals</span>
              </button>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
              <div class="flex flex-col sm:flex-row gap-4">
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search by user name, email, or code..."
                  class="flex-1 input"
                />
                <select v-model="statusFilter" class="input">
                  <option value="">All Status</option>
                  <option value="active">Active</option>
                  <option value="expired">Expired</option>
                </select>
              </div>
            </div>

            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earnings</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(code, index) in referralCodes" :key="code?.id || index">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div>
                        <div class="text-sm font-medium text-gray-900">{{ code?.user?.name || 'Unknown User' }}</div>
                        <div class="text-sm text-gray-500">{{ code?.user?.email || 'No email' }}</div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                        {{ code?.code || 'N/A' }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span :class="[
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                        code?.is_active && (!code?.expires_at || new Date(code.expires_at) > new Date())
                          ? 'bg-success-100 text-success-800'
                          : 'bg-danger-100 text-danger-800'
                      ]">
                        {{ code?.is_active && (!code?.expires_at || new Date(code.expires_at) > new Date()) ? 'Active' : 'Expired' }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ code?.usage_count || 0 }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      PKR {{ parseFloat(code?.total_earnings || 0).toFixed(2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ code?.expires_at ? new Date(code.expires_at).toLocaleDateString() : 'Never' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <div class="flex space-x-2">
                        <button
                          v-if="code?.is_active"
                          @click="deactivateCode(code)"
                          class="text-danger-600 hover:text-danger-900"
                        >
                          Deactivate
                        </button>
                        <button
                          v-else
                          @click="reactivateCode(code)"
                          class="text-success-600 hover:text-success-900"
                        >
                          Reactivate
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Referral Relationships Tab -->
          <div v-if="activeTab === 'relationships'" class="space-y-6">
            <h2 class="text-xl font-semibold text-gray-900">Referral Relationships</h2>
            
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referrer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referred</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code Used</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(relationship, index) in referralRelationships" :key="relationship?.id || index">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div>
                        <div class="text-sm font-medium text-gray-900">{{ relationship?.referrer?.name || 'Unknown User' }}</div>
                        <div class="text-sm text-gray-500">{{ relationship?.referrer?.email || 'No email' }}</div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div>
                        <div class="text-sm font-medium text-gray-900">{{ relationship?.referred?.name || 'Unknown User' }}</div>
                        <div class="text-sm text-gray-500">{{ relationship?.referred?.email || 'No email' }}</div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                        Level {{ relationship?.level || 1 }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ relationship?.referral_code?.code || 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ relationship?.created_at ? new Date(relationship.created_at).toLocaleDateString() : 'Unknown' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span :class="[
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                        relationship?.is_active
                          ? 'bg-success-100 text-success-800'
                          : 'bg-danger-100 text-danger-800'
                      ]">
                        {{ relationship?.is_active ? 'Active' : 'Inactive' }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Referral Earnings Tab -->
          <div v-if="activeTab === 'earnings'" class="space-y-6">
            <h2 class="text-xl font-semibold text-gray-900">Referral Earnings</h2>
            
            <div class="bg-gray-50 rounded-lg p-4">
              <div class="flex flex-col sm:flex-row gap-4">
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search by user name or email..."
                  class="flex-1 input"
                />
                <select v-model="statusFilter" class="input">
                  <option value="">All Status</option>
                  <option value="pending">Pending</option>
                  <option value="paid">Paid</option>
                  <option value="cancelled">Cancelled</option>
                </select>
                <select v-model="typeFilter" class="input">
                  <option value="">All Types</option>
                  <option value="referral">Referral</option>
                  <option value="buyer">Buyer</option>
                </select>
              </div>
            </div>

            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(earning, index) in referralEarnings" :key="earning?.id || index">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div>
                        <div class="text-sm font-medium text-gray-900">{{ earning?.user?.name || 'Unknown User' }}</div>
                        <div class="text-sm text-gray-500">{{ earning?.user?.email || 'No email' }}</div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ earning?.order?.order_number || 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ earning?.product?.name || 'Unknown Product' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span :class="[
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                        earning?.type === 'referral' ? 'bg-primary-100 text-primary-800' : 'bg-success-100 text-success-800'
                      ]">
                        {{ earning?.type || 'Unknown' }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ earning?.level || '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      PKR {{ parseFloat(earning?.amount || 0).toFixed(2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span :class="[
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                        earning?.status === 'paid' ? 'bg-success-100 text-success-800' :
                        earning?.status === 'pending' ? 'bg-warning-100 text-warning-800' :
                        'bg-danger-100 text-danger-800'
                      ]">
                        {{ earning?.status || 'Unknown' }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <div class="flex space-x-2">
                        <button
                          v-if="earning?.status === 'pending'"
                          @click="markAsPaid(earning)"
                          class="text-success-600 hover:text-success-900"
                        >
                          Mark Paid
                        </button>
                        <button
                          v-if="earning?.status === 'pending'"
                          @click="markAsCancelled(earning)"
                          class="text-danger-600 hover:text-danger-900"
                        >
                          Cancel
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import AdminLayout from '../../components/layout/AdminLayout.vue';
import api from '../../services/api';

export default {
  name: 'AdminReferrals',
  components: {
    AdminLayout,
  },
  setup() {
    const activeTab = ref('codes');
    const stats = ref({});
    const referralCodes = ref([]);
    const referralRelationships = ref([]);
    const referralEarnings = ref([]);
    const searchQuery = ref('');
    const statusFilter = ref('');
    const typeFilter = ref('');
    const processingRenewals = ref(false);

    const tabs = [
      { id: 'codes', name: 'Referral Codes' },
      { id: 'relationships', name: 'Relationships' },
      { id: 'earnings', name: 'Earnings' },
    ];

    const fetchStats = async () => {
      try {
        const response = await api.get('/admin/referrals/stats');
        stats.value = response.data?.data || {};
      } catch (error) {
        console.error('Error fetching stats:', error);
      }
    };

    const fetchReferralCodes = async () => {
      try {
        const params = {
          search: searchQuery.value,
          status: statusFilter.value,
        };
        const response = await api.get('/admin/referrals/codes', { params });
        referralCodes.value = response.data?.data?.data || response.data?.data || [];
      } catch (error) {
        console.error('Error fetching referral codes:', error);
      }
    };

    const fetchReferralRelationships = async () => {
      try {
        const response = await api.get('/admin/referrals/relationships');
        referralRelationships.value = response.data?.data?.data || response.data?.data || [];
      } catch (error) {
        console.error('Error fetching referral relationships:', error);
      }
    };

    const fetchReferralEarnings = async () => {
      try {
        const params = {
          search: searchQuery.value,
          status: statusFilter.value,
          type: typeFilter.value,
        };
        const response = await api.get('/admin/referrals/earnings', { params });
        referralEarnings.value = response.data?.data?.data || response.data?.data || [];
      } catch (error) {
        console.error('Error fetching referral earnings:', error);
      }
    };

    const processMonthlyRenewals = async () => {
      processingRenewals.value = true;
      try {
        const response = await api.post('/admin/referrals/process-renewals');
        if (response.data.success) {
          if (window.$notify) {
            window.$notify.success('Success', response.data.message);
          }
          fetchStats();
          fetchReferralCodes();
        }
      } catch (error) {
        console.error('Error processing renewals:', error);
        if (window.$notify) {
          window.$notify.error('Error', 'Failed to process renewals');
        }
      } finally {
        processingRenewals.value = false;
      }
    };

    const deactivateCode = async (code) => {
      try {
        await api.post(`/admin/referrals/codes/${code?.id}/deactivate`);
        if (window.$notify) {
          window.$notify.success('Success', 'Referral code deactivated');
        }
        fetchReferralCodes();
        fetchStats();
      } catch (error) {
        console.error('Error deactivating code:', error);
        if (window.$notify) {
          window.$notify.error('Error', 'Failed to deactivate code');
        }
      }
    };

    const reactivateCode = async (code) => {
      try {
        await api.post(`/admin/referrals/codes/${code?.id}/reactivate`);
        if (window.$notify) {
          window.$notify.success('Success', 'Referral code reactivated');
        }
        fetchReferralCodes();
        fetchStats();
      } catch (error) {
        console.error('Error reactivating code:', error);
        if (window.$notify) {
          window.$notify.error('Error', 'Failed to reactivate code');
        }
      }
    };

    const markAsPaid = async (earning) => {
      try {
        await api.post(`/admin/referrals/earnings/${earning?.id}/mark-paid`);
        if (window.$notify) {
          window.$notify.success('Success', 'Earning marked as paid');
        }
        fetchReferralEarnings();
        fetchStats();
      } catch (error) {
        console.error('Error marking as paid:', error);
        if (window.$notify) {
          window.$notify.error('Error', 'Failed to mark as paid');
        }
      }
    };

    const markAsCancelled = async (earning) => {
      try {
        await api.post(`/admin/referrals/earnings/${earning?.id}/mark-cancelled`);
        if (window.$notify) {
          window.$notify.success('Success', 'Earning marked as cancelled');
        }
        fetchReferralEarnings();
        fetchStats();
      } catch (error) {
        console.error('Error marking as cancelled:', error);
        if (window.$notify) {
          window.$notify.error('Error', 'Failed to mark as cancelled');
        }
      }
    };

    onMounted(() => {
      fetchStats();
      fetchReferralCodes();
    });

    return {
      activeTab,
      tabs,
      stats,
      referralCodes,
      referralRelationships,
      referralEarnings,
      searchQuery,
      statusFilter,
      typeFilter,
      processingRenewals,
      fetchReferralCodes,
      fetchReferralRelationships,
      fetchReferralEarnings,
      processMonthlyRenewals,
      deactivateCode,
      reactivateCode,
      markAsPaid,
      markAsCancelled,
    };
  },
};
</script>
