<x-guest-layout>
    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-1">Welcome Back</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Sign in to continue your fitness journey</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-3 text-sm text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded-xl border border-green-200 dark:border-green-800">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green focus:border-transparent outline-none transition-all duration-200 text-sm">
            @error('email')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-fit-green hover:text-fit-green-dark font-semibold transition-colors">Forgot password?</a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green focus:border-transparent outline-none transition-all duration-200 text-sm">
            @error('password')
                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 text-fit-green border-gray-300 rounded focus:ring-fit-green dark:bg-gray-700 dark:border-gray-600">
            <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-3.5 px-4 bg-fit-green hover:bg-fit-green-dark text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-fit-green/30 transform hover:scale-[1.01] text-sm tracking-wide">
            Sign In to FitNexus
        </button>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-fit-green hover:text-fit-green-dark font-bold transition-colors">Create one free</a>
        </p>
    </form>
</x-guest-layout>
