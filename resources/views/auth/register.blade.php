<x-guest-layout>
    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-1">Create Your Account</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Start your fitness transformation today</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green focus:border-transparent outline-none transition-all duration-200 text-sm">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green focus:border-transparent outline-none transition-all duration-200 text-sm">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green focus:border-transparent outline-none transition-all duration-200 text-sm">
            <p class="text-xs text-gray-400 mt-1">Min 8 chars, uppercase, number & special character.</p>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green focus:border-transparent outline-none transition-all duration-200 text-sm">
            @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Age / Height / Weight (3 columns) -->
        <div class="grid grid-cols-3 gap-3">
            <div>
                <label for="age" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Age</label>
                <input id="age" type="number" name="age" value="{{ old('age') }}" min="13" max="100" required
                    class="w-full px-3 py-3 rounded-xl border {{ $errors->has('age') ? 'border-red-500' : 'border-gray-200 dark:border-gray-700' }} bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
                @error('age')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="height_cm" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Height (cm)</label>
                <input id="height_cm" type="number" name="height_cm" value="{{ old('height_cm') }}" min="100" max="250" step="0.1" required
                    class="w-full px-3 py-3 rounded-xl border {{ $errors->has('height_cm') ? 'border-red-500' : 'border-gray-200 dark:border-gray-700' }} bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
                @error('height_cm')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="weight_kg" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Weight (kg)</label>
                <input id="weight_kg" type="number" name="weight_kg" value="{{ old('weight_kg') }}" min="30" max="300" step="0.1" required
                    class="w-full px-3 py-3 rounded-xl border {{ $errors->has('weight_kg') ? 'border-red-500' : 'border-gray-200 dark:border-gray-700' }} bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
                @error('weight_kg')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Fitness Goal -->
        <div>
            <label for="fitness_goal" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Fitness Goal</label>
            <select id="fitness_goal" name="fitness_goal" required
                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('fitness_goal') ? 'border-red-500' : 'border-gray-200 dark:border-gray-700' }} bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
                <option value="">Select your primary goal...</option>
                <option value="lose_weight" {{ old('fitness_goal') === 'lose_weight' ? 'selected' : '' }}>Lose Weight</option>
                <option value="build_muscle" {{ old('fitness_goal') === 'build_muscle' ? 'selected' : '' }}>Build Muscle</option>
                <option value="stay_fit" {{ old('fitness_goal') === 'stay_fit' ? 'selected' : '' }}>Stay Fit</option>
                <option value="improve_endurance" {{ old('fitness_goal') === 'improve_endurance' ? 'selected' : '' }}>Improve Endurance</option>
            </select>
            @error('fitness_goal')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full py-3.5 px-4 bg-fit-green hover:bg-fit-green-dark text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-fit-green/30 transform hover:scale-[1.01] text-sm tracking-wide">
            Create My FitNexus Account
        </button>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-fit-green hover:text-fit-green-dark font-bold transition-colors">Sign in</a>
        </p>
    </form>
</x-guest-layout>
