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
                    <svg class="w-4 h-4 mr-1 text-fit-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                @foreach($features as $feature)
                    <li class="flex items-start gap-2.5 text-sm text-gray-600 dark:text-gray-400">
                        <span class="w-5 h-5 rounded-full bg-fit-green/10 text-fit-green flex items-center justify-center font-bold flex-shrink-0 text-xs">
                            &#10003;
                        </span>
                        <span>{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- WEEKLY CURRICULUM SECTION -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Weekly Curriculum</h3>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ count($weeklyPlan) }} Weeks</span>
            </div>

            @if($isEnrolled)
                {{-- ENROLLED: Show full weekly plan --}}
                <div class="space-y-4">
                    @foreach($weeklyPlan as $index => $week)
                        <details class="group border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden" {{ $index === 0 ? 'open' : '' }}>
                            <summary class="flex items-center justify-between p-5 cursor-pointer bg-gray-50 dark:bg-gray-850 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-fit-green/10 text-fit-green flex items-center justify-center font-black text-xs">
                                        {{ $week['week_number'] }}
                                    </span>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $week['title'] }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $week['goal'] }}</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>

                            <div class="p-5 space-y-5 border-t border-gray-100 dark:border-gray-800">
                                {{-- Daily Calorie Target --}}
                                <div class="flex items-center gap-3 p-4 bg-fit-green/5 dark:bg-fit-green/10 rounded-xl border border-fit-green/15">
                                    <div class="w-10 h-10 rounded-xl bg-fit-green/15 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-fit-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Daily Calorie Target</span>
                                        <p class="text-xl font-black text-fit-green">{{ $week['daily_calories'] }} kcal</p>
                                    </div>
                                </div>

                                {{-- Meal Plan --}}
                                <div>
                                    <h5 class="text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17"></path></svg>
                                        Meal Plan
                                    </h5>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach($week['meals'] as $mealType => $mealDesc)
                                            <div class="p-3 bg-gray-50 dark:bg-gray-850 rounded-xl border border-gray-100 dark:border-gray-800">
                                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">{{ ucfirst($mealType) }}</span>
                                                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 leading-relaxed">{{ $mealDesc }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Exercises --}}
                                <div>
                                    <h5 class="text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Exercises
                                    </h5>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left text-sm">
                                            <thead>
                                                <tr class="border-b border-gray-100 dark:border-gray-800 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                                    <th class="pb-2.5">Exercise</th>
                                                    <th class="pb-2.5">Duration</th>
                                                    <th class="pb-2.5">Sets</th>
                                                    <th class="pb-2.5">Reps</th>
                                                    <th class="pb-2.5">Rest</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100 dark:divide-gray-850">
                                                @foreach($week['exercises'] as $ex)
                                                    <tr class="text-gray-700 dark:text-gray-300">
                                                        <td class="py-2.5 font-bold text-gray-900 dark:text-white text-xs">{{ $ex['name'] }}</td>
                                                        <td class="py-2.5 text-xs">{{ $ex['duration'] ?? '—' }}</td>
                                                        <td class="py-2.5 text-xs">{{ $ex['sets'] ?? '—' }}</td>
                                                        <td class="py-2.5 text-xs">{{ $ex['reps'] ?? '—' }}</td>
                                                        <td class="py-2.5 text-xs">{{ $ex['rest'] ?? '—' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Tips --}}
                                <div class="p-3 bg-blue-50 dark:bg-blue-950/20 rounded-xl border border-blue-100 dark:border-blue-900/30">
                                    <p class="text-xs font-semibold text-blue-700 dark:text-blue-400 flex items-start gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span><strong>Pro Tip:</strong> {{ $week['tips'] }}</span>
                                    </p>
                                </div>
                            </div>
                        </details>
                    @endforeach
                </div>
            @else
                {{-- NOT ENROLLED: Show locked preview --}}
                <div class="space-y-3">
                    @foreach($weeklyPlan as $index => $week)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-850 rounded-xl border border-gray-100 dark:border-gray-800 opacity-70">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-400 flex items-center justify-center font-black text-xs">
                                    {{ $week['week_number'] }}
                                </span>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ $week['title'] }}</h4>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $week['goal'] }}</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 p-5 bg-gradient-to-r from-fit-green/5 to-emerald-500/5 dark:from-fit-green/10 dark:to-emerald-500/10 rounded-2xl border border-fit-green/15 text-center">
                    <svg class="w-10 h-10 text-fit-green mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Enroll to Unlock Full Curriculum</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Get access to detailed weekly meal plans, exercise routines, calorie targets, and pro tips.</p>
                    <form method="POST" action="{{ route('courses.enroll', $course['_id']) }}">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 bg-fit-green hover:bg-fit-green-dark text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-fit-green/20 text-sm">
                            Enroll Now to Unlock
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- RIGHT: Sticky pricing/enroll card -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-md sticky top-24">
            <div class="text-center mb-6">
                <span class="text-xs font-bold text-gray-450 uppercase tracking-wider block mb-2">Program Value</span>
                @if($isEnrolled)
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-fit-green/10 text-fit-green dark:bg-fit-green/20">
                        <svg class="w-5 h-5 mr-1 text-fit-green" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Enrolled Program
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
                        <span class="text-fit-green">&#10003;</span> Weekly meal plans & calorie targets
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-fit-green">&#10003;</span> Exercise routines with sets & reps
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-fit-green">&#10003;</span> Pro tips & recovery guidance
                    </li>
                </ul>
            </div>

            <!-- Back to courses -->
            <div class="mt-6 pt-5 border-t border-gray-100 dark:border-gray-800">
                <a href="{{ route('courses.index') }}" class="flex items-center justify-center gap-2 text-sm font-bold text-gray-500 hover:text-fit-green transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to All Courses
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
