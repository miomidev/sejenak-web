<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSession;
use App\Models\Post;
use App\Models\Journal;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleAuthController extends Controller
{
    public function login(Request $request)
    {
        $accessToken = $request->input('access_token');

        if (!$accessToken) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Missing Google access token'
            ], 400);
        }

        try {
            // Ambil data user dari Google pakai access token
            $googleUser = Socialite::driver('google')->userFromToken($accessToken);

            $email = $googleUser->getEmail();
            $name = $googleUser->getName();
            $avatar = $googleUser->getAvatar();
            $googleId = $googleUser->getId();

            // Cek user
            $user = User::where('google_id', $googleId)
                        ->orWhere('email', $email)
                        ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'username' => Str::slug(explode('@', $email)[0]),
                    'google_id' => $googleId,
                    'avatar' => $avatar,
                    'password' => Hash::make(Str::random(16)),
                    'role_id' => 1,
                    'email_verified_at' => now(),
                ]);
            } else {
                $user->update(['avatar' => $avatar]);
            }

            // Generate JWT token
            $jwtAccessToken = JWTAuth::fromUser($user);
            $refreshToken = Str::random(64);

            // Buat sesi user
            UserSession::create([
                'user_id' => $user->id,
                'token' => hash('sha256', $jwtAccessToken),
                'refresh_token' => hash('sha256', $refreshToken),
                'expires_at' => Carbon::now()->addMinutes(config('jwt.ttl', 60)),
                'last_used_at' => now(),
                'device_name' => $request->header('User-Agent'),
                'ip_address' => $request->ip(),
            ]);

            // Hitung statistik user
            $userId = $user->id;
            $totalPost = Post::where('user_id', $userId)->count();
            $totalJournal = Journal::where('user_id', $userId)->count();
            $totalLike = Like::whereHas('post', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->count();

            // Hitung journal bulan ini
            $startOfMonth = Carbon::now()->startOfMonth();
            $now = Carbon::now();
            $journalThisMonth = Journal::where('user_id', $userId)
                ->whereDate('created_at', '>=', $startOfMonth)
                ->whereDate('created_at', '<=', $now)
                ->count();

            $journalStreak = $this->calculateStreak(Journal::class, $userId);
            $postStreak = $this->calculateStreak(Post::class, $userId);

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Login via Google berhasil',
                'token' => $jwtAccessToken,
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'refresh_token' => $refreshToken,
                'refresh_expires_in' => 60 * 60 * 24 * 7,
                'user' => $user->only(['id', 'name', 'email', 'username', 'avatar']),
                'total_post' => $totalPost,
                'total_journal' => $totalJournal,
                'total_like' => $totalLike,
                'journal_this_month' => $journalThisMonth,
                'journal_streak' => $journalStreak,
                'post_streak' => $postStreak,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'code' => 401,
                'status' => 'error',
                'message' => 'Gagal login via Google',
                'error' => $e->getMessage(),
            ], 401);
        }
    }

    private function calculateStreak(string $modelClass, int $userId): int
    {
        $today = Carbon::today();
        $streak = 0;

        while (true) {
            $dateToCheck = $today->copy()->subDays($streak);
            $count = $modelClass::where('user_id', $userId)
                ->whereDate('created_at', $dateToCheck)
                ->count();

            if ($count > 0) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }
}
