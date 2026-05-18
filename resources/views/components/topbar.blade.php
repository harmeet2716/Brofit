@php
    $user = auth()->user();
    $initials = '';
    if ($user) {
        $names = explode(' ', $user->name);
        $initials = strtoupper(substr($names[0] ?? '', 0, 1) . (isset($names[1]) ? substr($names[1], 0, 1) : ''));
    }
@endphp

<header class="sticky top-0 z-30 flex items-center justify-between w-full h-16 px-6 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 transition-all duration-300">
    <div class="flex items-center space-x-3">
        <!-- Hamburger Menu Toggle (Mobile) -->
        <button id="hamburger" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 md:hidden hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none" aria-label="Toggle Navigation">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <!-- Page Title -->
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">
            @yield('page_title', 'FitNexus')
        </h1>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Dark Mode Toggle -->
        <x-dark-mode-toggle />

        <!-- Notification Bell (Static UI) -->
        <button class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none" aria-label="Notifications">
            <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-fit-green animate-ping"></span>
            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-fit-green"></span>
        </button>

        <!-- User Dropdown (Avatar) -->
        <div class="relative">
            <button id="user-dropdown-btn" class="flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-fit-green rounded-full p-0.5" aria-expanded="false">
                <div class="w-9 h-9 rounded-full bg-fit-green text-white font-bold flex items-center justify-center border border-fit-green/30 text-sm">
                    {{ $initials }}
                </div>
            </button>
            
            <!-- Dropdown Menu -->
            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 text-gray-700 dark:text-gray-200">
                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $user->name ?? 'Guest User' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email ?? 'guest@fitportal.com' }}</p>
                </div>
                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">My Profile</a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Edit Settings</a>
                <div class="border-t border-gray-100 dark:border-gray-700"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hamburgerBtn = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const userDropdownBtn = document.getElementById('user-dropdown-btn');
        const userDropdown = document.getElementById('user-dropdown');

        // Toggle sidebar on mobile
        if (hamburgerBtn && sidebar) {
            hamburgerBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                sidebar.classList.toggle('-translate-x-full');
            });
            
            // Close sidebar when clicking outside
            document.addEventListener('click', function (e) {
                if (window.innerWidth < 768 && !sidebar.contains(e.target) && e.target !== hamburgerBtn) {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        }

        // Toggle user dropdown
        if (userDropdownBtn && userDropdown) {
            userDropdownBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function () {
                userDropdown.classList.add('hidden');
            });
        }
    });
</script>
