<template>
  <div class="role-manager-card">
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-300">Permissions</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage system permissions</p>
      </div>
      <router-link
        :to="{ name: 'permissions.create' }"
        class="role-manager-button"
      >
        <PlusIcon class="w-4 h-4 mr-2" />
        Add Permission
      </router-link>
    </div>

    <!-- Search Bar -->
    <div class="px-6 py-6 border-t border-slate-200 dark:border-slate-700">
      <div class="flex items-center justify-between">
        <div class="flex-1 max-w-lg">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <MagnifyingGlassIcon class="h-5 w-5 text-slate-400 dark:text-slate-500" />
            </div>
            <input
              v-model="searchTerm"
              type="search"
              class="role-manager-input !pl-10"
              placeholder="Search permissions..."
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

    <!-- Permissions Grid -->
    <div v-else class="p-6">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="permission in permissions.data"
          :key="permission.id"
          class="relative bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6 hover:border-slate-300 dark:hover:border-slate-600 transition-colors"
        >
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                  <CheckCircleIcon class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
              </div>
              <div class="ml-4">
                <h3 class="text-sm font-medium text-slate-900 dark:text-slate-300">{{ permission.name }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ permission.guard_name || 'web' }} guard</p>
              </div>
            </div>
            <div class="flex-shrink-0">
              <div class="relative inline-block text-left">
                <button
                  @click="toggleDropdown(permission.id)"
                  class="bg-white dark:bg-slate-800 rounded-full flex items-center text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-800 transition-colors"
                >
                  <EllipsisVerticalIcon class="h-5 w-5" />
                </button>
                
                <div
                  v-if="openDropdown === permission.id"
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 dark:ring-slate-700 z-10"
                >
                  <div class="py-1">
                    <router-link
                      :to="{ name: 'permissions.show', params: { id: permission.id } }"
                      class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                      @click="openDropdown = null"
                    >
                      <EyeIcon class="w-4 h-4 mr-2 inline" />
                      View Details
                    </router-link>
                    <router-link
                      :to="{ name: 'permissions.edit', params: { id: permission.id } }"
                      class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                      @click="openDropdown = null"
                    >
                      <PencilIcon class="w-4 h-4 mr-2 inline" />
                      Edit
                    </router-link>
                    <button
                      @click="confirmDelete(permission)"
                      class="flex items-center w-full text-left px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                    >
                      <TrashIcon class="w-4 h-4 mr-2" />
                      Delete
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="mt-4">
            <div class="text-xs text-slate-500 dark:text-slate-400">
              Created {{ formatDate(permission.created_at) }}
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="permissions.data.length === 0" class="text-center py-12">
        <CheckCircleIcon class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" />
        <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-300">
          {{ searchTerm ? 'No matching permissions' : 'No permissions' }}
        </h3>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
          {{ searchTerm ? 'No permissions match your search criteria.' : 'Get started by creating a new permission.' }}
        </p>
        <div v-if="!searchTerm" class="mt-6">
          <router-link
            :to="{ name: 'permissions.create' }"
            class="role-manager-button"
          >
            <PlusIcon class="w-4 h-4 mr-2" />
            Add Permission
          </router-link>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="permissions.data && permissions.data.length > 0" class="px-6 py-6 border-t border-slate-200 dark:border-slate-700 sm:px-6">
      <div class="flex items-center justify-between">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
          <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              Showing {{ permissions.from || 0 }} to {{ permissions.to || 0 }} of {{ permissions.total || 0 }} results
            </p>
          </div>
          <div class="flex items-center space-x-2">
            <button
              @click="goToPage(permissions.prev_page_url)"
              :disabled="!permissions.prev_page_url"
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-md border transition-colors',
                permissions.prev_page_url 
                  ? 'text-slate-700 bg-white border-slate-300 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:hover:bg-slate-700' 
                  : 'text-slate-400 bg-slate-100 border-slate-200 cursor-not-allowed dark:bg-slate-700 dark:border-slate-600 dark:text-slate-500'
              ]"
            >
              <ChevronLeftIcon class="w-4 h-4 mr-1" />
              Previous
            </button>
            <button
              @click="goToPage(permissions.next_page_url)"
              :disabled="!permissions.next_page_url"
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-md border transition-colors',
                permissions.next_page_url 
                  ? 'text-slate-700 bg-white border-slate-300 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:hover:bg-slate-700' 
                  : 'text-slate-400 bg-slate-100 border-slate-200 cursor-not-allowed dark:bg-slate-700 dark:border-slate-600 dark:text-slate-500'
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
    <div v-if="showDeleteModal" class="fixed inset-0 bg-slate-600 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-75 overflow-y-auto h-full w-full z-50">
      <div class="relative top-20 mx-auto p-5 border border-slate-200 dark:border-slate-700 w-96 shadow-lg rounded-md bg-white dark:bg-slate-800">
        <div class="mt-3 text-center">
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30">
            <ExclamationTriangleIcon class="h-6 w-6 text-red-600 dark:text-red-400" />
          </div>
          <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300 mt-2">Delete Permission</h3>
          <div class="mt-2 px-7 py-3">
            <p class="text-sm text-slate-500 dark:text-slate-400">
              Are you sure you want to delete the permission "{{ permissionToDelete?.name }}"? This action cannot be undone.
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
              @click="deletePermission"
              class="role-manager-button-danger"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Click outside to close dropdown -->
    <div
      v-if="openDropdown"
      @click="openDropdown = null"
      class="fixed inset-0 z-5"
    ></div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useDebounceFn } from '@vueuse/core'
import {
  PlusIcon,
  MagnifyingGlassIcon,
  CheckCircleIcon,
  EllipsisVerticalIcon,
  EyeIcon,
  PencilIcon,
  TrashIcon,
  ExclamationTriangleIcon,
  ChevronLeftIcon,
  ChevronRightIcon
} from '@heroicons/vue/24/outline'

const permissions = ref({ 
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
const permissionToDelete = ref(null)
const openDropdown = ref(null)

const fetchPermissions = async (url = null) => {
  try {
    loading.value = true
    const params = searchTerm.value ? { search: searchTerm.value } : {}
    const response = await window.roleManagerApi.getPermissions(params, url)
    permissions.value = response.permissions
  } catch (error) {
    console.error('Error fetching permissions:', error)
    window.showFlash('Error loading permissions', 'error')
  } finally {
    loading.value = false
  }
}

// Debounced search function
const debouncedSearch = useDebounceFn(() => {
  fetchPermissions()
}, 500)

// Watch for changes in searchTerm and trigger debounced search
watch(searchTerm, () => {
  debouncedSearch()
})

const clearSearch = () => {
  searchTerm.value = ''
  // fetchPermissions will be called automatically via the watcher
}

const goToPage = (url) => {
  if (url) {
    fetchPermissions(url)
  }
}

const toggleDropdown = (permissionId) => {
  openDropdown.value = openDropdown.value === permissionId ? null : permissionId
}

const confirmDelete = (permission) => {
  permissionToDelete.value = permission
  showDeleteModal.value = true
  openDropdown.value = null
}

const deletePermission = async () => {
  try {
    await window.roleManagerApi.deletePermission(permissionToDelete.value.id)
    window.showFlash('Permission deleted successfully')
    showDeleteModal.value = false
    permissionToDelete.value = null
    fetchPermissions()
  } catch (error) {
    console.error('Error deleting permission:', error)
    window.showFlash('Error deleting permission', 'error')
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
  fetchPermissions()
})
</script>