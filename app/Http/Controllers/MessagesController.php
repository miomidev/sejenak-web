<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\ChatMessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Http;

class MessagesController extends Controller
{
    public function index()
    {
        return view('messages.chat');
    }

    public function proxyToGemini()
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            Log::error('GEMINI_API_KEY not set in .env file.');
            return response()->json(['error' => 'Konfigurasi server tidak lengkap.'], 500);
        }

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";

        $response = Http::timeout(60)->post($apiUrl, [
            'contents' => $request->input('contents'),
        ]);

        if ($response->failed()) {
            Log::error('Gemini API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return response()->json(['error' => 'Gagal menghubungi layanan AI.'], 502);
        }

        return $response->json();
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('messages.chat', compact('user'));
    }

    public function getUsers()
    {
        $users = User::where('id', '!=', Auth::id())
                    ->select('id', 'name', 'email', 'avatar')
                    ->get()
                    ->map(function($user) {
                        $user->is_online = Cache::has('user-is-online-' . $user->id);
                        return $user;
                    });
        
        return response()->json($users);
    }

    public function getMessages($id)
    {
        $messages = Message::where(function($query) use ($id) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $id);
        })->orWhere(function($query) use ($id) {
            $query->where('sender_id', $id)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')
        ->get();

        return response()->json($messages);
    }
public function sendMessage(Request $request)
{
    // Validasi dan buat pesan
    $message = Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'body' => $request->message
    ]);
    
    $message->load('sender');
    
    broadcast(new ChatMessageSent($message, $request->receiver_id));
    
    broadcast(new ChatMessageSent($message, Auth::id()));
    
    return response()->json([
        'success' => true,
        'message' => $message
    ]);
}
    public function markAsRead($id)
    {
        Message::where('sender_id', $id)
               ->where('receiver_id', Auth::id())
               ->where('read', false)
               ->update(['read' => true]);

        return response()->json(['success' => true]);
    }

    public function searchUsers(Request $request)
    {
        $search = $request->get('search');
        
        $users = User::where('id', '!=', Auth::id())
                    ->where('name', 'like', '%'.$search.'%')
                    ->select('id', 'name', 'email', 'avatar')
                    ->get()
                    ->map(function($user) {
                        $user->is_online = Cache::has('user-is-online-' . $user->id);
                        return $user;
                    });
        
        return response()->json($users);
    }
}