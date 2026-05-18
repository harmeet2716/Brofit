<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExerciseController extends Controller
{
    /**
     * Display a listing of exercises with category filters, search and manual pagination.
     */
    public function index(Request $request)
    {
        try {
            session(['last_visited_page' => 'exercises.index']);

            $muscleGroup = $request->input('muscle_group');
            $search = $request->input('search');

            $query = DB::table('exercises');

            if ($muscleGroup && $muscleGroup !== 'all') {
                $query = $query->where('muscle_group', $muscleGroup);
            }

            if ($search) {
                // MongoDB-compatible case-insensitive like using standard where
                $query = $query->where('name', 'like', '%' . $search . '%');
            }

            // Manual Pagination
            $page = (int) $request->input('page', 1);
            if ($page < 1)
                $page = 1;
            $perPage = 6;
            $skip = ($page - 1) * $perPage;

            try {
                $total = $query->count();
                $exercises = $query->skip($skip)->take($perPage)->get()->map(function($item) {
                    $arr = (array)$item;
                    $arr['_id'] = (string)($arr['id'] ?? $arr['_id'] ?? '');
                    return $arr;
                })->toArray();
                $totalPages = (int) ceil($total / $perPage);
                if ($totalPages < 1)
                    $totalPages = 1;
            } catch (\Exception $dbEx) {
                // Mock fallbacks if DB is down/empty
                $exercises = [
                    [
                        '_id' => 'mock_ex1',
                        'name' => 'Barbell Bench Press',
                        'description' => 'The ultimate upper body push exercise for building chest, shoulders, and triceps.',
                        'muscle_group' => 'Chest',
                        'difficulty' => 'Intermediate',
                        'calories_burned_per_set' => 15,
                        'duration_seconds' => 45,
                        'image_url' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=600'
                    ],
                    [
                        '_id' => 'mock_ex2',
                        'name' => 'Pull-Ups',
                        'description' => 'Build a powerful and wide back using only your body weight with this classic movement.',
                        'muscle_group' => 'Back',
                        'difficulty' => 'Intermediate',
                        'calories_burned_per_set' => 12,
                        'duration_seconds' => 30,
                        'image_url' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=600'
                    ],
                    [
                        '_id' => 'mock_ex3',
                        'name' => 'Barbell Back Squats',
                        'description' => 'The king of lower body movements, perfect for building strong quads, hamstrings, and glutes.',
                        'muscle_group' => 'Legs',
                        'difficulty' => 'Advanced',
                        'calories_burned_per_set' => 25,
                        'duration_seconds' => 60,
                        'image_url' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=600'
                    ]
                ];
                $totalPages = 1;
            }

            // Muscle groups for tabs/filters
            $muscleGroups = ['Chest', 'Back', 'Legs', 'Shoulders', 'Arms', 'Core', 'Cardio', 'Flexibility'];

            return view('exercises.index', compact(
                'exercises',
                'muscleGroup',
                'search',
                'page',
                'totalPages',
                'muscleGroups'
            ));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Failed to retrieve exercises: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified exercise details.
     */
    public function show($id)
    {
        try {
            session(['last_visited_page' => 'exercises.show']);

            $exercise = (array) DB::table('exercises')->where('_id', $id)->first();
            if (empty($exercise)) {
                return redirect()->route('exercises.index')->with('error', 'Exercise not found.');
            }

            return view('exercises.show', compact('exercise'));
        } catch (\Exception $e) {
            return redirect()->route('exercises.index')->with('error', 'Failed to retrieve exercise: ' . $e->getMessage());
        }
    }

    /**
     * Add the exercise as a daily goal for today.
     */
    public function addToGoals(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $userId = $user->id ?? $user->_id;

            // Fetch the exercise details
            $exercise = (array) DB::table('exercises')->where('_id', $id)->first();
            if (empty($exercise)) {
                return redirect()->back()->with('error', 'Exercise not found.');
            }

            $todayStr = Carbon::today()->toDateString();

            // Fetch today's goals
            $goalDoc = (array) DB::table('daily_goals')
                ->where('user_id', $userId)
                ->where('date', $todayStr)
                ->first();

            $goalItem = [
                'title' => 'Do ' . $exercise['name'],
                'type' => 'workout',
                'completed' => false
            ];

            if (!empty($goalDoc)) {
                // Check if already in the list
                $goalsList = $goalDoc['goals'] ?? [];
                foreach ($goalsList as $g) {
                    if ($g['title'] === $goalItem['title']) {
                        return redirect()->back()->with('success', 'This exercise is already added to today\'s goals.');
                    }
                }

                // Add to list and update in MongoDB
                $goalsList[] = $goalItem;
                DB::table('daily_goals')
                    ->where('_id', $goalDoc['_id'])
                    ->update([
                        'goals' => $goalsList,
                        'updated_at' => now()
                    ]);
            } else {
                // Create a new document for today's goals
                DB::table('daily_goals')->insert([
                    'user_id' => $userId,
                    'date' => $todayStr,
                    'goals' => [$goalItem],
                    'notes' => '',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            session()->flash('success', 'Added "' . $exercise['name'] . '" to today\'s fitness goals! Let\'s do it! 💪');
            return redirect()->route('daily-goals.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add exercise to daily goals: ' . $e->getMessage());
        }
    }
}
