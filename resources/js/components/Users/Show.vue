<template>
  <div class="max-w-7xl mx-auto">
    <div class="role-manager-card">
      <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-300">User Role Management</h1>
            <p class="mt-1 text-sm text-slate-500">Assign and manage user roles</p>
          </div>
          <router-link
            :to="{ name: 'users.index' }"
            class="role-manager-button-secondary"
          >
            <ArrowLeftIcon class="w-4 h-4 mr-2" />
            Back to Users
          </router-link>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-12">
        <div class="loading-spinner"></div>
      </div>

      <div v-else class="px-4 py-5 sm:p-6">
        <!-- User Information -->
        <div class="mb-8">
          <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300 mb-4">User Information</h3>
          <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0 h-12 w-12">
                <div class="h-12 w-12 rounded-full bg-slate-300 dark:bg-slate-600 flex items-center justify-center">
                  <UserIcon class="w-8 h-8 text-slate-600 dark:text-slate-300" />
                </div>
              </div>
              <div class="ml-4">
                <div class="text-lg font-medium text-slate-900 dark:text-slate-300">{{ user?.name }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">{{ user?.email }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Current Roles -->
        <div class="mb-8">
          <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300 mb-4">Current Roles</h3>
          <div v-if="user?.roles?.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
              v-for="role in user.roles"
              :key="role.id"
              class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-4 flex items-center justify-between"
            >
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                    <UserGroupIcon class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                  </div>
                </div>
                <div class="ml-3">
                  <div class="text-sm font-medium text-slate-900 dark:text-slate-300">{{ role.name }}</div>
                  <div class="text-sm text-slate-500 dark:text-slate-400">{{ role.permissions?.length || 0 }} permissions</div>
                </div>
              </div>
              <button
                @click="removeRole(role)"
                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm transition-colors"
              >
                Remove
              </button>
            </div>
          </div>
          <div v-else class="text-center py-8">
            <UserGroupIcon class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" />
            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-300">No roles assigned</h3>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">This user doesn't have any roles assigned yet.</p>
          </div>
        </div>

        <!-- Assign Roles -->
        <div>
          <h3 class="text-lg font-medium text-slate-900 dark:text-slate-300 mb-4">Assign Roles</h3>
          <form @submit.prevent="assignRoles" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
              <label
                v-for="role in availableRoles"
                :key="role.id"
                class="relative flex items-start py-2 px-3 border rounded-md cursor-pointer transition-colors"
                :class="[
                  selectedRoles.includes(role.id) 
                    ? 'bg-indigo-50 border-indigo-200 dark:bg-indigo-900/20 dark:border-indigo-700' 
                    : 'border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800'
                ]"
              >
                <div class="flex items-center h-5">
                  <input
                    :id="`role-${role.id}`"
                    v-model="selectedRoles"
                    :value="role.id"
                    type="checkbox"
                    class="h-4 w-4 text-indigo-600 border-slate-300 dark:border-slate-600 rounded focus:ring-indigo-500 dark:bg-slate-700"
                  >
                </div>
                <div class="ml-3 text-sm">
                  <span class="font-medium text-slate-900 dark:text-slate-300">{{ role.name }}</span>
                  <div class="text-slate-500 dark:text-slate-400">{{ role.permissions_count || 0 }} permissions</div>
                </div>
              </label>
            </div>
            
            <div class="flex justify-end pt-4">
              <button
                type="submit"
                :disabled="processing"
                class="role-manager-button"
                :class="{ 'opacity-50 cursor-not-allowed': processing }"
              >
                <ArrowPathIcon v-if="processing" class="animate-spin -ml-1 mr-3 h-4 w-4" />
                Update Roles
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import {
  ArrowLeftIcon,
  UserIcon,
  UserGroupIcon,
  ArrowPathIcon
} from '@heroicons/vue/24/outline'

const props = defineProps({
  id: {
    type: [String, Number],
    required: true
  }
})

const route = useRoute()
const userId = props.id || route.params.id

const user = ref(null)
const availableRoles = ref([])
const selectedRoles = ref([])
const loading = ref(true)
const processing = ref(false)

const fetchUser = async () => {
  try {
    const response = await window.roleManagerApi.getUser(userId)
    user.value = response.user
    availableRoles.value = response.availableRoles
    selectedRoles.value = user.value.roles.map(role => role.id)
  } catch (error) {
    console.error('Error fetching user:', error)
    window.showFlash('Error loading user', 'error')
  } finally {
    loading.value = false
  }
}

const assignRoles = async () => {
  try {
    processing.value = true
    await window.roleManagerApi.assignUserRoles(userId, { roles: selectedRoles.value })
    window.showFlash('User roles updated successfully')
    await fetchUser()
  } catch (error) {
    console.error('Error updating user roles:', error)
    window.showFlash('Error updating user roles', 'error')
  } finally {
    processing.value = false
  }
}

const removeRole = async (role) => {
  try {
    await window.roleManagerApi.removeUserRole(userId, role.id)
    window.showFlash('Role removed successfully')
    await fetchUser()
  } catch (error) {
    console.error('Error removing role:', error)
    window.showFlash('Error removing role', 'error')
  }
}

onMounted(() => {
  fetchUser()
})
</script>