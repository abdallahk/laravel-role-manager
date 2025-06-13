<template>
  <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
    <div class="role-manager-card">
      <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Role</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Add a new role with specific permissions</p>
          </div>
          <router-link
            :to="{ name: 'roles.index' }"
            class="role-manager-button-secondary"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Roles
          </router-link>
        </div>
      </div>

      <form @submit.prevent="submit" class="px-4 py-5 sm:p-6 space-y-6">
        <!-- Role Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Role Name *
          </label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            class="role-manager-input"
            :class="{ 'border-red-300 dark:border-red-500': errors.name }"
            placeholder="Enter role name"
          >
          <div v-if="errors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">
            {{ errors.name }}
          </div>
        </div>

        <!-- Permissions -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
            Permissions
          </label>
          <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
              <span class="text-sm text-gray-600 dark:text-gray-400">Select permissions for this role</span>
              <div class="flex space-x-2">
                <button
                  type="button"
                  @click="selectAll"
                  class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors"
                >
                  Select All
                </button>
                <span class="text-gray-300 dark:text-gray-600">|</span>
                <button
                  type="button"
                  @click="deselectAll"
                  class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors"
                >
                  Deselect All
                </button>
              </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
              <label
                v-for="permission in permissions"
                :key="permission.id"
                class="relative flex items-start py-3 px-4 border rounded-md cursor-pointer transition-all duration-200"
                :class="[
                  form.permissions.includes(permission.id)
                    ? 'bg-indigo-50 dark:bg-indigo-900/20 border-indigo-200 dark:border-indigo-700'
                    : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50'
                ]"
              >
                <div class="flex items-center h-5">
                  <input
                    :id="`permission-${permission.id}`"
                    v-model="form.permissions"
                    :value="permission.id"
                    type="checkbox"
                    class="h-4 w-4 text-indigo-600 dark:text-indigo-400 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:ring-2"
                  >
                </div>
                <div class="ml-3 text-sm">
                  <span class="font-medium text-gray-900 dark:text-white">{{ permission.name }}</span>
                </div>
              </label>
            </div>
          </div>
          <div v-if="errors.permissions" class="mt-2 text-sm text-red-600 dark:text-red-400">
            {{ errors.permissions }}
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
          <router-link
            :to="{ name: 'roles.index' }"
            class="role-manager-button-secondary"
          >
            Cancel
          </router-link>
          <button
            type="submit"
            :disabled="processing"
            class="role-manager-button"
            :class="{ 'opacity-50 cursor-not-allowed': processing }"
          >
            <svg v-if="processing" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
              <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75"></path>
            </svg>
            Create Role
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const permissions = ref([])
const form = ref({
  name: '',
  permissions: []
})
const errors = ref({})
const processing = ref(false)

const fetchPermissions = async () => {
  try {
    const response = await window.roleManagerApi.getPermissionsForRole()
    permissions.value = response.permissions
  } catch (error) {
    console.error('Error fetching permissions:', error)
    window.showFlash('Error loading permissions', 'error')
  }
}

const selectAll = () => {
  form.value.permissions = permissions.value.map(p => p.id)
}

const deselectAll = () => {
  form.value.permissions = []
}

const submit = async () => {
  try {
    processing.value = true
    errors.value = {}
    
    await window.roleManagerApi.createRole(form.value)
    window.showFlash('Role created successfully')
    router.push({ name: 'roles.index' })
  } catch (error) {
    console.error('Error creating role:', error)
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
    } else {
      window.showFlash('Error creating role', 'error')
    }
  } finally {
    processing.value = false
  }
}

onMounted(() => {
  fetchPermissions()
})
</script>