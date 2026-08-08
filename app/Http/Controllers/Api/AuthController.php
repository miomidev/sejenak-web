<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\Journal;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
class AuthController extends Controller
{

    public function register(Request $request)
    {
        $userRoleId = DB::table('roles')->where('name', 'user')->value('id');
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:10',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $userRoleId ?? 2
        ]);

        // --- LOGIKA BARU: KIRIM KODE VERIFIKASI ---
        $verificationCode = rand(100000, 999999);
        $user->forceFill([
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => now()->addMinutes(10),
            'verification_requests_count' => 1,
            'last_verification_request_at' => now(),
        ])->save();

        try {
            Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Gagal membuat user, tidak dapat mengirim email verifikasi.'
            ], 500);
        }

        return response()->json([
            'code' => 201,
            'status' => 'success',
            'message' => 'Registrasi berhasil. Silakan cek email Anda untuk kode verifikasi.',
            'data' => [
                'email' => $user->email
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        // --- LOGIKA BARU: CEK SEBELUM LOGIN ---
        // 1. Cek apakah user ada
        if (!$user) {
            return response()->json(['code' => 401, 'status' => 'error', 'message' => 'Email atau password salah'], 401);
        }

        // 2. Cek apakah user sudah terverifikasi
        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'code' => 403,
                'status' => 'error',
                'message' => 'Akun belum diverifikasi. Silakan cek email Anda.',
                'data' => [
                    'email' => $user->email
                ]
            ], 403);
        }

        // 3. Coba login
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['code' => 401, 'status' => 'error', 'message' => 'Email atau password salah'], 401);
        }

        return $this->createSessionAndRespond($user, $request, $token);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|numeric|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['code' => 400, 'status' => 'error', 'message' => 'Akun ini sudah diverifikasi.'], 400);
        }

        if ($user->verification_code !== $request->code) {
            return response()->json(['code' => 422, 'status' => 'error', 'message' => 'Kode verifikasi salah.'], 422);
        }

        if (now()->isAfter($user->verification_code_expires_at)) {
            return response()->json(['code' => 422, 'status' => 'error', 'message' => 'Kode verifikasi telah kedaluwarsa.'], 422);
        }

        // Jika semua valid, verifikasi user
        $user->markEmailAsVerified(); // Ini akan mengisi 'email_verified_at'
        $user->forceFill([
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ])->save();

        // Buat token dan sesi
        $token = JWTAuth::fromUser($user);
        return $this->createSessionAndRespond($user, $request, $token);
    }

    public function resendVerification(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['code' => 400, 'status' => 'error', 'message' => 'Akun ini sudah diverifikasi.'], 400);
        }

        // Cek apakah tanggal terakhir request adalah hari ini
        if ($user->last_verification_request_at && Carbon::parse($user->last_verification_request_at)->isToday()) {
             // Jika ya, cek jumlah request
            if ($user->verification_requests_count >= 3) {
                return response()->json(['code' => 429, 'status' => 'error', 'message' => 'Anda telah mencapai batas maksimal permintaan kode hari ini.'], 429);
            }
        } else {
            // Jika hari baru, reset counter
            $user->verification_requests_count = 0;
        }

        $verificationCode = rand(100000, 999999);
        $user->forceFill([
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => now()->addMinutes(10),
            'verification_requests_count' => $user->verification_requests_count + 1,
            'last_verification_request_at' => now(),
        ])->save();

        try {
            Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'status' => 'error', 'message' => 'Gagal mengirim ulang email verifikasi.'], 500);
        }

        return response()->json(['code' => 200, 'status' => 'success', 'message' => 'Kode verifikasi baru telah dikirim ke email Anda.']);
    }

private function createSessionAndRespond(User $user, Request $request, $accessToken = null)
{
    if (!$accessToken) {
        $accessToken = JWTAuth::fromUser($user);
    }

    $refreshToken = Str::random(64);

    UserSession::create([
        'user_id' => $user->id,
        'token' => hash('sha256', $accessToken),
        'refresh_token' => hash('sha256', $refreshToken),
        'expires_at' => Carbon::now()->addMinutes(config('jwt.ttl', 60)),
        'last_used_at' => now(),
        'device_name' => $request->header('User-Agent'),
        'ip_address' => $request->ip(),
    ]);

    $userId = $user->id;

    // Hitung statistik
    $totalPost = Post::where('user_id', $userId)->count();
    $totalJournal = Journal::where('user_id', $userId)->count();
    $totalLike = Like::whereHas('post', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })->count();

    // Hitung journal bulan ini
    $startOfMonth = Carbon::now()->startOfMonth(); // Tanggal 1 bulan ini 00:00:00
    $now = Carbon::now(); // Tanggal dan waktu sekarang

    $journalThisMonth = Journal::where('user_id', $userId)
        ->whereDate('created_at', '>=', $startOfMonth)
        ->whereDate('created_at', '<=', $now)
        ->count();

    $journalStreak = $this->calculateStreak(Journal::class, $userId);
    $postStreak = $this->calculateStreak(Post::class, $userId);

    return response()->json([
        'code' => 200,
        'status' => 'success',
        'access_token' => $accessToken,
        'expires_in' => auth('api')->factory()->getTTL() * 60,
        'refresh_token' => $refreshToken,
        'refresh_expires_in' => 60 * 60 * 24 * 7,
        'user' => $user->only(['id', 'name', 'email', 'username']),
        'total_post' => $totalPost,
        'total_journal' => $totalJournal,
        'total_like' => $totalLike,
        'journal_this_month' => $journalThisMonth,
        'journal_streak' => $journalStreak,
        'post_streak' => $postStreak,
    ]);
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

    public function refresh(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required|string',
        ]);

        $hashed = hash('sha256', $request->refresh_token);

        $session = UserSession::where('refresh_token', $hashed)
            ->where('expires_at', '>', now())
            ->first();

        if (!$session) {
            return response()->json(['code' => 401, 'status' => 'error', 'message' => 'Invalid or expired refresh token'], 401);
        }

        $user = $session->user;

        $newAccessToken = JWTAuth::fromUser($user);

        $session->update([
            'token' => hash('sha256', $newAccessToken),
            'expires_at' => Carbon::now()->addMinutes(config('jwt.ttl', 60)),
            'last_used_at' => now(),
        ]);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'access_token' => $newAccessToken,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    public function logout(Request $request)
    {
        try {
            $accessToken = JWTAuth::getToken();
            if ($accessToken) {
                $hashed = hash('sha256', $accessToken);
                UserSession::where('token', $hashed)->delete();
                JWTAuth::invalidate($accessToken);
            }

            if ($request->refresh_token) {
                $hashedRefresh = hash('sha256', $request->refresh_token);
                UserSession::where('refresh_token', $hashedRefresh)->delete();
            }

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'status' => 'error', 'message' => 'Failed to logout'], 500);
        }
    }

    public function me()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'user' => $user->only(['id', 'name', 'email', 'username', 'avatar', 'bio', 'role_id']),
        ]);
    }
}
