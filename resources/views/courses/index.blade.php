@extends('layouts.app')

@section('title', 'Training Programs — FitNexus')
@section('page_title', 'Training Programs')
@section('breadcrumb', 'Courses')

@section('content')

{{-- Filter and Search Row --}}
<div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-5 shadow-sm">
    <form method="GET" action="{{ route('courses.index') }}" class="flex flex-col md:flex-row md:items-end gap-4">
        <!-- Difficulty Filter -->
        <div class="flex-1">
            <label for="difficulty" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Difficulty Level</label>
            <select name="difficulty" id="difficulty" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
                <option value="all" {{ $difficulty === 'all' || !$difficulty ? 'selected' : '' }}>All Levels</option>
                <option value="Beginner" {{ $difficulty === 'Beginner' ? 'selected' : '' }}>🟢 Beginner</option>
                <option value="Intermediate" {{ $difficulty === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                <option value="Advanced" {{ $difficulty === 'Advanced' ? 'selected' : '' }}>Advanced</option>
            </select>
        </div>

        <!-- Category Filter -->
        <div class="flex-1">
            <label for="category" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Program Category</label>
            <select name="category" id="category" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
                <option value="all" {{ $category === 'all' || !$category ? 'selected' : '' }}>All Categories</option>
                <option value="Strength" {{ $category === 'Strength' ? 'selected' : '' }}>Strength</option>
                <option value="Cardio" {{ $category === 'Cardio' ? 'selected' : '' }}>Cardio</option>
                <option value="Yoga" {{ $category === 'Yoga' ? 'selected' : '' }}>Yoga</option>
                <option value="HIIT" {{ $category === 'HIIT' ? 'selected' : '' }}>HIIT</option>
                <option value="Mixed" {{ $category === 'Mixed' ? 'selected' : '' }}>Mixed Methods</option>
            </select>
        </div>

        <!-- Filter & Reset Buttons -->
        <div class="flex gap-2">
            <button type="submit" class="px-6 py-3 bg-fit-green hover:bg-fit-green-dark text-white font-bold rounded-xl transition-all duration-300 shadow-md shadow-fit-green/20 text-sm flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Apply Filters
            </button>
            <a href="{{ route('courses.index') }}" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl transition-all duration-200 text-sm flex items-center justify-center">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- Courses Grid --}}
@if(count($courses) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses as $course)
            @php
                $isEnrolled = in_array((string)$course['_id'], $userEnrollments);
            @endphp
            <x-course-card :course="$course" :enrolled="$isEnrolled" />
        @endforeach
    </div>

    {{-- Manual Pagination Controls --}}
    @if($totalPages > 1)
        <div class="flex justify-center items-center gap-2 mt-8">
            <!-- Previous Button -->
            <a href="{{ $page > 1 ? route('courses.index', array_merge(request()->query(), ['page' => $page - 1])) : '#' }}"
                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 font-bold text-sm transition-all duration-250 {{ $page <= 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                &larr; Prev
            </a>

            <!-- Page indicators -->
            @for($i = 1; $i <= $totalPages; $i++)
                <a href="{{ route('courses.index', array_merge(request()->query(), ['page' => $i])) }}"
                    class="w-10 h-10 flex items-center justify-center rounded-xl font-bold text-sm transition-all duration-250 {{ $page === $i ? 'bg-fit-green text-white shadow-md shadow-fit-green/20' : 'border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    {{ $i }}
                </a>
            @endfor

            <!-- Next Button -->
            <a href="{{ $page < $totalPages ? route('courses.index', array_merge(request()->query(), ['page' => $page + 1])) : '#' }}"
                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 font-bold text-sm transition-all duration-250 {{ $page >= $totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Next &rarr;
            </a>
        </div>
    @endif
@else
    <div class="flex flex-col items-center justify-center py-16 bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm text-center">
        <svg class="w-16 h-16 text-gray-350 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-1">No Programs Found</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">Try loosening your filters or search keywords.</p>
    </div>
@endif

{{-- PRICING TIERS SECTION --}}
<div class="pt-10 border-t border-gray-150 dark:border-gray-850 mt-10">
    <div class="text-center max-w-xl mx-auto mb-10">
        <span class="text-xs font-bold text-fit-green uppercase tracking-widest bg-fit-green/10 px-3.5 py-1.5 rounded-full">Membership Pricing</span>
        <h3 class="text-3xl font-extrabold text-gray-950 dark:text-white mt-4 mb-2">Transform Your Body & Mind</h3>
        <p class="text-sm text-gray-550 dark:text-gray-450">Unlock tailored plans, complete library tracking, and AI coaching systems with a FitNexus subscription tier.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        <!-- Tier 1: Basic -->
        <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-3xl p-6 shadow-sm flex flex-col justify-between hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div>
                <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-2">Basic Plan</h4>
                <p class="text-2xl font-extrabold text-gray-950 dark:text-white mb-4">$9.99<span class="text-sm font-semibold text-gray-500">/month</span></p>
                <div class="border-t border-gray-100 dark:border-gray-800 py-4">
                    <ul class="space-y-3.5 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> Access to 5 Core Courses
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> Standard Workout Tracking
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> Standard Calorie Manager
                        </li>
                        <li class="flex items-center gap-2 text-gray-400 dark:text-gray-600 line-through">
                            <span>&#10005;</span> AI Coach Interaction
                        </li>
                        <li class="flex items-center gap-2 text-gray-400 dark:text-gray-600 line-through">
                            <span>&#10005;</span> 1-on-1 Personal Trainer
                        </li>
                    </ul>
                </div>
            </div>
            <button class="w-full py-3 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-250 font-bold rounded-xl transition-all duration-300 text-sm mt-6">
                Current Plan
            </button>
        </div>

        <!-- Tier 2: Pro -->
        <div class="bg-white dark:bg-gray-900 border-2 border-fit-green rounded-3xl p-6 shadow-md flex flex-col justify-between hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative">
            <span class="absolute -top-3.5 left-1/2 transform -translate-x-1/2 bg-fit-green text-white text-xs font-extrabold uppercase px-3 py-1 rounded-full tracking-wider">
                Most Popular
            </span>
            <div>
                <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-2">Pro Plan</h4>
                <p class="text-2xl font-extrabold text-gray-950 dark:text-white mb-4">$19.99<span class="text-sm font-semibold text-gray-500">/month</span></p>
                <div class="border-t border-gray-100 dark:border-gray-800 py-4">
                    <ul class="space-y-3.5 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> Unlimited Courses Access
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> Complete AI Coach Access
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> Pro Macros Calorie Tracking
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> Complete Biometrics Sheets
                        </li>
                        <li class="flex items-center gap-2 text-gray-400 dark:text-gray-600 line-through">
                            <span>&#10005;</span> 1-on-1 Personal Trainer
                        </li>
                    </ul>
                </div>
            </div>
            <button class="w-full py-3 bg-fit-green hover:bg-fit-green-dark text-white font-bold rounded-xl transition-all duration-300 text-sm shadow-md shadow-fit-green/20 mt-6">
                Upgrade to Pro
            </button>
        </div>

        <!-- Tier 3: Elite -->
        <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-3xl p-6 shadow-sm flex flex-col justify-between hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div>
                <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-2">Elite Plan</h4>
                <p class="text-2xl font-extrabold text-gray-950 dark:text-white mb-4">$39.99<span class="text-sm font-semibold text-gray-500">/month</span></p>
                <div class="border-t border-gray-100 dark:border-gray-800 py-4">
                    <ul class="space-y-3.5 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> Everything in Pro Plan
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> 1-on-1 Trainer Session (1/mo)
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> Direct Personal Workout Plan
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> Customized Daily Diet Logs
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-fit-green font-bold">&#10003;</span> VIP Support Response Time
                        </li>
                    </ul>
                </div>
            </div>
            <button class="w-full py-3 bg-gray-900 dark:bg-gray-850 hover:bg-gray-950 dark:hover:bg-gray-800 text-white font-bold rounded-xl transition-all duration-300 text-sm mt-6 border border-gray-800">
                Go Premium Elite
            </button>
        </div>
    </div>
</div>

@endsection
