<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mood;
use App\Models\Post;
use App\Models\Journal;
use App\Models\Exercise;
use App\Models\ExerciseUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function user(Request $request)
    {
        $user = Auth::user();
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);
        
        // Data untuk statistik
        $postCount = Post::where('user_id', $user->id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
            
        $journalCount = Journal::where('user_id', $user->id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
            
        // Hitung streak (hari berturut-turut menggunakan aplikasi)
        $streakCount = $this->calculateStreak($user->id);
        
        // Data untuk kalender
        $calendarData = $this->getCalendarData($user->id, $year, $month);
        
        // Data untuk chart mood
        $moodData = $this->getMoodData($user->id);
        
        return view('history.user', compact(
            'postCount',
            'journalCount',
            'streakCount',
            'calendarData',
            'moodData',
            'year',
            'month'
        ));
    }
    
    private function calculateStreak($userId)
    {
        // Ambil tanggal aktivitas terakhir user
        $lastPostDate = Post::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->value('created_at');
            
        $lastJournalDate = Journal::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->value('created_at');
            
        $lastMoodDate = Mood::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->value('created_at');
            
        $lastExerciseDate = ExerciseUser::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->value('created_at');
            
        // Cari tanggal terbaru dari semua aktivitas
        $dates = array_filter([$lastPostDate, $lastJournalDate, $lastMoodDate, $lastExerciseDate]);
        if (empty($dates)) {
            return 0;
        }
        
        $latestDate = max($dates);
        $today = Carbon::today();
        $latestDate = Carbon::parse($latestDate)->startOfDay();
        
        // Jika aktivitas terakhir bukan hari ini, streak = 0
        if ($latestDate->lt($today)) {
            return 0;
        }
        
        // Hitung hari berturut-turut
        $streak = 1;
        $currentDate = $today->copy()->subDay();
        
        while (true) {
            $hasActivity = Post::where('user_id', $userId)
                ->whereDate('created_at', $currentDate)
                ->orWhere(function($query) use ($userId, $currentDate) {
                    $query->where('user_id', $userId)
                        ->whereDate('created_at', $currentDate);
                })
                ->orWhere(function($query) use ($userId, $currentDate) {
                    $query->where('user_id', $userId)
                        ->whereDate('created_at', $currentDate);
                })
                ->orWhere(function($query) use ($userId, $currentDate) {
                    $query->where('user_id', $userId)
                        ->whereDate('created_at', $currentDate);
                })
                ->exists();
                
            if (!$hasActivity) {
                break;
            }
            
            $streak++;
            $currentDate->subDay();
        }
        
        return $streak;
    }
    
    private function getCalendarData($userId, $year, $month)
    {
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();
        
        // Ambil data post
        $postDays = Post::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->pluck('created_at')
            ->map(function($date) {
                return Carbon::parse($date)->day;
            })
            ->toArray();
            
        // Ambil data journal
        $journalDays = Journal::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->pluck('created_at')
            ->map(function($date) {
                return Carbon::parse($date)->day;
            })
            ->toArray();
            
        // Ambil data exercise (meditasi)
        $exerciseDays = ExerciseUser::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->pluck('created_at')
            ->map(function($date) {
                return Carbon::parse($date)->day;
            })
            ->toArray();
            
        // Ambil data mood
        $moodDays = Mood::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->day;
            })
            ->map(function($dayMoods) {
                // Ambil mood terakhir untuk setiap hari
                return $dayMoods->sortByDesc('created_at')->first()->mood;
            })
            ->toArray();
            
        return [
            'postDays' => $postDays,
            'journalDays' => $journalDays,
            'exerciseDays' => $exerciseDays,
            'moodDays' => $moodDays,
        ];
    }
    
    private function getMoodData($userId)
    {
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        $moods = Mood::where('user_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            })
            ->map(function($dayMoods) {
                // Ambil mood terakhir untuk setiap hari
                return $dayMoods->sortByDesc('created_at')->first();
            });
            
        // Buat data untuk 7 hari terakhir
        $moodHistory = [];
        $moodCounts = [
            'Bahagia' => 0,
            'Tenang' => 0,
            'Biasa' => 0,
            'Sedih' => 0,
            'Marah' => 0,
            'Semangat' => 0,
        ];
        
        $moodMap = [
            'happy' => 'Bahagia',
            'relaxed' => 'Tenang',
            'calm' => 'Biasa',
            'sad' => 'Sedih',
            'angry' => 'Marah',
            'energetic' => 'Semangat',
            'anxious' => 'Sedih', // Bisa disesuaikan
            'stressed' => 'Marah', // Bisa disesuaikan
            'tired' => 'Biasa', // Bisa disesuaikan
        ];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayName = Carbon::now()->subDays($i)->locale('id')->isoFormat('dd');
            
            if (isset($moods[$date])) {
                $mood = $moods[$date];
                $moodName = $moodMap[$mood->mood] ?? 'Biasa';
                
                $moodHistory[] = [
                    'day' => $dayName,
                    'mood' => $moodName,
                    'value' => $this->moodValue($mood->mood),
                ];
                
                $moodCounts[$moodName]++;
            } else {
                $moodHistory[] = [
                    'day' => $dayName,
                    'mood' => 'Biasa',
                    'value' => 50, // Nilai default untuk tidak ada data
                ];
            }
        }
        
        return [
            'moodHistory' => $moodHistory,
            'moodCounts' => $moodCounts,
        ];
    }
    
    private function moodValue($mood)
    {
        $values = [
            'sad' => 30,
            'anxious' => 40,
            'stressed' => 40,
            'calm' => 60,
            'tired' => 50,
            'happy' => 90,
            'relaxed' => 80,
            'angry' => 30,
            'energetic' => 95,
        ];
        
        return $values[$mood] ?? 50;
    }
}