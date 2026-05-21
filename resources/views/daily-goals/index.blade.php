@extends('layouts.app')

@section('title', 'Daily Goals Sheet — FitNexus')
@section('page_title', 'Daily Fitness Goals')
@section('breadcrumb', 'Daily Goals')

@section('content')

{{-- TOP ACTIONS ROW - Date Selection and Copying --}}
<div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-5 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
    <!-- Date picker -->
    <form id="dateForm" method="GET" action="{{ route('daily-goals.index') }}" class="flex items-center gap-3 w-full md:w-auto">
        <label for="date-picker" class="text-sm font-bold text-gray-500 whitespace-nowrap">Selected Date:</label>
        <input type="date" name="date" id="date-picker" value="{{ $date }}" onchange="document.getElementById('dateForm').submit();"
            class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-semibold focus:ring-2 focus:ring-fit-green outline-none text-sm w-full md:w-auto">
    </form>

    <!-- Copy yesterday's goals button -->
    <form method="POST" action="{{ route('daily-goals.copy-yesterday') }}" class="w-full md:w-auto">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        <button type="submit" class="w-full md:w-auto px-5 py-2.5 bg-gray-50 dark:bg-gray-850 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 font-bold border border-gray-200 dark:border-gray-800 rounded-xl transition-all duration-200 text-sm flex items-center justify-center gap-1.5">
 Copy Yesterday's Goals
        </button>
    </form>
</div>

{{-- PROGRESS BAR & OVERVIEW --}}
<div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
    <div class="flex justify-between items-center mb-2.5">
        <div>
            <h3 class="text-lg font-bold text-gray-950 dark:text-white">Daily Target Completion</h3>
            <p class="text-xs text-gray-450 dark:text-gray-500">Cross out each task to hit 100%.</p>
        </div>
        <span class="text-2xl font-extrabold text-fit-green">{{ $completionPercent }}%</span>
    </div>
    
    <div class="w-full h-3 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
        <div class="h-full bg-gradient-to-r from-fit-green to-fit-green-light rounded-full transition-all duration-500" style="width: {{ $completionPercent }}%"></div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- LEFT & CENTER COLUMN: Goal List & Add New Form -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Goal Checklist Card -->
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">Tracklist Checklist</h3>

            @if(count($goalsList) > 0)
                <div class="space-y-3 mb-6">
                    @foreach($goalsList as $index => $goal)
                        <div class="flex items-center justify-between p-3.5 bg-gray-50 dark:bg-gray-850/40 border border-gray-150/40 dark:border-gray-800 rounded-2xl gap-3">
                            
                            <!-- Checkbox Toggle form -->
                            @php
                                // Fetch target daily_goals document ID or similar to target correct row
                                $goalDoc = \DB::table('daily_goals')->where('user_id', auth()->user()->id ?? auth()->user()->_id)->where('date', $date)->first();
                                $docId = $goalDoc ? (string)($goalDoc->_id ?? $goalDoc->id ?? '') : '';
                            @endphp

                            <form method="POST" action="{{ route('daily-goals.update', $docId) }}" class="flex items-center gap-3.5 flex-1 min-w-0">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="toggle">
                                <input type="hidden" name="index" value="{{ $index }}">
                                
                                <input type="checkbox" onchange="this.form.submit();" {{ $goal['completed'] ? 'checked' : '' }}
                                    class="w-5 h-5 rounded border-gray-300 dark:border-gray-700 text-fit-green focus:ring-fit-green cursor-pointer bg-white dark:bg-gray-800 transition-colors">
                                
                                <span class="text-sm font-semibold truncate leading-tight {{ $goal['completed'] ? 'line-through text-fit-green' : 'text-gray-700 dark:text-gray-350' }}">
                                    {{ $goal['title'] }}
                                </span>
                            </form>

                            <!-- Badge and Delete -->
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full {{ $goal['type'] === 'workout' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : ($goal['type'] === 'nutrition' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($goal['type'] === 'rest' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-gray-100 text-gray-750 dark:bg-gray-800 dark:text-gray-400')) }}">
                                    {{ ucfirst($goal['type']) }}
                                </span>

                                <form method="POST" action="{{ route('daily-goals.destroy', $docId) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="index" value="{{ $index }}">
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete goal">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 border border-dashed border-gray-200 dark:border-gray-850 rounded-2xl mb-6">
                    <p class="text-gray-400 dark:text-gray-500 text-sm">No tasks programmed for {{ $date }} yet.</p>
                </div>
            @endif

            <!-- Add Goal Inline Form -->
            <div class="border-t border-gray-100 dark:border-gray-800 pt-6">
                <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Add Custom Goal</h4>
                
                <form method="POST" action="{{ route('daily-goals.store') }}" class="flex flex-col md:flex-row gap-3">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">
                    
                    <div class="flex-1">
                        <input type="text" name="title" placeholder="Goal name (e.g. Drink 3L water, Do 50 pushups)..." required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
                    </div>

                    <div class="w-full md:w-40">
                        <select name="type" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm">
                            <option value="workout">Workout</option>
                            <option value="nutrition">Nutrition</option>
                            <option value="rest">Rest</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <button type="submit" class="px-5 py-2.5 bg-fit-green hover:bg-fit-green-dark text-white font-bold rounded-xl transition-all duration-300 shadow-md shadow-fit-green/20 text-sm whitespace-nowrap">
                        + Add Goal
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Daily Notes Area -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm space-y-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daily Reflections</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Jot down how your body felt, sleep quality, and energy levels.</p>

            @php
                $goalDoc = \DB::table('daily_goals')->where('user_id', auth()->user()->id ?? auth()->user()->_id)->where('date', $date)->first();
                $docId = $goalDoc ? (string)($goalDoc->_id ?? $goalDoc->id ?? '') : '';
            @endphp

            @if($docId)
                <form method="POST" action="{{ route('daily-goals.update', $docId) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="save_notes">

                    <textarea name="notes" rows="6" placeholder="Felt strong during squats, diet was 100% clean..."
                        class="w-full p-4 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm leading-relaxed resize-none">{{ $notes }}</textarea>

                    <button type="submit" class="w-full py-3 bg-fit-green hover:bg-fit-green-dark text-white font-bold rounded-xl transition-all duration-300 shadow-md shadow-fit-green/20 text-sm">
                        Save Reflections
                    </button>
                </form>
            @else
                <div class="text-center py-8 border border-dashed border-gray-200 dark:border-gray-850 rounded-2xl">
                    <p class="text-xs text-gray-400 dark:text-gray-550 px-4">Add at least one goal above for this date to unlock the reflection notes section.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
