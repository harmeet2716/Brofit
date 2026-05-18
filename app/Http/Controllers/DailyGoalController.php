<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DailyGoalController extends Controller
{
    /**
     * Display a listing of daily goals for a selected date.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id ?? $user->_id;

            session(['last_visited_page' => 'daily-goals.index']);

            // Get selected date: priorities are 1. Request, 2. Session, 3. Today
            $todayStr = Carbon::today()->toDateString();
            $date = $request->input('date');

            if ($date) {
                session(['selected_date' => $date]);
            } else {
                $date = session('selected_date', $todayStr);
            }

            // Fetch goal doc for the selected date
            $goalDoc = DB::table('daily_goals')
                ->where('user_id', $userId)
                ->where('date', $date)
                ->first();
            
            if ($goalDoc) {
                $goalDoc = (array)$goalDoc;
                $goalDoc['_id'] = (string)($goalDoc['id'] ?? $goalDoc['_id'] ?? '');
            }

            $goalsList = $goalDoc['goals'] ?? [];
            $notes = $goalDoc['notes'] ?? '';

            // Calculate completion %
            $completionPercent = 0;
            if (count($goalsList) > 0) {
                $completed = 0;
                foreach ($goalsList as $g) {
                    if (isset($g['completed']) && $g['completed']) {
                        $completed++;
                    }
                }
                $completionPercent = round(($completed / count($goalsList)) * 100);
            }

            return view('daily-goals.index', compact('date', 'goalsList', 'notes', 'completionPercent'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve daily goals: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created goal item for the selected date.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id ?? $user->_id;

            $validated = $request->validate([
                'title' => ['required', 'string', 'min:3', 'max:100'],
                'type' => ['required', 'string', 'in:workout,nutrition,rest,other'],
                'date' => ['required', 'date_format:Y-m-d'],
            ]);

            $date = $validated['date'];

            // Fetch goal doc
            $goalDoc = DB::table('daily_goals')
                ->where('user_id', $userId)
                ->where('date', $date)
                ->first();
            
            if ($goalDoc) {
                $goalDoc = (array)$goalDoc;
                $goalDoc['_id'] = (string)($goalDoc['id'] ?? $goalDoc['_id'] ?? '');
            }

            $newGoal = [
                'title' => $validated['title'],
                'type' => $validated['type'],
                'completed' => false,
            ];

            if ($goalDoc) {
                $goalsList = $goalDoc['goals'] ?? [];
                $goalsList[] = $newGoal;

                // Update using both possible primary key fields to be robust
                $targetId = $goalDoc['_id'];
                DB::table('daily_goals')
                    ->where('_id', $targetId)
                    ->orWhere('id', $targetId)
                    ->update([
                        'goals' => $goalsList,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('daily_goals')->insert([
                    'user_id' => $userId,
                    'date' => $date,
                    'goals' => [$newGoal],
                    'notes' => '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            session()->flash('success', 'Goal added successfully!');
            return redirect()->route('daily-goals.index', ['date' => $date]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to save goal: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the completion state of a goal or delete/update.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $userId = $user->id ?? $user->_id;

            // Fetch using both fields
            $goalDoc = DB::table('daily_goals')->where('_id', $id)->first();
            if (!$goalDoc) {
                $goalDoc = DB::table('daily_goals')->where('id', $id)->first();
            }

            if ($goalDoc) {
                $goalDoc = (array)$goalDoc;
                $goalDoc['_id'] = (string)($goalDoc['id'] ?? $goalDoc['_id'] ?? '');
            }

            if (!$goalDoc || $goalDoc['user_id'] != $userId) {
                return redirect()->back()->with('error', 'Daily goals document not found.');
            }

            $date = $goalDoc['date'];
            $goalsList = $goalDoc['goals'] ?? [];

            // Action type: toggle or save notes
            $action = $request->input('action');

            if ($action === 'toggle') {
                $index = (int) $request->input('index');
                if (isset($goalsList[$index])) {
                    $goalsList[$index]['completed'] = !$goalsList[$index]['completed'];
                }

                DB::table('daily_goals')
                    ->where('_id', $id)
                    ->orWhere('id', $id)
                    ->update([
                        'goals' => $goalsList,
                        'updated_at' => now(),
                    ]);

                session()->flash('success', 'Goal status updated!');
            } elseif ($action === 'save_notes') {
                $notes = $request->input('notes', '');
                DB::table('daily_goals')
                    ->where('_id', $id)
                    ->orWhere('id', $id)
                    ->update([
                        'notes' => $notes,
                        'updated_at' => now(),
                    ]);

                session()->flash('success', 'Notes saved successfully!');
            }

            return redirect()->route('daily-goals.index', ['date' => $date]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update: ' . $e->getMessage());
        }
    }

    /**
     * Delete an individual goal from the goals array.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $userId = $user->id ?? $user->_id;

            $goalDoc = DB::table('daily_goals')->where('_id', $id)->first();
            if (!$goalDoc) {
                $goalDoc = DB::table('daily_goals')->where('id', $id)->first();
            }

            if ($goalDoc) {
                $goalDoc = (array)$goalDoc;
                $goalDoc['_id'] = (string)($goalDoc['id'] ?? $goalDoc['_id'] ?? '');
            }

            if (!$goalDoc || $goalDoc['user_id'] != $userId) {
                return redirect()->back()->with('error', 'Daily goals document not found.');
            }

            $date = $goalDoc['date'];
            $index = (int) $request->input('index');
            $goalsList = $goalDoc['goals'] ?? [];

            if (isset($goalsList[$index])) {
                array_splice($goalsList, $index, 1);
            }

            DB::table('daily_goals')
                ->where('_id', $id)
                ->orWhere('id', $id)
                ->update([
                    'goals' => $goalsList,
                    'updated_at' => now(),
                ]);

            session()->flash('success', 'Goal deleted successfully.');
            return redirect()->route('daily-goals.index', ['date' => $date]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete goal: ' . $e->getMessage());
        }
    }

    /**
     * Copy yesterday's goals to the selected date.
     */
    public function copyYesterday(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id ?? $user->_id;

            $date = $request->input('date');
            if (!$date) {
                $date = session('selected_date', Carbon::today()->toDateString());
            }

            $yesterday = Carbon::parse($date)->subDay()->toDateString();

            // Fetch yesterday's goals
            $yesterdayDoc = DB::table('daily_goals')
                ->where('user_id', $userId)
                ->where('date', $yesterday)
                ->first();
            
            if ($yesterdayDoc) {
                $yesterdayDoc = (array)$yesterdayDoc;
                $yesterdayDoc['_id'] = (string)($yesterdayDoc['id'] ?? $yesterdayDoc['_id'] ?? '');
            }

            if (!$yesterdayDoc || empty($yesterdayDoc['goals'])) {
                return redirect()->route('daily-goals.index', ['date' => $date])->with('error', 'No goals found on ' . $yesterday . ' to copy.');
            }

            // Prepare list (reset completion to false for the new day)
            $copiedGoals = [];
            foreach ($yesterdayDoc['goals'] as $g) {
                $copiedGoals[] = [
                    'title' => $g['title'],
                    'type' => $g['type'],
                    'completed' => false
                ];
            }

            // Store or insert into target date
            $targetDoc = DB::table('daily_goals')
                ->where('user_id', $userId)
                ->where('date', $date)
                ->first();
            
            if ($targetDoc) {
                $targetDoc = (array)$targetDoc;
                $targetDoc['_id'] = (string)($targetDoc['id'] ?? $targetDoc['_id'] ?? '');
            }

            if ($targetDoc) {
                $targetId = $targetDoc['_id'];
                DB::table('daily_goals')
                    ->where('_id', $targetId)
                    ->orWhere('id', $targetId)
                    ->update([
                        'goals' => $copiedGoals,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('daily_goals')->insert([
                    'user_id' => $userId,
                    'date' => $date,
                    'goals' => $copiedGoals,
                    'notes' => '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            session()->flash('success', 'Successfully copied yesterday\'s goals to today!');
            return redirect()->route('daily-goals.index', ['date' => $date]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to copy yesterday\'s goals: ' . $e->getMessage());
        }
    }
}
