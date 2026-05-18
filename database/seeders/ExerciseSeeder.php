<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exercises')->truncate();

        $exercises = [
            [
                'name' => 'Push-Up',
                'muscle_group' => 'Chest',
                'difficulty' => 'Beginner',
                'image_url' => 'https://images.unsplash.com/photo-1598971639058-fab3c3109a00?auto=format&fit=crop&q=80&w=800',
                'description' => 'A fundamental bodyweight exercise that strengthens the chest, shoulders, and triceps while building core stability.',
                'problems_solved' => ['Builds chest strength', 'Improves posture', 'Enhances pushing power'],
                'steps' => [
                    'Start in a solid plank position with hands slightly wider than shoulder-width.',
                    'Lower your body by bending your elbows until your chest nearly touches the floor, keeping your elbows at a 45-degree angle.',
                    'Push through your palms to return to the starting plank position while maintaining a straight line from head to toe.'
                ],
                'duration_seconds' => 45,
                'calories_burned_per_set' => 12
            ],
            [
                'name' => 'Incline Dumbbell Press',
                'muscle_group' => 'Chest',
                'difficulty' => 'Intermediate',
                'image_url' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?auto=format&fit=crop&q=80&w=800',
                'description' => 'Pressing at an incline shifts the focus to the upper chest (clavicular head) and front deltoids, helping build a full, rounded chest.',
                'problems_solved' => ['Fills out the upper chest', 'Improves shoulder press power', 'Balances chest muscles'],
                'steps' => [
                    'Lie back on an incline bench set to a 30 to 45 degree angle holding dumbbells at your chest.',
                    'Press the weights straight up above your chest, keeping your feet planted and shoulders retracted.',
                    'Slowly lower the dumbbells back down to chest height, feeling a stretch in your upper pecs.'
                ],
                'duration_seconds' => 60,
                'calories_burned_per_set' => 15
            ],
            [
                'name' => 'Barbell Bench Press',
                'muscle_group' => 'Chest',
                'difficulty' => 'Advanced',
                'image_url' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&q=80&w=800',
                'description' => 'The ultimate compound movement for building upper body mass and raw pushing strength in the pecs, front delts, and triceps.',
                'problems_solved' => ['Increases general upper body power', 'Builds dense muscle fibers', 'Boosts bone density'],
                'steps' => [
                    'Lie flat on the bench, grip the barbell with hands slightly wider than shoulder-width.',
                    'Unrack the bar and lower it with control to your mid-chest, keeping your elbows tucked.',
                    'Drive your feet into the floor and press the bar forcefully back to starting position.'
                ],
                'duration_seconds' => 60,
                'calories_burned_per_set' => 18
            ],
            [
                'name' => 'Pull-Up',
                'muscle_group' => 'Back',
                'difficulty' => 'Advanced',
                'image_url' => 'https://images.unsplash.com/photo-1598971639058-fab3c3109a00?auto=format&fit=crop&q=80&w=800',
                'description' => 'One of the best back-building exercises in existence, focusing heavily on the latissimus dorsi, rhomboids, and biceps.',
                'problems_solved' => ['Widens the upper back (V-taper)', 'Enhances grip strength', 'Improves shoulder mobility'],
                'steps' => [
                    'Hang from a pull-up bar with an overhand grip, hands slightly wider than shoulder-width.',
                    'Pull your shoulder blades down and back, then pull your chest up towards the bar by driving your elbows down.',
                    'Slowly lower yourself back down to a full dead hang with control.'
                ],
                'duration_seconds' => 45,
                'calories_burned_per_set' => 16
            ],
            [
                'name' => 'Bent-Over Barbell Row',
                'muscle_group' => 'Back',
                'difficulty' => 'Intermediate',
                'image_url' => 'https://images.unsplash.com/photo-1605296867304-46d5465a25f1?auto=format&fit=crop&q=80&w=800',
                'description' => 'A compound pulling exercise that targets the mid-back, lats, and rear delts, while building core and lower-back stability.',
                'problems_solved' => ['Thickens the mid-back', 'Improves pulling strength', 'Strengthens lower-back endurance'],
                'steps' => [
                    'Stand over a barbell, hinge forward at the hips while keeping your back straight and knees slightly bent.',
                    'Grip the bar with an overhand grip, pull the bar up towards your lower ribs, squeezing your shoulder blades.',
                    'Lower the bar back to the starting position with control, keeping your core tight.'
                ],
                'duration_seconds' => 60,
                'calories_burned_per_set' => 15
            ],
            [
                'name' => 'Lat Pulldown',
                'muscle_group' => 'Back',
                'difficulty' => 'Beginner',
                'image_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=800',
                'description' => 'An excellent exercise for building back strength, particularly for those working towards their first full bodyweight pull-up.',
                'problems_solved' => ['Builds upper back width', 'Excellent pull-up regression', 'Assists in posture correction'],
                'steps' => [
                    'Sit at a lat pulldown machine, securing your thighs under the pads and grabbing the wide bar with an overhand grip.',
                    'Pull the bar down toward your upper chest, focusing on driving your elbows down and back.',
                    'Slowly return the bar to the top, allowing your lats to stretch fully.'
                ],
                'duration_seconds' => 50,
                'calories_burned_per_set' => 10
            ],
            [
                'name' => 'Goblet Squat',
                'muscle_group' => 'Legs',
                'difficulty' => 'Beginner',
                'image_url' => 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?auto=format&fit=crop&q=80&w=800',
                'description' => 'Holding the weight in front improves squat posture and targets the quads, glutes, and core without heavy spine loading.',
                'problems_solved' => ['Perfects squat mechanics', 'Builds quad and glute strength', 'Improves hip mobility'],
                'steps' => [
                    'Stand with feet shoulder-width apart, holding a dumbbell or kettlebell vertically against your chest.',
                    'Hinge at your hips and bend your knees to lower your body, keeping your chest up and back flat.',
                    'Drive through your heels to stand back up, squeezing your glutes at the top.'
                ],
                'duration_seconds' => 45,
                'calories_burned_per_set' => 12
            ],
            [
                'name' => 'Barbell Romanian Deadlift',
                'muscle_group' => 'Legs',
                'difficulty' => 'Intermediate',
                'image_url' => 'https://images.unsplash.com/photo-1605296867304-46d5465a25f1?auto=format&fit=crop&q=80&w=800',
                'description' => 'A hip-hinge movement that targets the posterior chain—specifically the hamstrings and glutes—while strengthening the lower back.',
                'problems_solved' => ['Strengthens posterior chain', 'Improves hamstring flexibility', 'Protects lower back from injury'],
                'steps' => [
                    'Stand with feet hip-width apart holding a barbell at hip height with an overhand grip.',
                    'Hinge at your hips, pushing them backwards with knees slightly bent, lowering the bar down your shins.',
                    'Drive your hips forward, squeeze your glutes, and return to standing.'
                ],
                'duration_seconds' => 60,
                'calories_burned_per_set' => 16
            ],
            [
                'name' => 'Barbell Back Squat',
                'muscle_group' => 'Legs',
                'difficulty' => 'Advanced',
                'image_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=800',
                'description' => 'The undisputed king of lower body movements. Promotes massive leg size and full-body athletic power.',
                'problems_solved' => ['Builds powerful quads and glutes', 'Improves core stability', 'Increases growth hormone release'],
                'steps' => [
                    'Support a barbell across your upper traps, keeping your hands snug and feet shoulder-width apart.',
                    'Inhale, brace your core, hinge your hips, and squat down until your thighs are parallel to the floor.',
                    'Exhale as you drive through your heels to return to an upright position.'
                ],
                'duration_seconds' => 60,
                'calories_burned_per_set' => 20
            ],
            [
                'name' => 'Dumbbell Shoulder Press',
                'muscle_group' => 'Shoulders',
                'difficulty' => 'Intermediate',
                'image_url' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?auto=format&fit=crop&q=80&w=800',
                'description' => 'Pressing dumbbells overhead builds strength in the anterior and lateral deltoids while engaging the core and triceps.',
                'problems_solved' => ['Builds shoulder width and mass', 'Corrects strength imbalances between shoulders', 'Improves overhead stability'],
                'steps' => [
                    'Sit on a bench with back support, holding dumbbells at shoulder height with palms facing forward.',
                    'Press the weights straight up overhead until your arms are fully extended but not locked.',
                    'Lower the dumbbells back down to shoulder level with control.'
                ],
                'duration_seconds' => 50,
                'calories_burned_per_set' => 14
            ],
            [
                'name' => 'Lateral Raise',
                'muscle_group' => 'Shoulders',
                'difficulty' => 'Beginner',
                'image_url' => 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?auto=format&fit=crop&q=80&w=800',
                'description' => 'An isolation exercise that targets the lateral (side) deltoid head, key for creating broad, capped shoulders.',
                'problems_solved' => ['Widens the shoulders', 'Improves posture and shoulder health', 'Balances deltoid development'],
                'steps' => [
                    'Stand tall with dumbbells in hands, palms facing each other, and a slight bend in your elbows.',
                    'Raise your arms out to the sides until they are parallel to the floor, leading with your elbows.',
                    'Slowly lower the weights back to the starting position.'
                ],
                'duration_seconds' => 45,
                'calories_burned_per_set' => 8
            ],
            [
                'name' => 'Dumbbell Bicep Curl',
                'muscle_group' => 'Arms',
                'difficulty' => 'Beginner',
                'image_url' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?auto=format&fit=crop&q=80&w=800',
                'description' => 'The classic isolation exercise to target the bicep brachii for muscle growth and arm definition.',
                'problems_solved' => ['Increases arm size and definition', 'Improves elbow joint stability', 'Strengthens grip'],
                'steps' => [
                    'Stand tall with dumbbells at your sides, palms facing forward, keeping your elbows close to your torso.',
                    'Curl the weights while contracting your biceps, keeping your upper arms stationary.',
                    'Slowly lower the dumbbells back to the starting position.'
                ],
                'duration_seconds' => 40,
                'calories_burned_per_set' => 9
            ],
            [
                'name' => 'Tricep Rope Overhead Extension',
                'muscle_group' => 'Arms',
                'difficulty' => 'Intermediate',
                'image_url' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?auto=format&fit=crop&q=80&w=800',
                'description' => 'Extending overhead puts the long head of the tricep in a deep stretch, leading to better muscle activation and growth.',
                'problems_solved' => ['Builds the long head of the triceps', 'Enhances pressing lockout power', 'Strengthens elbow extension'],
                'steps' => [
                    'Face away from a cable pulley station, holding the rope overhead with elbows bent and pointing forward.',
                    'Extend your arms overhead to lift the weight, keeping your upper arms locked in place.',
                    'Lower the rope back behind your head, feeling a deep stretch in your triceps.'
                ],
                'duration_seconds' => 45,
                'calories_burned_per_set' => 10
            ],
            [
                'name' => 'Plank',
                'muscle_group' => 'Core',
                'difficulty' => 'Beginner',
                'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&q=80&w=800',
                'description' => 'An isometric core exercise that works the entire abdominal wall, obliques, and lower back, creating deep stabilizer strength.',
                'problems_solved' => ['Alleviates lower back pain', 'Creates a solid midsection', 'Enhances body posture and balance'],
                'steps' => [
                    'Place elbows directly beneath your shoulders on the floor, toes tucked, body in a straight line.',
                    'Squeeze your glutes, pull your belly button towards your spine, and breathe steadily.',
                    'Hold this position without letting your hips sag towards the ground.'
                ],
                'duration_seconds' => 60,
                'calories_burned_per_set' => 10
            ],
            [
                'name' => 'Hanging Knee Raise',
                'muscle_group' => 'Core',
                'difficulty' => 'Intermediate',
                'image_url' => 'https://images.unsplash.com/photo-1598971639058-fab3c3109a00?auto=format&fit=crop&q=80&w=800',
                'description' => 'An excellent core movement that hits the lower abs and hip flexors, while challenging grip and shoulder stability.',
                'problems_solved' => ['Strengthens lower abdominals', 'Enhances overall grip strength', 'Improves hip mobility'],
                'steps' => [
                    'Hang from a pull-up bar with straight arms, shoulders active.',
                    'Slowly lift your knees towards your chest while contracting your abs, avoiding swinging.',
                    'Lower your legs back to straight hanging position under control.'
                ],
                'duration_seconds' => 45,
                'calories_burned_per_set' => 11
            ],
            [
                'name' => 'Ab Wheel Rollout',
                'muscle_group' => 'Core',
                'difficulty' => 'Advanced',
                'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&q=80&w=800',
                'description' => 'An extremely challenging anti-extension exercise that puts the entire anterior core under deep eccentric loading.',
                'problems_solved' => ['Builds powerful anterior core strength', 'Teaches spine stability under load', 'Engages shoulders and lats'],
                'steps' => [
                    'Kneel on the floor, gripping the handles of the ab wheel placed directly in front of you.',
                    'Roll the wheel forward, extending your body into a straight line without letting your hips sag.',
                    'Squeeze your core and roll back to the starting kneeling position.'
                ],
                'duration_seconds' => 50,
                'calories_burned_per_set' => 15
            ],
            [
                'name' => 'Jumping Jacks',
                'muscle_group' => 'Cardio',
                'difficulty' => 'Beginner',
                'image_url' => 'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?auto=format&fit=crop&q=80&w=800',
                'description' => 'A classic high-energy cardiovascular warmup and conditioning exercise that promotes agility and coordination.',
                'problems_solved' => ['Increases heart rate rapidly', 'Improves coordination and agility', 'Great full-body warm up'],
                'steps' => [
                    'Stand with feet together and arms at your sides.',
                    'Jump up, spreading your legs wider than shoulder-width, while bringing your arms overhead.',
                    'Immediately jump again, returning your feet and arms to the starting position.'
                ],
                'duration_seconds' => 60,
                'calories_burned_per_set' => 14
            ],
            [
                'name' => 'Kettlebell Swing',
                'muscle_group' => 'Cardio',
                'difficulty' => 'Intermediate',
                'image_url' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&q=80&w=800',
                'description' => 'A ballistic posterior chain movement combining strength training with high-demand aerobic cardiovascular conditioning.',
                'problems_solved' => ['Burns high amounts of calories', 'Builds explosive power', 'Develops active cardiovascular endurance'],
                'steps' => [
                    'Stand with feet wider than shoulder-width, hinge at hips, and grab a kettlebell placed in front of you.',
                    'Swing the bell back between your legs, then snap your hips forward to drive it up to chest level.',
                    'Allow the kettlebell to fall back between your legs while hinging at your hips.'
                ],
                'duration_seconds' => 45,
                'calories_burned_per_set' => 16
            ],
            [
                'name' => 'Cobra Stretch',
                'muscle_group' => 'Flexibility',
                'difficulty' => 'Beginner',
                'image_url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&q=80&w=800',
                'description' => 'An excellent chest and abdominal opener that counteracts daily desk slouching and improves spinal extension.',
                'problems_solved' => ['Relieves tightness in abdominal wall', 'Stretches chest and anterior shoulders', 'Promotes lumbar spine health'],
                'steps' => [
                    'Lie face down on the floor with your palms flat under your shoulders.',
                    'Press through your palms to gently lift your chest off the floor, keeping your hips grounded.',
                    'Keep your shoulders relaxed away from your ears and hold, breathing deeply.'
                ],
                'duration_seconds' => 30,
                'calories_burned_per_set' => 4
            ],
            [
                'name' => 'Kneeling Hip Flexor Stretch',
                'muscle_group' => 'Flexibility',
                'difficulty' => 'Beginner',
                'image_url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&q=80&w=800',
                'description' => 'Stretching the tight hip flexors is key to curing anterior pelvic tilt and relieving lower back tightness.',
                'problems_solved' => ['Relieves hip flexor tightness', 'Reduces lower back pain', 'Improves stride length and gait'],
                'steps' => [
                    'Get into a lunge position with your back knee resting on the floor and front foot flat.',
                    'Squeeze your back glute and shift your weight slightly forward until you feel a stretch in the front of your hip.',
                    'Keep your chest high and hold, switching sides after the allotted time.'
                ],
                'duration_seconds' => 35,
                'calories_burned_per_set' => 4
            ]
        ];

        DB::table('exercises')->insert($exercises);
    }
}
