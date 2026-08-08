<?php
namespace App\Http\Controllers\Api;

use App\Models\UserChallenge;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyChallenge;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserDailyChallengeController extends Controller
{
    public function listChallenges()
    {
        $challenges = DailyChallenge::where('is_active', true)->get();

        return response()->json([
            'status' => 'success',
            'data' => $challenges
        ]);
    }

    public function chooseChallenge(Request $request)
    {
        $request->validate([
            'daily_challenge_id' => 'required|exists:daily_challenges,id',
            'date' => 'nullable|date'
        ]);

        $user = Auth::user();
        $date = $request->date ?? now()->toDateString();

        $existing = UserChallenge::where('user_id', $user->id)
            ->where('daily_challenge_id', $request->daily_challenge_id)
            ->where('date', $date)
            ->first();

        if ($existing) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Challenge sudah dipilih untuk tanggal ini.'
            ], 409);
        }

        $userChallenge = UserChallenge::create([
            'user_id' => $user->id,
            'daily_challenge_id' => $request->daily_challenge_id,
            'date' => $date,
            'is_completed' => false
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Challenge berhasil dipilih.',
            'data' => $userChallenge
        ]);
    }

    public function completeChallenge($id)
    {
        $user = Auth::user();

        $challenge = UserChallenge::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$challenge) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Challenge tidak ditemukan.'
            ], 404);
        }

        if ($challenge->is_completed) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Challenge sudah diselesaikan.'
            ], 400);
        }

        $challenge->update([
            'is_completed' => true,
            'completed_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Challenge ditandai selesai.',
            'data' => $challenge
        ]);
    }

    public function myChallenges(Request $request)
    {
        $user = Auth::user();
        $date = $request->query('date', now()->toDateString());

        $challenges = UserChallenge::with('dailyChallenge')
            ->where('user_id', $user->id)
            ->where('date', $date)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $challenges
        ]);
    }
}
