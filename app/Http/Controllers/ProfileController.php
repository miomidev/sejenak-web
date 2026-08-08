<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(){
          $user = Auth::user()->loadCount(['transactions', 'posts', 'journals']);

        return view('profile.show', compact('user'));
    }
    public function edit()
    {
        $user = Auth::user();
        
        return view('profile.edit', ['user' => $user]);
    }
    public function update(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB
        ]);

        $user = Auth::user();

        // Memperbarui data pengguna
        $user->name = $request->name;
        $user->bio = $request->bio;

        // Mengunggah dan menyimpan avatar baru jika ada
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Simpan gambar baru ke folder 'public/avatars'
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('user.profiles')->with('success', 'Profil berhasil diperbarui!');
    }
}
