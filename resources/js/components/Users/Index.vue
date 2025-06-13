<template>
  <div class="role-manager-card">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-300">Users</h1>
        <p class="mt-1 text-sm text-slate-500">Manage user roles and permissions</p>
      </div>
    </div>

    <!-- Search Bar -->
    <div class="px-6 py-6 border-t border-slate-200 dark:border-slate-700">
      <div class="flex items-center justify-between">
        <div class="flex-1 max-w-lg">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <MagnifyingGlassIcon class="h-5 w-5 text-slate-400" />
            </div>
            <input
              v-model="searchTerm"
              type="search"
              class="role-manager-input !pl-10"
              placeholder="Search users..."
            >
          </div>
        </div>
        <button
          @click="clearSearch"
          v-if="searchTerm"
          class="ml-3 role-manager-button-secondary"
        >
          Clear
        </button>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex items-center justify-center py-12">
      <div class="loading-spinner"></div>
    </div>

    <!-- Users Table -->
    <div v-else class="overflow-hidden">
      <table class="role-manager-table">
        <thead class="bg-slate-50">
          <tr>
            <th>User</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Created</th>
            <th class="relative px-6 py-6">
              <span class="sr-only">Actions</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-200">
          <tr v-for="user in users.data" :key="user.id">
            <td>
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <div class="h-10 w-10 rounded-full bg-slate-300 flex items-center justify-center">
                    <UserIcon class="w-6 h-6 text-slate-600" />
                  </div>
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium">{{ user.name }}</div>
                </div>
              </div>
            </td>
            <td class="text-slate-500">
              {{ user.email }}
            </td>
            <td>
              <div class="flex flex-wrap gap-1">
                <span
                  v-for="role in user.roles"
                  :key="role.id"
                  class="role-manager-badge role-manager-badge-primary"
                >
                  {{ role.name }}
                </span>
                <span v-if="user.roles.length === 0" class="text-slate-400 text-sm">
                  No roles assigned
                </span>
              </div>
            </td>
            <td class="text-slate-500">
              {{ formatDate(user.created_at) }}
            </td>
            <td class="text-right text-sm font-medium">
              <router-link
                :to="{ name: 'users.show', params: { id: user.id } }"
                class="text-indigo-600 hover:text-indigo-900"
              >
                Manage Roles
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div v-if="users.data && users.data.length > 0" class="px-6 py-6 border-t border-slate-200 dark:border-slate-700 sm:px-6">
      <div class="flex items-center justify-between">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
          <div>
            <p class="text-sm text-slate-500">
              Showing {{ users.from || 0 }} to {{ users.to || 0 }} of {{ users.total || 0 }} results
            </p>
          </div>
          <div class="flex items-center space-x-2">
            <button
              @click="goToPage(users.prev_page_url)"
              :disabled="!users.prev_page_url"
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-md border transition-colors',
                users.prev_page_url 
                  ? 'text-slate-700 bg-white border-slate-300 hover:bg-slate-50 hover:text-slate-900' 
                  : 'text-slate-400 bg-slate-100 border-slate-200 cursor-not-allowed'
              ]"
            >
              <ChevronLeftIcon class="w-4 h-4 mr-1" />
              Previous
            </button>
            <button
              @click="goToPage(users.next_page_url)"
              :disabled="!users.next_page_url"
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-md border transition-colors',
                users.next_page_url 
                  ? 'text-slate-700 bg-white border-slate-300 hover:bg-slate-50 hover:text-slate-900' 
                  : 'text-slate-400 bg-slate-100 border-slate-200 cursor-not-allowed'
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
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useDebounceFn } from '@vueuse/core'
import {
  MagnifyingGlassIcon,
  UserIcon,
  ChevronLeftIcon,
  ChevronRightIcon
} from '@heroicons/vue/24/outline'

const users = ref({ 
  data: [], 
  links: [], 
  from: 0, 
  to: 0, 
  total: 0,
  prev_page_url: null,
  next_page_url: null,
  current_page: 1,
  last_page: 1
})
const loading = ref(true)
const searchTerm = ref('')

const fetchUsers = async (url = null) => {
  try {
    loading.value = true
    const params = searchTerm.value ? { search: searchTerm.value } : {}
    const response = await window.roleManagerApi.getUsers(params, url)
    users.value = response.users
  } catch (error) {
    console.error('Error fetching users:', error)
    window.showFlash('Error loading users', 'error')
  } finally {
    loading.value = false
  }
}

// Debounced search function
const debouncedSearch = useDebounceFn(() => {
  fetchUsers()
}, 500)

// Watch for changes in searchTerm and trigger debounced search
watch(searchTerm, () => {
  debouncedSearch()
})

const clearSearch = () => {
  searchTerm.value = ''
  // fetchUsers will be called automatically via the watcher
}

const goToPage = (url) => {
  if (url) {
    fetchUsers(url)
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-GB', {
   day: '2-digit',
   month: 'short',
   year: 'numeric'
 })
}

onMounted(() => {
  fetchUsers()
})
</script>