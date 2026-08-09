<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Show token package selection page.
     */
    public function showTokenPage()
    {
        $packages = [
            ['icon' => 'fas fa-seedling', 'name' => 'Paket Basic', 'tokens' => 50, 'price' => 2500, 'color' => 'primary'],
            ['icon' => 'fas fa-piggy-bank', 'name' => 'Paket Hemat', 'tokens' => 120, 'price' => 6000, 'color' => 'secondary'],
            ['icon' => 'fas fa-gift', 'name' => 'Paket Medium', 'tokens' => 250, 'price' => 12500, 'color' => 'orange'],
            ['icon' => 'fas fa-star', 'name' => 'Paket Mega', 'tokens' => 550, 'price' => 27500, 'color' => 'primary'],
            ['icon' => 'fas fa-fire', 'name' => 'Paket Super', 'tokens' => 1200, 'price' => 60000, 'color' => 'secondary'],
            ['icon' => 'fas fa-rocket', 'name' => 'Paket Ultimate', 'tokens' => 3000, 'price' => 150000, 'color' => 'orange'],
            ['icon' => 'fas fa-heart', 'name' => 'Paket Keluarga', 'tokens' => 5000, 'price' => 250000, 'color' => 'primary'],
            ['icon' => 'fas fa-calendar-alt', 'name' => 'Paket Tahunan', 'tokens' => 10000, 'price' => 500000, 'color' => 'secondary'],
            ['icon' => 'fas fa-infinity', 'name' => 'Paket Sejenak', 'tokens' => 25000, 'price' => 1250000, 'color' => 'orange'],
        ];

        return view('transactions.token', compact('packages'));
    }

    /**
     * Handle user request to checkout a token package via MiomiPay.
     * Returns QRIS data for inline modal display.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string',
            'token_amount' => 'required|integer',
            'price' => 'required|integer',
        ]);

        // Buat Order ID yang unik
        $orderId = 'SEJENAK-' . strtoupper(Str::random(10)) . '-' . time();

        // Simpan transaksi ke database dengan status pending
        $transaction = Transaction::create([
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'package_name' => $request->package_name,
            'token_amount' => $request->token_amount,
            'price' => $request->price,
            'status' => 'pending',
        ]);

        // Kirim request ke MiomiPay API
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('miomipay.api_key'),
                'Content-Type' => 'application/json',
            ])->post(config('miomipay.base_url') . '/trx', [
                'order_id' => $orderId,
                'amount' => (int) $request->price,
                'link_name' => $request->package_name . ' - ' . $request->token_amount . ' Token',
                'webhook_url' => 'https://sejenak.miomidev.com/api/miomipay/webhook',
            ]);

            if ($response->successful()) {
                $data = $response->json();

                Log::info('MiomiPay checkout response', $data);

                // Ambil data QRIS dari response
                $paymentUrl = $data['paylink'] ?? $data['payment_url'] ?? $data['url'] ?? null;
                $rawQris    = $data['raw_qris'] ?? null;
                $expiredAt  = $data['expired_at'] ?? $data['expiry_time'] ?? null;

                // Generate QRIS image URL dari raw_qris string menggunakan QR code API
                $qrisImageUrl = null;
                if ($rawQris) {
                    $qrisImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($rawQris);
                }

                // Simpan payment URL ke snap_token
                if ($paymentUrl) {
                    $transaction->update(['snap_token' => $paymentUrl]);
                }

                // Simpan raw_qris ke DB jika ada (untuk fitur "Bayar Lagi")
                if ($rawQris) {
                    $transaction->update(['snap_token' => $rawQris]);
                }

                return response()->json([
                    'success'      => true,
                    'order_id'     => $orderId,
                    'payment_url'  => $paymentUrl,
                    'qris_url'     => $qrisImageUrl,
                    'raw_qris'     => $rawQris,
                    'expired_at'   => $expiredAt,
                    'amount'       => (int) $request->price,
                    'package_name' => $request->package_name,
                    'token_amount' => (int) $request->token_amount,
                    'data'         => $data,
                ]);
            } else {
                Log::error('MiomiPay API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return response()->json(['error' => 'Gagal membuat transaksi MiomiPay: ' . $response->body()], 500);
            }
        } catch (\Exception $e) {
            Log::error('MiomiPay Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Check transaction status for polling.
     */
    public function checkStatus(Request $request)
    {
        $request->validate(['order_id' => 'required|string']);

        $transaction = Transaction::where('order_id', $request->order_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json([
            'status'       => $transaction->status,
            'order_id'     => $transaction->order_id,
            'token_amount' => $transaction->token_amount,
        ]);
    }

    /**
     * Get QRIS for an existing pending transaction (for "Bayar Lagi" feature).
     */
    public function getQris(Request $request)
    {
        $request->validate(['order_id' => 'required|string']);

        $transaction = Transaction::where('order_id', $request->order_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($transaction->status !== 'pending') {
            return response()->json(['error' => 'Transaksi sudah ' . $transaction->status], 422);
        }

        // Cek apakah sudah expired (60 menit)
        if ($transaction->created_at->diffInMinutes(now()) >= 60) {
            $transaction->update(['status' => 'expired']);
            return response()->json(['error' => 'Transaksi sudah kedaluwarsa'], 422);
        }

        // Hitung sisa waktu dalam detik
        $remainingSeconds = max(0, 3600 - $transaction->created_at->diffInSeconds(now()));

        // Jika snap_token berisi raw_qris (bukan URL), generate QR image
        $rawQris = $transaction->snap_token;
        $qrisImageUrl = null;
        $paymentUrl = null;

        if ($rawQris && !str_starts_with($rawQris, 'http')) {
            // snap_token berisi raw QRIS string
            $qrisImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($rawQris);
        } elseif ($rawQris && str_starts_with($rawQris, 'http')) {
            // snap_token berisi payment URL
            $paymentUrl = $rawQris;
        }

        return response()->json([
            'success'          => true,
            'order_id'         => $transaction->order_id,
            'package_name'     => $transaction->package_name,
            'token_amount'     => $transaction->token_amount,
            'amount'           => $transaction->price,
            'qris_url'         => $qrisImageUrl,
            'payment_url'      => $paymentUrl,
            'remaining_seconds'=> $remainingSeconds,
        ]);
    }

    /**
     * Handle MiomiPay webhook notification.
     */
    public function miomipayWebhook(Request $request)
    {
        // Ambil payload mentah
        $payload = $request->getContent();

        // Validasi signature HMAC SHA-256
        $signatureHeader = $request->header('X-Signature', '');
        $secretKey = config('miomipay.webhook_secret');
        $calculatedSignature = hash_hmac('sha256', $payload, $secretKey);

        if (!hash_equals($calculatedSignature, $signatureHeader)) {
            Log::warning('MiomiPay Webhook: Invalid signature');
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $data = $request->json()->all();

        Log::info('MiomiPay Webhook received', $data);

        $orderId = $data['order_id'] ?? null;
        $transactionStatus = $data['transaction_status'] ?? null;

        if (!$orderId) {
            return response()->json(['status' => 'ok']);
        }

        $transaction = Transaction::where('order_id', $orderId)->first();

        if ($transaction && $transaction->status === 'pending') {
            if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
                $transaction->update(['status' => 'success']);

                $user = User::find($transaction->user_id);
                if ($user) {
                    $user->increment('tokens_balance', $transaction->token_amount);
                    Log::info("Token added: user {$user->id} +{$transaction->token_amount} tokens");
                }
            } elseif ($transactionStatus === 'expire') {
                $transaction->update(['status' => 'expired']);
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'failure'])) {
                $transaction->update(['status' => 'failed']);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Menampilkan halaman ketika pembayaran berhasil.
     */
    public function success()
    {
        return view('transactions.success');
    }

    /**
     * Menampilkan halaman ketika pembayaran pending.
     */
    public function pending()
    {
        return view('transactions.pending');
    }

    /**
     * Menampilkan halaman ketika pembayaran gagal.
     */
    public function failed()
    {
        return view('transactions.failed');
    }

    /**
     * Menampilkan riwayat transaksi pengguna yang sedang login.
     */
    public function userHistory()
    {
        $userId = Auth::id();

        // Lazy Expiration: Update transaksi pending yang sudah lebih dari 60 menit menjadi expired
        Transaction::where('user_id', $userId)
            ->where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(60))
            ->update(['status' => 'expired']);

        // Ambil riwayat transaksi, terbaru di atas
        $transactions = Transaction::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transactions.history', compact('transactions'));
    }

    public function index()
    {
        $transactions = Transaction::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::all();
        return view('transactions.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer',
            'type' => 'required|in:topup,usage',
            'description' => 'nullable|string',
        ]);

        Transaction::create([
            'user_id' => $validated['user_id'],
            'token_amount' => $validated['amount'],
            'status' => $validated['type'] == 'topup' ? 'manual_topup' : 'manual_usage',
            'description' => $validated['description'],
        ]);

        $user = User::find($validated['user_id']);
        if ($validated['type'] === 'topup') {
            $user->increment('tokens_balance', $validated['amount']);
        } else {
            $user->decrement('tokens_balance', $validated['amount']);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('user');
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $users = User::all();
        return view('transactions.edit', compact('transaction', 'users'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer',
            'type' => 'required|in:topup,usage',
            'description' => 'nullable|string',
        ]);

        $oldUser = User::find($transaction->user_id);
        if ($transaction->type === 'topup') {
            $oldUser->decrement('tokens_balance', $transaction->amount);
        } else {
            $oldUser->increment('tokens_balance', $transaction->amount);
        }

        $transaction->update($validated);

        $user = User::find($validated['user_id']);
        if ($validated['type'] === 'topup') {
            $user->increment('tokens_balance', $validated['amount']);
        } else {
            $user->decrement('tokens_balance', $validated['amount']);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $user = User::find($transaction->user_id);
        if ($transaction->type === 'topup') {
            $user->decrement('tokens_balance', $transaction->amount);
        } else {
            $user->increment('tokens_balance', $transaction->amount);
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
