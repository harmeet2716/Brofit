@php
    $user = auth()->user();
    $initials = '';
    if ($user) {
        $names = explode(' ', $user->name);
        $initials = strtoupper(substr($names[0] ?? '', 0, 1) . substr($names[1] ?? '', 0, 1));
    }
    
    $goalLabels = [
        'lose_weight' => 'Lose Weight',
        'build_muscle' => 'Build Muscle',
        'stay_fit' => 'Stay Fit',
        'improve_endurance' => 'Endurance',
    ];
    $goal = $user->fitness_goal ?? 'stay_fit';
    $goalText = $goalLabels[$goal] ?? 'FitLife';
@endphp

<div id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full md:translate-x-0 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between">
    <div class="px-5 py-6 overflow-y-auto flex-1">
        <!-- Logo -->
        <div class="flex items-center space-x-3 mb-8 px-2">
            <div class="w-10 h-10 rounded-xl bg-fit-green flex items-center justify-center text-white shadow-lg shadow-fit-green/30 animate-pulse">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div>
                <span class="text-xl font-bold tracking-wider text-gray-900 dark:text-white">Fit</span>
                <span class="text-xl font-extrabold tracking-wider text-fit-green">Nexus</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-fit-green/10 text-fit-green border-l-4 border-fit-green pl-3 dark:bg-fit-green/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                </svg>
                Dashboard
            </a>

            <!-- My Profile -->
            <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('profile.*') ? 'bg-fit-green/10 text-fit-green border-l-4 border-fit-green pl-3 dark:bg-fit-green/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                My Profile
            </a>

            <!-- Courses -->
            <a href="{{ route('courses.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('courses.*') ? 'bg-fit-green/10 text-fit-green border-l-4 border-fit-green pl-3 dark:bg-fit-green/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                Courses
            </a>

            <!-- Exercises -->
            <a href="{{ route('exercises.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('exercises.*') ? 'bg-fit-green/10 text-fit-green border-l-4 border-fit-green pl-3 dark:bg-fit-green/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Exercises
            </a>

            <!-- Daily Goals -->
            <a href="{{ route('daily-goals.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('daily-goals.*') ? 'bg-fit-green/10 text-fit-green border-l-4 border-fit-green pl-3 dark:bg-fit-green/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Daily Goals
            </a>

            <!-- Nutrition & Calories -->
            <a href="{{ route('nutrition.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('nutrition.*') ? 'bg-fit-green/10 text-fit-green border-l-4 border-fit-green pl-3 dark:bg-fit-green/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                </svg>
                Nutrition & Calories
            </a>

            <!-- AI Coach -->
            <a href="{{ route('ai-coach.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('ai-coach.*') ? 'bg-fit-green/10 text-fit-green border-l-4 border-fit-green pl-3 dark:bg-fit-green/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 113.536 0V21h2v-2.757"></path>
                </svg>
                AI Coach
            </a>
        </nav>
    </div>

    <!-- User Info Card & Logout -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/60 rounded-t-2xl">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-fit-green/20 text-fit-green font-extrabold flex items-center justify-center border border-fit-green/30">
                {{ $initials }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $user->name ?? 'Guest User' }}</p>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-fit-green/10 text-fit-green dark:bg-fit-green/20">
                    {{ $goalText }}
                </span>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-all duration-300 shadow-md shadow-red-500/25">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>
</div>
