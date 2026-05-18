@props([
    'exercise'
])

<div class="group relative flex flex-col overflow-hidden bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <!-- Image with Zoom and Overlay -->
    <div class="relative aspect-video w-full overflow-hidden bg-gray-100">
        <img src="{{ $exercise['image_url'] }}" alt="{{ $exercise['name'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/40 via-transparent to-transparent"></div>
        
        <!-- Muscle Group Badge -->
        <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-fit-green/90 backdrop-blur-md text-white border border-white/10">
            {{ $exercise['muscle_group'] }}
        </span>
    </div>

    <!-- Content -->
    <div class="flex flex-1 flex-col p-6">
        <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $exercise['difficulty'] === 'Beginner' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($exercise['difficulty'] === 'Intermediate' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
                {{ $exercise['difficulty'] }}
            </span>
            <span class="text-xs font-semibold text-fit-green flex items-center bg-fit-green/10 px-2 py-0.5 rounded-full">
                🔥 {{ $exercise['calories_burned_per_set'] }} Cal/Set
            </span>
        </div>

        <h4 class="text-lg font-bold text-gray-950 dark:text-white mb-2 group-hover:text-fit-green transition-colors line-clamp-1">
            {{ $exercise['name'] }}
        </h4>
        
        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-6 flex-grow">
            {{ $exercise['description'] }}
        </p>

        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100 dark:border-gray-800">
            <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                ~{{ $exercise['duration_seconds'] }} Seconds/Set
            </span>
            
            <a href="{{ route('exercises.show', $exercise['_id']) }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-fit-green hover:bg-fit-green-dark rounded-xl transition-all duration-300 shadow-lg shadow-fit-green/20">
                View Details
                <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
