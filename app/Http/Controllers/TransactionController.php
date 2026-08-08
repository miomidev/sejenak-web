<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Set up Midtrans configuration.
     */
    public function __construct()
    {
        // Set Midtrans configuration
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    /**
     * Show token package selection page.
     */
    public function showTokenPage()
    {
        $packages = [
            ['icon' => 'fas fa-seedling', 'name' => 'Paket Basic', 'tokens' => 50, 'price' => 10000, 'color' => 'primary'],
            ['icon' => 'fas fa-piggy-bank', 'name' => 'Paket Hemat', 'tokens' => 120, 'price' => 20000, 'color' => 'secondary'],
            ['icon' => 'fas fa-gift', 'name' => 'Paket Medium', 'tokens' => 250, 'price' => 40000, 'color' => 'orange'],
            ['icon' => 'fas fa-star', 'name' => 'Paket Mega', 'tokens' => 550, 'price' => 80000, 'color' => 'primary'],
            ['icon' => 'fas fa-fire', 'name' => 'Paket Super', 'tokens' => 1200, 'price' => 150000, 'color' => 'secondary'],
            ['icon' => 'fas fa-rocket', 'name' => 'Paket Ultimate', 'tokens' => 3000, 'price' => 300000, 'color' => 'orange'],
            ['icon' => 'fas fa-heart', 'name' => 'Paket Keluarga', 'tokens' => 5000, 'price' => 450000, 'color' => 'primary'],
            ['icon' => 'fas fa-calendar-alt', 'name' => 'Paket Tahunan', 'tokens' => 10000, 'price' => 600000, 'color' => 'secondary'],
            ['icon' => 'fas fa-infinity', 'name' => 'Paket Sejenak', 'tokens' => 25000, 'price' => 1500000, 'color' => 'orange'],

            // ...tambahkan semua paket lainnya di sini
        ];

        return view('transactions.token', compact('packages'));
    }

    /**
     * Handle user request to checkout a token package.
     */
    public function checkout(Request $request)
    {
        // Validasi request dari frontend
        $request->validate([
            'package_name' => 'required|string',
            'token_amount' => 'required|integer',
            'price' => 'required|integer',
        ]);

        // Buat Order ID yang unik
        $orderId = Str::uuid();

        // Buat transaksi baru di database dengan status pending
        // Pastikan model Transaction Anda memiliki 'order_id', 'package_name', 'token_amount', 'price', 'status' di $fillable
        $transaction = Transaction::create([
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'package_name' => $request->package_name,
            'token_amount' => $request->token_amount,
            'price' => $request->price,
            'status' => 'pending',
        ]);

        // Siapkan parameter untuk Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => $transaction->price,
            ],
            'item_details' => [[
                'id' => $request->token_amount . '_tokens',
                'price' => $transaction->price,
                'quantity' => 1,
                'name' => $transaction->package_name . ' (' . $transaction->token_amount . ' Tokens)',
            ]],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            // Simpan snap_token ke database
            $transaction->snap_token = $snapToken;
            $transaction->save();

            // Kembalikan snapToken ke frontend
            return response()->json(['snapToken' => $snapToken]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle Midtrans payment notification callback.
     */
    public function callback(Request $request)
    {
        // 1. Ambil Server Key dari config
        $serverKey = config('midtrans.server_key');

        // 2. Buat hash signature untuk validasi
        // Formula: sha512(order_id + status_code + gross_amount + server_key)
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // 3. Validasi signature dari Midtrans
        // Ini PENTING untuk keamanan, agar tidak ada notifikasi palsu
        if ($hashed == $request->signature_key) {
            
            // 4. Cari transaksi di database berdasarkan order_id
            $transaction = Transaction::where('order_id', $request->order_id)->first();

            // Jika transaksi ditemukan
            if ($transaction) {
                // 5. Periksa status pembayaran dari Midtrans
                // 'capture' atau 'settlement' berarti pembayaran berhasil
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    
                    // 6. Pastikan kita hanya memproses transaksi yang statusnya masih 'pending'
                    // Ini untuk mencegah penambahan token berulang kali jika Midtrans mengirim notifikasi lebih dari sekali
                    if ($transaction->status == 'pending') {
                        
                        // Update status transaksi di database menjadi 'success'
                        $transaction->update(['status' => 'success']);
                        
                        // Cari user yang memiliki transaksi ini
                        $user = User::find($transaction->user_id);
                        
                        // Tambahkan token ke saldo user
                        // Pastikan nama kolom di tabel 'users' adalah 'tokens_balance'
                        $user->increment('tokens_balance', $transaction->token_amount);
                    }
                } 
                // Jika pembayaran kadaluwarsa
                elseif ($request->transaction_status == 'expire') {
                    $transaction->update(['status' => 'expired']);
                } 
                // Jika pembayaran ditolak atau dibatalkan
                elseif ($request->transaction_status == 'deny' || $request->transaction_status == 'cancel') {
                    $transaction->update(['status' => 'failed']);
                }
            }
        }

        // 7. Beri respons 'OK' ke Midtrans agar mereka tahu notifikasi sudah diterima
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

    public function index()
    {
        // Ganti 'amount' ke 'token_amount' jika Anda sudah mengubah skema DB
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
            'amount' => 'required|integer', // Sebaiknya ganti ini menjadi 'token_amount'
            'type' => 'required|in:topup,usage',
            'description' => 'nullable|string',
        ]);
        
        // Sesuaikan dengan skema database baru
        Transaction::create([
            'user_id' => $validated['user_id'],
            'token_amount' => $validated['amount'],
            'status' => $validated['type'] == 'topup' ? 'manual_topup' : 'manual_usage',
            'description' => $validated['description'],
        ]);

        // Update user's token balance
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
        // Sebaiknya sesuaikan validasi dan logika ini dengan skema database baru Anda
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer',
            'type' => 'required|in:topup,usage',
            'description' => 'nullable|string',
        ]);

        // Revert previous transaction effect
        $oldUser = User::find($transaction->user_id);
        if ($transaction->type === 'topup') {
            $oldUser->decrement('tokens_balance', $transaction->amount);
        } else {
            $oldUser->increment('tokens_balance', $transaction->amount);
        }

        $transaction->update($validated);

        // Apply new transaction effect
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
        // Revert transaction effect before deletion
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