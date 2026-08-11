<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TokenPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Get list of active token packages
     */
    public function getPackages()
    {
        $packages = TokenPackage::orderBy('token_amount', 'asc')->get();
        return response()->json([
            'success' => true,
            'message' => 'Token packages retrieved successfully',
            'data' => $packages
        ]);
    }
    /**
     * Handle mobile user request to checkout a token package via MiomiPay.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string',
            'token_amount' => 'required|integer',
            'price' => 'required|integer',
        ]);

        $orderId = 'SEJENAK-' . strtoupper(Str::random(10)) . '-' . time();

        $transaction = Transaction::create([
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'package_name' => $request->package_name,
            'token_amount' => $request->token_amount,
            'price' => $request->price,
            'status' => 'pending',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('miomipay.api_key'),
                'Content-Type' => 'application/json',
            ])->post(config('miomipay.base_url') . '/trx', [
                'order_id' => $orderId,
                'amount' => (int) $request->price,
                'link_name' => $request->package_name . ' - ' . $request->token_amount . ' Token',
                'webhook_url' => 'https://sejenak.miomidev.com/api/miomipay/webhook', // Tetap menggunakan webhook url global
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $paymentUrl = $data['paylink'] ?? $data['payment_url'] ?? $data['url'] ?? null;
                $rawQris    = $data['raw_qris'] ?? null;
                $expiredAt  = $data['expired_at'] ?? $data['expiry_time'] ?? null;

                $qrisImageUrl = null;
                if ($rawQris) {
                    $qrisImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($rawQris);
                    $transaction->update(['snap_token' => $rawQris]); // Save raw qris
                } elseif ($paymentUrl) {
                    $transaction->update(['snap_token' => $paymentUrl]); // Save pay link if no raw qris
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
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat transaksi MiomiPay: ' . $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get transaction history for mobile app
     */
    public function history()
    {
        $userId = Auth::id();

        // Lazy Expiration: Update transaksi pending yang sudah lebih dari 60 menit menjadi expired
        Transaction::where('user_id', $userId)
            ->where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(60))
            ->update(['status' => 'expired']);

        $transactions = Transaction::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }
}
