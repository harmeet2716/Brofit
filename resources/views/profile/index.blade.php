@extends('layouts.app')

@section('title', 'My Profile — FitNexus')
@section('page_title', 'My Profile')
@section('breadcrumb', 'Profile')

@section('content')
@php
    $initials = '';
    if ($user) {
        $names = explode(' ', $user->name);
        $initials = strtoupper(substr($names[0] ?? '', 0, 1) . (isset($names[1]) ? substr($names[1], 0, 1) : ''));
    }

    $goalLabels = [
        'lose_weight' => 'Lose Weight',
        'build_muscle' => 'Build Muscle',
        'stay_fit' => 'Stay Fit',
        'improve_endurance' => 'Improve Endurance',
    ];
    $goal = $user->fitness_goal ?? 'stay_fit';
    $goalText = $goalLabels[$goal] ?? 'Stay Fit';
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- LEFT COLUMN - User Info Card -->
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm flex flex-col items-center text-center">
        <!-- Large Initials Avatar -->
        <div class="w-24 h-24 rounded-full bg-fit-green/20 text-fit-green font-extrabold flex items-center justify-center border-4 border-fit-green text-3xl mb-4 shadow-lg shadow-fit-green/10">
            {{ $initials }}
        </div>

        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $user->name }}</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $user->email }}</p>

        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-fit-green/15 text-fit-green dark:bg-fit-green/25 border border-fit-green/20 mb-6">
            {{ $goalText }}
        </span>

        <!-- Stats Grid -->
        <div class="grid grid-cols-3 gap-4 w-full py-4 border-y border-gray-100 dark:border-gray-800 mb-6">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Age</p>
                <p class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $user->age ?? 'N/A' }} yrs</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Height</p>
                <p class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $user->height_cm ?? 'N/A' }} cm</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Weight</p>
                <p class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $user->weight_kg ?? 'N/A' }} kg</p>
            </div>
        </div>

        <!-- Extra Details -->
        <div class="w-full space-y-3.5 mb-6 text-left">
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-500 dark:text-gray-400">BMI</span>
                @php
                    $bmi = 'N/A';
                    if (!empty($user->height_cm) && !empty($user->weight_kg)) {
                        $heightMeters = $user->height_cm / 100;
                        $bmiVal = $user->weight_kg / ($heightMeters * $heightMeters);
                        $bmi = round($bmiVal, 1);
                    }
                @endphp
                <span class="font-bold text-gray-800 dark:text-gray-200">
                    {{ $bmi }}
                    @if(is_numeric($bmi))
                        <span class="text-xs font-medium {{ $bmi < 18.5 ? 'text-blue-550' : ($bmi < 25 ? 'text-green-500' : 'text-orange-500') }}">
                            ({{ $bmi < 18.5 ? 'Underweight' : ($bmi < 25 ? 'Normal' : 'Overweight') }})
                        </span>
                    @endif
                </span>
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-500 dark:text-gray-400">Member Since</span>
                <span class="font-bold text-gray-850 dark:text-gray-300">
                    {{ $user->created_at ? $user->created_at->format('M d, Y') : now()->format('M d, Y') }}
                </span>
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="w-full py-3 px-4 bg-fit-green hover:bg-fit-green-dark text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-fit-green/20 text-center flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Profile
        </a>
    </div>

    <!-- RIGHT COLUMN - Stats & Enrolled Courses -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Progress Card -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Overall Fitness Progress</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Calculated based on your enrolled course completion rates.</p>

            <div class="flex justify-between items-center mb-2 text-sm font-bold text-fit-green">
                <span>Completed Tasks & Classes</span>
                <span>{{ $overallFitnessProgress }}%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden mb-4">
                <div class="h-full bg-gradient-to-r from-fit-green to-fit-green-light rounded-full transition-all duration-500" style="width: {{ $overallFitnessProgress }}%"></div>
            </div>

            <div class="flex justify-between items-center py-2.5 px-4 bg-gray-50 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-800 rounded-2xl">
                <span class="text-sm text-gray-600 dark:text-gray-400">Need direct tracking sheet?</span>
                <a href="{{ route('daily-goals.index') }}" class="text-sm font-bold text-fit-green hover:underline">Go to Daily Goals &rarr;</a>
            </div>
        </div>

        <!-- Enrolled Courses List -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">Course Enrollment Status</h3>

            @if(count($enrolledCourses) > 0)
                <div class="space-y-4">
                    @foreach($enrolledCourses as $course)
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/40 border border-gray-100 dark:border-gray-800 rounded-2xl gap-4">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-base font-bold text-gray-900 dark:text-white mb-1 truncate">{{ $course['name'] }}</h4>
                                <span class="text-xs text-gray-400">
                                    Enrolled on: {{ is_string($course['enrolled_at']) ? $course['enrolled_at'] : $course['enrolled_at']->format('M d, Y') }}
                                </span>
                            </div>

                            <div class="w-full md:w-48 flex flex-col justify-center">
                                <div class="flex justify-between items-center mb-1 text-xs font-semibold text-fit-green">
                                    <span>Progress</span>
                                    <span>{{ $course['progress'] }}%</span>
                                </div>
                                <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-fit-green rounded-full" style="width: {{ $course['progress'] }}%"></div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $course['status'] === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-150 text-gray-650' }}">
                                    {{ ucfirst($course['status']) }}
                                </span>
                                <a href="{{ route('courses.show', $course['course_id']) }}" class="text-sm font-bold text-fit-green hover:underline">
                                    Continue
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-400 dark:text-gray-500 mb-4">You are not enrolled in any training program yet.</p>
                    <a href="{{ route('courses.index') }}" class="px-5 py-2.5 bg-fit-green text-white text-sm font-bold rounded-xl hover:bg-fit-green-dark transition-colors shadow-md shadow-fit-green/25">Browse All Programs</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
