<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NutritionController extends Controller
{
    /**
     * Get the hardcoded food database.
     */
    private function getFoodDatabase(): array
    {
        return [
            ['name' => 'Chicken Breast', 'cal_per_100g' => 165, 'protein' => 31.0, 'carbs' => 0.0, 'fat' => 3.6],
            ['name' => 'Brown Rice', 'cal_per_100g' => 216, 'protein' => 5.0, 'carbs' => 45.0, 'fat' => 1.8],
            ['name' => 'Whole Egg (1 piece - 50g)', 'cal_per_100g' => 143, 'protein' => 12.6, 'carbs' => 0.7, 'fat' => 9.5],
            ['name' => 'Rolled Oats', 'cal_per_100g' => 379, 'protein' => 13.5, 'carbs' => 67.7, 'fat' => 6.5],
            ['name' => 'Banana (1 medium - 118g)', 'cal_per_100g' => 89, 'protein' => 1.1, 'carbs' => 22.8, 'fat' => 0.3],
            ['name' => 'Apple (1 medium - 182g)', 'cal_per_100g' => 52, 'protein' => 0.3, 'carbs' => 13.8, 'fat' => 0.2],
            ['name' => 'Whole Milk', 'cal_per_100g' => 61, 'protein' => 3.2, 'carbs' => 4.8, 'fat' => 3.3],
            ['name' => 'Almonds', 'cal_per_100g' => 579, 'protein' => 21.2, 'carbs' => 21.6, 'fat' => 49.9],
            ['name' => 'Sweet Potato', 'cal_per_100g' => 86, 'protein' => 1.6, 'carbs' => 20.1, 'fat' => 0.1],
            ['name' => 'Salmon Fillet', 'cal_per_100g' => 208, 'protein' => 20.0, 'carbs' => 0.0, 'fat' => 13.0],
            ['name' => 'Canned Tuna (in water)', 'cal_per_100g' => 116, 'protein' => 26.0, 'carbs' => 0.0, 'fat' => 1.0],
            ['name' => 'Greek Yogurt (Plain, Low Fat)', 'cal_per_100g' => 73, 'protein' => 10.0, 'carbs' => 3.6, 'fat' => 2.0],
            ['name' => 'Broccoli', 'cal_per_100g' => 34, 'protein' => 2.8, 'carbs' => 6.6, 'fat' => 0.4],
            ['name' => 'Spinach', 'cal_per_100g' => 23, 'protein' => 2.9, 'carbs' => 3.6, 'fat' => 0.4],
            ['name' => 'Lentils (Cooked)', 'cal_per_100g' => 116, 'protein' => 9.0, 'carbs' => 20.0, 'fat' => 0.4],
            ['name' => 'Whey Protein Powder', 'cal_per_100g' => 393, 'protein' => 80.0, 'carbs' => 6.0, 'fat' => 5.0],
            ['name' => 'Olive Oil', 'cal_per_100g' => 884, 'protein' => 0.0, 'carbs' => 0.0, 'fat' => 100.0],
            ['name' => 'Avocado', 'cal_per_100g' => 160, 'protein' => 2.0, 'carbs' => 8.5, 'fat' => 14.7],
            ['name' => 'Peanut Butter', 'cal_per_100g' => 588, 'protein' => 25.0, 'carbs' => 20.0, 'fat' => 50.0],
            ['name' => 'Whole Wheat Bread', 'cal_per_100g' => 247, 'protein' => 13.0, 'carbs' => 41.0, 'fat' => 3.4],
            ['name' => 'Lean Beef (Sirloin)', 'cal_per_100g' => 202, 'protein' => 27.0, 'carbs' => 0.0, 'fat' => 10.4],
            ['name' => 'Turkey Breast', 'cal_per_100g' => 135, 'protein' => 30.0, 'carbs' => 0.0, 'fat' => 1.5],
            ['name' => 'Quinoa (Cooked)', 'cal_per_100g' => 120, 'protein' => 4.4, 'carbs' => 21.3, 'fat' => 1.9],
            ['name' => 'Mixed Berries', 'cal_per_100g' => 50, 'protein' => 0.7, 'carbs' => 12.0, 'fat' => 0.3],
            ['name' => 'Chia Seeds', 'cal_per_100g' => 486, 'protein' => 16.5, 'carbs' => 42.1, 'fat' => 30.7],
            ['name' => 'Cottage Cheese', 'cal_per_100g' => 98, 'protein' => 11.0, 'carbs' => 3.4, 'fat' => 4.3],
            ['name' => 'Tofu (Firm)', 'cal_per_100g' => 144, 'protein' => 17.0, 'carbs' => 3.0, 'fat' => 9.0],
            ['name' => 'Black Beans (Cooked)', 'cal_per_100g' => 132, 'protein' => 8.9, 'carbs' => 23.7, 'fat' => 0.5],
            ['name' => 'White Rice', 'cal_per_100g' => 130, 'protein' => 2.7, 'carbs' => 28.0, 'fat' => 0.3],
            ['name' => 'Potato (Baked)', 'cal_per_100g' => 93, 'protein' => 2.5, 'carbs' => 21.0, 'fat' => 0.1],
            ['name' => 'Walnuts', 'cal_per_100g' => 654, 'protein' => 15.2, 'carbs' => 13.7, 'fat' => 65.2],
        ];
    }

    /**
     * Display listing of food logs and workout calorie calculator.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                throw new \Exception("Guest Mode");
            }
            $userId = $user->id ?? $user->_id;

            session(['last_visited_page' => 'nutrition.index']);

            // Current date selection
            $today = Carbon::today()->toDateString();
            $date = $request->input('date', $today);

            // Food database
            $foodDatabase = $this->getFoodDatabase();

            // Calculate BMR and Maintenance Calories based on user's profile data (Mifflin-St Jeor)
            $weight = (float) ($user->weight_kg ?? 70);
            $height = (float) ($user->height_cm ?? 175);
            $age = (int) ($user->age ?? 25);
            $goal = $user->fitness_goal ?? 'stay_fit';

            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
            $maintenanceCalories = round($bmr * 1.4);

            // Calorie & macro targets based on fitness goals
            if ($goal === 'lose_weight') {
                $calorieGoal = max(1200, $maintenanceCalories - 500);
                $proteinRatio = 0.35; $fatRatio = 0.25; $carbsRatio = 0.40;
            } elseif ($goal === 'build_muscle') {
                $calorieGoal = $maintenanceCalories + 400;
                $proteinRatio = 0.30; $fatRatio = 0.25; $carbsRatio = 0.45;
            } elseif ($goal === 'improve_endurance') {
                $calorieGoal = $maintenanceCalories + 200;
                $proteinRatio = 0.20; $fatRatio = 0.25; $carbsRatio = 0.55;
            } else { // stay_fit
                $calorieGoal = $maintenanceCalories;
                $proteinRatio = 0.25; $fatRatio = 0.25; $carbsRatio = 0.50;
            }
            $calorieGoal = round($calorieGoal);

            $targetProtein = round(($calorieGoal * $proteinRatio) / 4);
            $targetCarbs = round(($calorieGoal * $carbsRatio) / 4);
            $targetFat = round(($calorieGoal * $fatRatio) / 9);

            try {
                // Fetch today's food logs via Query Builder
                $logs = DB::table('nutrition_logs')
                    ->where('user_id', $userId)
                    ->where('date', $date)
                    ->get()
                    ->map(fn($item) => (array)$item)
                    ->toArray();

                // Calculate daily totals
                $totals = [
                    'calories' => 0,
                    'protein' => 0,
                    'carbs' => 0,
                    'fat' => 0
                ];

                foreach ($logs as $log) {
                    $totals['calories'] += $log['calories'] ?? 0;
                    $totals['protein'] += $log['protein_g'] ?? 0;
                    $totals['carbs'] += $log['carbs_g'] ?? 0;
                    $totals['fat'] += $log['fat_g'] ?? 0;
                }

                // Ensure values are rounded
                $totals['calories'] = round($totals['calories']);
                $totals['protein'] = round($totals['protein'], 1);
                $totals['carbs'] = round($totals['carbs'], 1);
                $totals['fat'] = round($totals['fat'], 1);

                // Fetch last 7 days of calorie history for the bar chart
                $sevenDaysAgo = Carbon::today()->subDays(6)->toDateString();
                $weeklyLogs = DB::table('nutrition_logs')
                    ->where('user_id', $userId)
                    ->where('date', '>=', $sevenDaysAgo)
                    ->get()
                    ->map(fn($item) => (array)$item)
                    ->toArray();

                $weeklyHistory = [];
                for ($i = 6; $i >= 0; $i--) {
                    $d = Carbon::today()->subDays($i)->toDateString();
                    $label = Carbon::today()->subDays($i)->format('D');
                    $weeklyHistory[$label] = 0;

                    foreach ($weeklyLogs as $wLog) {
                        if (isset($wLog['date']) && $wLog['date'] === $d) {
                            $weeklyHistory[$label] += $wLog['calories'] ?? 0;
                        }
                    }
                    $weeklyHistory[$label] = round($weeklyHistory[$label]);
                }

                // Fetch all exercises from DB for the workout calorie calculator
                $exercises = DB::table('exercises')->get()->map(fn($item) => (array)$item)->toArray();

                // MET value mapping by exercise muscle group/category for workout calorie tracking
                $metValues = [
                    'Chest' => 4.0,
                    'Back' => 4.5,
                    'Legs' => 6.0,
                    'Shoulders' => 4.0,
                    'Arms' => 3.5,
                    'Core' => 3.8,
                    'Cardio' => 8.0,
                    'Flexibility' => 2.5
                ];

                // Map exercises with MET values
                $exercisesJson = [];
                foreach ($exercises as $exercise) {
                    $muscleGroup = $exercise['muscle_group'] ?? 'Cardio';
                    $met = $metValues[$muscleGroup] ?? 4.0;
                    $exercisesJson[] = [
                        'id' => (string) $exercise['_id'],
                        'name' => $exercise['name'],
                        'met' => $met
                    ];
                }
            } catch (\Exception $dbEx) {
                // Graceful fallbacks for unseeded / offline databases
                $logs = [
                    [
                        '_id' => 'mock_log_1',
                        'food_name' => 'Chicken Breast',
                        'quantity_grams' => 200,
                        'calories' => 330,
                        'protein_g' => 62.0,
                        'carbs_g' => 0.0,
                        'fat_g' => 7.2,
                        'meal_type' => 'Lunch'
                    ],
                    [
                        '_id' => 'mock_log_2',
                        'food_name' => 'Brown Rice',
                        'quantity_grams' => 150,
                        'calories' => 324,
                        'protein_g' => 7.5,
                        'carbs_g' => 67.5,
                        'fat_g' => 2.7,
                        'meal_type' => 'Lunch'
                    ]
                ];

                $totals = [
                    'calories' => 654,
                    'protein' => 69.5,
                    'carbs' => 67.5,
                    'fat' => 9.9
                ];

                $weeklyHistory = [
                    'Mon' => 2100,
                    'Tue' => 2300,
                    'Wed' => 1950,
                    'Thu' => 2400,
                    'Fri' => 2200,
                    'Sat' => 2600,
                    'Sun' => 2150
                ];

                $exercisesJson = [
                    ['id' => 'mock_ex1', 'name' => 'Barbell Bench Press', 'met' => 4.0],
                    ['id' => 'mock_ex2', 'name' => 'Pull-Ups', 'met' => 4.5],
                    ['id' => 'mock_ex3', 'name' => 'Barbell Back Squats', 'met' => 6.0]
                ];
            }

            return view('nutrition.index', compact(
                'date',
                'foodDatabase',
                'calorieGoal',
                'maintenanceCalories',
                'targetProtein',
                'targetCarbs',
                'targetFat',
                'logs',
                'totals',
                'weeklyHistory',
                'exercisesJson',
                'user'
            ));

        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Failed to retrieve nutrition data: ' . $e->getMessage());
        }
    }

    /**
     * Store food log entry in nutrition_logs.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id ?? $user->_id;

            $validated = $request->validate([
                'food_name' => ['required', 'string'],
                'meal_type' => ['required', 'string', 'in:breakfast,lunch,dinner,snack'],
                'quantity_grams' => ['required', 'numeric', 'min:1', 'max:5000'],
                'date' => ['required', 'date_format:Y-m-d'],
            ]);

            $foodName = $validated['food_name'];
            $quantity = (float) $validated['quantity_grams'];
            $date = $validated['date'];

            // Find food in array
            $foodItem = null;
            foreach ($this->getFoodDatabase() as $food) {
                if ($food['name'] === $foodName) {
                    $foodItem = $food;
                    break;
                }
            }

            if (!$foodItem) {
                return redirect()->back()->with('error', 'Selected food item not found in database.');
            }

            // Calculate macro values based on selected quantity
            $ratio = $quantity / 100.0;
            $calories = $foodItem['cal_per_100g'] * $ratio;
            $protein = $foodItem['protein'] * $ratio;
            $carbs = $foodItem['carbs'] * $ratio;
            $fat = $foodItem['fat'] * $ratio;

            // Insert into MongoDB
            DB::table('nutrition_logs')->insert([
                'user_id' => $userId,
                'date' => $date,
                'meal_type' => $validated['meal_type'],
                'food_name' => $foodName,
                'quantity_grams' => $quantity,
                'calories' => (float) $calories,
                'protein_g' => (float) $protein,
                'carbs_g' => (float) $carbs,
                'fat_g' => (float) $fat,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            session()->flash('success', 'Food log added successfully!');
            return redirect()->route('nutrition.index', ['date' => $date]);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to log food: ' . $e->getMessage());
        }
    }

    /**
     * Delete a food log entry.
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $userId = $user->id ?? $user->_id;

            // Delete entry using Query Builder
            $log = DB::table('nutrition_logs')->where('_id', $id)->first();
            if ($log) {
                $log = (array)$log;
            }
            if (!$log || $log['user_id'] != $userId) {
                return redirect()->back()->with('error', 'Food log not found or unauthorized.');
            }

            $date = $log['date'];

            DB::table('nutrition_logs')->where('_id', $id)->delete();

            session()->flash('success', 'Food entry removed.');
            return redirect()->route('nutrition.index', ['date' => $date]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete food entry: ' . $e->getMessage());
        }
    }
}
