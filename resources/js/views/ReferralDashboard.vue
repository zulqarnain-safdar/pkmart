<template>
  <MainLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Referral Dashboard</h1>
        <p class="mt-2 text-gray-600">Manage your referral code and track your earnings</p>
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
              <h3 class="text-lg font-semibold text-gray-900">{{ stats.total_referrals || 0 }}</h3>
              <p class="text-sm text-gray-600">Total Referrals</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft p-6">
          <div class="flex items-center">
            <div class="p-3 bg-success-100 rounded-xl">
              <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-900">PKR {{ parseFloat(stats?.total_earnings || 0).toFixed(2) }}</h3>
              <p class="text-sm text-gray-600">Total Earnings</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft p-6">
          <div class="flex items-center">
            <div class="p-3 bg-warning-100 rounded-xl">
              <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-900">PKR {{ parseFloat(stats?.pending_earnings || 0).toFixed(2) }}</h3>
              <p class="text-sm text-gray-600">Pending Earnings</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft p-6">
          <div class="flex items-center">
            <div class="p-3 bg-info-100 rounded-xl">
              <svg class="w-6 h-6 text-info-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-gray-900">{{ referralCode?.usage_count || 0 }}</h3>
              <p class="text-sm text-gray-600">Code Usage</p>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Referral Code Section -->
        <div class="bg-white rounded-xl shadow-soft p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">My Referral Code</h2>
            <button
              @click="renewReferralCode"
              :disabled="renewing"
              class="btn-secondary"
            >
              <span v-if="renewing">Renewing...</span>
              <span v-else>Renew Code</span>
            </button>
          </div>

          <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg p-6 text-white">
            <div class="text-center">
              <p class="text-sm opacity-90 mb-2">Your Referral Code</p>
              <div class="bg-white bg-opacity-20 rounded-lg p-4 mb-4">
                <p class="text-3xl font-bold tracking-wider">{{ referralCode?.code || 'Loading...' }}</p>
              </div>
              <button
                @click="copyReferralCode"
                class="bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
              >
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                Copy Code
              </button>
            </div>
          </div>

          <div class="mt-6 space-y-4">
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Status</span>
              <span :class="[
                'px-2 py-1 rounded-full text-xs font-medium',
                isCodeActive ? 'bg-success-100 text-success-800' : 'bg-danger-100 text-danger-800'
              ]">
                {{ isCodeActive ? 'Active' : 'Expired' }}
              </span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Expires</span>
              <span class="text-sm font-medium text-gray-900">
                {{ referralCode?.expires_at ? new Date(referralCode.expires_at).toLocaleDateString() : 'Never' }}
              </span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-600">Total Earnings</span>
              <span class="text-sm font-medium text-gray-900">
                PKR {{ parseFloat(referralCode?.total_earnings || 0).toFixed(2) }}
              </span>
            </div>
          </div>
        </div>

        <!-- Referral Link Section -->
        <div class="bg-white rounded-xl shadow-soft p-6">
          <h2 class="text-xl font-semibold text-gray-900 mb-6">Share Your Referral Link</h2>
          
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Your Referral Link</label>
              <div class="flex">
                <input
                  :value="referralLink"
                  readonly
                  class="flex-1 input rounded-r-none"
                />
                <button
                  @click="copyReferralLink"
                  class="px-4 py-2 bg-primary-600 text-white rounded-r-lg hover:bg-primary-700 transition-colors duration-200"
                >
                  Copy
                </button>
              </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
              <h3 class="text-sm font-medium text-blue-800 mb-2">How it works:</h3>
              <ul class="text-sm text-blue-700 space-y-1">
                <li>• Share your referral code with friends and family</li>
                <li>• When they register using your code, you become their referrer</li>
                <li>• Earn commissions when they make purchases</li>
                <li>• Your code expires monthly and needs renewal</li>
              </ul>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
              <h3 class="text-sm font-medium text-green-800 mb-2">Commission Structure:</h3>
              <ul class="text-sm text-green-700 space-y-1">
                <li>• <strong>1st Level:</strong> Earn when your direct referrals purchase</li>
                <li>• <strong>2nd Level:</strong> Earn when your referrals' referrals purchase</li>
                <li>• <strong>Buyer Bonus:</strong> Earn when you make purchases yourself</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Referral Tree -->
      <div class="mt-8 bg-white rounded-xl shadow-soft p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">My Referral Network</h2>
        
        <div v-if="referralTree.length > 0" class="space-y-4">
          <div v-for="(referral, index) in referralTree" :key="referral?.user?.id || index" class="border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mr-4">
                  <span class="text-primary-600 font-semibold">{{ referral?.user?.name?.charAt(0) || '?' }}</span>
                </div>
                <div>
                  <h3 class="font-medium text-gray-900">{{ referral?.user?.name || 'Unknown User' }}</h3>
                  <p class="text-sm text-gray-500">{{ referral?.user?.email || 'No email' }}</p>
                  <p class="text-xs text-gray-400">Joined: {{ referral?.user?.joined_at ? new Date(referral.user.joined_at).toLocaleDateString() : 'Unknown' }}</p>
                </div>
              </div>
              <div class="text-right">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                  Level {{ referral?.level || 1 }}
                </span>
              </div>
            </div>
            
            <!-- Second Level Referrals -->
            <div v-if="referral?.second_level_referrals?.length > 0" class="mt-4 ml-6 space-y-2">
              <h4 class="text-sm font-medium text-gray-700">Their Referrals:</h4>
              <div v-for="(secondLevel, secondIndex) in referral.second_level_referrals" :key="secondLevel?.user?.id || secondIndex" class="flex items-center">
                <div class="w-6 h-6 bg-success-100 rounded-full flex items-center justify-center mr-3">
                  <span class="text-success-600 font-semibold text-xs">{{ secondLevel?.user?.name?.charAt(0) || '?' }}</span>
                </div>
                <div class="flex-1">
                  <span class="text-sm font-medium text-gray-900">{{ secondLevel?.user?.name || 'Unknown User' }}</span>
                  <span class="text-xs text-gray-500 ml-2">({{ secondLevel?.user?.email || 'No email' }})</span>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                  Level {{ secondLevel?.level || 2 }}
                </span>
              </div>
            </div>
          </div>
        </div>
        
        <div v-else class="text-center py-8">
          <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No referrals yet</h3>
          <p class="text-gray-500">Share your referral code to start building your network!</p>
        </div>
      </div>

      <!-- Earnings History -->
      <div class="mt-8 bg-white rounded-xl shadow-soft p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Earnings History</h2>
        
        <div v-if="earnings.history && earnings.history.length > 0" class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(earning, index) in earnings.history" :key="earning?.id || index">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ earning?.created_at ? new Date(earning.created_at).toLocaleDateString() : 'Unknown' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                    earning.type === 'referral' ? 'bg-primary-100 text-primary-800' : 'bg-success-100 text-success-800'
                  ]">
                    {{ earning?.type || 'Unknown' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ earning?.product?.name || 'Unknown Product' }}
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
              </tr>
            </tbody>
          </table>
        </div>
        
        <div v-else class="text-center py-8">
          <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No earnings yet</h3>
          <p class="text-gray-500">Start referring friends to earn commissions!</p>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import MainLayout from '../components/layout/MainLayout.vue';
import api from '../services/api';

export default {
  name: 'ReferralDashboard',
  components: {
    MainLayout,
  },
  setup() {
    const stats = ref({});
    const referralCode = ref(null);
    const referralTree = ref([]);
    const earnings = ref({});
    const renewing = ref(false);

    const isCodeActive = computed(() => {
      if (!referralCode.value) return false;
      return referralCode.value.is_active && 
             (!referralCode.value.expires_at || new Date(referralCode.value.expires_at) > new Date());
    });

    const referralLink = computed(() => {
      if (!referralCode.value) return '';
      return `${window.location.origin}/register?ref=${referralCode.value.code}`;
    });

    const fetchReferralData = async () => {
      try {
        const [statsResponse, treeResponse, earningsResponse] = await Promise.all([
          api.get('/referrals/stats'),
          api.get('/referrals/tree'),
          api.get('/referrals/earnings')
        ]);

        stats.value = statsResponse.data?.data || {};
        referralCode.value = stats.value?.active_referral_code || null;
        referralTree.value = treeResponse.data?.data || [];
        earnings.value = earningsResponse.data?.data || { history: [] };
      } catch (error) {
        console.error('Error fetching referral data:', error);
      }
    };

    const copyReferralCode = async () => {
      try {
        await navigator.clipboard.writeText(referralCode.value.code);
        if (window.$notify) {
          window.$notify.success('Success', 'Referral code copied to clipboard!');
        }
      } catch (error) {
        console.error('Error copying referral code:', error);
      }
    };

    const copyReferralLink = async () => {
      try {
        await navigator.clipboard.writeText(referralLink.value);
        if (window.$notify) {
          window.$notify.success('Success', 'Referral link copied to clipboard!');
        }
      } catch (error) {
        console.error('Error copying referral link:', error);
      }
    };

    const renewReferralCode = async () => {
      renewing.value = true;
      try {
        const response = await api.post('/referrals/renew');
        if (response.data.success) {
          if (window.$notify) {
            window.$notify.success('Success', 'Referral code renewed successfully!');
          }
          fetchReferralData();
        }
      } catch (error) {
        console.error('Error renewing referral code:', error);
        if (window.$notify) {
          window.$notify.error('Error', 'Failed to renew referral code');
        }
      } finally {
        renewing.value = false;
      }
    };

    onMounted(() => {
      fetchReferralData();
    });

    return {
      stats,
      referralCode,
      referralTree,
      earnings,
      renewing,
      isCodeActive,
      referralLink,
      copyReferralCode,
      copyReferralLink,
      renewReferralCode,
    };
  },
};
</script>
