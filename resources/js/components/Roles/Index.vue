<!-- resources/js/components/Roles/Index.vue -->
<template>
  <div class="role-manager-card">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-300">Roles</h1>
        <p class="mt-1 text-sm text-slate-500">Manage system roles and their permissions</p>
      </div>
      <router-link
        :to="{ name: 'roles.create' }"
        class="role-manager-button"
      >
        <PlusIcon class="w-4 h-4 mr-2" />
        Add Role
      </router-link>
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
              @keyup.enter="search"
              type="text"
              class="role-manager-input !pl-10"
              placeholder="Search roles..."
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

    <!-- Roles Table -->
    <div v-else class="overflow-hidden">
      <table class="role-manager-table">
        <thead class="bg-slate-50">
          <tr>
            <th>Role Name</th>
            <th>Permissions</th>
            <th>Users Count</th>
            <th>Created</th>
            <th class="relative px-6 py-6">
              <span class="sr-only">Actions</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-200">
          <tr v-for="role in roles.data" :key="role.id">
            <td>
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                    <UserGroupIcon class="w-6 h-6 text-indigo-600" />
                  </div>
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium">{{ role.name }}</div>
                </div>
              </div>
            </td>
            <td>
              <div class="flex flex-wrap gap-1">
                <span
                  v-for="permission in role.permissions.slice(0, 3)"
                  :key="permission.id"
                  class="role-manager-badge role-manager-badge-primary"
                >
                  {{ permission.name }}
                </span>
                <span
                  v-if="role.permissions.length > 3"
                  class="role-manager-badge"
                >
                  +{{ role.permissions.length - 3 }} more
                </span>
              </div>
            </td>
            <td>
              {{ role.users_count || 0 }}
            </td>
            <td class="text-slate-500">
              {{ formatDate(role.created_at) }}
            </td>
            <td class="text-right text-sm font-medium">
              <div class="flex items-center justify-end space-x-2">
                <router-link
                  :to="{ name: 'roles.show', params: { id: role.id } }"
                  class="text-indigo-600 hover:text-indigo-900"
                >
                  View
                </router-link>
                <router-link
                  :to="{ name: 'roles.edit', params: { id: role.id } }"
                  class="text-green-600 hover:text-green-900"
                >
                  Edit
                </router-link>
                <button
                  @click="confirmDelete(role)"
                  class="text-red-600 hover:text-red-900"
                >
                  Delete
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div v-if="roles.data && roles.data.length > 0" class="px-6 py-6 border-t border-slate-200 dark:border-slate-700 sm:px-6">
      <div class="flex items-center justify-between">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
          <div>
            <p class="text-sm text-slate-500">
              Showing {{ roles.from || 0 }} to {{ roles.to || 0 }} of {{ roles.total || 0 }} results
            </p>
          </div>
          <div class="flex items-center space-x-2">
            <button
              @click="goToPage(roles.prev_page_url)"
              :disabled="!roles.prev_page_url"
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-md border transition-colors',
                roles.prev_page_url 
                  ? 'text-slate-700 bg-white border-slate-300 hover:bg-slate-50 hover:text-slate-900' 
                  : 'text-slate-400 bg-slate-100 border-slate-200 cursor-not-allowed'
              ]"
            >
              <ChevronLeftIcon class="w-4 h-4 mr-1" />
              Previous
            </button>
            <button
              @click="goToPage(roles.next_page_url)"
              :disabled="!roles.next_page_url"
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-md border transition-colors',
                roles.next_page_url 
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

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-slate-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
            <ExclamationTriangleIcon class="h-6 w-6 text-red-600" />
          </div>
          <h3 class="text-lg font-medium text-slate-900 mt-2">Delete Role</h3>
          <div class="mt-2 px-7 py-3">
            <p class="text-sm text-slate-500">
              Are you sure you want to delete the role "{{ roleToDelete?.name }}"? This action cannot be undone.
            </p>
          </div>
          <div class="flex gap-4 justify-center mt-4">
            <button
              @click="showDeleteModal = false"
              class="role-manager-button-secondary"
            >
              Cancel
            </button>
            <button
              @click="deleteRole"
              class="role-manager-button-danger"
            >
              Delete
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
  PlusIcon,
  MagnifyingGlassIcon,
  UserGroupIcon,
  ExclamationTriangleIcon,
  ChevronLeftIcon,
  ChevronRightIcon
} from '@heroicons/vue/24/outline'

const roles = ref({ 
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
const showDeleteModal = ref(false)
const roleToDelete = ref(null)

const fetchRoles = async (url = null) => {
  try {
    loading.value = true
    const params = searchTerm.value ? { search: searchTerm.value } : {}
    const response = await window.roleManagerApi.getRoles(params, url)
    roles.value = response.roles
  } catch (error) {
    console.error('Error fetching roles:', error)
    window.showFlash('Error loading roles', 'error')
  } finally {
    loading.value = false
  }
}

// Debounced search function
const debouncedSearch = useDebounceFn(() => {
  fetchRoles()
}, 500)

// Watch for changes in searchTerm and trigger debounced search
watch(searchTerm, () => {
  debouncedSearch()
})

const clearSearch = () => {
  searchTerm.value = ''
  // fetchRoles will be called automatically via the watcher
}

const goToPage = (url) => {
  if (url) {
    fetchRoles(url)
  }
}

const confirmDelete = (role) => {
  roleToDelete.value = role
  showDeleteModal.value = true
}

const deleteRole = async () => {
  try {
    await window.roleManagerApi.deleteRole(roleToDelete.value.id)
    window.showFlash('Role deleted successfully')
    showDeleteModal.value = false
    roleToDelete.value = null
    fetchRoles()
  } catch (error) {
    console.error('Error deleting role:', error)
    window.showFlash('Error deleting role', 'error')
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
  fetchRoles()
})
</script>