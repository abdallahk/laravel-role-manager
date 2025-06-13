<template>
  <div class="documentation-page min-h-screen transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="flex gap-8">
        <!-- Sidebar Navigation -->
        <aside class="hidden lg:block w-64 flex-shrink-0">
          <div class="sticky top-8">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-6 shadow-xl">
              <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                <div class="w-6 h-6 bg-indigo-600 rounded-lg flex items-center justify-center mr-3">
                  <ListBulletIcon class="w-4 h-4 text-white" />
                </div>
                Contents
              </h3>
              <nav class="space-y-2">
                <a 
                  href="#overview" 
                  :class="activeSection === 'overview' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700/50'"
                  class="flex items-center px-3 py-2 text-sm font-medium rounded-lg border border-transparent transition-all duration-200"
                  @click="setActiveSection('overview')"
                >
                  <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900/50 rounded-md flex items-center justify-center mr-3 text-xs font-bold text-blue-600 dark:text-blue-400">1</div>
                  Overview
                </a>
                <a 
                  href="#installation" 
                  :class="activeSection === 'installation' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700/50'"
                  class="flex items-center px-3 py-2 text-sm font-medium rounded-lg border border-transparent transition-all duration-200"
                  @click="setActiveSection('installation')"
                >
                  <div class="w-6 h-6 bg-green-100 dark:bg-green-900/50 rounded-md flex items-center justify-center mr-3 text-xs font-bold text-green-600 dark:text-green-400">2</div>
                  Installation & Setup
                </a>
                <a 
                  href="#concepts" 
                  :class="activeSection === 'concepts' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700/50'"
                  class="flex items-center px-3 py-2 text-sm font-medium rounded-lg border border-transparent transition-all duration-200"
                  @click="setActiveSection('concepts')"
                >
                  <div class="w-6 h-6 bg-yellow-100 dark:bg-yellow-900/50 rounded-md flex items-center justify-center mr-3 text-xs font-bold text-yellow-600 dark:text-yellow-400">3</div>
                  Key Concepts
                </a>
                <a 
                  href="#features" 
                  :class="activeSection === 'features' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700/50'"
                  class="flex items-center px-3 py-2 text-sm font-medium rounded-lg border border-transparent transition-all duration-200"
                  @click="setActiveSection('features')"
                >
                  <div class="w-6 h-6 bg-purple-100 dark:bg-purple-900/50 rounded-md flex items-center justify-center mr-3 text-xs font-bold text-purple-600 dark:text-purple-400">4</div>
                  Features
                </a>
                <a 
                  href="#usage" 
                  :class="activeSection === 'usage' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700/50'"
                  class="flex items-center px-3 py-2 text-sm font-medium rounded-lg border border-transparent transition-all duration-200"
                  @click="setActiveSection('usage')"
                >
                  <div class="w-6 h-6 bg-indigo-100 dark:bg-indigo-900/50 rounded-md flex items-center justify-center mr-3 text-xs font-bold text-indigo-600 dark:text-indigo-400">5</div>
                  Usage Examples
                </a>
                <a 
                  href="#configuration" 
                  :class="activeSection === 'configuration' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700/50'"
                  class="flex items-center px-3 py-2 text-sm font-medium rounded-lg border border-transparent transition-all duration-200"
                  @click="setActiveSection('configuration')"
                >
                  <div class="w-6 h-6 bg-orange-100 dark:bg-orange-900/50 rounded-md flex items-center justify-center mr-3 text-xs font-bold text-orange-600 dark:text-orange-400">6</div>
                  Configuration
                </a>
                <a 
                  href="#api" 
                  :class="activeSection === 'api' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700/50'"
                  class="flex items-center px-3 py-2 text-sm font-medium rounded-lg border border-transparent transition-all duration-200"
                  @click="setActiveSection('api')"
                >
                  <div class="w-6 h-6 bg-emerald-100 dark:bg-emerald-900/50 rounded-md flex items-center justify-center mr-3 text-xs font-bold text-emerald-600 dark:text-emerald-400">7</div>
                  API Reference
                </a>
              </nav>
              
              <!-- Progress Indicator -->
              <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                <div class="text-xs font-medium text-slate-500 dark:text-slate-400 mb-2">Reading Progress</div>
                <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                  <div 
                    class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full transition-all duration-300 ease-out"
                    :style="{ width: `${scrollProgress}%` }"
                  ></div>
                </div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ Math.round(scrollProgress) }}% complete</div>
              </div>
            </div>
          </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
      <!-- Hero Header -->
      <div class="text-center mb-16">
        <div class="relative inline-flex items-center justify-center w-20 h-20 mb-8">
          <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500 rounded-3xl transform rotate-3 opacity-20"></div>
          <div class="relative w-16 h-16 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500 rounded-2xl flex items-center justify-center shadow-xl">
            <DocumentTextIcon class="w-8 h-8 text-white drop-shadow-sm" />
          </div>
        </div>
        <h1 class="text-5xl font-bold bg-gradient-to-r from-slate-900 via-indigo-800 to-purple-800 dark:from-white dark:via-indigo-200 dark:to-purple-200 bg-clip-text text-transparent mb-6">
          Role Manager Documentation
        </h1>
        <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
          A comprehensive guide to managing roles and permissions using the Laravel Spatie Permissions package with our intuitive UI interface.
        </p>
      </div>

      <!-- Spatie Credit Card -->
      <div class="relative mb-12">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-3xl transform rotate-1 opacity-10"></div>
        <div class="relative bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 border border-emerald-200/50 dark:border-emerald-700/50 rounded-2xl p-8 backdrop-blur-sm">
          <div class="flex items-start space-x-6">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg">
                <HeartIcon class="w-6 h-6 text-white" />
              </div>
            </div>
            <div class="flex-1">
              <h3 class="text-xl font-bold text-emerald-800 dark:text-emerald-200 mb-3">
                Built with ❤️ using Spatie Laravel Permission
              </h3>
              <p class="text-emerald-700 dark:text-emerald-300 mb-4 leading-relaxed">
                This Role Manager is a UI wrapper around the excellent <strong>Laravel Permission</strong> package by 
                <a href="https://spatie.be" target="_blank" rel="noopener" class="font-semibold underline decoration-2 underline-offset-2 hover:text-emerald-800 dark:hover:text-emerald-200 transition-colors">
                  Spatie
                </a>. 
                All the core functionality is powered by their robust and well-tested package.
              </p>
              <div class="flex flex-wrap gap-3">
                <a 
                  href="https://github.com/spatie/laravel-permission" 
                  target="_blank" 
                  rel="noopener"
                  class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-xl hover:bg-emerald-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg"
                >
                  <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path>
                  </svg>
                  GitHub
                </a>
                <a 
                  href="https://spatie.be/docs/laravel-permission" 
                  target="_blank" 
                  rel="noopener"
                  class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-emerald-200 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 text-sm font-medium rounded-xl hover:bg-emerald-50 dark:hover:bg-slate-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg"
                >
                  <DocumentTextIcon class="w-4 h-4 mr-2" />
                  Official Docs
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Table of Contents -->
      <div class="relative mb-12">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl transform -rotate-1"></div>
        <div class="relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl">
          <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center mr-3">
              <ListBulletIcon class="w-5 h-5 text-white" />
            </div>
            Table of Contents
          </h2>
          <nav class="grid md:grid-cols-2 gap-4">
            <a href="#overview" class="group flex items-center p-3 rounded-xl text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200">
              <span class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">1</span>
              Overview
            </a>
            <a href="#installation" class="group flex items-center p-3 rounded-xl text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200">
              <span class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">2</span>
              Installation & Setup
            </a>
            <a href="#concepts" class="group flex items-center p-3 rounded-xl text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200">
              <span class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">3</span>
              Key Concepts
            </a>
            <a href="#features" class="group flex items-center p-3 rounded-xl text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200">
              <span class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">4</span>
              Features
            </a>
            <a href="#usage" class="group flex items-center p-3 rounded-xl text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200">
              <span class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">5</span>
              Usage Examples
            </a>
            <a href="#configuration" class="group flex items-center p-3 rounded-xl text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200">
              <span class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">6</span>
              Configuration
            </a>
            <a href="#api" class="group flex items-center p-3 rounded-xl text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-200">
              <span class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">7</span>
              API Reference
            </a>
          </nav>
        </div>
      </div>

      <!-- Content Sections -->
      <div class="space-y-12">
        <!-- Overview -->
        <section id="overview" class="scroll-mt-8">
          <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8 flex items-center">
              <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                <InformationCircleIcon class="w-6 h-6 text-white" />
              </div>
              Overview
            </h2>
            <div class="prose prose-lg dark:prose-invert max-w-none">
              <p class="text-slate-600 dark:text-slate-300 mb-6 text-lg leading-relaxed">
                This Role Manager provides a clean, intuitive web interface for managing Laravel applications' roles and permissions. 
                It's built on top of the <strong class="text-slate-900 dark:text-white">Spatie Laravel Permission</strong> package, which is the industry standard for 
                implementing role-based access control (RBAC) in Laravel applications.
              </p>
              <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed">
                The Spatie package offers a flexible and powerful way to manage user permissions through roles and direct permission assignments, 
                supporting complex permission structures while maintaining excellent performance.
              </p>
            </div>
          </div>
        </section>

        <!-- Installation -->
        <section id="installation" class="scroll-mt-8">
          <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8 flex items-center">
              <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center mr-4">
                <CommandLineIcon class="w-6 h-6 text-white" />
              </div>
              Installation & Setup
            </h2>
            
            <!-- Quick Install Section -->
            <div class="relative mb-10">
              <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-400 rounded-2xl transform rotate-1 opacity-10"></div>
              <div class="relative bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border border-green-200/50 dark:border-green-700/50 rounded-xl p-8">
                <h3 class="text-xl font-bold text-green-800 dark:text-green-200 mb-6 flex items-center">
                  <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                    <CheckIcon class="w-5 h-5 text-white" />
                  </div>
                  Quick Installation
                </h3>
                <p class="text-green-700 dark:text-green-300 mb-6 text-lg">
                  For a complete setup with our Role Manager UI, run these commands in sequence:
                </p>
                <div class="bg-slate-900 dark:bg-black rounded-2xl p-6 font-mono text-sm space-y-4 shadow-inner">
                  <div class="flex items-center">
                    <span class="text-green-400 mr-4 font-bold">$</span>
                    <code class="text-slate-100">composer require abdallahk/laravel-role-manager</code>
                  </div>
                  <div class="flex items-center">
                    <span class="text-green-400 mr-4 font-bold">$</span>
                    <code class="text-slate-100">php artisan migrate</code>
                  </div>
                  <div class="flex items-center">
                    <span class="text-green-400 mr-4 font-bold">$</span>
                    <code class="text-slate-100">php artisan role-manager:install --force</code>
                  </div>
                  <div class="flex items-center">
                    <span class="text-green-400 mr-4 font-bold">$</span>
                    <code class="text-slate-100">php artisan role-manager:publish --force</code>
                  </div>
                </div>
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-xl">
                  <p class="text-blue-700 dark:text-blue-300 flex items-start">
                    <InformationCircleIcon class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" />
                    <span><strong>Note:</strong> This package automatically installs the Spatie Laravel Permission package as a dependency. But you need to add the <code class="bg-blue-100 dark:bg-blue-800 px-2 py-1 rounded">HasRoles</code> trait to your User model.</span>
                  </p>
                </div>
              </div>
            </div>

            <!-- Command Explanations -->
            <div class="bg-slate-50 dark:bg-slate-900/50 rounded-2xl p-8 border border-slate-200 dark:border-slate-700">
              <h4 class="font-bold text-slate-900 dark:text-white mb-6 text-lg">Command Explanations</h4>
              <div class="grid md:grid-cols-2 gap-6">
                <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center">
                    <CommandLineIcon class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                  </div>
                  <div>
                    <code class="bg-indigo-100 dark:bg-indigo-900/50 px-3 py-1 rounded-lg text-indigo-700 dark:text-indigo-300 font-mono text-sm">role-manager:install</code>
                    <p class="text-slate-600 dark:text-slate-300 mt-2">Installs required assets, publishes configuration files, and sets up routes</p>
                  </div>
                </div>
                <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0 w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-xl flex items-center justify-center">
                    <DocumentTextIcon class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                  </div>
                  <div>
                    <code class="bg-purple-100 dark:bg-purple-900/50 px-3 py-1 rounded-lg text-purple-700 dark:text-purple-300 font-mono text-sm">role-manager:publish</code>
                    <p class="text-slate-600 dark:text-slate-300 mt-2">Publishes Vue components, CSS assets, and JavaScript files for customization</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Key Concepts -->
        <section id="concepts" class="scroll-mt-8">
          <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8 flex items-center">
              <div class="w-10 h-10 bg-yellow-600 rounded-xl flex items-center justify-center mr-4">
                <LightBulbIcon class="w-6 h-6 text-white" />
              </div>
              Key Concepts
            </h2>
            <div class="grid md:grid-cols-2 gap-8">
              <div class="group">
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-2xl p-6 border border-indigo-200/50 dark:border-indigo-700/50 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                  <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mr-4">
                      <ShieldCheckIcon class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Permissions</h3>
                  </div>
                  <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Permissions are granular actions or capabilities that can be assigned to users or roles. 
                    Examples: 'edit posts', 'delete users', 'view reports'.
                  </p>
                </div>
              </div>
              
              <div class="group">
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-2xl p-6 border border-green-200/50 dark:border-green-700/50 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                  <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mr-4">
                      <UsersIcon class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Roles</h3>
                  </div>
                  <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Roles are collections of permissions that can be assigned to users. 
                    Examples: 'admin', 'editor', 'viewer'. Users can have multiple roles.
                  </p>
                </div>
              </div>
              
              <div class="group">
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-2xl p-6 border border-blue-200/50 dark:border-blue-700/50 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                  <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                      <UserIcon class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Users</h3>
                  </div>
                  <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Users can be assigned roles and/or direct permissions. Direct permissions override role permissions.
                  </p>
                </div>
              </div>
              
              <div class="group">
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 rounded-2xl p-6 border border-purple-200/50 dark:border-purple-700/50 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                  <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mr-4">
                      <CogIcon class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Guards</h3>
                  </div>
                  <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Guards separate permissions for different authentication systems (web, api, etc.). 
                    Permissions are guard-specific.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Features -->
        <section id="features" class="scroll-mt-8">
          <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8 flex items-center">
              <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center mr-4">
                <StarIcon class="w-6 h-6 text-white" />
              </div>
              Features
            </h2>
            <div class="grid md:grid-cols-2 gap-8">
              <div class="space-y-6">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center">
                  <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center mr-3">
                    <ShieldCheckIcon class="w-5 h-5 text-white" />
                  </div>
                  Role Management
                </h3>
                <ul class="space-y-3">
                  <li class="flex items-center text-slate-600 dark:text-slate-300">
                    <CheckIcon class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" />
                    Create, edit, and delete roles
                  </li>
                  <li class="flex items-center text-slate-600 dark:text-slate-300">
                    <CheckIcon class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" />
                    Assign permissions to roles
                  </li>
                  <li class="flex items-center text-slate-600 dark:text-slate-300">
                    <CheckIcon class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" />
                    Role hierarchy support
                  </li>
                  <li class="flex items-center text-slate-600 dark:text-slate-300">
                    <CheckIcon class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" />
                    Bulk operations
                  </li>
                </ul>
              </div>
              
              <div class="space-y-6">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center">
                  <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                    <CogIcon class="w-5 h-5 text-white" />
                  </div>
                  Permission Management
                </h3>
                <ul class="space-y-3">
                  <li class="flex items-center text-slate-600 dark:text-slate-300">
                    <CheckIcon class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" />
                    Create and organize permissions
                  </li>
                  <li class="flex items-center text-slate-600 dark:text-slate-300">
                    <CheckIcon class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" />
                    Permission categories
                  </li>
                  <li class="flex items-center text-slate-600 dark:text-slate-300">
                    <CheckIcon class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" />
                    Search and filter capabilities
                  </li>
                  <li class="flex items-center text-slate-600 dark:text-slate-300">
                    <CheckIcon class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" />
                    Usage tracking
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>

        <!-- Usage Examples -->
        <section id="usage" class="scroll-mt-8">
          <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8 flex items-center">
              <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center mr-4">
                <CodeBracketIcon class="w-6 h-6 text-white" />
              </div>
              Usage Examples
            </h2>
            <div class="space-y-8">
              <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Checking Permissions in Blade</h3>
                <div class="bg-slate-900 dark:bg-black rounded-2xl p-6 font-mono text-sm shadow-inner overflow-x-auto">
                  <code class="text-slate-100">
                    <span class="text-purple-400">@can</span>(<span class="text-green-400">'edit posts'</span>)<br/>
                    &nbsp;&nbsp;<span class="text-blue-400">&lt;button&gt;</span>Edit Post<span class="text-blue-400">&lt;/button&gt;</span><br/>
                    <span class="text-purple-400">@endcan</span>
                  </code>
                </div>
              </div>
              
              <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Checking Roles in Controllers</h3>
                <div class="bg-slate-900 dark:bg-black rounded-2xl p-6 font-mono text-sm shadow-inner overflow-x-auto">
                  <code class="text-slate-100">
                    <span class="text-purple-400">if</span> (<span class="text-yellow-400">$user</span>-><span class="text-blue-400">hasRole</span>(<span class="text-green-400">'admin'</span>)) {<br/>
                    &nbsp;&nbsp;<span class="text-gray-400">// Admin logic here</span><br/>
                    }
                  </code>
                </div>
              </div>

              <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Assigning Permissions</h3>
                <div class="bg-slate-900 dark:bg-black rounded-2xl p-6 font-mono text-sm shadow-inner overflow-x-auto">
                  <code class="text-slate-100">
                    <span class="text-yellow-400">$user</span>-><span class="text-blue-400">givePermissionTo</span>(<span class="text-green-400">'edit posts'</span>);<br/>
                    <span class="text-yellow-400">$role</span>-><span class="text-blue-400">givePermissionTo</span>([<span class="text-green-400">'create posts'</span>, <span class="text-green-400">'edit posts'</span>]);
                  </code>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Configuration -->
        <section id="configuration" class="scroll-mt-8">
          <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8 flex items-center">
              <div class="w-10 h-10 bg-orange-600 rounded-xl flex items-center justify-center mr-4">
                <CogIcon class="w-6 h-6 text-white" />
              </div>
              Configuration
            </h2>
            
            <p class="text-slate-600 dark:text-slate-300 mb-8 text-lg leading-relaxed">
              The Role Manager can be extensively customized through the <code class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">config/role-manager.php</code> configuration file. 
              Here's a comprehensive guide to all available options:
            </p>

            <div class="space-y-8">
              <!-- Route Configuration -->
              <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-xl p-6 border border-blue-200/50 dark:border-blue-700/50">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                  <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  Route Configuration
                </h3>
                <div class="grid md:grid-cols-2 gap-4">
                  <div>
                    <h4 class="font-semibold text-slate-900 dark:text-white mb-2">route_prefix</h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">The URL prefix for all Role Manager routes.</p>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-sm">
                      <code class="text-slate-100">'route_prefix' => 'role-manager'</code>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Access at: /role-manager</p>
                  </div>
                  <div>
                    <h4 class="font-semibold text-slate-900 dark:text-white mb-2">middleware</h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">Middleware applied to all Role Manager routes.</p>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-sm">
                      <code class="text-slate-100">'middleware' => ['web', 'auth']</code>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Requires authentication by default</p>
                  </div>
                </div>
              </div>

              <!-- Authorization Configuration -->
              <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/30 dark:to-orange-900/30 rounded-xl p-6 border border-red-200/50 dark:border-red-700/50">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                  <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center mr-3">
                    <ShieldCheckIcon class="w-5 h-5 text-white" />
                  </div>
                  Authorization Configuration
                </h3>
                <p class="text-slate-600 dark:text-slate-300 mb-4">Control who can access the Role Manager UI with multiple authorization methods:</p>
                
                <div class="grid md:grid-cols-2 gap-6">
                  <div class="space-y-4">
                    <div>
                      <h4 class="font-semibold text-slate-900 dark:text-white mb-2">allowed_user_ids</h4>
                      <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">Specific user IDs that can access the manager.</p>
                      <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-sm">
                        <code class="text-slate-100">'allowed_user_ids' => [1, 2, 3]</code>
                      </div>
                    </div>
                    
                    <div>
                      <h4 class="font-semibold text-slate-900 dark:text-white mb-2">allowed_domains</h4>
                      <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">Email domains that are allowed access.</p>
                      <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-sm">
                        <code class="text-slate-100">'allowed_domains' => ['yourcompany.com']</code>
                      </div>
                    </div>
                  </div>
                  
                  <div class="space-y-4">
                    <div>
                      <h4 class="font-semibold text-slate-900 dark:text-white mb-2">required_roles</h4>
                      <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">Users must have one of these roles.</p>
                      <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-sm">
                        <code class="text-slate-100">'required_roles' => ['admin', 'super-admin']</code>
                      </div>
                    </div>
                    
                    <div>
                      <h4 class="font-semibold text-slate-900 dark:text-white mb-2">custom_callback</h4>
                      <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">Custom authorization logic.</p>
                      <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-sm">
                        <code class="text-slate-100">'custom_callback' => function($user) {<br/>&nbsp;&nbsp;return $user->isAdmin();<br/>}</code>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- UI Configuration -->
              <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 rounded-xl p-6 border border-purple-200/50 dark:border-purple-700/50">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                  <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M13 7.343V15a2 2 0 002 2h4"></path>
                    </svg>
                  </div>
                  UI Configuration
                </h3>
                <div class="grid md:grid-cols-2 gap-4">
                  <div>
                    <h4 class="font-semibold text-slate-900 dark:text-white mb-2">title</h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">The application title displayed in the header.</p>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-sm">
                      <code class="text-slate-100">'title' => 'Role Manager'</code>
                    </div>
                  </div>
                  <div>
                    <h4 class="font-semibold text-slate-900 dark:text-white mb-2">show_docs</h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">Whether to show the documentation link.</p>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-sm">
                      <code class="text-slate-100">'show_docs' => true</code>
                    </div>
                  </div>
                  <div>
                    <h4 class="font-semibold text-slate-900 dark:text-white mb-2">theme</h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">The UI theme to use.</p>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-sm">
                      <code class="text-slate-100">'theme' => 'default'</code>
                    </div>
                  </div>
                  <div>
                    <h4 class="font-semibold text-slate-900 dark:text-white mb-2">per_page</h4>
                    <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">Default number of items per page.</p>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-sm">
                      <code class="text-slate-100">'per_page' => 15</code>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Permissions and Models Configuration -->
              <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-xl p-6 border border-green-200/50 dark:border-green-700/50">
                  <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                      <CheckIcon class="w-5 h-5 text-white" />
                    </div>
                    Permissions
                  </h3>
                  <p class="text-slate-600 dark:text-slate-300 text-sm mb-4">Default permission names used by the system:</p>
                  <div class="space-y-3">
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-xs">
                      <code class="text-slate-100">'manage_roles' => 'manage roles'</code>
                    </div>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-xs">
                      <code class="text-slate-100">'manage_permissions' => 'manage permissions'</code>
                    </div>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-xs">
                      <code class="text-slate-100">'assign_roles' => 'assign roles to users'</code>
                    </div>
                  </div>
                </div>

                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/30 dark:to-blue-900/30 rounded-xl p-6 border border-indigo-200/50 dark:border-indigo-700/50">
                  <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center mr-3">
                      <UserIcon class="w-5 h-5 text-white" />
                    </div>
                    Models
                  </h3>
                  <p class="text-slate-600 dark:text-slate-300 text-sm mb-4">Model classes used by the system:</p>
                  <div class="space-y-3">
                    <div>
                      <h4 class="font-semibold text-slate-900 dark:text-white mb-2 text-sm">User Model</h4>
                      <div class="bg-slate-900 dark:bg-black rounded-lg p-3 font-mono text-xs">
                        <code class="text-slate-100">'user' => \App\Models\User::class</code>
                      </div>
                      <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Must use HasRoles trait</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Configuration Examples -->
              <div class="bg-slate-50 dark:bg-slate-900/50 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Common Configuration Examples</h3>
                
                <div class="space-y-6">
                  <div>
                    <h4 class="font-semibold text-slate-900 dark:text-white mb-3">Restrict Access to Admins Only</h4>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-4 font-mono text-sm">
                      <code class="text-slate-100">
                        'authorization' => [<br/>
                        &nbsp;&nbsp;'required_roles' => ['admin'],<br/>
                        &nbsp;&nbsp;'required_permissions' => ['access-admin-panel'],<br/>
                        ],
                      </code>
                    </div>
                  </div>

                  <div>
                    <h4 class="font-semibold text-slate-900 dark:text-white mb-3">Company Domain Restriction</h4>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-4 font-mono text-sm">
                      <code class="text-slate-100">
                        'authorization' => [<br/>
                        &nbsp;&nbsp;'allowed_domains' => ['yourcompany.com'],<br/>
                        &nbsp;&nbsp;'custom_callback' => function ($user) {<br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;return $user->hasVerifiedEmail();<br/>
                        &nbsp;&nbsp;},<br/>
                        ],
                      </code>
                    </div>
                  </div>

                  <div>
                    <h4 class="font-semibold text-slate-900 dark:text-white mb-3">Custom Route and UI Settings</h4>
                    <div class="bg-slate-900 dark:bg-black rounded-lg p-4 font-mono text-sm">
                      <code class="text-slate-100">
                        'route_prefix' => 'admin/roles',<br/>
                        'middleware' => ['web', 'auth', 'admin'],<br/>
                        'ui' => [<br/>
                        &nbsp;&nbsp;'title' => 'Admin Panel - Roles',<br/>
                        &nbsp;&nbsp;'show_docs' => false,<br/>
                        &nbsp;&nbsp;'per_page' => 25,<br/>
                        ],
                      </code>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section id="api" class="scroll-mt-8">
          <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8 flex items-center">
              <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center mr-4">
                <CommandLineIcon class="w-6 h-6 text-white" />
              </div>
              Common API Methods
            </h2>
            <div class="grid md:grid-cols-2 gap-8">
              <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                  <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                    <UserIcon class="w-5 h-5 text-white" />
                  </div>
                  User Methods
                </h3>
                <div class="space-y-4">
                  <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-xl p-4 border border-blue-200/50 dark:border-blue-700/50">
                    <code class="text-blue-700 dark:text-blue-300 font-mono text-sm font-semibold">$user->assignRole('role')</code>
                    <p class="text-slate-600 dark:text-slate-300 mt-2 text-sm">Assign a role to user</p>
                  </div>
                  <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-xl p-4 border border-blue-200/50 dark:border-blue-700/50">
                    <code class="text-blue-700 dark:text-blue-300 font-mono text-sm font-semibold">$user->hasPermissionTo('permission')</code>
                    <p class="text-slate-600 dark:text-slate-300 mt-2 text-sm">Check if user has permission</p>
                  </div>
                  <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-xl p-4 border border-blue-200/50 dark:border-blue-700/50">
                    <code class="text-blue-700 dark:text-blue-300 font-mono text-sm font-semibold">$user->getAllPermissions()</code>
                    <p class="text-slate-600 dark:text-slate-300 mt-2 text-sm">Get all user permissions</p>
                  </div>
                </div>
              </div>
              
              <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                  <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                    <ShieldCheckIcon class="w-5 h-5 text-white" />
                  </div>
                  Role Methods
                </h3>
                <div class="space-y-4">
                  <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-xl p-4 border border-green-200/50 dark:border-green-700/50">
                    <code class="text-green-700 dark:text-green-300 font-mono text-sm font-semibold">Role::create(['name' => 'writer'])</code>
                    <p class="text-slate-600 dark:text-slate-300 mt-2 text-sm">Create a new role</p>
                  </div>
                  <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-xl p-4 border border-green-200/50 dark:border-green-700/50">
                    <code class="text-green-700 dark:text-green-300 font-mono text-sm font-semibold">$role->givePermissionTo('permission')</code>
                    <p class="text-slate-600 dark:text-slate-300 mt-2 text-sm">Give permission to role</p>
                  </div>
                  <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-xl p-4 border border-green-200/50 dark:border-green-700/50">
                    <code class="text-green-700 dark:text-green-300 font-mono text-sm font-semibold">$role->revokePermissionTo('permission')</code>
                    <p class="text-slate-600 dark:text-slate-300 mt-2 text-sm">Revoke permission from role</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Footer -->
      <div class="mt-16 text-center py-12">
        <div class="relative">
          <div class="absolute inset-0 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl transform rotate-1"></div>
          <div class="relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
              <HeartIcon class="w-8 h-8 text-white" />
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Need More Help?</h3>
            <p class="text-slate-600 dark:text-slate-300 mb-6 max-w-2xl mx-auto">
              For more detailed information and advanced usage patterns, visit the official Spatie Laravel Permission documentation.
            </p>
            <a 
              href="https://spatie.be/docs/laravel-permission" 
              target="_blank" 
              rel="noopener" 
              class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl"
            >
              <DocumentTextIcon class="w-5 h-5 mr-2" />
              Official Documentation
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { 
  DocumentTextIcon,
  HeartIcon,
  InformationCircleIcon,
  CommandLineIcon,
  LightBulbIcon,
  StarIcon,
  CodeBracketIcon,
  ListBulletIcon,
  ShieldCheckIcon,
  UsersIcon,
  UserIcon,
  CogIcon,
  CheckIcon
} from '@heroicons/vue/24/outline'

const activeSection = ref('overview')
const scrollProgress = ref(0)

const setActiveSection = (section) => {
  activeSection.value = section
}

const updateScrollProgress = () => {
  const scrollTop = window.pageYOffset || document.documentElement.scrollTop
  const scrollHeight = document.documentElement.scrollHeight - window.innerHeight
  const progress = (scrollTop / scrollHeight) * 100
  scrollProgress.value = Math.min(100, Math.max(0, progress))
}

const handleScroll = () => {
  updateScrollProgress()
  
  // Update active section based on scroll position
  const sections = ['overview', 'installation', 'concepts', 'features', 'usage', 'configuration', 'api']
  const scrollTop = window.pageYOffset + 100 // Offset for better UX
  
  for (let i = sections.length - 1; i >= 0; i--) {
    const element = document.getElementById(sections[i])
    if (element && element.offsetTop <= scrollTop) {
      activeSection.value = sections[i]
      break
    }
  }
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  updateScrollProgress()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.documentation-page {
  scroll-behavior: smooth;
}

.prose {
  line-height: 1.8;
}

.prose code {
  background-color: theme('colors.slate.100');
  padding: 0.125rem 0.375rem;
  border-radius: 0.375rem;
  font-size: 0.875em;
  font-weight: 600;
}

.dark .prose code {
  background-color: theme('colors.slate.800');
  color: theme('colors.slate.200');
}

/* Smooth scrolling for anchor links */
html {
  scroll-behavior: smooth;
}

/* Enhanced scrollbar styling */
.documentation-page::-webkit-scrollbar {
  width: 10px;
}

.documentation-page::-webkit-scrollbar-track {
  background: theme('colors.slate.100');
  border-radius: 10px;
}

.documentation-page::-webkit-scrollbar-thumb {
  background: linear-gradient(180deg, theme('colors.indigo.400'), theme('colors.purple.500'));
  border-radius: 10px;
  border: 2px solid theme('colors.slate.100');
}

.documentation-page::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(180deg, theme('colors.indigo.500'), theme('colors.purple.600'));
}

.dark .documentation-page::-webkit-scrollbar-track {
  background: theme('colors.slate.800');
}

.dark .documentation-page::-webkit-scrollbar-thumb {
  background: linear-gradient(180deg, theme('colors.indigo.600'), theme('colors.purple.700'));
  border-color: theme('colors.slate.800');
}

.dark .documentation-page::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(180deg, theme('colors.indigo.500'), theme('colors.purple.600'));
}

/* Scroll margin for anchor navigation */
.scroll-mt-8 {
  scroll-margin-top: 2rem;
}

/* Enhanced animations */
@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-10px) rotate(1deg); }
}

.group:hover .animate-float {
  animation: float 3s ease-in-out infinite;
}

/* Code syntax highlighting improvements */
.documentation-page pre {
  overflow-x: auto;
  scrollbar-width: thin;
  scrollbar-color: theme('colors.slate.600') theme('colors.slate.800');
}

.documentation-page pre::-webkit-scrollbar {
  height: 6px;
}

.documentation-page pre::-webkit-scrollbar-track {
  background: theme('colors.slate.800');
}

.documentation-page pre::-webkit-scrollbar-thumb {
  background: theme('colors.slate.600');
  border-radius: 3px;
}
</style>