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
        $konselorId = Auth::id();

        // 1. DATA ASLI UNTUK KARTU STATISTIK
        $activeClients = \App\Models\Session::where('konselor_id', $konselorId)
                                            ->where('status', 'ongoing')
                                            ->distinct('user_id')
                                            ->count('user_id');

        $sessionsThisWeek = \App\Models\Session::where('konselor_id', $konselorId)
                                               ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                               ->count();

        $completedSessions = \App\Models\Session::where('konselor_id', $konselorId)
                                                ->where('status', 'closed')
                                                ->count();

        $stats = [
            'active_clients' => $activeClients,
            'sessions_this_week' => $sessionsThisWeek,
            'new_messages' => 0, // Bisa diintegrasikan dengan tabel pesan jika ada
            'completed_sessions' => $completedSessions,
        ];

        // 2. DATA ASLI UNTUK SESI AKTIF SAAT INI (Menggantikan 'Jadwal Mendatang' karena tabel sesi menggunakan 'ongoing')
        $upcomingSessions = \App\Models\Session::with('user')
                                               ->where('konselor_id', $konselorId)
                                               ->where('status', 'ongoing')
                                               ->orderBy('created_at', 'desc')
                                               ->take(5)
                                               ->get()
                                               ->map(function($session) {
                                                    return (object)[
                                                        'user' => (object)['name' => $session->user->name ?? 'Klien'],
                                                        'schedule_time' => $session->created_at, // Menggunakan waktu dibuat sebagai referensi waktu
                                                        'status' => 'Berjalan'
                                                    ];
                                               });

        // 3. DATA ASLI UNTUK AKTIVITAS TERBARU (Diambil dari sesi terakhir diperbarui/ditutup)
        $recentActivities = \App\Models\Session::with('user')
                                               ->where('konselor_id', $konselorId)
                                               ->orderBy('updated_at', 'desc')
                                               ->take(3)
                                               ->get()
                                               ->map(function($session) {
                                                    $action = $session->status == 'closed' ? 'telah selesai' : 'dimulai';
                                                    return (object)[
                                                        'description' => 'Sesi dengan ' . ($session->user->name ?? 'Klien') . ' ' . $action . '.',
                                                        'created_at' => $session->updated_at,
                                                    ];
                                               });
        
        // 4. Mengirim semua data ke view
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