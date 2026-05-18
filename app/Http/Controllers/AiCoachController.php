<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AiCoachController extends Controller
{
    /**
     * Get the dynamic API endpoint, model and headers based on the API Key format.
     */
    private function getApiConfig($apiKey): array
    {
        $isOpenRouter = str_starts_with($apiKey, 'sk-or-');
        
        return [
            'endpoint' => $isOpenRouter 
                ? 'https://openrouter.ai/api/v1/chat/completions' 
                : 'https://api.openai.com/v1/chat/completions',
            'model' => $isOpenRouter 
                ? 'openai/gpt-4o-mini' 
                : 'gpt-4o-mini',
            'headers' => $isOpenRouter ? [
                'HTTP-Referer' => 'http://localhost',
                'X-Title' => 'FitNexus',
            ] : []
        ];
    }

    /**
     * Display the AI Coach chat interface.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            session(['last_visited_page' => 'ai-coach.index']);

            $chatHistory = session('ai_chat_history', []);
            $weeklyPlan = session('ai_weekly_plan', null);
            $apiAvailable = !empty(config('services.openai.key')) && config('services.openai.key') !== 'your_openai_api_key_here';

            return view('ai-coach.index', compact('user', 'chatHistory', 'weeklyPlan', 'apiAvailable'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load AI Coach: ' . $e->getMessage());
        }
    }

    /**
     * Send a chat message to OpenAI and return the response.
     */
    public function chat(Request $request)
    {
        try {
            $user = Auth::user();
            $message = $request->validate([
                'message' => ['required', 'string', 'max:1000'],
            ])['message'];

            $apiKey = config('services.openai.key');
            if (empty($apiKey) || $apiKey === 'your_openai_api_key_here') {
                return redirect()->back()->with('error', 'AI Coach unavailable: OpenAI API key not configured.');
            }

            $apiConfig = $this->getApiConfig($apiKey);

            // System prompt
            $systemPrompt = "You are FitNexus's AI fitness coach. The user's profile: " .
                "Name: {$user->name}, Age: {$user->age}, Weight: {$user->weight_kg}kg, " .
                "Height: {$user->height_cm}cm, Goal: {$user->fitness_goal}. " .
                "Provide specific, actionable fitness and nutrition advice. " .
                "Keep responses under 300 words. Format with bullet points where helpful. Be encouraging and motivating.";

            // Build message history for context
            $chatHistory = session('ai_chat_history', []);
            $messages = [['role' => 'system', 'content' => $systemPrompt]];
            foreach (array_slice($chatHistory, -10) as $chat) {
                $messages[] = ['role' => 'user', 'content' => $chat['user']];
                $messages[] = ['role' => 'assistant', 'content' => $chat['assistant']];
            }
            $messages[] = ['role' => 'user', 'content' => $message];

            // Call API
            $headers = array_merge([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ], $apiConfig['headers']);

            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->post($apiConfig['endpoint'], [
                    'model' => $apiConfig['model'],
                    'messages' => $messages,
                    'max_tokens' => 500,
                    'temperature' => 0.7,
                ]);

            if (!$response->successful()) {
                $errorBody = $response->json();
                $errorMessage = $errorBody['error']['message'] ?? 'Unknown API error';
                return redirect()->back()->with('error', 'AI Error: ' . $errorMessage);
            }

            $aiReply = $response->json('choices.0.message.content', 'I\'m sorry, I could not generate a response right now.');

            // Store in session
            $chatHistory[] = [
                'user' => $message,
                'assistant' => $aiReply,
                'timestamp' => now()->format('h:i A'),
            ];
            session(['ai_chat_history' => $chatHistory]);

            return redirect()->route('ai-coach.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'AI Coach request failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate a 7-day personalized workout & nutrition plan.
     */
    public function generatePlan(Request $request)
    {
        try {
            $user = Auth::user();

            $apiKey = config('services.openai.key');
            if (empty($apiKey) || $apiKey === 'your_openai_api_key_here') {
                return redirect()->back()->with('error', 'AI Coach unavailable: OpenAI API key not configured.');
            }

            $apiConfig = $this->getApiConfig($apiKey);

            $systemPrompt = "You are FitNexus's AI fitness coach. The user's profile: " .
                "Name: {$user->name}, Age: {$user->age}, Weight: {$user->weight_kg}kg, " .
                "Height: {$user->height_cm}cm, Goal: {$user->fitness_goal}. ";

            $planRequest = "Generate a detailed, structured 7-day (Monday to Sunday) weekly fitness and nutrition plan for this user. " .
                "For each day, provide: 1) A workout (exercises with sets/reps), 2) A nutrition recommendation (meals and macros target). " .
                "Format the response as JSON with this exact structure: " .
                "{\"plan\": [{\"day\": \"Monday\", \"workout\": \"...\", \"nutrition\": \"...\"},...]} " .
                "Make it specific to the user's goal. Keep each day's content concise but actionable.";

            $headers = array_merge([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ], $apiConfig['headers']);

            $response = Http::withHeaders($headers)
                ->timeout(60)
                ->post($apiConfig['endpoint'], [
                    'model' => $apiConfig['model'],
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $planRequest],
                    ],
                    'max_tokens' => 2000,
                    'temperature' => 0.7,
                    'response_format' => ['type' => 'json_object'],
                ]);

            if (!$response->successful()) {
                $errorBody = $response->json();
                $errorMessage = $errorBody['error']['message'] ?? 'Unknown API error';
                return redirect()->back()->with('error', 'Plan generation failed: ' . $errorMessage);
            }

            $content = $response->json('choices.0.message.content', '{}');
            $planData = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE || !isset($planData['plan'])) {
                return redirect()->back()->with('error', 'Failed to parse AI response. Please try again.');
            }

            session(['ai_weekly_plan' => $planData['plan']]);

            return redirect()->route('ai-coach.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate weekly plan: ' . $e->getMessage());
        }
    }

    /**
     * Clear the chat session history.
     */
    public function clearChat()
    {
        session()->forget('ai_chat_history');
        session()->forget('ai_weekly_plan');
        session()->flash('success', 'Chat history cleared. Fresh start! 🚀');
        return redirect()->route('ai-coach.index');
    }
}
