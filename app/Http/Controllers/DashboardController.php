<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getWeather(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $latitude = $request->lat;
        $longitude = $request->lon;
        $apiKey = env('OPENWEATHER_API_KEY');

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat' => $latitude,
            'lon' => $longitude,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);

        // ==========================================================
        // PERUBAHAN UTAMA ADA DI SINI
        // ==========================================================
        if ($response->failed()) {
            // Catat pesan error yang sebenarnya ke dalam file log
            Log::error('Gagal mengambil data cuaca dari OpenWeatherMap.', [
                'status' => $response->status(),
                'body' => $response->body(), // Ini bagian paling penting
            ]);

            // Kirim response error seperti biasa
            return response()->json(['error' => 'Gagal mengambil data cuaca.'], 500);
        }
        // ==========================================================
        // AKHIR PERUBAHAN
        // ==========================================================

        $data = $response->json();

        $weatherData = [
            'city' => $data['name'],
            'temperature' => round($data['main']['temp']),
            'description' => ucfirst($data['weather'][0]['description']),
            'icon' => $data['weather'][0]['icon'],
        ];

        return response()->json($weatherData);
    }

    function getRandomQuote()
    {
        // Path file JSON
        $path = public_path('assets/json/text.json');

        // Cek apakah file ada
        if (!file_exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'File JSON tidak ditemukan'
            ], 404);
        }

        // Ambil isi file JSON
        $json = file_get_contents($path);
        $quotes = json_decode($json, true);

        // Cek validitas data
        if (!$quotes || !is_array($quotes)) {
            return response()->json([
                'success' => false,
                'message' => 'Data JSON tidak valid'
            ], 500);
        }

        // Ambil random 1 data
        $randomQuote = $quotes[array_rand($quotes)];

        return $randomQuote;
    }
    public function index()
    {
        $user = Auth::user(); // Mengambil user yang sedang login
        
        // Redirect Admin/Konselor ke dashboard masing-masing
        if ($user && $user->role) {
            if ($user->role->name === 'konselor') {
                return redirect()->route('konselor.dashboard');
            } elseif (in_array($user->role->name, ['admin', 'super_admin'])) {
                return redirect()->route('admin.dashboard');
            }
        }

        $userId = $user->id;

        // Biarkan ini, karena untuk fitur 'Top Post' yang berbeda
        $topPost = Post::inRandomOrder()->first();

        $currentMonth = now()->month;
        $currentYear = now()->year;

        // DIUBAH: Query dibuat lebih efisien, langsung filter di database
        $riwayatJurnal = $user->journals()
                            ->whereYear('created_at', $currentYear)
                            ->whereMonth('created_at', $currentMonth)
                            ->pluck('created_at')
                            ->map(fn($date) => Carbon::parse($date)->day)
                            ->unique()
                            ->values();

        // BARU: Query untuk mengambil riwayat postingan (menggantikan meditasi)
        // Pastikan model User Anda memiliki relasi 'posts'
        $riwayatPostingan = $user->posts()
                                ->whereYear('created_at', $currentYear)
                                ->whereMonth('created_at', $currentMonth)
                                ->pluck('created_at')
                                ->map(fn($date) => Carbon::parse($date)->day)
                                ->unique()
                                ->values();

        // Bagian untuk Grafik Mood 7 Hari Terakhir
        $recentMoods = Mood::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->orderBy('created_at', 'desc')
            ->get();

        $moodMap = [
            'sad' => 1,
            'anxious' => 2,
            'stressed' => 2,
            'angry' => 2,
            'tired' => 3,
            'calm' => 3,
            'relaxed' => 4,
            'happy' => 4,
            'energetic' => 5,
        ];

        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $labels[] = $day->locale('id')->isoFormat('ddd');
            $dateStr = $day->toDateString();

            $dayMood = $recentMoods->first(function ($m) use ($dateStr) {
                return Carbon::parse($m->created_at)->toDateString() === $dateStr;
            });

            $data[] = $dayMood ? ($moodMap[$dayMood->mood] ?? 0) : 0;
        }

        $quote = $this->getRandomQuote();

        // DIUBAH: Mengirim variabel baru ke view
        return view('dashboard', [
            'user' => $user,
            'topPost' => $topPost,
            'riwayatJurnal' => $riwayatJurnal,
            'riwayatPostingan' => $riwayatPostingan, // Menggantikan riwayatMeditasi
            'labels' => $labels,
            'data' => $data,
            'quote' => $quote,
        ]);
    }
}
