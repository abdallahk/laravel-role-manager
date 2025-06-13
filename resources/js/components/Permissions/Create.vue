<template>
  <div class="">
    <div class="role-manager-card">
      <div class="px-4 py-5 sm:px-6 border-b border-slate-200 dark:border-slate-700">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-300 dark:text-white">Create Permission</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Add a new permission to the system</p>
          </div>
          <router-link
            :to="{ name: 'permissions.index' }"
            class="role-manager-button-secondary"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Permissions
          </router-link>
        </div>
      </div>

      <form @submit.prevent="submit" class="px-4 py-5 sm:p-6 space-y-6">
        <!-- Permission Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
            Permission Name *
          </label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            class="role-manager-input"
            :class="{ 'border-red-300 dark:border-red-500': errors.name }"
            placeholder="e.g., manage users, edit posts, view reports"
          >
          <div v-if="errors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">
            {{ errors.name }}
          </div>
          <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Use clear, descriptive names like "manage users" or "edit posts". Avoid spaces and special characters where possible.
          </p>
        </div>

        <!-- Permission Examples -->
        <div>
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
            Common Permission Examples
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <button
              v-for="example in permissionExamples"
              :key="example"
              type="button"
              @click="form.name = example"
              class="text-left p-3 border border-slate-200 dark:border-slate-600 rounded-md bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition-colors"
            >
              <div class="text-sm font-medium text-slate-900 dark:text-white">{{ example }}</div>
            </button>
          </div>
        </div>

        <!-- Preview -->
        <div v-if="form.name">
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
            Preview
          </label>
          <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-3">
                <div class="text-sm font-medium text-slate-900 dark:text-white">{{ form.name }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">web guard</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-200 dark:border-slate-700">
          <router-link
            :to="{ name: 'permissions.index' }"
            class="role-manager-button-secondary"
          >
            Cancel
          </router-link>
          <button
            type="submit"
            :disabled="processing || !form.name"
            class="role-manager-button"
            :class="{ 'opacity-50 cursor-not-allowed': processing || !form.name }"
          >
            <svg v-if="processing" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
              <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75"></path>
            </svg>
            Create Permission
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const form = ref({
  name: ''
})
const errors = ref({})
const processing = ref(false)

const permissionExamples = [
  'manage users',
  'manage roles',
  'manage permissions',
  'view reports',
  'edit posts',
  'publish posts',
  'delete posts',
  'manage comments',
  'manage settings',
  'view analytics',
  'manage products',
  'manage orders'
]

const submit = async () => {
  try {
    processing.value = true
    errors.value = {}
    
    await window.roleManagerApi.createPermission(form.value)
    window.showFlash('Permission created successfully')
    router.push({ name: 'permissions.index' })
  } catch (error) {
    console.error('Error creating permission:', error)
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
    } else {
      window.showFlash('Error creating permission', 'error')
    }
  } finally {
    processing.value = false
  }
}
</script>