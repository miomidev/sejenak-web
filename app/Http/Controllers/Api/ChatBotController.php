<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');
        $conversationHistory = $request->input('history', []); // array berisi ['role' => 'user'/'assistant', 'content' => '...']

        if (!$userMessage) {
            return response()->json(['error' => 'No message provided.'], 400);
        }

        try {
            $apiKey = env('GEMINI_API_KEY', 'AIzaSyB_7Uj-0FLFYq1YiE0RL0Jxy8G5vLR_6NU');
            $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key=$apiKey";

            // Informasi waktu lokal Indonesia (WIB)
            $now = now()->setTimezone('Asia/Jakarta');
            $currentDateTime = [
                'fullDateTime' => $now->format('l, d F Y H:i'),
                'dayName' => $now->translatedFormat('l'),
                'date' => $now->format('d'),
                'monthName' => $now->translatedFormat('F'),
                'year' => $now->format('Y'),
                'hours' => $now->format('H'),
                'minutes' => $now->format('i'),
            ];

            // Ubah riwayat percakapan menjadi format teks
            $historyText = collect($conversationHistory)
                ->map(fn($msg) => ($msg['role'] === 'user' ? 'Klien' : 'Nemo') . ': ' . $msg['content'])
                ->join("\n");

            // Prompt utama (persona + waktu + instruksi)
            $prompt = <<<PROMPT
Kamu adalah *Nemo*, asisten virtual dari aplikasi **Sejenak** 🐋  
Kamu ramah, hangat, dan suportif — ngerti banget soal psikologi, kesehatan mental, dan keseharian Gen Z.  
Gunakan bahasa Indonesia santai, seperti ngobrol sama teman sendiri.  
Hindari jawaban kaku, panjang, atau kayak robot.  
Jawaban maksimal **2–3 kalimat aja**.  

[INFORMASI WAKTU SAAT INI: {$currentDateTime['fullDateTime']} WIB]
[HARI INI: {$currentDateTime['dayName']}]
[TANGGAL: {$currentDateTime['date']} {$currentDateTime['monthName']} {$currentDateTime['year']}]
[JAM: {$currentDateTime['hours']}:{$currentDateTime['minutes']} WIB]

Riwayat percakapan:
{$historyText}

Pesan user: "{$userMessage}"

INSTRUKSI:
- Hanya gunakan informasi waktu jika user secara spesifik menanyakan tentang hari, tanggal, atau jam.
- Kalau user nggak nanya soal waktu, jangan sebut waktu.
- Tetap berperan sebagai Nemo yang santai, empatik, dan suportif.
PROMPT;

            // Request ke Gemini API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'contents' => [
                    ['parts' => [['text' => $prompt]]],
                ],
                'generationConfig' => [
                    'temperature' => 0.8,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 150,
                ],
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Gemini API failed',
                    'details' => $response->json(),
                ], $response->status());
            }

            $data = $response->json();
            $aiResponse = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Nemo lagi mikir bentar ya 😅';

            return response()->json([
                'status' => 'success',
                'ai_response' => $aiResponse,
                'timestamp' => $now->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
