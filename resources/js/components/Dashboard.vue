<template>
  <div class="dashboard-page min-h-screen transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <!-- Hero Header -->
      <div class="text-center mb-16">
        <div class="relative inline-flex items-center justify-center w-20 h-20 mb-8">
          <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500 rounded-3xl transform rotate-3 opacity-20"></div>
          <div class="relative w-16 h-16 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500 rounded-2xl flex items-center justify-center shadow-xl">
            <ShieldCheckIcon class="w-8 h-8 text-white" />
          </div>
        </div>
        <h1 class="text-5xl font-bold bg-gradient-to-r from-slate-900 via-indigo-800 to-purple-800 dark:from-white dark:via-indigo-200 dark:to-purple-200 bg-clip-text text-transparent mb-6">
          Welcome back, {{ stats.user?.name || 'Role Manager' }}!
        </h1>
        <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
          Ready to manage your roles and permissions today? Here's your system overview.
        </p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
      </div>

      <!-- Stats Grid -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <!-- Total Roles Card -->
        <router-link
          :to="{ name: 'roles.index' }"
          class="group block"
        >
          <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-2xl transform rotate-1 opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
            <div class="relative bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
              <div class="flex items-center justify-between mb-6">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                  <UsersIcon class="w-8 h-8 text-white" />
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  <ArrowTopRightOnSquareIcon class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                </div>
              </div>
              <div>
                <div class="text-4xl font-bold text-slate-900 dark:text-white mb-2">
                  {{ stats.roles_count }}
                </div>
                <div class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 mb-1">
                  Total Roles
                </div>
                <div class="text-sm text-slate-500 dark:text-slate-400">
                  Click to manage roles
                </div>
              </div>
            </div>
          </div>
        </router-link>

        <!-- Permissions Card -->
        <router-link
          :to="{ name: 'permissions.index' }"
          class="group block"
        >
          <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-emerald-400 rounded-2xl transform rotate-1 opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
            <div class="relative bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
              <div class="flex items-center justify-between mb-6">
                <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                  <CheckCircleIcon class="w-8 h-8 text-white" />
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  <ArrowTopRightOnSquareIcon class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
              </div>
              <div>
                <div class="text-4xl font-bold text-slate-900 dark:text-white mb-2">
                  {{ stats.permissions_count }}
                </div>
                <div class="text-lg font-semibold text-green-600 dark:text-green-400 mb-1">
                  Permissions
                </div>
                <div class="text-sm text-slate-500 dark:text-slate-400">
                  Click to manage permissions
                </div>
              </div>
            </div>
          </div>
        </router-link>

        <!-- Total Users Card -->
        <router-link
          :to="{ name: 'users.index' }"
          class="group block"
        >
          <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-cyan-400 rounded-2xl transform rotate-1 opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
            <div class="relative bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
              <div class="flex items-center justify-between mb-6">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                  <UserIcon class="w-8 h-8 text-white" />
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  <ArrowTopRightOnSquareIcon class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
              </div>
              <div>
                <div class="text-4xl font-bold text-slate-900 dark:text-white mb-2">
                  {{ stats.users_count }}
                </div>
                <div class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-1">
                  Total Users
                </div>
                <div class="text-sm text-slate-500 dark:text-slate-400">
                  Click to manage users
                </div>
              </div>
            </div>
          </div>
        </router-link>
      </div>

      <!-- Quick Actions Section -->
      <div class="mb-12">
        <div class="relative">
          <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl transform -rotate-1"></div>
          <div class="relative bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-8 shadow-xl">
            <div class="mb-8">
              <h3 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                  <BoltIcon class="w-6 h-6 text-white" />
                </div>
                Quick Actions
              </h3>
              <p class="text-slate-600 dark:text-slate-300 mt-2 ml-14">
                Jump to the most common tasks and get things done quickly
              </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
              <router-link
                :to="{ name: 'roles.create' }"
                class="group block"
              >
                <div class="relative overflow-hidden bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-2xl p-6 border border-indigo-200 dark:border-indigo-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                  <div class="absolute inset-0 bg-gradient-to-br from-indigo-400/10 to-purple-400/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                  <div class="relative">
                    <div class="flex items-center mb-4">
                      <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <PlusIcon class="w-6 h-6 text-white" />
                      </div>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Create Role</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">Add a new role to the system with custom permissions</p>
                  </div>
                </div>
              </router-link>

              <router-link
                :to="{ name: 'permissions.create' }"
                class="group block"
              >
                <div class="relative overflow-hidden bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-2xl p-6 border border-green-200 dark:border-green-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                  <div class="absolute inset-0 bg-gradient-to-br from-green-400/10 to-emerald-400/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                  <div class="relative">
                    <div class="flex items-center mb-4">
                      <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <PlusIcon class="w-6 h-6 text-white" />
                      </div>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Add Permission</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">Create a new permission for granular access control</p>
                  </div>
                </div>
              </router-link>

              <router-link
                :to="{ name: 'roles.index' }"
                class="group block"
              >
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-2xl p-6 border border-blue-200 dark:border-blue-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                  <div class="absolute inset-0 bg-gradient-to-br from-blue-400/10 to-cyan-400/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                  <div class="relative">
                    <div class="flex items-center mb-4">
                      <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <ClipboardDocumentListIcon class="w-6 h-6 text-white" />
                      </div>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Manage Roles</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">View, edit, and organize all existing roles</p>
                  </div>
                </div>
              </router-link>

              <router-link
                :to="{ name: 'users.index' }"
                class="group block"
              >
                <div class="relative overflow-hidden bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 rounded-2xl p-6 border border-purple-200 dark:border-purple-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                  <div class="absolute inset-0 bg-gradient-to-br from-purple-400/10 to-pink-400/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                  <div class="relative">
                    <div class="flex items-center mb-4">
                      <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <UserGroupIcon class="w-6 h-6 text-white" />
                      </div>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">User Roles</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">Assign and manage user role assignments</p>
                  </div>
                </div>
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Activity Section -->
      <div v-if="false" class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Recent Roles -->
        <div class="lg:col-span-2">
          <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl transform -rotate-1"></div>
            <div class="relative bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-8 shadow-xl">
              <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                  <ClipboardDocumentListIcon class="w-5 h-5 text-white" />
                </div>
                Recent Activity
              </h3>
              
              <div class="space-y-4">
                <div v-if="stats.recent_roles && stats.recent_roles.length > 0">
                  <div v-for="role in stats.recent_roles.slice(0, 5)" :key="role.id" class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center space-x-3">
                      <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                        <UsersIcon class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                      </div>
                      <div>
                        <div class="font-semibold text-slate-900 dark:text-white">{{ role.name }}</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">{{ role.permissions_count || 0 }} permissions</div>
                      </div>
                    </div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                      {{ formatDate(role.created_at) }}
                    </div>
                  </div>
                </div>
                <div v-else class="text-center py-8">
                  <ClipboardDocumentListIcon class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500 mb-4" />
                  <h4 class="text-lg font-medium text-slate-900 dark:text-white mb-2">No recent activity</h4>
                  <p class="text-slate-500 dark:text-slate-400 mb-4">Start by creating your first role or permission.</p>
                  <router-link :to="{ name: 'roles.create' }" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    <PlusIcon class="w-4 h-4 mr-2" />
                    Create First Role
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- System Health -->
        <div>
          <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl transform rotate-1"></div>
            <div class="relative bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-8 shadow-xl">
              <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                  <CheckCircleIcon class="w-5 h-5 text-white" />
                </div>
                System Health
              </h3>
              
              <div class="space-y-4">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Database</span>
                  </div>
                  <span class="text-xs text-green-600 dark:text-green-400 font-medium">Operational</span>
                </div>
                
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Authentication</span>
                  </div>
                  <span class="text-xs text-green-600 dark:text-green-400 font-medium">Active</span>
                </div>
                
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Permissions Engine</span>
                  </div>
                  <span class="text-xs text-green-600 dark:text-green-400 font-medium">Running</span>
                </div>
                
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Cache</span>
                  </div>
                  <span class="text-xs text-green-600 dark:text-green-400 font-medium">Optimized</span>
                </div>

                <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                  <div class="text-xs text-slate-500 dark:text-slate-400 mb-2">Overall System Health</div>
                  <div class="flex items-center space-x-2">
                    <div class="flex-1 bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                      <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full w-[98%]"></div>
                    </div>
                    <span class="text-sm font-medium text-green-600 dark:text-green-400">98%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Tips & Getting Started -->
      <div v-if="config?.showDocs" class="relative">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl transform rotate-1"></div>
        <div class="relative bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-8 shadow-xl">
          <div class="flex items-start space-x-6">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <LightBulbIcon class="w-6 h-6 text-white" />
              </div>
            </div>
            <div class="flex-1">
              <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">
                💡 Getting Started Tips
              </h3>
              <p class="text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                New to Role Manager? Here are some helpful tips to get you started with managing roles and permissions effectively.
              </p>
              <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                  <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                      <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">1</span>
                    </div>
                    <div>
                      <h4 class="font-semibold text-slate-900 dark:text-white">Create Basic Permissions</h4>
                      <p class="text-sm text-slate-600 dark:text-slate-300">Start by defining granular permissions like 'view users', 'edit posts', etc.</p>
                    </div>
                  </div>
                  <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                      <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">2</span>
                    </div>
                    <div>
                      <h4 class="font-semibold text-slate-900 dark:text-white">Group into Roles</h4>
                      <p class="text-sm text-slate-600 dark:text-slate-300">Create roles like 'Admin', 'Editor', 'Viewer' and assign relevant permissions.</p>
                    </div>
                  </div>
                </div>
                <div class="space-y-4">
                  <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                      <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">3</span>
                    </div>
                    <div>
                      <h4 class="font-semibold text-slate-900 dark:text-white">Assign to Users</h4>
                      <p class="text-sm text-slate-600 dark:text-slate-300">Use the Users section to assign roles or direct permissions to team members.</p>
                    </div>
                  </div>
                  <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                      <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">4</span>
                    </div>
                    <div>
                      <h4 class="font-semibold text-slate-900 dark:text-white">Test & Validate</h4>
                      <p class="text-sm text-slate-600 dark:text-slate-300">Always test permission changes to ensure they work as expected in your app.</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                <router-link 
                  :to="{ name: 'documentation' }" 
                  class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg"
                >
                  <BookOpenIcon class="w-4 h-4 mr-2" />
                  View Full Documentation
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { 
  UsersIcon,
  CheckCircleIcon,
  UserIcon,
  BoltIcon,
  PlusIcon,
  ClipboardDocumentListIcon,
  UserGroupIcon,
  ShieldCheckIcon,
  ArrowTopRightOnSquareIcon,
  LightBulbIcon,
  BookOpenIcon
} from '@heroicons/vue/24/outline'

const stats = ref({
  user: null,
  roles_count: 0,
  permissions_count: 0,
  users_count: 0,
  recent_roles: []
})
const loading = ref(true)

const config = window.roleManagerConfig || {}

const fetchStats = async () => {
  try {
    loading.value = true
    const response = await window.roleManagerApi.getDashboardStats()
    stats.value = response.stats
  } catch (error) {
    console.error('Error fetching dashboard stats:', error)
    window.showFlash('Error loading dashboard data', 'error')
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  if (!dateString) return 'Recently'
  const date = new Date(dateString)
  const now = new Date()
  const diff = now - date
  const days = Math.floor(diff / (1000 * 60 * 60 * 24))
  
  if (days === 0) return 'Today'
  if (days === 1) return 'Yesterday'
  if (days < 7) return `${days} days ago`
  if (days < 30) return `${Math.floor(days / 7)} weeks ago`
  return date.toLocaleDateString()
}

onMounted(() => {
  fetchStats()
})
</script>