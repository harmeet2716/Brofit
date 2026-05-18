@props([
    'title',
    'value',
    'icon' => null,
    'color' => 'fit-green',
    'accent' => true
])

<div class="relative overflow-hidden bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">{{ $title }}</p>
            <h3 class="text-3xl font-extrabold text-gray-950 dark:text-white">{{ $value }}</h3>
        </div>
        @if ($icon)
            <div class="w-12 h-12 rounded-xl bg-fit-green/10 dark:bg-fit-green/20 text-fit-green flex items-center justify-center">
                {!! $icon !!}
            </div>
        @endif
    </div>
    
    @if ($accent)
        <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-gradient-to-r from-fit-green to-fit-green-light"></div>
    @endif
</div>
