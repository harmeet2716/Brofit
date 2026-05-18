@extends('layouts.app')

@section('title', 'Edit Profile — FitNexus')
@section('page_title', 'Edit Profile')
@section('breadcrumb', 'Edit Profile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 md:p-8 shadow-sm">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Update Biometrics & Goals</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Keeping your vitals up to date ensures accurate AI coach advice and calorie calculators.</p>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green focus:border-transparent outline-none transition-all duration-200 text-sm">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Age / Height / Weight (3 columns) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="age" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Age</label>
                    <input id="age" type="number" name="age" value="{{ old('age', $user->age) }}" min="13" max="100" required
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('age') ? 'border-red-500' : 'border-gray-200 dark:border-gray-700' }} bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
                    @error('age')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="height_cm" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Height (cm)</label>
                    <input id="height_cm" type="number" name="height_cm" value="{{ old('height_cm', $user->height_cm) }}" min="100" max="250" step="0.1" required
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('height_cm') ? 'border-red-500' : 'border-gray-200 dark:border-gray-700' }} bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
                    @error('height_cm')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="weight_kg" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Weight (kg)</label>
                    <input id="weight_kg" type="number" name="weight_kg" value="{{ old('weight_kg', $user->weight_kg) }}" min="30" max="300" step="0.1" required
                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('weight_kg') ? 'border-red-500' : 'border-gray-200 dark:border-gray-700' }} bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
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
                    <option value="lose_weight" {{ old('fitness_goal', $user->fitness_goal) === 'lose_weight' ? 'selected' : '' }}>🏃 Lose Weight</option>
                    <option value="build_muscle" {{ old('fitness_goal', $user->fitness_goal) === 'build_muscle' ? 'selected' : '' }}>💪 Build Muscle</option>
                    <option value="stay_fit" {{ old('fitness_goal', $user->fitness_goal) === 'stay_fit' ? 'selected' : '' }}>🌿 Stay Fit</option>
                    <option value="improve_endurance" {{ old('fitness_goal', $user->fitness_goal) === 'improve_endurance' ? 'selected' : '' }}>⚡ Improve Endurance</option>
                </select>
                @error('fitness_goal')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="flex-1 py-3.5 px-4 bg-fit-green hover:bg-fit-green-dark text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-fit-green/20 text-sm">
                    Save Modifications
                </button>
                <a href="{{ route('profile.show') }}" class="px-6 py-3.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-2xl transition-all duration-200 text-sm text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
