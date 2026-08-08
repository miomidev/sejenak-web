<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        if (!$userMessage) {
            return response()->json(['error' => 'No message provided.'], 400);
        }

        try {
            // Konfigurasi Gemini API dengan API Key Anda
            $client = new GenerativeModel([
                'api_key' => 'AIzaSyB_7Uj-0FLFYq1YiE0RL0Jxy8G5vLR_6NU' // Ganti dengan kunci API Anda
            ]);

            // Buat konten untuk dikirim ke model
            $content = new Content([
                'role' => 'user',
                'parts' => [
                    new Part(['text' => $userMessage])
                ]
            ]);

            // Kirim permintaan ke Gemini
            $response = $client->generateContent([
                'contents' => [$content],
                'generation_config' => new GenerationConfig([
                    'temperature' => 0.7,
                ])
            ]);

            // Ambil respons teks dari AI
            $aiResponse = $response->getParts()[0]->getText();

            return response()->json(['ai_response' => $aiResponse]);
        } catch (\Exception $e) {
            // Tangani kesalahan
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
