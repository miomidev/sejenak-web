<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class VerificationController extends Controller
{
    /**
     * Menampilkan halaman form verifikasi.
     */
    public function show(Request $request)
    {
        // Ambil email dari session yang disimpan saat registrasi
        $email = session('email_for_verification');

        // Jika tidak ada email di session (misalnya user langsung buka URL),
        // dan user sudah login tapi belum verifikasi, gunakan email user tersebut.
        if (!$email && Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            $email = Auth::user()->email;
        }

        if (!$email) {
            // Jika tetap tidak ada email, redirect ke halaman login
            return redirect()->route('login')->with('error', 'Sesi verifikasi tidak ditemukan. Silakan login kembali.');
        }

        return view('auth.verify-code', ['email' => $email]);
    }

    /**
     * Memproses kode verifikasi yang di-submit.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|numeric|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('user.dashboard')->with('info', 'Akun Anda sudah terverifikasi.');
        }

        if ($user->verification_code !== $request->verification_code) {
            return back()->withErrors(['verification_code' => 'Kode verifikasi salah.'])->withInput();
        }

        if (Carbon::now()->isAfter($user->verification_code_expires_at)) {
            return back()->withErrors(['verification_code' => 'Kode verifikasi telah kedaluwarsa. Silakan minta kode baru.'])->withInput();
        }

        // Jika semua benar, verifikasi user
        $user->markEmailAsVerified(); // Ini akan mengisi kolom 'email_verified_at'
        $user->forceFill([
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ])->save();
        
        // Login user secara manual
        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Verifikasi berhasil! Selamat datang.');
    }

    /**
     * Mengirim ulang kode verifikasi.
     */
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Akun Anda sudah terverifikasi.');
        }

        // Logika pembatasan 3x sehari
        $today = Carbon::today()->toDateString();
        if ($user->last_verification_request_at == $today && $user->verification_requests_count >= 3) {
            return back()->with('error', 'Anda telah mencapai batas maksimal permintaan kode hari ini.');
        }

        // Reset hitungan jika sudah beda hari
        if ($user->last_verification_request_at != $today) {
            $user->verification_requests_count = 0;
        }

        // Buat kode baru dan kirim email
        $verificationCode = rand(100000, 999999);
        $user->forceFill([
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => now()->addMinutes(10),
            'verification_requests_count' => $user->verification_requests_count + 1,
            'last_verification_request_at' => $today,
        ])->save();

        Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

        return back()->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }
}