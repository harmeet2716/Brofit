<?php

namespace App\Services;

class CourseContentProvider
{
    /**
     * Get the detailed weekly plan for a course based on its category.
     */
    public static function getWeeklyPlan(array $course): array
    {
        $category = strtolower($course['category'] ?? 'cardio');
        $weeks = (int) ($course['duration_weeks'] ?? 4);

        $plans = self::getCategoryPlans();
        $basePlan = $plans[$category] ?? $plans['cardio'];

        // Cycle through available weeks if course is longer than template
        $result = [];
        for ($i = 0; $i < $weeks; $i++) {
            $templateWeek = $basePlan[$i % count($basePlan)];
            $templateWeek['week_number'] = $i + 1;
            $templateWeek['title'] = 'Week ' . ($i + 1) . ': ' . $templateWeek['title'];
            $result[] = $templateWeek;
        }

        return $result;
    }

    /**
     * Get features list for a course based on category.
     */
    public static function getFeatures(array $course): array
    {
        $category = strtolower($course['category'] ?? 'cardio');

        $features = [
            'cardio' => [
                'High-intensity fat burning protocols',
                'Heart rate zone training guidance',
                'Progressive endurance building',
                'Recovery and cool-down routines',
                'Calorie-optimized meal plans',
                'Weekly performance tracking',
            ],
            'strength' => [
                'Progressive overload programming',
                'Compound lift technique mastery',
                'Hypertrophy-focused split routines',
                'Deload and recovery protocols',
                'High-protein meal plans for muscle gain',
                'Strength benchmarks and PR tracking',
            ],
            'flexibility' => [
                'Full-body mobility sequences',
                'Deep stretch recovery flows',
                'Core stability and balance drills',
                'Posture correction exercises',
                'Anti-inflammatory nutrition plans',
                'Mindfulness and breathing techniques',
            ],
        ];

        return $features[$category] ?? $features['cardio'];
    }

    /**
     * Category-based weekly curriculum templates.
     */
    private static function getCategoryPlans(): array
    {
        return [
            'cardio' => [
                [
                    'title' => 'Foundation & Assessment',
                    'goal' => 'Build aerobic base and assess current fitness level',
                    'daily_calories' => 2200,
                    'meals' => [
                        'breakfast' => 'Oatmeal with banana, honey, and almonds (450 kcal)',
                        'lunch' => 'Grilled chicken salad with quinoa and olive oil dressing (550 kcal)',
                        'dinner' => 'Salmon fillet with steamed broccoli and brown rice (600 kcal)',
                        'snacks' => 'Greek yogurt with berries + protein shake (400 kcal)',
                    ],
                    'exercises' => [
                        ['name' => 'Brisk Walking', 'duration' => '30 min', 'sets' => null, 'reps' => null, 'rest' => null],
                        ['name' => 'Jumping Jacks', 'duration' => '3 min', 'sets' => '3', 'reps' => '30', 'rest' => '60s'],
                        ['name' => 'Bodyweight Squats', 'duration' => null, 'sets' => '3', 'reps' => '15', 'rest' => '45s'],
                        ['name' => 'Mountain Climbers', 'duration' => null, 'sets' => '3', 'reps' => '20', 'rest' => '60s'],
                        ['name' => 'Plank Hold', 'duration' => '30s', 'sets' => '3', 'reps' => null, 'rest' => '30s'],
                    ],
                    'tips' => 'Focus on form over speed. Track your resting heart rate each morning.',
                ],
                [
                    'title' => 'Intensity Ramp-Up',
                    'goal' => 'Increase workout intensity and introduce interval training',
                    'daily_calories' => 2300,
                    'meals' => [
                        'breakfast' => 'Scrambled eggs with whole wheat toast and avocado (500 kcal)',
                        'lunch' => 'Turkey wrap with hummus, spinach, and peppers (500 kcal)',
                        'dinner' => 'Lean beef stir-fry with vegetables and jasmine rice (650 kcal)',
                        'snacks' => 'Trail mix + apple with peanut butter (450 kcal)',
                    ],
                    'exercises' => [
                        ['name' => 'Sprint Intervals', 'duration' => '20 min', 'sets' => '8', 'reps' => '30s sprint / 60s walk', 'rest' => null],
                        ['name' => 'Burpees', 'duration' => null, 'sets' => '4', 'reps' => '10', 'rest' => '60s'],
                        ['name' => 'High Knees', 'duration' => '45s', 'sets' => '4', 'reps' => null, 'rest' => '30s'],
                        ['name' => 'Box Jumps', 'duration' => null, 'sets' => '3', 'reps' => '12', 'rest' => '60s'],
                        ['name' => 'Russian Twists', 'duration' => null, 'sets' => '3', 'reps' => '20', 'rest' => '30s'],
                    ],
                    'tips' => 'Push your heart rate to 80-85% max during sprint intervals. Stay hydrated.',
                ],
                [
                    'title' => 'Peak Performance',
                    'goal' => 'Maximum cardiovascular output and endurance test',
                    'daily_calories' => 2400,
                    'meals' => [
                        'breakfast' => 'Protein pancakes with mixed berries and maple syrup (480 kcal)',
                        'lunch' => 'Tuna poke bowl with edamame and avocado (580 kcal)',
                        'dinner' => 'Chicken breast with sweet potato and asparagus (620 kcal)',
                        'snacks' => 'Cottage cheese + banana + protein bar (520 kcal)',
                    ],
                    'exercises' => [
                        ['name' => 'Tabata Circuit', 'duration' => '25 min', 'sets' => '5', 'reps' => '20s on / 10s off', 'rest' => null],
                        ['name' => 'Tuck Jumps', 'duration' => null, 'sets' => '4', 'reps' => '12', 'rest' => '45s'],
                        ['name' => 'Lateral Shuffles', 'duration' => '30s', 'sets' => '4', 'reps' => null, 'rest' => '30s'],
                        ['name' => 'Plank to Push-Up', 'duration' => null, 'sets' => '3', 'reps' => '10', 'rest' => '45s'],
                        ['name' => 'Cool-Down Jog', 'duration' => '10 min', 'sets' => null, 'reps' => null, 'rest' => null],
                    ],
                    'tips' => 'This is your hardest week. Trust the process and fuel properly.',
                ],
                [
                    'title' => 'Recovery & Results',
                    'goal' => 'Active recovery and performance benchmarking',
                    'daily_calories' => 2100,
                    'meals' => [
                        'breakfast' => 'Smoothie bowl with granola and chia seeds (420 kcal)',
                        'lunch' => 'Grilled fish tacos with cabbage slaw (480 kcal)',
                        'dinner' => 'Pasta with turkey meatballs and marinara (580 kcal)',
                        'snacks' => 'Hummus with veggies + dark chocolate square (420 kcal)',
                    ],
                    'exercises' => [
                        ['name' => 'Yoga Flow', 'duration' => '30 min', 'sets' => null, 'reps' => null, 'rest' => null],
                        ['name' => 'Light Cycling', 'duration' => '20 min', 'sets' => null, 'reps' => null, 'rest' => null],
                        ['name' => 'Foam Rolling', 'duration' => '15 min', 'sets' => null, 'reps' => null, 'rest' => null],
                        ['name' => 'Bodyweight Squats', 'duration' => null, 'sets' => '2', 'reps' => '15', 'rest' => '60s'],
                        ['name' => 'Stretching Routine', 'duration' => '15 min', 'sets' => null, 'reps' => null, 'rest' => null],
                    ],
                    'tips' => 'Deload week. Let muscles recover. Compare your fitness metrics to Week 1.',
                ],
            ],

            'strength' => [
                [
                    'title' => 'Structural Foundation',
                    'goal' => 'Master compound lifts with proper form and build base strength',
                    'daily_calories' => 2800,
                    'meals' => [
                        'breakfast' => 'Egg omelette with cheese, spinach, and whole wheat toast (550 kcal)',
                        'lunch' => 'Double chicken breast with brown rice and green beans (700 kcal)',
                        'dinner' => 'Steak with baked potato and steamed vegetables (750 kcal)',
                        'snacks' => 'Protein shake + mixed nuts + banana (600 kcal)',
                    ],
                    'exercises' => [
                        ['name' => 'Barbell Back Squat', 'duration' => null, 'sets' => '4', 'reps' => '8', 'rest' => '90s'],
                        ['name' => 'Barbell Bench Press', 'duration' => null, 'sets' => '4', 'reps' => '8', 'rest' => '90s'],
                        ['name' => 'Bent-Over Barbell Row', 'duration' => null, 'sets' => '4', 'reps' => '8', 'rest' => '90s'],
                        ['name' => 'Overhead Press', 'duration' => null, 'sets' => '3', 'reps' => '10', 'rest' => '60s'],
                        ['name' => 'Plank Hold', 'duration' => '45s', 'sets' => '3', 'reps' => null, 'rest' => '30s'],
                    ],
                    'tips' => 'Start light, perfect your form. Record your lifts for progressive tracking.',
                ],
                [
                    'title' => 'Hypertrophy Phase',
                    'goal' => 'Increase training volume for muscle growth',
                    'daily_calories' => 3000,
                    'meals' => [
                        'breakfast' => 'Protein pancakes with peanut butter and banana (600 kcal)',
                        'lunch' => 'Salmon with sweet potato mash and broccoli (700 kcal)',
                        'dinner' => 'Ground turkey pasta with parmesan and side salad (750 kcal)',
                        'snacks' => 'Greek yogurt parfait + protein bar + almonds (650 kcal)',
                    ],
                    'exercises' => [
                        ['name' => 'Incline Dumbbell Press', 'duration' => null, 'sets' => '4', 'reps' => '12', 'rest' => '60s'],
                        ['name' => 'Lat Pulldown', 'duration' => null, 'sets' => '4', 'reps' => '12', 'rest' => '60s'],
                        ['name' => 'Leg Press', 'duration' => null, 'sets' => '4', 'reps' => '12', 'rest' => '90s'],
                        ['name' => 'Dumbbell Lateral Raise', 'duration' => null, 'sets' => '4', 'reps' => '15', 'rest' => '45s'],
                        ['name' => 'Barbell Curl', 'duration' => null, 'sets' => '3', 'reps' => '12', 'rest' => '45s'],
                    ],
                    'tips' => 'Focus on mind-muscle connection. Increase weight by 2.5kg when reps feel easy.',
                ],
                [
                    'title' => 'Strength Peak',
                    'goal' => 'Heavy compounds with low reps for maximum strength gains',
                    'daily_calories' => 3100,
                    'meals' => [
                        'breakfast' => 'Scrambled eggs with bacon, avocado toast (650 kcal)',
                        'lunch' => 'Chicken thigh with jasmine rice and stir-fried veggies (720 kcal)',
                        'dinner' => 'Ribeye steak with roasted potatoes and asparagus (800 kcal)',
                        'snacks' => 'Mass gainer shake + trail mix + cheese slices (700 kcal)',
                    ],
                    'exercises' => [
                        ['name' => 'Deadlift', 'duration' => null, 'sets' => '5', 'reps' => '5', 'rest' => '120s'],
                        ['name' => 'Barbell Back Squat', 'duration' => null, 'sets' => '5', 'reps' => '5', 'rest' => '120s'],
                        ['name' => 'Weighted Pull-Ups', 'duration' => null, 'sets' => '4', 'reps' => '6', 'rest' => '90s'],
                        ['name' => 'Dumbbell Shoulder Press', 'duration' => null, 'sets' => '4', 'reps' => '8', 'rest' => '90s'],
                        ['name' => 'Hanging Leg Raises', 'duration' => null, 'sets' => '3', 'reps' => '12', 'rest' => '45s'],
                    ],
                    'tips' => 'Heavy week. Use a spotter for max lifts. Sleep 8+ hours for recovery.',
                ],
                [
                    'title' => 'Deload & Reassess',
                    'goal' => 'Active recovery to prevent overtraining, test new PRs',
                    'daily_calories' => 2600,
                    'meals' => [
                        'breakfast' => 'Overnight oats with whey protein and berries (480 kcal)',
                        'lunch' => 'Grilled chicken Caesar salad (520 kcal)',
                        'dinner' => 'Baked cod with quinoa and roasted vegetables (580 kcal)',
                        'snacks' => 'Protein shake + rice cakes with peanut butter (520 kcal)',
                    ],
                    'exercises' => [
                        ['name' => 'Light Barbell Squat (50%)', 'duration' => null, 'sets' => '3', 'reps' => '10', 'rest' => '60s'],
                        ['name' => 'Light Bench Press (50%)', 'duration' => null, 'sets' => '3', 'reps' => '10', 'rest' => '60s'],
                        ['name' => 'Band Pull-Aparts', 'duration' => null, 'sets' => '3', 'reps' => '15', 'rest' => '30s'],
                        ['name' => 'Foam Rolling Full Body', 'duration' => '15 min', 'sets' => null, 'reps' => null, 'rest' => null],
                        ['name' => 'Stretching Routine', 'duration' => '10 min', 'sets' => null, 'reps' => null, 'rest' => null],
                    ],
                    'tips' => 'Deload at 50% intensity. Compare your lifts to Week 1 and celebrate progress.',
                ],
            ],

            'flexibility' => [
                [
                    'title' => 'Mobility Baseline',
                    'goal' => 'Assess flexibility and build foundational mobility patterns',
                    'daily_calories' => 1900,
                    'meals' => [
                        'breakfast' => 'Green smoothie with spinach, banana, and chia seeds (350 kcal)',
                        'lunch' => 'Mediterranean bowl with falafel and hummus (480 kcal)',
                        'dinner' => 'Grilled salmon with steamed vegetables and lemon (520 kcal)',
                        'snacks' => 'Mixed berries + handful of walnuts (350 kcal)',
                    ],
                    'exercises' => [
                        ['name' => 'Sun Salutation Flow', 'duration' => '15 min', 'sets' => null, 'reps' => null, 'rest' => null],
                        ['name' => 'Hip Flexor Stretch', 'duration' => '60s each side', 'sets' => '3', 'reps' => null, 'rest' => null],
                        ['name' => 'Cat-Cow Stretch', 'duration' => null, 'sets' => '3', 'reps' => '10', 'rest' => '15s'],
                        ['name' => 'Seated Forward Fold', 'duration' => '45s', 'sets' => '3', 'reps' => null, 'rest' => '15s'],
                        ['name' => 'Deep Breathing Meditation', 'duration' => '10 min', 'sets' => null, 'reps' => null, 'rest' => null],
                    ],
                    'tips' => 'Never force a stretch. Breathe deeply and let gravity do the work.',
                ],
                [
                    'title' => 'Deep Stretch & Core',
                    'goal' => 'Improve range of motion and build core stability',
                    'daily_calories' => 1900,
                    'meals' => [
                        'breakfast' => 'Avocado toast with poached eggs and cherry tomatoes (420 kcal)',
                        'lunch' => 'Lentil soup with whole grain bread (450 kcal)',
                        'dinner' => 'Tofu stir-fry with brown rice and sesame sauce (500 kcal)',
                        'snacks' => 'Apple slices with almond butter + herbal tea (330 kcal)',
                    ],
                    'exercises' => [
                        ['name' => 'Pigeon Pose', 'duration' => '90s each side', 'sets' => '2', 'reps' => null, 'rest' => null],
                        ['name' => 'Thoracic Spine Rotation', 'duration' => null, 'sets' => '3', 'reps' => '10 each side', 'rest' => '15s'],
                        ['name' => 'Dead Bug', 'duration' => null, 'sets' => '3', 'reps' => '12', 'rest' => '30s'],
                        ['name' => 'Supine Hamstring Stretch', 'duration' => '60s each', 'sets' => '3', 'reps' => null, 'rest' => null],
                        ['name' => 'Child Pose with Side Reach', 'duration' => '60s each side', 'sets' => '2', 'reps' => null, 'rest' => null],
                    ],
                    'tips' => 'Hold stretches longer this week. Aim for 2-3 minutes per position.',
                ],
            ],
        ];
    }
}
