<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Events\NewChatMessage;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function anonymous()
    {
        // Show AI chat interface directly
        return view('chat.anonymous');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'room_id' => 'nullable|string',
            'chat_type' => 'required|string|in:anonymous'
        ]);

        $roomId = $request->room_id ?: 'general';

        $message = ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'chat_type' => $request->chat_type,
            'room_id' => $roomId,
            'anonymous_name' => session()->get('anonymous_name')
        ]);

        // Broadcast the message to other users
        broadcast(new NewChatMessage($message))->toOthers();

        return response()->json($message);
    }

    // AI chat UI
    public function ai()
    {
        $history = session('ai_history', []);
        return view('chat.ai', compact('history'));
    }

    // AI chat send -> calls OpenAI-compatible API (Ollama)
    public function sendAi(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $history = session('ai_history', []);

        $userId = Auth::id();

        ChatMessage::create([
            'user_id' => $userId,
            'message' => $request->message,
            'chat_type' => 'ai',
            'room_id' => 'ai-assistant',
            'anonymous_name' => null,
        ]);

        // Build messages array with basic system prompt
        $messages = array_merge([
            ['role' => 'system', 'content' => 'You are a supportive, friendly mental health companion named MindLink Assistant. Be kind, concise, and non-judgmental. Avoid medical advice.'],
        ], $history, [
            ['role' => 'user', 'content' => $request->message],
        ]);

        $base = config('services.openai.base');
        $model = config('services.openai.model');
        $key = config('services.openai.key');

        try {
            // Increase timeout for AI API requests (default is 30s)
            set_time_limit(120);

            $response = Http::timeout(120)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . ($key ?: 'ollama'),
                    'Content-Type' => 'application/json',
                ])->post(rtrim($base, '/') . '/chat/completions', [
                    'model' => $model,
                    'messages' => $messages,
                    'stream' => false,
                ])->throw();

            $data = $response->json();
            $assistant = $data['choices'][0]['message']['content'] ?? 'Sorry, I could not generate a response.';

            // Update session history (cap to last 20 exchanges)
            $timestamp = now()->format('h:i A');
            $history[] = ['role' => 'user', 'content' => $request->message, 'timestamp' => $timestamp];
            $history[] = ['role' => 'assistant', 'content' => $assistant, 'timestamp' => $timestamp];
            $history = array_slice($history, -40); // 20 pairs
            session(['ai_history' => $history]);

            return response()->json([
                'reply' => $assistant,
            ]);
        } catch (\Throwable $e) {
            \Log::error('AI chat error', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'AI service is unavailable. Please try again.',
            ], 502);
        }
    }

    protected function generateAnonymousName()
    {
        $adjectives = ['Happy', 'Brave', 'Gentle', 'Wise', 'Kind', 'Calm', 'Bright', 'Peaceful'];
        $nouns = ['Soul', 'Heart', 'Mind', 'Spirit', 'Star', 'Sun', 'Moon', 'Cloud'];
        
        return $adjectives[array_rand($adjectives)] . $nouns[array_rand($nouns)] . Str::random(4);
    }

    protected function getRoomName($room)
    {
        $rooms = [
            'general' => 'General Support',
            'anxiety' => 'Anxiety & Stress',
            'academic' => 'Academic Pressure',
            'counselor-sarah' => 'Counselor Sarah'
        ];

        return $rooms[$room] ?? 'Unknown Room';
    }
}
