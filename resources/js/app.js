import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';
import '../css/app.css';

// Import components
import App from './components/App.vue';
import Dashboard from './components/Dashboard.vue';
import RolesIndex from './components/Roles/Index.vue';
import RolesCreate from './components/Roles/Create.vue';
import RolesEdit from './components/Roles/Edit.vue';
import RolesShow from './components/Roles/Show.vue';
import PermissionsIndex from './components/Permissions/Index.vue';
import PermissionsCreate from './components/Permissions/Create.vue';
import PermissionsEdit from './components/Permissions/Edit.vue';
import PermissionsShow from './components/Permissions/Show.vue';
import UsersIndex from './components/Users/Index.vue';
import UsersShow from './components/Users/Show.vue';
import Documentation from './components/Documentation.vue';

// Configure axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const csrfToken = document.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
}

// Get base URL from global config
const config = window.roleManagerConfig || {};
const baseUrl = config.apiUrl || '/admin/roles/api';
axios.defaults.baseURL = baseUrl;

// API Service
class ApiService {
    constructor() {
        this.axios = axios;
    }

    async request(method, url, data = null) {
        try {
            const config = {
                method,
                url,
                headers: {
                    'Content-Type': 'application/json',
                }
            };

            if (data) {
                config.data = data;
            }

            const response = await this.axios(config);
            return response.data;
        } catch (error) {
            if (error.response?.data?.message) {
                throw new Error(error.response.data.message);
            }
            throw error;
        }
    }

    // Dashboard
    getDashboardStats() {
        return this.request('GET', '/');
    }

    // Roles
    getRoles(params = {}, url = null) {
        // If a specific URL is provided (for pagination), use it directly
        if (url) {
            // Make the request directly with the full URL, bypassing baseURL
            return this.axios.get(url).then(response => response.data);
        }
        
        // Otherwise, build the query string from params
        const query = new URLSearchParams(params).toString();
        return this.request('GET', `/roles${query ? `?${query}` : ''}`);
    }

    // Add this method to your ApiService class
getRoleUsers(roleId, params = {}, url = null) {
    // If a specific URL is provided (for pagination), use it directly
    if (url) {
        // Make the request directly with the full URL, bypassing baseURL
        return this.axios.get(url).then(response => response.data);
    }
    
    // Otherwise, build the query string from params
    const query = new URLSearchParams(params).toString();
    return this.request('GET', `/roles/${roleId}/users${query ? `?${query}` : ''}`);
}

// Keep the existing getRole method for role details
getRole(id) {
    return this.request('GET', `/roles/${id}`);
}

    createRole(data) {
        return this.request('POST', '/roles', data);
    }

    updateRole(id, data) {
        return this.request('PUT', `/roles/${id}`, data);
    }

    deleteRole(id) {
        return this.request('DELETE', `/roles/${id}`);
    }

    getRoleForEdit(id) {
        return this.request('GET', `/roles/${id}/edit`);
    }

    updateRolePermissions(id, data) {
        return this.request('POST', `/roles/${id}/permissions`, data);
    }

    // Permissions
    getPermissions(params = {}, url = null) {
        // If a specific URL is provided (for pagination), use it directly
        if (url) {
            // Make the request directly with the full URL, bypassing baseURL
            return this.axios.get(url).then(response => response.data);
        }
        
        // Otherwise, build the query string from params
        const query = new URLSearchParams(params).toString();
        return this.request('GET', `/permissions${query ? `?${query}` : ''}`);
    }

    getPermission(id) {
        return this.request('GET', `/permissions/${id}`);
    }

    createPermission(data) {
        return this.request('POST', '/permissions', data);
    }

    updatePermission(id, data) {
        return this.request('PUT', `/permissions/${id}`, data);
    }

    deletePermission(id) {
        return this.request('DELETE', `/permissions/${id}`);
    }

    getPermissionForEdit(id) {
        return this.request('GET', `/permissions/${id}/edit`);
    }

    // Users
    getUsers(params = {}, url = null) {
        // If a specific URL is provided (for pagination), use it directly
        if (url) {
            // Make the request directly with the full URL, bypassing baseURL
            return this.axios.get(url).then(response => response.data);
        }
        
        // Otherwise, build the query string from params
        const query = new URLSearchParams(params).toString();
        return this.request('GET', `/users${query ? `?${query}` : ''}`);
    }

    getUser(id) {
        return this.request('GET', `/users/${id}`);
    }

    assignUserRoles(id, data) {
        return this.request('POST', `/users/${id}/roles`, data);
    }

    removeUserRole(userId, roleId) {
        return this.request('DELETE', `/users/${userId}/roles/${roleId}`);
    }

    getPermissionsForRole() {
        return this.request('GET', '/roles/create');
    }
}

// Router configuration
const routes = [
    { path: '/', name: 'dashboard', component: Dashboard },
    { path: '/roles', name: 'roles.index', component: RolesIndex },
    { path: '/roles/create', name: 'roles.create', component: RolesCreate },
    { path: '/roles/:id', name: 'roles.show', component: RolesShow, props: true },
    { path: '/roles/:id/edit', name: 'roles.edit', component: RolesEdit, props: true },
    { path: '/permissions', name: 'permissions.index', component: PermissionsIndex },
    { path: '/permissions/create', name: 'permissions.create', component: PermissionsCreate },
    { path: '/permissions/:id', name: 'permissions.show', component: PermissionsShow, props: true },
    { path: '/permissions/:id/edit', name: 'permissions.edit', component: PermissionsEdit, props: true },
    { path: '/users', name: 'users.index', component: UsersIndex },
    { path: '/users/:id', name: 'users.show', component: UsersShow, props: true },
    { path: '/documentation', name: 'documentation', component: Documentation},
    
];

// Get router base from config
const routerBase = window.roleManagerConfig?.baseUrl || '/admin/roles';

const router = createRouter({
    history: createWebHistory(routerBase),
    routes
});

// Create and mount the app
const app = createApp(App);
app.use(router);

// Global API service
const apiService = new ApiService();
app.config.globalProperties.$api = apiService;
window.roleManagerApi = apiService;

// Global flash message handler
window.showFlash = (message, type = 'success') => {
    window.dispatchEvent(new CustomEvent('flash-message', {
        detail: { message, type }
    }));
};

app.mount('#role-manager-app');