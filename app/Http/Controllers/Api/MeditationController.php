<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Audio;
use Illuminate\Http\Request;

class MeditationController extends Controller
{
    public function daily()
    {
        $dailySong = Audio::inRandomOrder()->first();

        return response()->json([
            'success' => true,
            'data' => $dailySong,
        ]);
    }

    public function audios()
    {
        $audios = Audio::inRandomOrder()->take(30)->get();

        $categories = Audio::select('category')
            ->distinct()
            ->pluck('category')
            ->toArray();

        array_unshift($categories, "Semua");

        return response()->json([
            'success' => true,
            'categories' => $categories,
            'data' => $audios,
        ]);
    }
}

