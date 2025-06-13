<!-- resources/js/components/App.vue -->
<template>
  <div id="app" class="min-h-screen bg-slate-100 dark:bg-slate-900 transition-colors duration-500 ease-in-out">
    <!-- Navigation -->
    <nav class="sticky top-0 z-40 bg-white border-b border-slate-300 dark:bg-slate-950 dark:border-slate-700 transition-colors duration-500 ease-in-out">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <router-link to="/" class="flex-shrink-0 flex items-center">
              <div class="flex items-center space-x-3">
                <!-- Logo Icon -->
                <div class="relative">
                  <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500 rounded-xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-200">
                    <ShieldCheckIcon class="w-6 h-6 text-white drop-shadow-sm" />
                  </div>
                  <!-- Animated dot indicator -->
                  <div class="absolute -top-1 -right-1 w-3 h-3 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full border-2 border-white dark:border-slate-950 animate-pulse"></div>
                </div>
                <!-- Logo Text -->
                <div class="hidden sm:block">
                  <h1 class="text-xl font-bold bg-gradient-to-r from-slate-900 via-indigo-800 to-purple-800 dark:from-white dark:via-indigo-200 dark:to-purple-200 bg-clip-text text-transparent transition-colors duration-500 ease-in-out">
                    {{ config.title || 'Role Manager' }}
                  </h1>
                </div>
              </div>
            </router-link>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
              <router-link to="/" :class="isActive('/') ? activeClass : defaultClass"
                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-300 ease-in-out">
                Dashboard
              </router-link>
              <router-link to="/roles" :class="isActive('/roles') ? activeClass : defaultClass"
                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-300 ease-in-out">
                Roles
              </router-link>
              <router-link to="/permissions" :class="isActive('/permissions') ? activeClass : defaultClass"
                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-300 ease-in-out">
                Permissions
              </router-link>
              <router-link to="/users" :class="isActive('/users') ? activeClass : defaultClass"
                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-300 ease-in-out">
                Users
              </router-link>
              <router-link v-show="config?.showDocs" to="/documentation" :class="isActive('/documentation') ? activeClass : defaultClass"
                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-300 ease-in-out">
                Documentation
              </router-link>
            </div>
          </div>

          <!-- Right side buttons -->
          <div class="flex items-center space-x-4">
            <!-- Dark mode toggle with HeadlessUI -->
            <div class="hidden sm:flex items-center">
              <Switch
                v-model="isDarkMode"
                :class="isDarkMode ? 'bg-slate-700' : 'bg-slate-300'"
                class="relative inline-flex h-6 w-12 items-center rounded-full border border-slate-300 dark:border-slate-800 cursor-pointer transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2"
              >
                <span class="sr-only">Toggle dark mode</span>
                <SunIcon
                  v-if="!isDarkMode"
                  class="translate-x-1 text-yellow-500 inline-block bg-white p-1 h-4 w-4 transform rounded-full transition duration-200 ease-in-out"
                />
                <MoonIcon
                  v-else
                  class="translate-x-7 text-slate-50 inline-block bg-slate-950 p-1 h-4 w-4 transform rounded-full transition duration-200 ease-in-out"
                />
              </Switch>
            </div>

            <!-- Back to Application button -->
            <button @click="backToApplication"
              class="hidden sm:inline-flex items-center px-4 py-2 border border-slate-200 rounded-md shadow-sm text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800 transition-all duration-300 ease-in-out">
              <ArrowUturnLeftIcon class="w-4 h-4 mr-2" />
              Back to Application
            </button>

            <!-- Mobile menu button -->
            <div class="sm:hidden flex items-center">
              <button @click="showMobileMenu = !showMobileMenu"
                class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 dark:text-slate-500 dark:hover:text-slate-300 dark:hover:bg-slate-800 transition-all duration-300 ease-in-out">
                <Bars3Icon v-if="!showMobileMenu" class="h-6 w-6" />
                <XMarkIcon v-else class="h-6 w-6" />
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div class="sm:hidden dark:bg-slate-900 transition-colors duration-500 ease-in-out" v-show="showMobileMenu">
        <div class="pt-2 pb-3 space-y-1">
          <router-link to="/"
            :class="isActive('/') ? 'bg-indigo-50 border-indigo-500 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-slate-100'"
            class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-all duration-300 ease-in-out" @click="showMobileMenu = false">
            Dashboard
          </router-link>
          <router-link to="/roles"
            :class="isActive('/roles') ? 'bg-indigo-50 border-indigo-500 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-slate-100'"
            class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-all duration-300 ease-in-out" @click="showMobileMenu = false">
            Roles
          </router-link>
          <router-link to="/permissions"
            :class="isActive('/permissions') ? 'bg-indigo-50 border-indigo-500 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-slate-100'"
            class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-all duration-300 ease-in-out" @click="showMobileMenu = false">
            Permissions
          </router-link>
          <router-link to="/users"
            :class="isActive('/users') ? 'bg-indigo-50 border-indigo-500 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-slate-100'"
            class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-all duration-300 ease-in-out" @click="showMobileMenu = false">
            Users
          </router-link>
          <router-link to="/documentation" v-show="config?.showDocs"
            :class="isActive('/documentation') ? 'bg-indigo-50 border-indigo-500 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-slate-100'"
            class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-all duration-300 ease-in-out" @click="showMobileMenu = false">
            Documentation
          </router-link>

          <!-- Mobile Back to Application button -->
          <button @click="backToApplication; showMobileMenu = false"
            class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800 text-base font-medium dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-slate-100 transition-all duration-300 ease-in-out">
            <ArrowLeftIcon class="w-4 h-4 inline mr-2" />
            Back to Application
          </button>

          <!-- Mobile Dark mode toggle -->
          <div class="block pl-3 pr-4 py-2 border-l-4 border-transparent">
            <div class="flex items-center justify-between">
              <span class="text-base font-medium text-slate-600 dark:text-slate-300">Dark Mode</span>
              <Switch
                v-model="isDarkMode"
                :class="isDarkMode ? 'bg-slate-700' : 'bg-slate-300'"
                class="relative inline-flex h-6 w-12 items-center rounded-full border border-slate-300 dark:border-slate-800 cursor-pointer transition-all duration-300 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 hover:scale-105"
              >
                <span class="sr-only">Toggle dark mode</span>
                <Transition
                  enter-active-class="transition-all duration-300 ease-out"
                  enter-from-class="opacity-0 scale-0 rotate-180"
                  enter-to-class="opacity-100 scale-100 rotate-0"
                  leave-active-class="transition-all duration-300 ease-in"
                  leave-from-class="opacity-100 scale-100 rotate-0"
                  leave-to-class="opacity-0 scale-0 -rotate-180"
                  mode="out-in"
                >
                  <SunIcon
                    v-if="!isDarkMode"
                    key="sun"
                    class="translate-x-1 text-yellow-500 inline-block bg-white p-0.5 h-4 w-4 transform rounded-full shadow-sm"
                  />
                  <MoonIcon
                    v-else
                    key="moon"
                    class="translate-x-7 text-blue-400 inline-block bg-slate-800 p-0.5 h-4 w-4 transform rounded-full shadow-sm"
                  />
                </Transition>
              </Switch>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Flash Messages -->
    <Transition
      enter-active-class="transition-all duration-500 ease-out"
      enter-from-class="opacity-0 translate-y-3"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition-all duration-300 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-2"
    >
      <div v-if="flashMessage" class="fixed top-6 right-6 z-50 w-full max-w-sm">
        <div
          :class="[
            'rounded-xl shadow-lg border p-4 backdrop-blur-xl',
            flashMessage.type === 'success' 
              ? 'bg-white/80 border-green-200/50 text-green-800 dark:bg-slate-800/80 dark:border-green-800/50 dark:text-green-300' 
              : 'bg-white/80 border-red-200/50 text-red-800 dark:bg-slate-800/80 dark:border-red-800/50 dark:text-red-300'
          ]"
        >
          <div class="flex items-start space-x-3">
            <div class="flex-shrink-0 mt-0.5">
              <div 
                :class="[
                  'w-2 h-2 rounded-full',
                  flashMessage.type === 'success' 
                    ? 'bg-green-400 dark:bg-green-500' 
                    : 'bg-red-400 dark:bg-red-500'
                ]"
              ></div>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium leading-relaxed">
                {{ flashMessage.message }}
              </p>
            </div>
            <div class="flex-shrink-0">
              <button
                @click="dismissMessage"
                class="inline-flex rounded-lg p-1 transition-all duration-200 hover:bg-black/5 dark:hover:bg-white/5 focus:outline-none focus:ring-2 focus:ring-slate-300 dark:focus:ring-slate-600"
              >
                <span class="sr-only">Dismiss</span>
                <XMarkIcon class="h-4 w-4 text-slate-400 dark:text-slate-500" />
              </button>
            </div>
          </div>
          
          <!-- Subtle progress indicator -->
          <div class="mt-3 w-full h-px bg-slate-200/50 dark:bg-slate-700/50 overflow-hidden">
            <div 
              class="h-full transition-all duration-75 ease-linear"
              :class="[
                flashMessage.type === 'success' 
                  ? 'bg-green-300 dark:bg-green-600' 
                  : 'bg-red-300 dark:bg-red-600'
              ]"
              :style="{ width: `${progressWidth}%` }"
            ></div>
          </div>
        </div>
      </div>
    </Transition>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <router-view v-slot="{ Component }">
          <Transition name="fade" mode="out-in">
            <component :is="Component" />
          </Transition>
        </router-view>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useColorMode } from '@vueuse/core'
import { Switch } from '@headlessui/vue'
import {
  ShieldCheckIcon,
  ArrowLeftIcon,
  Bars3Icon,
  XMarkIcon,
  ArrowUturnLeftIcon
} from '@heroicons/vue/24/outline'

import {
  SunIcon,
  MoonIcon,
} from '@heroicons/vue/20/solid'

const route = useRoute()
const flashMessage = ref(null)
const progressWidth = ref(100)
const progressInterval = ref(null)
const showMobileMenu = ref(false)
const config = window.roleManagerConfig || {}

// Dark mode setup
const mode = useColorMode()

// Computed property to handle the toggle state
const isDarkMode = computed({
  get: () => mode.value === 'dark',
  set: (value) => {
    mode.value = value ? 'dark' : 'light'
  }
})

const activeClass = 'border-indigo-500 text-slate-900 dark:text-white'
const defaultClass = 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-200'

const isActive = (path) => {
  if (path === '/') {
    return route.path === '/'
  }
  return route.path.startsWith(path)
}

const backToApplication = () => {
  // Add your logic here - example options:
  window.location.href = config.homeUrl
  console.log('Back to application clicked')
}

// Global method to show flash messages
const showFlash = (message, type = 'success') => {
  // Clear any existing interval
  if (progressInterval.value) {
    clearInterval(progressInterval.value)
  }
  
  flashMessage.value = { message, type }
  progressWidth.value = 100
  
  // Start progress bar animation
  const duration = 5000 // 5 seconds
  const interval = 50 // Update every 50ms
  const decrement = (100 / duration) * interval
  
  progressInterval.value = setInterval(() => {
    progressWidth.value -= decrement
    if (progressWidth.value <= 0) {
      clearInterval(progressInterval.value)
      flashMessage.value = null
      progressWidth.value = 100
    }
  }, interval)
}

// Flash message event listener
const handleFlashMessage = (event) => {
  const { message, type } = event.detail
  showFlash(message, type)
}

// Close mobile menu on route change
watch(() => route.path, () => {
  showMobileMenu.value = false
})

onMounted(() => {
  // Provide flash method globally
  window.showFlash = showFlash

  // Listen for flash message events
  window.addEventListener('flash-message', handleFlashMessage)

  // Emit app mounted event for loading screen
  window.dispatchEvent(new CustomEvent('role-manager-mounted'))
})

onUnmounted(() => {
  window.removeEventListener('flash-message', handleFlashMessage)
  if (progressInterval.value) {
    clearInterval(progressInterval.value)
  }
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>