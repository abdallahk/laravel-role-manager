<!-- resources/js/components/Permissions/Edit.vue -->
<template>
  <div class="max-w-7xl mx-auto">
    <div class="role-manager-card">
      <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-300">Edit Permission</h1>
            <p class="mt-1 text-sm text-slate-500">Update permission information</p>
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

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-12">
        <div class="loading-spinner"></div>
      </div>

      <form v-else @submit.prevent="submit" class="px-4 py-5 sm:p-6">
        <!-- Permission Name -->
        <div class="mb-6">
          <label for="name" class="block text-sm font-medium text-slate-600">
            Permission Name *
          </label>
          <div class="mt-1">
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="role-manager-input"
              :class="{ 'border-red-300': errors.name }"
              placeholder="e.g., manage users, edit posts, view reports"
            >
          </div>
          <div v-if="errors.name" class="mt-2 text-sm text-red-600">
            {{ errors.name }}
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-3">
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
            Update Permission
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'

export default {
  name: 'PermissionsEdit',
  props: {
    id: {
      type: [String, Number],
      required: true
    }
  },
  setup(props) {
    const router = useRouter()
    const route = useRoute()
    const permissionId = props.id || route.params.id
    
    const permission = ref(null)
    const form = ref({
      name: ''
    })
    const errors = ref({})
    const processing = ref(false)
    const loading = ref(true)

    const fetchPermission = async () => {
      try {
        const response = await window.roleManagerApi.getPermissionForEdit(permissionId)
        permission.value = response.permission
        form.value.name = permission.value.name
      } catch (error) {
        console.error('Error fetching permission:', error)
        window.showFlash('Error loading permission', 'error')
      } finally {
        loading.value = false
      }
    }

    const submit = async () => {
      try {
        processing.value = true
        errors.value = {}
        
        await window.roleManagerApi.updatePermission(permissionId, form.value)
        window.showFlash('Permission updated successfully')
        router.push({ name: 'permissions.index' })
      } catch (error) {
        console.error('Error updating permission:', error)
        if (error.response?.data?.errors) {
          errors.value = error.response.data.errors
        } else {
          window.showFlash('Error updating permission', 'error')
        }
      } finally {
        processing.value = false
      }
    }

    onMounted(() => {
      fetchPermission()
    })

    return {
      permission,
      form,
      errors,
      processing,
      loading,
      submit
    }
  }
}
</script>