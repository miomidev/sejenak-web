<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role_id' => 1,
        ]);

        // --- LOGIKA BARU: KIRIM KODE VERIFIKASI ---

        // 1. Buat 6 digit kode acak
        $verificationCode = rand(100000, 999999);

        // 2. Simpan kode dan data terkait ke user
        $user->forceFill([
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => now()->addMinutes(10), // Kode berlaku 10 menit
            'verification_requests_count' => 1,
            'last_verification_request_at' => now(),
        ])->save();

        // 3. Kirim email berisi kode ke user
        try {
            Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));
        } catch (\Exception $e) {
            // Opsional: tangani jika email gagal dikirim
            // Log::error("Gagal mengirim email verifikasi ke {$user->email}: {$e->getMessage()}");
        }

        // Simpan email user di session untuk halaman verifikasi
        session(['email_for_verification' => $user->email]);

        // Fortify akan menangani sisanya, yaitu mengarahkan ke halaman verifikasi
        // karena User model sekarang mengimplementasikan MustVerifyEmail
        return $user;
    }
}