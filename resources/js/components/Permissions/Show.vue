<template>
  <div class="max-w-7xl mx-auto">
    <div class="role-manager-card">
      <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-300">Permission Details</h1>
            <p class="mt-1 text-sm text-slate-500">View permission information and usage</p>
          </div>
          <div class="flex space-x-3">
            <router-link
              :to="{ name: 'permissions.edit', params: { id: permissionId } }"
              class="role-manager-button-secondary"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
              </svg>
              Edit
            </router-link>
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
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-12">
        <div class="loading-spinner"></div>
      </div>

      <div v-else class="px-4 py-5 sm:p-6">
        <!-- Permission Information -->
        <div class="mb-8">
          <h3 class="text-lg font-medium text-slate-900 mb-4">Permission Information</h3>
          <div class="bg-slate-50 rounded-lg p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700">Permission Name</label>
                <div class="mt-1 text-sm text-slate-900">{{ permission?.name }}</div>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700">Guard</label>
                <div class="mt-1 text-sm text-slate-900">{{ permission?.guard_name || 'web' }}</div>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700">Created</label>
                <div class="mt-1 text-sm text-slate-900">{{ formatDate(permission?.created_at) }}</div>
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700">Roles Using Permission</label>
                <div class="mt-1 text-sm text-slate-900">{{ permission?.roles?.length || 0 }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Roles using this Permission -->
        <div>
          <h3 class="text-lg font-medium text-slate-900 mb-4">Roles using this Permission</h3>
          <div v-if="permission?.roles?.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
              v-for="role in permission.roles"
              :key="role.id"
              class="bg-white border border-slate-200 rounded-lg p-4 hover:shadow-md transition-shadow"
            >
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                      <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                      </svg>
                    </div>
                  </div>
                  <div class="ml-3">
                    <div class="text-sm font-medium text-slate-900">{{ role.name }}</div>
                    <div class="text-sm text-slate-500">{{ role.permissions_count || 0 }} permissions</div>
                  </div>
                </div>
                <router-link
                  :to="{ name: 'roles.show', params: { id: role.id } }"
                  class="text-indigo-600 hover:text-indigo-900 text-sm"
                >
                  View
                </router-link>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-slate-900">No roles</h3>
            <p class="mt-1 text-sm text-slate-500">This permission is not assigned to any roles yet.</p>
            <div class="mt-6">
              <router-link
                :to="{ name: 'roles.index' }"
                class="role-manager-button"
              >
                Manage Roles
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

export default {
  name: 'PermissionsShow',
  props: {
    id: {
      type: [String, Number],
      required: true
    }
  },
  setup(props) {
    const route = useRoute()
    const permissionId = props.id || route.params.id
    
    const permission = ref(null)
    const loading = ref(true)

    const fetchPermission = async () => {
      try {
        const response = await window.roleManagerApi.getPermission(permissionId)
        permission.value = response.permission
      } catch (error) {
        console.error('Error fetching permission:', error)
        window.showFlash('Error loading permission', 'error')
      } finally {
        loading.value = false
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
      fetchPermission()
    })

    return {
      permission,
      loading,
      permissionId,
      formatDate
    }
  }
}
</script>