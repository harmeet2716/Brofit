@extends('layouts.app')

@section('title', 'Nutrition & Exercise Calories — FitNexus')
@section('page_title', 'Nutrition & Calories')
@section('breadcrumb', 'Nutrition Manager')

@section('content')

{{-- TOP BAR - Date Selector & Overview stats --}}
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Date picker -->
    <div class="lg:col-span-1 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-5 shadow-sm flex flex-col justify-center">
        <form id="nutriDateForm" method="GET" action="{{ route('nutrition.index') }}" class="space-y-2">
            <label for="nutri-date" class="text-xs font-bold text-gray-400 uppercase tracking-widest">Select Date</label>
            <input type="date" name="date" id="nutri-date" value="{{ $date }}" onchange="document.getElementById('nutriDateForm').submit();"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-semibold focus:ring-2 focus:ring-fit-green outline-none text-sm">
        </form>
    </div>

    <!-- Stat Ring / Bar of Daily Calories -->
    <div class="lg:col-span-3 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex-1 space-y-2">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Calorie Target Status</h3>
            <div class="flex justify-between items-center text-sm font-bold text-gray-500">
                <span>Consumed: <span class="text-fit-green">{{ $totals['calories'] }} kcal</span></span>
                <span>Goal: <span>{{ $calorieGoal }} kcal</span></span>
            </div>
            
            @php
                $pct = $calorieGoal > 0 ? min(100, round(($totals['calories'] / $calorieGoal) * 100)) : 0;
            @endphp
            <div class="w-full h-3 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-fit-green to-emerald-500 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
            </div>
            <p class="text-xs text-gray-450 dark:text-gray-500 font-medium">
                {{ $pct < 100 ? 'You have ' . ($calorieGoal - $totals['calories']) . ' kcal remaining to reach your target.' : 'Target calories met for today! Great job! 🚀' }}
            </p>
        </div>

        <div class="flex gap-4 md:border-l border-gray-100 dark:border-gray-800 md:pl-6">
            <div class="text-center px-2">
                <span class="text-xs font-semibold text-gray-450 uppercase block">Protein</span>
                <span class="text-lg font-black text-gray-900 dark:text-white mt-1 block">{{ $totals['protein'] }}g</span>
            </div>
            <div class="text-center px-2">
                <span class="text-xs font-semibold text-gray-450 uppercase block">Carbs</span>
                <span class="text-lg font-black text-gray-900 dark:text-white mt-1 block">{{ $totals['carbs'] }}g</span>
            </div>
            <div class="text-center px-2">
                <span class="text-xs font-semibold text-gray-450 uppercase block">Fat</span>
                <span class="text-lg font-black text-gray-900 dark:text-white mt-1 block">{{ $totals['fat'] }}g</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- LEFT: Food Logger Form -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm space-y-5">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Log Nutrition Intake</h3>

            <!-- Food Search and Quantity Form -->
            <form method="POST" action="{{ route('nutrition.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">

                <!-- Meal selection -->
                <div>
                    <label for="meal_type" class="block text-xs font-bold text-gray-450 uppercase tracking-widest mb-1.5">Meal Type</label>
                    <select name="meal_type" id="meal_type" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-250 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm font-semibold">
                        <option value="breakfast">🌅 Breakfast</option>
                        <option value="lunch">☀️ Lunch</option>
                        <option value="dinner">🌌 Dinner</option>
                        <option value="snack">🍇 Snack</option>
                    </select>
                </div>

                <!-- Food name selector with vanilla search filtering -->
                <div>
                    <label for="food_name" class="block text-xs font-bold text-gray-450 uppercase tracking-widest mb-1.5">Choose Food</label>
                    
                    <!-- Search input inside dropdown container -->
                    <div class="space-y-2">
                        <input type="text" id="food-search" placeholder="Type to search catalog..." onkeyup="filterFoodCatalog()"
                            class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-750 bg-white dark:bg-gray-850 text-gray-900 dark:text-gray-100 focus:ring-1 focus:ring-fit-green outline-none text-xs">
                        
                        <select name="food_name" id="food_name" required onchange="calculateMacros()"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-250 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm font-medium">
                            @foreach($foodDatabase as $food)
                                <option value="{{ $food['name'] }}"
                                    data-cal="{{ $food['cal_per_100g'] }}"
                                    data-pro="{{ $food['protein'] }}"
                                    data-carbs="{{ $food['carbs'] }}"
                                    data-fat="{{ $food['fat'] }}">
                                    {{ $food['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Quantity in grams -->
                <div>
                    <label for="quantity_grams" class="block text-xs font-bold text-gray-450 uppercase tracking-widest mb-1.5">Weight / Grams</label>
                    <input type="number" name="quantity_grams" id="quantity_grams" value="100" min="1" max="5000" required oninput="calculateMacros()"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-250 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm font-semibold">
                </div>

                <!-- LIVE METRIC PREVIEW ROW -->
                <div class="p-4 bg-gray-50 dark:bg-gray-850 border border-gray-150/50 dark:border-gray-800 rounded-2xl space-y-2">
                    <span class="text-[10px] font-black uppercase text-gray-400 tracking-wider">Estimated Preview (selected weight)</span>
                    <div class="grid grid-cols-4 gap-2 text-center">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 block">Kcal</span>
                            <span id="preview-cal" class="text-xs font-black text-gray-800 dark:text-white">0</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 block">Prot(g)</span>
                            <span id="preview-pro" class="text-xs font-black text-gray-800 dark:text-white">0</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 block">Carbs(g)</span>
                            <span id="preview-carbs" class="text-xs font-black text-gray-800 dark:text-white">0</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 block">Fat(g)</span>
                            <span id="preview-fat" class="text-xs font-black text-gray-800 dark:text-white">0</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 bg-fit-green hover:bg-fit-green-dark text-white font-extrabold rounded-2xl transition-all duration-300 shadow-lg shadow-fit-green/20 text-sm">
                    🍇 Add to Today's Logs
                </button>
            </form>
        </div>
    </div>

    <!-- CENTER COLUMN: Daily Food Log Sheet -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm space-y-5">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Intake Log Sheet</h3>

            @if(count($logs) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="pb-3.5">Meal</th>
                                <th class="pb-3.5">Food</th>
                                <th class="pb-3.5">Qty</th>
                                <th class="pb-3.5">Kcal</th>
                                <th class="pb-3.5">Macros (P/C/F)</th>
                                <th class="pb-3.5 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-850">
                            @foreach($logs as $log)
                                <tr class="text-gray-700 dark:text-gray-300">
                                    <td class="py-3.5 font-bold">
                                        <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold tracking-wide {{ $log['meal_type'] === 'breakfast' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30' : ($log['meal_type'] === 'lunch' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30' : ($log['meal_type'] === 'dinner' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30' : 'bg-green-105 text-green-805 dark:bg-green-900/30')) }}">
                                            {{ $log['meal_type'] }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 font-semibold text-gray-900 dark:text-white truncate max-w-[120px]" title="{{ $log['food_name'] }}">
                                        {{ $log['food_name'] }}
                                    </td>
                                    <td class="py-3.5 font-medium text-xs text-gray-450">{{ $log['quantity_grams'] }}g</td>
                                    <td class="py-3.5 font-black text-xs text-fit-green">{{ round($log['calories']) }}</td>
                                    <td class="py-3.5 font-medium text-xs text-gray-400">
                                        {{ round($log['protein_g'], 1) }}g / {{ round($log['carbs_g'], 1) }}g / {{ round($log['fat_g'], 1) }}g
                                    </td>
                                    <td class="py-3.5 text-right">
                                        <form method="POST" action="{{ route('nutrition.destroy', $log['_id']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-450 hover:text-red-500 transition-colors" title="Delete log">
                                                &#10005;
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- TOTALS ROW -->
                            <tr class="bg-gray-50/65 dark:bg-gray-850/30 font-black text-gray-900 dark:text-white border-t-2 border-gray-150 dark:border-gray-800">
                                <td class="py-4 pl-3" colspan="2">Daily Consumed Totals</td>
                                <td class="py-4">&mdash;</td>
                                <td class="py-4 text-fit-green">{{ $totals['calories'] }} kcal</td>
                                <td class="py-4" colspan="2">
                                    {{ $totals['protein'] }}g P / {{ $totals['carbs'] }}g C / {{ $totals['fat'] }}g F
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-10 border border-dashed border-gray-200 dark:border-gray-850 rounded-2xl">
                    <p class="text-gray-400 dark:text-gray-550 text-sm">No food logged for this date. Enter items on the left side to get started!</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- CHARTS ROW --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-4">
    <!-- Doughnut Chart: Macros breakdown -->
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm flex flex-col items-center">
        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-6 w-full text-left">Today's Macros Ratio</h3>
        <div class="w-64 h-64">
            <canvas id="macroDoughnutChart"></canvas>
        </div>
    </div>

    <!-- Bar Chart: Weekly calories consumed -->
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm">
        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-6">Weekly Calorie History</h3>
        <div class="h-64 w-full">
            <canvas id="weeklyCalBarChart"></canvas>
        </div>
    </div>
</div>

{{-- BOTTOM ROW: Workout Calorie Burn Calculator --}}
<div class="pt-8 border-t border-gray-150 dark:border-gray-850 mt-8">
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 md:p-8 shadow-sm">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Workout Calorie Burn Calculator</h3>
        <p class="text-sm text-gray-550 dark:text-gray-450 mb-6">Calculate calories burned based on exercise MET values and your current biometrics profile weight.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Select Exercise -->
            <div>
                <label for="workout_exercise" class="block text-xs font-bold text-gray-450 uppercase tracking-widest mb-1.5">Exercise Movement</label>
                <select id="workout_exercise" class="w-full px-4 py-3 rounded-xl border border-gray-250 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm font-semibold">
                    @foreach($exercisesJson as $ex)
                        <option value="{{ $ex['id'] }}" data-met="{{ $ex['met'] }}">
                            {{ $ex['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Duration in Minutes -->
            <div>
                <label for="workout_duration" class="block text-xs font-bold text-gray-450 uppercase tracking-widest mb-1.5">Duration (Minutes)</label>
                <input type="number" id="workout_duration" value="30" min="1" max="300"
                    class="w-full px-4 py-3 rounded-xl border border-gray-250 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm font-semibold">
            </div>

            <!-- Weight pre-filled -->
            <div>
                <label for="workout_weight" class="block text-xs font-bold text-gray-450 uppercase tracking-widest mb-1.5">Body Weight (kg)</label>
                <input type="number" id="workout_weight" value="{{ $user->weight_kg ?? 70 }}" min="30" max="300"
                    class="w-full px-4 py-3 rounded-xl border border-gray-250 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm font-semibold">
            </div>
        </div>

        <!-- Calculate Trigger row -->
        <div class="mt-6 flex flex-col md:flex-row items-center justify-between gap-4 p-5 bg-fit-green/5 dark:bg-fit-green/10 border border-fit-green/20 rounded-2xl">
            <div class="flex items-center gap-3">
                <span class="text-3xl">🔥</span>
                <div>
                    <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200">Estimated Burn</h4>
                    <p class="text-2xl font-black text-fit-green"><span id="burned-calories-display">0</span> kcal</p>
                </div>
            </div>
            
            <button type="button" onclick="calculateWorkoutBurn()" class="px-8 py-3 bg-fit-green hover:bg-fit-green-dark text-white font-extrabold rounded-xl transition-all duration-300 shadow-md shadow-fit-green/20 text-sm whitespace-nowrap">
                ⚡ Calculate Calories
            </button>
        </div>
    </div>
</div>

{{-- Chart.js & Vanilla JavaScript logic scripts --}}
<script>
    // Initialize Preview on page load
    document.addEventListener("DOMContentLoaded", function() {
        calculateMacros();
        initCharts();
    });

    // 1. Food Dropdown Filtering Search Input logic
    function filterFoodCatalog() {
        const query = document.getElementById("food-search").value.toLowerCase();
        const select = document.getElementById("food_name");
        const options = select.options;

        let firstMatchIdx = -1;
        for (let i = 0; i < options.length; i++) {
            const text = options[i].text.toLowerCase();
            if (text.includes(query)) {
                options[i].style.display = "block";
                if (firstMatchIdx === -1) {
                    firstMatchIdx = i;
                }
            } else {
                options[i].style.display = "none";
            }
        }

        // Switch to the first match if found
        if (firstMatchIdx !== -1) {
            select.selectedIndex = firstMatchIdx;
            calculateMacros();
        }
    }

    // 2. Calorie live macro calculator
    function calculateMacros() {
        const select = document.getElementById("food_name");
        const selectedOpt = select.options[select.selectedIndex];
        
        if (!selectedOpt) return;

        const quantity = parseFloat(document.getElementById("quantity_grams").value) || 0;
        const ratio = quantity / 100.0;

        const cal = parseFloat(selectedOpt.getAttribute("data-cal")) * ratio;
        const pro = parseFloat(selectedOpt.getAttribute("data-pro")) * ratio;
        const carbs = parseFloat(selectedOpt.getAttribute("data-carbs")) * ratio;
        const fat = parseFloat(selectedOpt.getAttribute("data-fat")) * ratio;

        document.getElementById("preview-cal").innerText = Math.round(cal);
        document.getElementById("preview-pro").innerText = pro.toFixed(1);
        document.getElementById("preview-carbs").innerText = carbs.toFixed(1);
        document.getElementById("preview-fat").innerText = fat.toFixed(1);
    }

    // 3. MET Workout calorie burn formula
    function calculateWorkoutBurn() {
        const select = document.getElementById("workout_exercise");
        const selectedOpt = select.options[select.selectedIndex];
        if (!selectedOpt) return;

        const met = parseFloat(selectedOpt.getAttribute("data-met")) || 4.0;
        const durationMin = parseFloat(document.getElementById("workout_duration").value) || 0;
        const weight = parseFloat(document.getElementById("workout_weight").value) || 70;

        // Formula: Calories = MET * Weight(kg) * Duration(hours)
        const durationHours = durationMin / 60.0;
        const burned = met * weight * durationHours;

        document.getElementById("burned-calories-display").innerText = Math.round(burned);
    }

    // 4. Initialize charts with dynamic totals
    function initCharts() {
        const isDark = document.documentElement.classList.contains('dark');
        const textGridColor = isDark ? '#374151' : '#e5e7eb';
        const labelTextColor = isDark ? '#9ca3af' : '#4b5563';

        // A. Macros Ratio Doughnut Chart
        const proTotal = parseFloat("{{ $totals['protein'] }}") || 0;
        const carbsTotal = parseFloat("{{ $totals['carbs'] }}") || 0;
        const fatTotal = parseFloat("{{ $totals['fat'] }}") || 0;

        const doughnutCtx = document.getElementById('macroDoughnutChart').getContext('2d');
        
        if (proTotal === 0 && carbsTotal === 0 && fatTotal === 0) {
            // Draw empty chart warning or empty doughnut
            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['No logged foods'],
                    datasets: [{
                        data: [1],
                        backgroundColor: [isDark ? '#1f2937' : '#f3f4f6'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        } else {
            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Protein (g)', 'Carbs (g)', 'Fat (g)'],
                    datasets: [{
                        data: [proTotal, carbsTotal, fatTotal],
                        backgroundColor: ['#22c55e', '#3b82f6', '#f59e0b'],
                        hoverOffset: 4,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: labelTextColor,
                                font: { size: 12, weight: 'bold' }
                            }
                        }
                    }
                });
            }

        // B. Weekly Calories Consumed Bar Chart
        const weeklyHistoryData = @json($weeklyHistory);
        const barLabels = Object.keys(weeklyHistoryData);
        const barValues = Object.values(weeklyHistoryData);

        const barCtx = document.getElementById('weeklyCalBarChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'Consumed (kcal)',
                    data: barValues,
                    backgroundColor: '#39D353',
                    borderRadius: 8,
                    maxBarThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: labelTextColor, font: { weight: 'bold' } }
                    },
                    y: {
                        grid: { color: textGridColor },
                        ticks: { color: labelTextColor, font: { weight: 'semibold' } }
                    }
                }
            }
        });
    }
</script>

@endsection
