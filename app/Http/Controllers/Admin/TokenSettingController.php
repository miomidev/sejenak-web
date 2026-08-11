<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\TokenPackage;
use Illuminate\Http\Request;

class TokenSettingController extends Controller
{
    public function index()
    {
        $sessionPrice = Setting::where('key', 'session_price')->first()->value ?? 500;
        $packages = TokenPackage::orderBy('token_amount', 'asc')->get();

        return view('admin.token-settings', compact('sessionPrice', 'packages'));
    }

    public function updateSessionPrice(Request $request)
    {
        $request->validate([
            'session_price' => 'required|integer|min:1',
        ]);

        Setting::updateOrCreate(
            ['key' => 'session_price'],
            ['value' => $request->session_price]
        );

        return redirect()->route('admin.token.settings')->with('success', 'Harga sesi berhasil diperbarui!');
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'token_amount' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'icon' => 'nullable|string',
        ]);

        TokenPackage::create([
            'name' => $request->name,
            'token_amount' => $request->token_amount,
            'price' => $request->price,
            'icon' => $request->icon ?? 'spa_rounded',
        ]);

        return redirect()->route('admin.token.settings')->with('success', 'Paket Token berhasil ditambahkan!');
    }

    public function updatePackage(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'token_amount' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'icon' => 'nullable|string',
        ]);

        $package = TokenPackage::findOrFail($id);
        $package->update([
            'name' => $request->name,
            'token_amount' => $request->token_amount,
            'price' => $request->price,
            'icon' => $request->icon ?? 'spa_rounded',
        ]);

        return redirect()->route('admin.token.settings')->with('success', 'Paket Token berhasil diperbarui!');
    }

    public function destroyPackage($id)
    {
        $package = TokenPackage::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.token.settings')->with('success', 'Paket Token berhasil dihapus!');
    }
}
