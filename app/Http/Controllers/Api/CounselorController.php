<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CounselorController extends Controller
{
    /**
     * Get global session price
     */
    public function getSessionPrice()
    {
        $sessionPrice = Setting::where('key', 'session_price')->first()->value ?? 500;
        return response()->json([
            'success' => true,
            'data' => (int) $sessionPrice
        ]);
    }

    /**
     * Get a list of all counselors.
     */
    public function index()
    {
        $counselors = User::whereHas('role', function ($query) {
            $query->where('name', 'konselor');
        })
        ->select('id', 'name', 'avatar', 'bio')
        ->get();

        // Map data to include dummy experience/specialization if bio doesn't have it
        // Or we can just let mobile handle it. For now, just return what we have.
        $counselors = $counselors->map(function ($counselor) {
            return [
                'id' => $counselor->id,
                'name' => $counselor->name,
                'avatar_url' => $counselor->avatar_url,
                'bio' => $counselor->bio,
                'is_online' => $counselor->isOnline(),
                'specialization' => 'Psikolog Klinis', // default fallback
                'experience' => '5 Tahun', // default fallback
                'rating' => '4.8', // default fallback
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $counselors
        ]);
    }

    /**
     * Request a counseling session (Costs 500 tokens).
     */
    public function requestSession(Request $request)
    {
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'scheduled_at' => 'nullable|date'
        ]);

        $user = Auth::user();
        $counselorId = $request->counselor_id;
        $sessionPrice = (int) (Setting::where('key', 'session_price')->first()->value ?? 500);

        // Cek apakah user yang dituju adalah benar konselor
        $counselor = User::where('id', $counselorId)->whereHas('role', function($q) {
            $q->where('name', 'konselor');
        })->first();

        if (!$counselor) {
            return response()->json([
                'success' => false,
                'message' => 'Konselor tidak ditemukan.'
            ], 404);
        }

        if ($user->tokens_balance < $sessionPrice) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak cukup. Sisa token: ' . $user->tokens_balance . '. Dibutuhkan: ' . $sessionPrice,
                'requires_topup' => true
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Kurangi token user
            $user->tokens_balance -= $sessionPrice;
            $user->save();

            // Buat record session
            $session = Session::create([
                'user_id' => $user->id,
                'konselor_id' => $counselor->id,
                'status' => 'pending', // pending until counselor accepts
                'scheduled_at' => $request->scheduled_at
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan sesi berhasil! Menunggu konfirmasi konselor.',
                'data' => $session
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's sessions.
     */
    public function mySessions()
    {
        $user = Auth::user();
        
        $sessions = Session::with(['counselor:id,name,avatar', 'user:id,name,avatar'])
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('konselor_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sessions
        ]);
    }

    /**
     * Counselor accepts a session request
     */
    public function acceptSession($id)
    {
        $session = Session::find($id);
        if (!$session) return response()->json(['success' => false, 'message' => 'Sesi tidak ditemukan'], 404);
        
        if (Auth::id() !== $session->konselor_id) {
            return response()->json(['success' => false, 'message' => 'Tidak diizinkan'], 403);
        }

        $session->status = 'ongoing';
        $session->save();

        return response()->json([
            'success' => true,
            'message' => 'Sesi berhasil dimulai.',
            'data' => $session
        ]);
    }

    /**
     * End a counseling session
     */
    public function endSession($id)
    {
        $session = Session::find($id);
        if (!$session) return response()->json(['success' => false, 'message' => 'Sesi tidak ditemukan'], 404);

        if (Auth::id() !== $session->user_id && Auth::id() !== $session->konselor_id) {
            return response()->json(['success' => false, 'message' => 'Tidak diizinkan'], 403);
        }

        if ($session->status !== 'completed') {
            $session->status = 'completed';
            $session->save();

            // Berikan token ke konselor
            $sessionPrice = (int) (Setting::where('key', 'session_price')->first()->value ?? 500);
            $counselor = User::find($session->konselor_id);
            if ($counselor) {
                $counselor->tokens_balance += $sessionPrice;
                $counselor->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesi berhasil diakhiri.',
            'data' => $session
        ]);
    }
}
