<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Illuminate\Http\Request;

class MeditationController extends Controller
{
    public function user(){
    $dailySong = Audio::inRandomOrder()->first();
        return view('meditation.user',compact('dailySong'));
    }
public function meditasi()
{
    $audios = Audio::inRandomOrder()->take(30)->get();

    // Ambil kategori unik dari tabel audios
    $categories = Audio::select('category')->distinct()->pluck('category')->toArray();

    // Tambahin kategori "Semua" di awal
    array_unshift($categories, "Semua");

    return view('audios.user', compact('audios', 'categories'));
}

    
}
