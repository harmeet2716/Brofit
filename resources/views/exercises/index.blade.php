@extends('layouts.app')

@section('title', 'Exercise Directory — FitNexus')
@section('page_title', 'Exercise Directory')
@section('breadcrumb', 'Exercises')

@section('content')

{{-- Filter & Search Panel --}}
<div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-5 shadow-sm space-y-4">
    <!-- Muscle Group Quick Tabs (GET) -->
    <div class="overflow-x-auto pb-2 flex gap-2">
        <a href="{{ route('exercises.index', ['muscle_group' => 'all', 'search' => $search]) }}"
            class="px-4 py-2.5 rounded-xl font-bold text-sm whitespace-nowrap transition-all duration-200 {{ !$muscleGroup || $muscleGroup === 'all' ? 'bg-fit-green text-white shadow-md shadow-fit-green/10' : 'bg-gray-50 dark:bg-gray-850 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-150 dark:border-gray-800' }}">
 All Exercises
        </a>
        @foreach($muscleGroups as $mg)
            <a href="{{ route('exercises.index', ['muscle_group' => $mg, 'search' => $search]) }}"
                class="px-4 py-2.5 rounded-xl font-bold text-sm whitespace-nowrap transition-all duration-200 {{ $muscleGroup === $mg ? 'bg-fit-green text-white shadow-md shadow-fit-green/10' : 'bg-gray-50 dark:bg-gray-850 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-150 dark:border-gray-800' }}">
                {{ $mg }}
            </a>
        @endforeach
    </div>

    <!-- Search input form -->
    <form method="GET" action="{{ route('exercises.index') }}" class="flex flex-col md:flex-row gap-3">
        <input type="hidden" name="muscle_group" value="{{ $muscleGroup ?? 'all' }}">
        
        <div class="flex-1 relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search exercises by name (e.g. Squat, Push-up)..."
                class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
            <span class="absolute right-3.5 top-3.5 text-gray-450">

            </span>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="px-6 py-3 bg-fit-green hover:bg-fit-green-dark text-white font-bold rounded-xl transition-all duration-300 shadow-md shadow-fit-green/20 text-sm flex items-center gap-2">
                Search
            </button>
            @if($search || ($muscleGroup && $muscleGroup !== 'all'))
                <a href="{{ route('exercises.index') }}" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl transition-all duration-200 text-sm flex items-center justify-center">
                    Clear Filters
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Exercises Grid --}}
@if(count($exercises) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($exercises as $exercise)
            <x-exercise-card :exercise="$exercise" />
        @endforeach
    </div>

    {{-- Manual Pagination Controls --}}
    @if($totalPages > 1)
        <div class="flex justify-center items-center gap-2 mt-8">
            <!-- Previous Button -->
            <a href="{{ $page > 1 ? route('exercises.index', array_merge(request()->query(), ['page' => $page - 1])) : '#' }}"
                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 font-bold text-sm transition-all duration-250 {{ $page <= 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                &larr; Prev
            </a>

            <!-- Page indicators -->
            @for($i = 1; $i <= $totalPages; $i++)
                <a href="{{ route('exercises.index', array_merge(request()->query(), ['page' => $i])) }}"
                    class="w-10 h-10 flex items-center justify-center rounded-xl font-bold text-sm transition-all duration-250 {{ $page === $i ? 'bg-fit-green text-white shadow-md shadow-fit-green/20' : 'border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    {{ $i }}
                </a>
            @endfor

            <!-- Next Button -->
            <a href="{{ $page < $totalPages ? route('exercises.index', array_merge(request()->query(), ['page' => $page + 1])) : '#' }}"
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
        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-1">No Exercises Found</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">We couldn't find matching movements. Try another keyword.</p>
    </div>
@endif

@endsection
