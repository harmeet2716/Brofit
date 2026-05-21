<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        try {
            $user = Auth::user();
            $userId = $user->id ?? $user->_id;

            session(['last_visited_page' => 'profile.show']);

            // Fetch enrolled courses via Query Builder
            $enrollments = DB::table('enrollments')
                ->where('user_id', $userId)
                ->get()
                ->map(fn($item) => (array)$item)
                ->toArray();

            $enrolledCourses = [];
            $totalProgress = 0;
            $count = 0;

            foreach ($enrollments as $enrollment) {
                $course = DB::table('courses')->where('_id', $enrollment['course_id'])->first();
                if ($course) {
                    $course = (array)$course;
                    $course['_id'] = (string)($course['_id'] ?? $course['id'] ?? $enrollment['course_id']);
                    $enrollmentData = [
                        'course_id' => $course['_id'],
                        'name' => $course['name'],
                        'enrolled_at' => $enrollment['enrolled_at'] ?? now(),
                        'progress' => $enrollment['progress'] ?? 0,
                        'status' => $enrollment['status'] ?? 'active',
                    ];
                    $enrolledCourses[] = $enrollmentData;
                    
                    $totalProgress += ($enrollment['progress'] ?? 0);
                    $count++;
                }
            }

            $overallFitnessProgress = $count > 0 ? round($totalProgress / $count) : 0;

            return view('profile.index', compact('user', 'enrolledCourses', 'overallFitnessProgress'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load profile: ' . $e->getMessage());
        }
    }

    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        try {
            $user = Auth::user();
            session(['last_visited_page' => 'profile.edit']);
            return view('profile.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load profile editor: ' . $e->getMessage());
        }
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id ?? $user->_id;

            // Form validation
            $validated = $request->validate([
                'name' => ['required', 'string', 'min:2', 'max:50'],
                'age' => ['required', 'integer', 'min:13', 'max:100'],
                'height_cm' => ['required', 'numeric', 'min:100', 'max:250'],
                'weight_kg' => ['required', 'numeric', 'min:30', 'max:300'],
                'fitness_goal' => ['required', 'string', 'in:lose_weight,build_muscle,stay_fit,improve_endurance'],
            ]);

            // Query Builder update
            DB::table('users')
                ->where('_id', $userId)
                ->update([
                    'name' => $validated['name'],
                    'age' => (int) $validated['age'],
                    'height_cm' => (float) $validated['height_cm'],
                    'weight_kg' => (float) $validated['weight_kg'],
                    'fitness_goal' => $validated['fitness_goal'],
                    'updated_at' => now(),
                ]);

            // Sync session
            session(['fitness_goal' => $validated['fitness_goal']]);

            session()->flash('success', 'Profile updated successfully!');
            return redirect()->route('profile.show');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }
}
