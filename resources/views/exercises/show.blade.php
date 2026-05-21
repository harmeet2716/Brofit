@extends('layouts.app')

@section('title', $exercise['name'] . ' — FitNexus')
@section('page_title', 'Exercise Details')
@section('breadcrumb', 'Exercise Details')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- LEFT & CENTER: Main Exercise Guide -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Hero Card with Visuals -->
        <div class="relative overflow-hidden rounded-3xl h-64 md:h-96 shadow-md bg-gray-100 dark:bg-gray-800">
            <img src="{{ $exercise['image_url'] }}" alt="{{ $exercise['name'] }}" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/30 to-transparent"></div>
            
            <div class="absolute bottom-6 left-6 right-6 text-white">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-fit-green text-white">
                        {{ $exercise['muscle_group'] }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm border border-white/10">
                        {{ $exercise['difficulty'] }}
                    </span>
                </div>
                <h2 class="text-3xl font-extrabold text-white mb-1">{{ $exercise['name'] }}</h2>
                <p class="text-sm text-gray-300 flex items-center">
 Estimated calories burned: ~{{ $exercise['calories_burned_per_set'] }} Cal / set
                </p>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Exercise Overview</h3>
            <p class="text-gray-650 dark:text-gray-400 text-sm leading-relaxed">{{ $exercise['description'] }}</p>
        </div>

        <!-- Steps instructions -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">Step-by-Step Instructions</h3>
            
            <ol class="space-y-4">
                @if(isset($exercise['steps']) && is_array($exercise['steps']))
                    @foreach($exercise['steps'] as $index => $step)
                        <li class="flex gap-4">
                            <span class="w-7 h-7 rounded-full bg-fit-green/10 text-fit-green flex items-center justify-center font-bold text-sm flex-shrink-0">
                                {{ $index + 1 }}
                            </span>
                            <div class="pt-0.5">
                                <p class="text-sm text-gray-650 dark:text-gray-400 leading-relaxed">{{ $step }}</p>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="text-sm text-gray-450">Step directions are coming soon.</li>
                @endif
            </ol>
        </div>
    </div>

    <!-- RIGHT SIDEBAR: Benefits & Actions -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Add to goals card -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-md text-center">
            <div class="w-14 h-14 rounded-2xl bg-fit-green/10 text-fit-green flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h4 class="text-base font-bold text-gray-900 dark:text-white mb-2">Integrate Into Your Day</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">Add this movement to today's personal tracking sheet list to log your sets.</p>

            <form method="POST" action="{{ route('exercises.add-to-goals', $exercise['_id']) }}">
                @csrf
                <button type="submit" class="w-full py-3.5 px-4 bg-fit-green hover:bg-fit-green-dark text-white font-extrabold rounded-2xl transition-all duration-300 shadow-lg shadow-fit-green/20 text-sm">
 Add to Today's Goals
                </button>
            </form>
        </div>

        <!-- Problems Solved -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
            <h4 class="text-sm font-bold text-gray-450 uppercase tracking-widest mb-4">Key Benefits:</h4>
            
            <ul class="space-y-3">
                @if(isset($exercise['problems_solved']) && is_array($exercise['problems_solved']))
                    @foreach($exercise['problems_solved'] as $problem)
                        <li class="flex items-center gap-2.5 text-sm text-gray-650 dark:text-gray-450 font-medium">
                            <span class="text-fit-green font-bold text-lg">&#10003;</span>
                            <span>{{ $problem }}</span>
                        </li>
                    @endforeach
                @else
                    <li class="text-sm text-gray-400">Loading benefits summary...</li>
                @endif
            </ul>
        </div>
    </div>
</div>

@endsection
