<?php

namespace App\Http\Controllers\Konselor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Models\Audio;
use Illuminate\Support\Facades\Storage;

class KonselorController extends Controller
{
    /**
     * Dashboard Konselor
     */
    public function dashboard()
    {
        // 1. DATA DUMMY UNTUK KARTU STATISTIK
        $stats = [
            'active_clients' => 8,
            'sessions_this_week' => 3,
            'new_messages' => 2,
            'completed_sessions' => 47,
        ];

        // 2. DATA DUMMY UNTUK JADWAL SESI MENDATANG
        $upcomingSessions = new Collection([
            (object)[
                'user' => (object)['name' => 'Budi Santoso'],
                'schedule_time' => Carbon::now()->addDays(1)->setTime(10, 0),
            ],
            (object)[
                'user' => (object)['name' => 'Citra Lestari'],
                'schedule_time' => Carbon::now()->addDays(2)->setTime(14, 30),
            ],
            (object)[
                'user' => (object)['name' => 'Agus Wijaya'],
                'schedule_time' => Carbon::now()->addDays(4)->setTime(11, 0),
            ],
        ]);

        // 3. DATA DUMMY UNTUK AKTIVITAS TERBARU
        $recentActivities = new Collection([
            (object)[
                'description' => 'Sesi dengan Budi Santoso berhasil dijadwalkan ulang.',
                'created_at' => Carbon::now()->subMinutes(30),
            ],
            (object)[
                'description' => 'Anda menerima pesan baru dari Citra Lestari.',
                'created_at' => Carbon::now()->subHours(2),
            ],
            (object)[
                'description' => 'Laporan sesi untuk Agus Wijaya telah selesai.',
                'created_at' => Carbon::now()->subHours(5),
            ],
        ]);
        
        // 4. Mengirim semua data dummy ke view
        return view('konselor.index', compact('stats', 'upcomingSessions', 'recentActivities'));
    }

    /**
     * Manajemen Audio
     */
    public function audios()
    {
        $audios = Audio::latest()->paginate(12);
        $categories = Audio::distinct()->pluck('category');
        return view('konselor.audios.index', compact('audios', 'categories'));
    }

    public function createAudio()
    {
        $categories = ['rain', 'forest', 'piano', 'ocean', 'white-noise', 'meditation', 'nature', 'ambient'];
        return view('konselor.audios.create', compact('categories'));
    }

    public function storeAudio(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:mp3,wav,ogg|max:10240',
            'category' => 'required|string|max:100',
            'is_premium' => 'boolean',
        ]);

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('audios', 'public');
        }

        Audio::create($validated);
        return redirect()->route('konselor.audios')->with('success', 'Audio uploaded successfully.');
    }

    public function editAudio(Audio $audio)
    {
        $categories = ['rain', 'forest', 'piano', 'ocean', 'white-noise', 'meditation', 'nature', 'ambient'];
        return view('konselor.audios.edit', compact('audio', 'categories'));
    }

    public function updateAudio(Request $request, Audio $audio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'category' => 'required|string|max:100',
            'is_premium' => 'boolean',
        ]);

        if ($request->hasFile('file_path')) {
            if ($audio->file_path) {
                Storage::disk('public')->delete($audio->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('audios', 'public');
        } else {
            unset($validated['file_path']);
        }

        $audio->update($validated);
        return redirect()->route('konselor.audios')->with('success', 'Audio updated successfully.');
    }

    public function deleteAudio(Audio $audio)
    {
        if ($audio->file_path) {
            Storage::disk('public')->delete($audio->file_path);
        }
        $audio->delete();
        return redirect()->route('konselor.audios')->with('success', 'Audio deleted successfully.');
    }
}