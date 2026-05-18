<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FitNexus') }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;850;900&display=swap" rel="stylesheet">

    <!-- Pre-check Theme -->
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
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-950 dark:text-gray-50 h-full flex items-center justify-center p-4 transition-all duration-300">
    <div class="w-full max-w-lg bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-800 shadow-2xl rounded-3xl overflow-hidden p-8 space-y-6">
        <!-- Logo -->
        <div class="flex flex-col items-center text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-fit-green flex items-center justify-center text-white shadow-lg shadow-fit-green/30 animate-bounce">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div>
                <span class="text-2xl font-bold tracking-wider text-gray-900 dark:text-white">Fit</span>
                <span class="text-2xl font-extrabold tracking-wider text-fit-green">Nexus</span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Your premium gateway to health and absolute peak performance</p>
        </div>

        <!-- Slot Content -->
        <div class="mt-4">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
