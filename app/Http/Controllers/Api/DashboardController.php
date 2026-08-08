<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mood;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private function getRandomQuote()
    {
        $path = public_path('assets/json/text.json');

        if (!file_exists($path)) {
            return null;
        }

        $json = file_get_contents($path);
        $quotes = json_decode($json, true);

        if (!$quotes || !is_array($quotes)) {
            return null;
        }

        return $quotes[array_rand($quotes)];
    }

    public function index()
    {
        $user = Auth::user()->load([
            'role',
            'messages',
            'moods',
            'journals',
            'challenges',
            'exercises'
        ]);

        $userId = $user->id;

        $topPost = Post::inRandomOrder()->first();

        $riwayatJournal = $user->journals->map(function ($journal) {
            return Carbon::parse($journal->updated_at)->day;
        });

        $riwayatMeditasi = $user->exercises->map(function ($exercise) {
            return Carbon::parse($exercise->updated_at)->day;
        });

        $moods = Mood::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('MAX(mood) as mood')
            )
            ->where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $moodMap = [
            'sad' => 1,
            'anxious' => 2,
            'stressed' => 2,
            'calm' => 3,
            'tired' => 3,
            'happy' => 4,
            'relaxed' => 4,
            'angry' => 2,
            'energetic' => 5,
        ];

        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $labels[] = $day->locale('id')->isoFormat('dd'); // Sen, Sel, dst

            $found = $moods->firstWhere('date', $day->toDateString());

            $data[] = $found ? ($moodMap[$found->mood] ?? 0) : 0;
        }

        $quote = $this->getRandomQuote();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'top_post' => $topPost,
            'riwayat_journal' => $riwayatJournal,
            'riwayat_meditasi' => $riwayatMeditasi,
            'labels' => $labels,
            'mood_data' => $data,
            'quote' => $quote
        ]);
    }
}
