@extends('layouts.app')

@section('title', $course['name'] . ' — FitNexus')
@section('page_title', 'Course Details')
@section('breadcrumb', 'Course Details')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- LEFT & CENTER: Course Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Hero Banner Card -->
        <div class="relative overflow-hidden rounded-3xl h-64 md:h-80 shadow-md">
            <img src="{{ $course['image_url'] }}" alt="{{ $course['name'] }}" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/40 to-transparent"></div>
            
            <div class="absolute bottom-6 left-6 right-6 text-white">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-fit-green text-white">
                        {{ $course['category'] }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-sm border border-white/10">
                        {{ $course['difficulty'] }}
                    </span>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold leading-tight text-white mb-2">{{ $course['name'] }}</h2>
                <p class="text-sm text-gray-300 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-fit-green" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Program duration: {{ $course['duration_weeks'] }} Weeks
                </p>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">About the Program</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $course['description'] }}</p>
        </div>

        <!-- Features list -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">What You Will Master</h3>
            
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if(isset($course['features']) && is_array($course['features']))
                    @foreach($course['features'] as $feature)
                        <li class="flex items-start gap-2.5 text-sm text-gray-600 dark:text-gray-400">
                            <span class="w-5 h-5 rounded-full bg-fit-green/10 text-fit-green flex items-center justify-center font-bold flex-shrink-0 text-xs">
                                &#10003;
                            </span>
                            <span>{{ $feature }}</span>
                        </li>
                    @endforeach
                @else
                    <li class="text-sm text-gray-400">Features are coming soon for this program.</li>
                @endif
            </ul>
        </div>
    </div>

    <!-- RIGHT: Sticky pricing/enroll card -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-md sticky top-24">
            <div class="text-center mb-6">
                <span class="text-xs font-bold text-gray-450 uppercase tracking-wider block mb-2">Program Value</span>
                @if($isEnrolled)
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-fit-green/10 text-fit-green dark:bg-fit-green/20">
                        <svg class="w-5 h-5 mr-1 text-fit-green" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Enrolled Program ✓
                    </span>
                @else
                    <h4 class="text-4xl font-extrabold text-gray-950 dark:text-white mb-2">
                        ${{ number_format($course['price'], 2) }}
                    </h4>
                    <p class="text-xs text-gray-400">One-time payment for lifetime access</p>
                @endif
            </div>

            @if($isEnrolled)
                <!-- Enrolled Progress details -->
                <div class="border-t border-gray-100 dark:border-gray-850 py-5">
                    <div class="flex justify-between items-center mb-1 text-xs font-bold text-fit-green">
                        <span>Course Completion</span>
                        <span>{{ $progress }}%</span>
                    </div>
                    <div class="w-full h-3 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden mb-4">
                        <div class="h-full bg-gradient-to-r from-fit-green to-fit-green-light rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center leading-relaxed">You are actively participating in this program. Complete daily workouts to advance your progress!</p>
                </div>
            @else
                <!-- Enroll Button Action form -->
                <form method="POST" action="{{ route('courses.enroll', $course['_id']) }}" class="mb-6">
                    @csrf
                    <button type="submit" class="w-full py-4 px-4 bg-fit-green hover:bg-fit-green-dark text-white font-extrabold rounded-2xl transition-all duration-300 shadow-lg shadow-fit-green/20 text-center text-sm">
                        Enroll in Course Now
                    </button>
                </form>
            @endif

            <!-- What's included checklist -->
            <div class="border-t border-gray-100 dark:border-gray-800 pt-5 space-y-3.5">
                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">What's Included:</h5>
                <ul class="space-y-3 text-sm text-gray-650 dark:text-gray-400">
                    <li class="flex items-center gap-2">
                        <span class="text-fit-green">&#10003;</span> Full lifetime course access
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-fit-green">&#10003;</span> {{ $course['duration_weeks'] }} Weeks schedule
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-fit-green">&#10003;</span> High-definition movement steps
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-fit-green">&#10003;</span> Mobile & Desktop responsive layout
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
