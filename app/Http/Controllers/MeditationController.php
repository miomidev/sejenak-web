<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Exercise;
use Illuminate\Http\Request;

class MeditationController extends Controller
{
    public function user()
    {
        $audios = Audio::orderBy('created_at', 'desc')->get();
        $dailySong = $audios->first();
        $exercises = Exercise::orderBy('created_at', 'desc')->get();

        return view('meditation.user', compact('audios', 'dailySong', 'exercises'));
    }

    public function meditasi()
    {
        $audios = Audio::orderBy('created_at', 'desc')->get();
        $categories = Audio::select('category')->distinct()->pluck('category')->toArray();
        array_unshift($categories, "Semua");

        return view('audios.user', compact('audios', 'categories'));
    }
}
