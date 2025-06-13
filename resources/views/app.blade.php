<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('role-manager.ui.title', 'Role Manager') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Role Manager Styles (Vite Built) -->
    @php
        $manifest = null;
        $manifestPath = public_path('vendor/role-manager/manifest.json');
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
        }
        
        $cssFile = $manifest ? ($manifest['resources/js/app.js']['css'][0] ?? 'app.css') : 'app.css';
        $jsFile = $manifest ? ($manifest['resources/js/app.js']['file'] ?? 'app.js') : 'app.js';
    @endphp
    
    <link href="{{ asset('vendor/role-manager/' . $cssFile) }}" rel="stylesheet">
    
    <style>
        /* Critical CSS for loading state */
        .loading-spinner {
            border: 4px solid #f3f4f6;
            border-top: 4px solid #4f46e5;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Prevent FOUC */
        #role-manager-app {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        #role-manager-app.loaded {
            opacity: 1;
        }
    </style>
</head>
<body class="font-sans antialiased bg-slate-100">
    <!-- Loading screen -->
    <div id="loading-screen" class="fixed inset-0 bg-white flex items-center justify-center z-50">
        <div class="text-center">
            <div class="loading-spinner mx-auto mb-4"></div>
            <p class="text-slate-600">Loading Role Manager...</p>
        </div>
    </div>
    
    <!-- Vue App Mount Point -->
    <div id="role-manager-app"></div>
    
    <!-- Global Configuration -->
    <script>
        window.roleManagerConfig = {
            baseUrl: '{{ config("role-manager.route_prefix", "role-manager") }}',
            csrfToken: '{{ csrf_token() }}',
            title: '{{ config("role-manager.ui.title", "Role Manager") }}',
            showDocs: '{{ config("role-manager.ui.show_docs", true) }}',
            perPage: {{ config('role-manager.ui.per_page', 15) }},
            apiUrl: '{{ url(config("role-manager.route_prefix", "role-manager")) }}/api',
            version: '{{ config("role-manager.version", "1.0.0") }}',
            homeUrl: '{{ config("role-manager.ui.home_url", "/dashboard") }}',
            
        };
    </script>
    
    <!-- Role Manager Scripts (Vite Built) -->
    <script src="{{ asset('vendor/role-manager/' . $jsFile) }}" defer></script>
    
    <script>
        // Enhanced app initialization with proper loading handling
        document.addEventListener('DOMContentLoaded', function() {
            let appInitialized = false;
            
            // Check for app initialization
            const checkApp = setInterval(() => {
                const app = document.getElementById('role-manager-app');
                const loadingScreen = document.getElementById('loading-screen');
                
                if (app && (app.children.length > 0 || appInitialized)) {
                    app.classList.add('loaded');
                    if (loadingScreen) {
                        loadingScreen.style.opacity = '0';
                        setTimeout(() => {
                            loadingScreen.style.display = 'none';
                        }, 300);
                    }
                    clearInterval(checkApp);
                }
            }, 100);
            
            // Fallback: hide loading screen after reasonable time
            setTimeout(() => {
                const loadingScreen = document.getElementById('loading-screen');
                if (loadingScreen && loadingScreen.style.display !== 'none') {
                    console.warn('Role Manager: App initialization timeout, hiding loading screen');
                    loadingScreen.style.display = 'none';
                    document.getElementById('role-manager-app').classList.add('loaded');
                }
                clearInterval(checkApp);
            }, 5000);
            
            // Listen for Vue app mounted event
            window.addEventListener('role-manager-mounted', () => {
                appInitialized = true;
            });
        });
    </script>
</body>
</html>