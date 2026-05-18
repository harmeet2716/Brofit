@props([
    'course',
    'enrolled' => false,
    'progress' => 0
])

<div class="group relative flex flex-col overflow-hidden bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <!-- Image with Zoom and Overlay -->
    <div class="relative aspect-video w-full overflow-hidden bg-gray-100">
        <img src="{{ $course['image_url'] }}" alt="{{ $course['name'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/40 via-transparent to-transparent"></div>
        
        <!-- Category Badge -->
        <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-950/60 backdrop-blur-md text-white border border-white/10">
            {{ $course['category'] }}
        </span>
    </div>

    <!-- Content -->
    <div class="flex flex-1 flex-col p-6">
        <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $course['difficulty'] === 'Beginner' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($course['difficulty'] === 'Intermediate' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
                {{ $course['difficulty'] }}
            </span>
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 flex items-center">
                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $course['duration_weeks'] }} Weeks
            </span>
        </div>

        <h4 class="text-lg font-bold text-gray-950 dark:text-white mb-2 group-hover:text-fit-green transition-colors line-clamp-1">
            {{ $course['name'] }}
        </h4>
        
        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-6 flex-grow">
            {{ $course['description'] }}
        </p>

        @if ($enrolled)
            <!-- Progress Bar -->
            <div class="mb-5">
                <div class="flex justify-between items-center mb-1 text-xs font-semibold text-fit-green">
                    <span>Course Progress</span>
                    <span>{{ $progress }}%</span>
                </div>
                <div class="w-full h-2 bg-gray-150 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-fit-green transition-all duration-500 rounded-full" style="width: {{ $progress }}%"></div>
                </div>
            </div>
        @endif

        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100 dark:border-gray-800">
            @if ($enrolled)
                <span class="inline-flex items-center text-sm font-bold text-fit-green">
                    <svg class="w-5 h-5 mr-1 text-fit-green" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Enrolled ✓
                </span>
            @else
                <span class="text-2xl font-extrabold text-gray-950 dark:text-white">
                    ${{ number_format($course['price'], 2) }}
                </span>
            @endif
            
            <a href="{{ route('courses.show', $course['_id']) }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-fit-green hover:bg-fit-green-dark rounded-xl transition-all duration-300 shadow-lg shadow-fit-green/20">
                Details
                <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
