@extends('layouts.app')

@section('title', 'Dashboard — FitNexus')
@section('page_title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

{{-- HERO SECTION --}}
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-fit-green via-emerald-500 to-teal-600 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 dark:border dark:border-fit-green/20 p-8 md:p-10 shadow-xl shadow-fit-green/20">
    <div class="absolute inset-0 opacity-10 dark:opacity-5">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)" /></svg>
    </div>
    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">{{ $greeting }}</h2>
            @php
                $goalLabels = ['lose_weight'=>'Lose Weight','build_muscle'=>'Build Muscle','stay_fit'=>'Stay Fit','improve_endurance'=>'Improve Endurance'];
                $goalLabel = $goalLabels[auth()->user()->fitness_goal ?? 'stay_fit'] ?? 'Stay Fit';
            @endphp
            <span class="inline-flex items-center mt-3 px-4 py-1.5 rounded-full text-xs font-bold bg-white/20 backdrop-blur-sm text-white border border-white/30">
                🎯 Goal: {{ $goalLabel }}
            </span>
            <p class="mt-4 text-sm text-white/80 italic max-w-md">"{{ $quote }}"</p>
        </div>
        <div class="flex-shrink-0">
            <img src="https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&q=80&w=200&h=200" alt="Fitness" class="w-28 h-28 md:w-36 md:h-36 rounded-2xl object-cover shadow-xl ring-4 ring-white/30">
        </div>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
    <x-stat-card title="Courses Enrolled" value="{{ $coursesEnrolledCount }}" :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\'></path></svg>'" />
    <x-stat-card title="Workouts This Week" value="{{ $workoutsLoggedThisWeek }}" :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2\'></path></svg>'" />
    <x-stat-card title="Daily Goal %" value="{{ $todayCompletionPercent }}%" :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\'></path></svg>'" />
    <x-stat-card title="Current Streak" value="{{ $streak }} Days" :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z\'></path><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z\'></path></svg>'" />
</div>

{{-- ENROLLED COURSES --}}
<div>
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">My Courses</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Continue where you left off</p>
        </div>
        <a href="{{ route('courses.index') }}" class="text-sm font-bold text-fit-green hover:text-fit-green-dark flex items-center gap-1 transition-colors">
            View All
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>
    @if(count($enrolledCourses) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($enrolledCourses as $course)
                <x-course-card :course="$course" :enrolled="true" :progress="$course['progress']" />
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-12 bg-white dark:bg-gray-900 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <p class="text-gray-500 dark:text-gray-400 font-semibold mb-3">No courses enrolled yet</p>
            <a href="{{ route('courses.index') }}" class="px-5 py-2.5 bg-fit-green text-white text-sm font-bold rounded-xl hover:bg-fit-green-dark transition-colors shadow-md shadow-fit-green/25">Browse Courses</a>
        </div>
    @endif
</div>

{{-- QUICK ACTIONS --}}
<div>
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-5">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $actions = [
                ['label'=>'Log Workout','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','route'=>'daily-goals.index','color'=>'from-green-500 to-emerald-600'],
                ['label'=>'Update Goals','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','route'=>'daily-goals.index','color'=>'from-blue-500 to-indigo-600'],
                ['label'=>'View Exercises','icon'=>'M13 10V3L4 14h7v7l9-11h-7z','route'=>'exercises.index','color'=>'from-purple-500 to-violet-600'],
                ['label'=>'AI Coach','icon'=>'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 113.536 0V21h2v-2.757','route'=>'ai-coach.index','color'=>'from-orange-500 to-amber-600'],
            ];
        @endphp
        @foreach($actions as $action)
            <a href="{{ route($action['route']) }}" class="group flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $action['color'] }} flex items-center justify-center mb-3 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"></path></svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $action['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>

{{-- TODAY'S GOALS PREVIEW --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Today's Goals</h3>
            <a href="{{ route('daily-goals.index') }}" class="text-xs text-fit-green font-bold hover:underline">Manage →</a>
        </div>
        @if(count($todayGoalsList) > 0)
            <div class="space-y-3">
                @foreach(array_slice($todayGoalsList, 0, 5) as $goal)
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ $goal['completed'] ? 'bg-fit-green/5 dark:bg-fit-green/10' : 'bg-gray-50 dark:bg-gray-800/50' }}">
                        <div class="w-5 h-5 rounded-full flex-shrink-0 border-2 {{ $goal['completed'] ? 'bg-fit-green border-fit-green' : 'border-gray-300 dark:border-gray-600' }} flex items-center justify-center">
                            @if($goal['completed'])
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            @endif
                        </div>
                        <span class="text-sm font-medium {{ $goal['completed'] ? 'line-through text-fit-green' : 'text-gray-700 dark:text-gray-300' }}">{{ $goal['title'] }}</span>
                        <span class="ml-auto text-xs px-2 py-0.5 rounded-full {{ $goal['type'] === 'workout' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : ($goal['type'] === 'nutrition' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400') }} font-semibold">{{ ucfirst($goal['type']) }}</span>
                    </div>
                @endforeach
            </div>
            @if(count($todayGoalsList) > 5)
                <p class="mt-3 text-xs text-center text-gray-400">+{{ count($todayGoalsList) - 5 }} more goals</p>
            @endif
        @else
            <div class="text-center py-8">
                <p class="text-gray-400 dark:text-gray-500 text-sm mb-3">No goals set for today yet!</p>
                <a href="{{ route('daily-goals.index') }}" class="text-sm font-bold text-fit-green">+ Add Goals</a>
            </div>
        @endif
    </div>

    {{-- COMPLETION RING --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 shadow-sm flex flex-col items-center justify-center">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Today's Progress</h3>
        <div class="relative w-36 h-36">
            <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
                <circle cx="60" cy="60" r="50" fill="none" stroke="#e5e7eb" stroke-width="10" class="dark:stroke-gray-700"/>
                <circle cx="60" cy="60" r="50" fill="none" stroke="#39D353" stroke-width="10" stroke-linecap="round"
                    stroke-dasharray="{{ 2 * 3.14159 * 50 }}"
                    stroke-dashoffset="{{ 2 * 3.14159 * 50 * (1 - $todayCompletionPercent / 100) }}"
                    class="transition-all duration-1000"/>
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $todayCompletionPercent }}%</span>
                <span class="text-xs text-gray-500 font-semibold">Complete</span>
            </div>
        </div>
        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 text-center">{{ $todayCompletionPercent < 50 ? 'Keep pushing! You can do it! 💪' : ($todayCompletionPercent < 100 ? 'Almost there! Finish strong! 🔥' : 'Amazing! All goals crushed today! 🏆') }}</p>
    </div>
</div>

{{-- MOTIVATIONAL BANNER --}}
<div class="relative overflow-hidden rounded-3xl h-48 shadow-xl">
    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=1200&h=300" alt="Motivation" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-r from-gray-950/80 via-gray-950/50 to-transparent"></div>
    <div class="relative z-10 h-full flex flex-col justify-center px-10">
        <p class="text-white/70 text-sm font-semibold uppercase tracking-widest mb-1">Daily Mantra</p>
        <h3 class="text-2xl md:text-3xl font-extrabold text-white max-w-lg leading-tight">Train Insane or Remain the Same.</h3>
        <a href="{{ route('exercises.index') }}" class="mt-4 inline-flex items-center gap-2 text-fit-green font-bold text-sm hover:underline">
            Explore Exercises →
        </a>
    </div>
</div>

@endsection
