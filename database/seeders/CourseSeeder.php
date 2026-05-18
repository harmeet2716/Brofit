<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->truncate();

        $courses = [
            [
                'name' => 'Hypertrophy Mastery: Build Lean Muscle',
                'description' => 'A comprehensive weight training program designed for maximum muscle growth (hypertrophy). Learn the science behind progressive overload, proper lifting form, and high-intensity set execution.',
                'difficulty' => 'Intermediate',
                'category' => 'Strength',
                'duration_weeks' => 12,
                'price' => 29.99,
                'image_url' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&q=80&w=800',
                'features' => [
                    '3 Full-body workout schedules per week',
                    'Video guides for key compound movements',
                    'Detailed nutrition & macronutrient breakdown plans',
                    'Private forum support from certified trainers'
                ],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'HIIT Shred: 30-Day Fat Burner',
                'description' => 'Torch body fat and elevate your metabolism with high-intensity interval training. Designed for fast-paced action with zero to minimal equipment, perfect for calorie burning.',
                'difficulty' => 'Intermediate',
                'category' => 'HIIT',
                'duration_weeks' => 4,
                'price' => 19.99,
                'image_url' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&q=80&w=800',
                'features' => [
                    'Daily 20-minute bodyweight interval sessions',
                    'Heart rate zone training guidance',
                    'Low-carb meal prep schedules',
                    'Interactive tracking sheets'
                ],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ultimate Vinyasa Yoga Flow',
                'description' => 'Find balance, increase flexibility, and build core strength with our progressive Vinyasa flows. Perfect for clearing your mind while building deep muscular endurance.',
                'difficulty' => 'Beginner',
                'category' => 'Yoga',
                'duration_weeks' => 6,
                'price' => 14.99,
                'image_url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&q=80&w=800',
                'features' => [
                    '15 Progressive flow sessions',
                    'Breathing (Pranayama) instructions',
                    'Active recovery day protocols',
                    'Guided meditation audio sessions included'
                ],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Endurance Builder: 10K Running Prep',
                'description' => 'Whether you are new to running or looking to shatter your personal record, this structural course builds aerobic capacity, leg power, and running economy.',
                'difficulty' => 'Intermediate',
                'category' => 'Cardio',
                'duration_weeks' => 8,
                'price' => 24.99,
                'image_url' => 'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?auto=format&fit=crop&q=80&w=800',
                'features' => [
                    'Weekly structured pacing and interval plans',
                    'Injury prevention dynamic warm-ups',
                    'Carb-loading and hydration guidelines',
                    'Smartwatch metric integration support'
                ],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Powerlifting 101: Big Three Mechanics',
                'description' => 'Perfect your Squat, Bench Press, and Deadlift. Under the guidance of elite coaches, master the leverages, breathing techniques, and programming for ultimate strength.',
                'difficulty' => 'Advanced',
                'category' => 'Strength',
                'duration_weeks' => 10,
                'price' => 39.99,
                'image_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=800',
                'features' => [
                    'Form breakdown analysis templates',
                    'Neuromuscular coordination exercises',
                    'Peaking protocol for maximum one-rep max attempts',
                    'Joint longevity and stretching guides'
                ],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Lean & Athletic: The Mixed Method',
                'description' => 'A versatile, athletic-based program combining bodyweight exercises, plyometrics, kettlebell training, and steady-state cardio to build a functional, shredded physique.',
                'difficulty' => 'Advanced',
                'category' => 'Mixed',
                'duration_weeks' => 8,
                'price' => 27.99,
                'image_url' => 'https://images.unsplash.com/photo-1518310383802-640c2de311b2?auto=format&fit=crop&q=80&w=800',
                'features' => [
                    'Explosive power development workouts',
                    'Kettlebell and sandbag routines',
                    'Agility drills for coordination',
                    'High-protein nutrition protocols'
                ],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Intro to Calisthenics: Bodyweight Control',
                'description' => 'Start your bodyweight journey. Build relative strength, learn your first pull-up, master push-up variations, and lay the foundation for advanced skills.',
                'difficulty' => 'Beginner',
                'category' => 'Strength',
                'duration_weeks' => 6,
                'price' => 15.99,
                'image_url' => 'https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?auto=format&fit=crop&q=80&w=800',
                'features' => [
                    'Step-by-step regressions for absolute beginners',
                    'Core compression strength modules',
                    'Wrist and shoulder mobility routines',
                    'Daily flexibility workouts'
                ],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Total Body Pilates & Core',
                'description' => 'Sculpt a strong, stable core and long, lean muscles with classical Pilates exercises. Focused heavily on control, posture, and deep stabilizer muscle strength.',
                'difficulty' => 'Beginner',
                'category' => 'Yoga',
                'duration_weeks' => 4,
                'price' => 12.99,
                'image_url' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&q=80&w=800',
                'features' => [
                    'Mat-based Pilates lessons with adjustments',
                    'Deep transverse abdominis activation drills',
                    'Spine health and spinal articulation tutorials',
                    'Glute and lower-back support guide'
                ],
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('courses')->insert($courses);
    }
}
