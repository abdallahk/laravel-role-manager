<template>
  <div class="max-w-7xl mx-auto">
    <div class="role-manager-card">
      <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-300">Role Details</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">View role information and permissions</p>
          </div>
          <div class="flex space-x-3">
            <router-link
              :to="{ name: 'roles.edit', params: { id: roleId } }"
              class="role-manager-button-secondary"
            >
              <PencilIcon class="w-4 h-4 mr-2" />
              Edit
            </router-link>
            <router-link
              :to="{ name: 'roles.index' }"
              class="role-manager-button-secondary"
            >
              <ArrowLeftIcon class="w-4 h-4 mr-2" />
              Back to Roles
            </router-link>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-12">
        <div class="loading-spinner"></div>
      </div>

      <div v-else class="px-4 py-5 sm:p-6">
        <!-- Role Information -->
        <div class="mb-8">
          <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300 mb-4">Role Information</h3>
          <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Role Name</label>
                <div class="mt-1 text-sm text-slate-900 dark:text-slate-300">{{ role?.name }}</div>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Created</label>
                <div class="mt-1 text-sm text-slate-900 dark:text-slate-300">{{ formatDate(role?.created_at) }}</div>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Total Permissions</label>
                <div class="mt-1 text-sm text-slate-900 dark:text-slate-300">{{ role?.permissions?.length || 0 }}</div>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Total Users with Role</label>
                <div class="mt-1 text-sm text-slate-900 dark:text-slate-300">{{ users?.total || 0 }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Permissions -->
        <div class="mb-8">
          <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300 mb-4">Permissions</h3>
          <div v-if="role?.permissions?.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            <div
              v-for="permission in role.permissions"
              :key="permission.id"
              class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-3 flex items-center"
            >
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                  <CheckCircleIcon class="w-4 h-4 text-green-600 dark:text-green-400" />
                </div>
              </div>
              <div class="ml-3">
                <div class="text-sm font-medium text-slate-900 dark:text-slate-300">{{ permission.name }}</div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-8">
            <CheckCircleIcon class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" />
            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-300">No permissions</h3>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">This role doesn't have any permissions assigned.</p>
            <div class="mt-6">
              <router-link
                :to="{ name: 'roles.edit', params: { id: roleId } }"
                class="role-manager-button"
              >
                <PlusIcon class="w-4 h-4 mr-2" />
                Add Permissions
              </router-link>
            </div>
          </div>
        </div>

        <!-- Users with this Role -->
        <div>
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300">Users with this Role</h3>
            <!-- Search Bar for Users -->
            <div v-if="users?.total > 0" class="flex-1 max-w-sm ml-4">
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <MagnifyingGlassIcon class="h-4 w-4 text-slate-400" />
                </div>
                <input
                  v-model="userSearchTerm"
                  type="search"
                  class="role-manager-input !pl-9 !py-2 text-sm"
                  placeholder="Search by name or email..."
                >
              </div>
            </div>
          </div>

          <!-- Users Loading State -->
          <div v-if="usersLoading" class="flex items-center justify-center py-8">
            <div class="loading-spinner"></div>
          </div>

          <!-- Users List -->
          <div v-else-if="users?.data?.length > 0" class="bg-white dark:bg-slate-800 shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-slate-200 dark:divide-slate-700">
              <li v-for="user in users.data" :key="user.id" class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-slate-300 dark:bg-slate-600 flex items-center justify-center">
                        <UserIcon class="w-6 h-6 text-slate-600 dark:text-slate-300" />
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-slate-900 dark:text-slate-300">{{ user.name }}</div>
                      <div class="text-sm text-slate-500 dark:text-slate-400">{{ user.email }}</div>
                    </div>
                  </div>
                  <div class="flex-shrink-0">
                    <router-link
                      :to="{ name: 'users.show', params: { id: user.id } }"
                      class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium transition-colors"
                    >
                      View User
                    </router-link>
                  </div>
                </div>
              </li>
            </ul>

            <!-- Users Pagination -->
            <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700 sm:px-6">
              <div class="flex items-center justify-between">
                <div class="flex-1 flex items-center justify-between">
                  <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                      Showing {{ users.from || 0 }} to {{ users.to || 0 }} of {{ users.total || 0 }} users
                    </p>
                  </div>
                  <div class="flex items-center space-x-2">
                    <button
                      @click="goToUserPage(users.prev_page_url)"
                      :disabled="!users.prev_page_url"
                      :class="[
                        'flex items-center px-3 py-1 text-sm font-medium rounded-md border transition-colors',
                        users.prev_page_url 
                          ? 'text-slate-700 bg-white border-slate-300 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:hover:bg-slate-700' 
                          : 'text-slate-400 bg-slate-100 border-slate-200 cursor-not-allowed dark:bg-slate-700 dark:border-slate-600'
                      ]"
                    >
                      <ChevronLeftIcon class="w-4 h-4 mr-1" />
                      Previous
                    </button>
                    <button
                      @click="goToUserPage(users.next_page_url)"
                      :disabled="!users.next_page_url"
                      :class="[
                        'flex items-center px-3 py-1 text-sm font-medium rounded-md border transition-colors',
                        users.next_page_url 
                          ? 'text-slate-700 bg-white border-slate-300 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:hover:bg-slate-700' 
                          : 'text-slate-400 bg-slate-100 border-slate-200 cursor-not-allowed dark:bg-slate-700 dark:border-slate-600'
                      ]"
                    >
                      Next
                      <ChevronRightIcon class="w-4 h-4 ml-1" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- No Users State -->
          <div v-else class="text-center py-8">
            <UserGroupIcon class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" />
            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-300">
              {{ userSearchTerm ? 'No matching users' : 'No users' }}
            </h3>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
              {{ userSearchTerm ? 'No users match your search criteria. Try searching by name or email.' : 'No users have been assigned this role yet.' }}
            </p>
            <div v-if="!userSearchTerm" class="mt-6">
              <router-link
                :to="{ name: 'users.index' }"
                class="role-manager-button"
              >
                Manage Users
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useDebounceFn } from '@vueuse/core'
import {
  PencilIcon,
  ArrowLeftIcon,
  CheckCircleIcon,
  PlusIcon,
  UserIcon,
  UserGroupIcon,
  MagnifyingGlassIcon,
  ChevronLeftIcon,
  ChevronRightIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  id: {
    type: [String, Number],
    required: true
  }
})

const route = useRoute()
const roleId = props.id || route.params.id

const role = ref(null)
const users = ref({
  data: [],
  from: 0,
  to: 0,
  total: 0,
  prev_page_url: null,
  next_page_url: null,
  current_page: 1,
  last_page: 1
})
const loading = ref(true)
const usersLoading = ref(false)
const userSearchTerm = ref('')

const fetchRole = async () => {
  try {
    const response = await window.roleManagerApi.getRole(roleId)
    role.value = response.role
  } catch (error) {
    console.error('Error fetching role:', error)
    window.showFlash('Error loading role', 'error')
  } finally {
    loading.value = false
  }
}

const fetchRoleUsers = async (url = null) => {
  try {
    usersLoading.value = true
    const params = userSearchTerm.value ? { search: userSearchTerm.value } : {}
    const response = await window.roleManagerApi.getRoleUsers(roleId, params, url)
    users.value = response.users
  } catch (error) {
    console.error('Error fetching role users:', error)
    window.showFlash('Error loading users', 'error')
  } finally {
    usersLoading.value = false
  }
}

// Debounced search for users
const debouncedUserSearch = useDebounceFn(() => {
  fetchRoleUsers()
}, 500)

// Watch for changes in userSearchTerm and trigger debounced search
watch(userSearchTerm, () => {
  debouncedUserSearch()
})

const goToUserPage = (url) => {
  if (url) {
    fetchRoleUsers(url)
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-GB', {
   day: '2-digit',
   month: 'short',
   year: 'numeric'
 })
}

onMounted(async () => {
  await fetchRole()
  await fetchRoleUsers()
})
</script>