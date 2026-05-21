@extends('layouts.app')

@section('title', 'AI Fitness Coach — FitNexus')
@section('page_title', 'AI Fitness Coach')
@section('breadcrumb', 'AI Coach')

@section('content')

<!-- Banner alerting if API key is not configured -->
@if(!$apiAvailable)
    <div class="p-4 mb-6 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-850 dark:text-amber-400 text-sm flex gap-3 shadow-sm">
        <span class="text-xl"></span>
        <div>
            <span class="font-bold block">OpenAI API Key Not Found!</span>
            <span class="block mt-1">Please set your `OPENAI_API_KEY` inside the `.env` file to fully unlock dynamic AI chat coaching and weekly customized planners.</span>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- LEFT PANEL: Chat Interface (2 columns on desktop) -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm flex flex-col h-[600px]">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4 mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-fit-green animate-ping"></span>
                    Nexus AI Personal Coach
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Powered by OpenAI GPT model. Chat about diets, form, or workout routines.</p>
            </div>
            
            @if(count($chatHistory) > 0)
                <form method="POST" action="{{ route('ai-coach.clear') }}">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-500 hover:underline">Clear Chat History</button>
                </form>
            @endif
        </div>

        <!-- Chat Bubble Logs Container -->
        <div class="flex-1 overflow-y-auto space-y-4 pr-2 mb-4 scrollbar-thin scroll-smooth" id="chat-box">
            @if(count($chatHistory) > 0)
                @foreach($chatHistory as $chat)
                    <!-- User bubble -->
                    <div class="flex justify-end">
                        <div class="bg-fit-green text-white text-sm font-semibold rounded-2xl rounded-tr-none px-4 py-3 max-w-[80%] shadow-md shadow-fit-green/10">
                            <p class="leading-relaxed">{{ $chat['user'] }}</p>
                            <span class="text-[9px] text-white/70 block text-right mt-1.5 font-medium">{{ $chat['timestamp'] }}</span>
                        </div>
                    </div>

                    <!-- Assistant bubble -->
                    <div class="flex justify-start">
                        <div class="bg-gray-100 dark:bg-gray-800 text-gray-850 dark:text-gray-250 text-sm rounded-2xl rounded-tl-none px-4 py-3 max-w-[85%] border border-gray-150 dark:border-gray-750">
                            <div class="prose prose-sm dark:prose-invert leading-relaxed max-w-none">
                                {!! nl2br(e($chat['assistant'])) !!}
                            </div>
                            <span class="text-[9px] text-gray-400 dark:text-gray-500 block mt-1.5 font-medium">{{ $chat['timestamp'] }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Welcome prompt message -->
                <div class="flex flex-col items-center justify-center h-full text-center p-6 space-y-3">
                    <div class="w-16 h-16 bg-fit-green/10 rounded-full flex items-center justify-center text-3xl">

                    </div>
                    <h4 class="text-base font-bold text-gray-800 dark:text-gray-250">Ask your biometrics personal trainer!</h4>
                    <p class="text-xs text-gray-450 dark:text-gray-550 max-w-sm">"Hey Coach, can you suggest an intermediate core workout plan?" or "How many carbs should I eat before jogging?"</p>
                </div>
            @endif
        </div>

        <!-- Send message form -->
        <form method="POST" action="{{ route('ai-coach.chat') }}" class="flex items-center gap-2 pt-2 border-t border-gray-100 dark:border-gray-800" onsubmit="showChatSpinner()">
            @csrf
            <input type="text" name="message" id="chat-input" placeholder="{{ $apiAvailable ? 'Ask Coach anything about fitness...' : 'API key required...' }}" required {{ !$apiAvailable ? 'disabled' : '' }}
                class="flex-1 px-4 py-3.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-850 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-fit-green outline-none text-sm font-semibold">
            
            <button type="submit" id="chat-submit-btn" {{ !$apiAvailable ? 'disabled' : '' }}
                class="px-5 py-3.5 bg-fit-green hover:bg-fit-green-dark text-white font-extrabold rounded-xl transition-all duration-300 shadow-md shadow-fit-green/20 text-sm whitespace-nowrap flex items-center justify-center">
                Send &rarr;
            </button>
        </form>
    </div>

    <!-- RIGHT PANEL: Personalized 7-Day Planner (1 column) -->
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-6 shadow-sm flex flex-col h-[600px]">
        <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">7-Day FitNexus Plan</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Generate a custom Monday-to-Sunday routine adjusted to your specific goal.</p>
        </div>

        @if($weeklyPlan)
            <!-- Slides / Carousel list for the days -->
            <div class="flex-1 overflow-y-auto space-y-4 pr-1 scrollbar-thin">
                @foreach($weeklyPlan as $dayPlan)
                    <div class="p-4 bg-gray-55 dark:bg-gray-850 border border-gray-150/40 dark:border-gray-800 rounded-2xl space-y-2">
                        <span class="text-xs font-black uppercase text-fit-green tracking-widest">{{ $dayPlan['day'] }}</span>
                        
                        <div class="space-y-1 pt-1">
                            <span class="text-xs font-bold text-gray-400 block uppercase tracking-wider">Workout routine:</span>
                            <p class="text-sm text-gray-800 dark:text-gray-250 leading-relaxed font-semibold">{{ $dayPlan['workout'] }}</p>
                        </div>
                        
                        <div class="space-y-1 pt-1">
                            <span class="text-xs font-bold text-gray-400 block uppercase tracking-wider">Nutrition plan:</span>
                            <p class="text-sm text-gray-800 dark:text-gray-250 leading-relaxed font-semibold">{{ $dayPlan['nutrition'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Generate trigger button placeholder -->
            <div class="flex-1 flex flex-col items-center justify-center text-center p-6 space-y-5">
                <div class="w-16 h-16 bg-fit-green/10 rounded-full flex items-center justify-center text-3xl">

                </div>
                <h4 class="text-base font-bold text-gray-800 dark:text-gray-250">No plan compiled yet!</h4>
                <p class="text-xs text-gray-450 dark:text-gray-550 max-w-xs">Run the compiler to build a personalized calendar split mapping exercises and foods to your fitness goal.</p>
                
                <form method="POST" action="{{ route('ai-coach.plan') }}" onsubmit="showPlanSpinner()">
                    @csrf
                    <button type="submit" id="plan-submit-btn" {{ !$apiAvailable ? 'disabled' : '' }}
                        class="px-6 py-3 bg-fit-green hover:bg-fit-green-dark text-white font-extrabold rounded-xl transition-all duration-300 shadow-md shadow-fit-green/20 text-sm flex items-center justify-center">
 Generate Weekly Planner
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

<!-- Modal spinners / loading block screens -->
<div id="loading-overlay" class="fixed inset-0 bg-gray-950/60 backdrop-blur-sm z-50 items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-3xl p-8 max-w-sm text-center space-y-4 shadow-2xl flex flex-col items-center justify-center">
        <div class="w-12 h-12 border-4 border-fit-green border-t-transparent rounded-full animate-spin"></div>
        <h4 class="text-lg font-bold text-gray-900 dark:text-white" id="loading-title">Nexus AI thinking...</h4>
        <p class="text-xs text-gray-500" id="loading-desc">Fetching parameters and calculating targets. This may take up to a minute.</p>
    </div>
</div>

<script>
    // Keep chat history scrolled to the bottom on load
    document.addEventListener("DOMContentLoaded", function() {
        const chatBox = document.getElementById("chat-box");
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });

    function showChatSpinner() {
        document.getElementById("loading-title").innerText = "Nexus AI Coach typing...";
        document.getElementById("loading-desc").innerText = "Formulating direct answers for your biometrics query.";
        const overlay = document.getElementById("loading-overlay");
        overlay.classList.remove("hidden");
        overlay.classList.add("flex");
    }

    function showPlanSpinner() {
        document.getElementById("loading-title").innerText = "Assembling 7-Day Plan...";
        document.getElementById("loading-desc").innerText = "Compiling calories targets, active rest segments, and exercises split splits.";
        const overlay = document.getElementById("loading-overlay");
        overlay.classList.remove("hidden");
        overlay.classList.add("flex");
    }
</script>

@endsection
