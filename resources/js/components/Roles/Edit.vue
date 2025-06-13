<template>
  <div class="max-w-7xl mx-auto">
    <div class="role-manager-card">
      <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-300">Edit Role</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Update role information and permissions</p>
          </div>
          <router-link
            :to="{ name: 'roles.index' }"
            class="role-manager-button-secondary"
          >
            <ArrowLeftIcon class="w-4 h-4 mr-2" />
            Back to Roles
          </router-link>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-12">
        <div class="loading-spinner"></div>
      </div>

      <form v-else @submit.prevent="submit" class="px-4 py-5 sm:p-6">
        <!-- Role Name -->
        <div class="mb-6">
          <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
            Role Name *
          </label>
          <div class="mt-1">
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="role-manager-input"
              :class="{ 'border-red-300 dark:border-red-600': errors.name }"
              placeholder="Enter role name"
            >
          </div>
          <div v-if="errors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">
            {{ errors.name }}
          </div>
        </div>

        <!-- Permissions -->
        <div class="mb-6">
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
            Permissions
          </label>
          <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between mb-4">
              <span class="text-sm text-slate-600 dark:text-slate-400">Select permissions for this role</span>
              <div class="flex space-x-2">
                <button
                  type="button"
                  @click="selectAll"
                  class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors"
                >
                  Select All
                </button>
                <span class="text-slate-300 dark:text-slate-600">|</span>
                <button
                  type="button"
                  @click="deselectAll"
                  class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors"
                >
                  Deselect All
                </button>
              </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
              <label
                v-for="permission in permissions"
                :key="permission.id"
                class="relative flex items-start py-2 px-3 border rounded-md cursor-pointer transition-colors"
                :class="[
                  form.permissions.includes(permission.id) 
                    ? 'bg-indigo-50 border-indigo-200 dark:bg-indigo-900/20 dark:border-indigo-700' 
                    : 'border-slate-200 dark:border-slate-700 hover:bg-white dark:hover:bg-slate-700'
                ]"
              >
                <div class="flex items-center h-5">
                  <input
                    :id="`permission-${permission.id}`"
                    v-model="form.permissions"
                    :value="permission.id"
                    type="checkbox"
                    class="h-4 w-4 text-indigo-600 border-slate-300 dark:border-slate-600 rounded focus:ring-indigo-500 dark:bg-slate-700"
                  >
                </div>
                <div class="ml-3 text-sm">
                  <div class="flex items-center">
                    <CheckCircleIcon class="w-4 h-4 text-green-500 dark:text-green-400 mr-2" />
                    <span class="font-medium text-slate-900 dark:text-slate-300">{{ permission.name }}</span>
                  </div>
                </div>
              </label>
            </div>

            <!-- No Permissions State -->
            <div v-if="permissions.length === 0" class="text-center py-8">
              <CheckCircleIcon class="mx-auto h-8 w-8 text-slate-400 dark:text-slate-500" />
              <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-300">No permissions available</h3>
              <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Create some permissions first to assign to this role.</p>
            </div>
          </div>
          <div v-if="errors.permissions" class="mt-2 text-sm text-red-600 dark:text-red-400">
            {{ errors.permissions }}
          </div>
        </div>

        <!-- Selected Permissions Summary -->
        <div v-if="form.permissions.length > 0" class="mb-6">
          <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-4">
            <div class="flex items-center">
              <CheckCircleIcon class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mr-2" />
              <span class="text-sm font-medium text-indigo-800 dark:text-indigo-300">
                {{ form.permissions.length }} permission{{ form.permissions.length !== 1 ? 's' : '' }} selected
              </span>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-200 dark:border-slate-700">
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
            <ArrowPathIcon v-if="processing" class="animate-spin -ml-1 mr-3 h-4 w-4" />
            Update Role
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import {
  ArrowLeftIcon,
  CheckCircleIcon,
  ArrowPathIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  id: {
    type: [String, Number],
    required: true
  }
})

const router = useRouter()
const route = useRoute()
const roleId = props.id || route.params.id

const role = ref(null)
const permissions = ref([])
const form = ref({
  name: '',
  permissions: []
})
const errors = ref({})
const processing = ref(false)
const loading = ref(true)

const fetchRole = async () => {
  try {
    const response = await window.roleManagerApi.getRoleForEdit(roleId)
    role.value = response.role
    permissions.value = response.permissions
    
    form.value.name = role.value.name
    form.value.permissions = role.value.permissions.map(p => p.id)
  } catch (error) {
    console.error('Error fetching role:', error)
    window.showFlash('Error loading role', 'error')
  } finally {
    loading.value = false
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
    
    await window.roleManagerApi.updateRole(roleId, form.value)
    window.showFlash('Role updated successfully')
    router.push({ name: 'roles.index' })
  } catch (error) {
    console.error('Error updating role:', error)
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
    } else {
      window.showFlash('Error updating role', 'error')
    }
  } finally {
    processing.value = false
  }
}

onMounted(() => {
  fetchRole()
})
</script>