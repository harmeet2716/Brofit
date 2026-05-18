<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title') — FitNexus</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;850;900&display=swap" rel="stylesheet">

    <!-- Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Pre-check Theme to prevent light flash -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-950 dark:text-gray-50 h-full overflow-hidden transition-all duration-300">
    <div class="flex h-full w-full">
        <!-- Left Sidebar -->
        <x-sidebar />

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col md:pl-64 h-full overflow-hidden">
            <!-- Top Sticky Navbar -->
            <x-topbar />

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">
                <!-- Breadcrumbs -->
                <nav class="flex text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 space-x-2" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-fit-green transition-colors">Home</a>
                    <span>/</span>
                    <span class="text-gray-600 dark:text-gray-300">@yield('breadcrumb', 'Dashboard')</span>
                </nav>

                <!-- Success / Error Alerts -->
                @if (session('success'))
                    <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-200 rounded-2xl bg-green-50 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800 shadow-sm" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Success</span>
                        <div>
                            <span class="font-bold">Success!</span> {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-200 rounded-2xl bg-red-50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800 shadow-sm" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Error</span>
                        <div>
                            <span class="font-bold">Error!</span> {{ session('error') }}
                        </div>
                    </div>
                @endif

                @if (Auth::user() && Auth::user()->email === 'demo@fitportal.com')
                    <div class="relative overflow-hidden bg-gradient-to-r from-fit-green/10 via-emerald-500/5 to-transparent border border-fit-green/20 dark:border-fit-green/30 rounded-3xl p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                        <div class="space-y-1">
                            <h4 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="flex h-2.5 w-2.5 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-fit-green opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-fit-green"></span>
                                </span>
                                FitNexus Guest Preview Mode
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                You are currently viewing the platform as the pre-configured <strong class="text-fit-green">Demo User</strong>. Explore training plans, nutrition managers, and custom goals instantly!
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-fit-green to-emerald-600 hover:from-fit-green-hover hover:to-emerald-700 rounded-xl transition-all duration-300 shadow-md shadow-fit-green/20 text-center">
                                Create Account
                            </a>
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl transition-all duration-300 text-center">
                                Sign In
                            </a>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
