<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function index()
    {
        $audios = Audio::orderBy('created_at', 'desc')->paginate(12);
        $categories = Audio::distinct()->pluck('category');

        return response()->json([
            'status' => 'success',
            'audios' => $audios,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:mp3,wav,ogg|max:10240',
            'category' => 'required|string|max:100',
        ]);

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('audios', 'public');
        }

        $audio = Audio::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Audio uploaded successfully.',
            'data' => $audio
        ], 201);
    }

    public function show(Audio $audio)
    {
        return response()->json([
            'status' => 'success',
            'data' => $audio,
        ]);
    }

    public function update(Request $request, Audio $audio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'category' => 'required|string|max:100',
        ]);

        if ($request->hasFile('file_path')) {
            if ($audio->file_path) {
                Storage::disk('public')->delete($audio->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('audios', 'public');
        } else {
            unset($validated['file_path']);
        }

        $audio->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Audio updated successfully.',
            'data' => $audio
        ]);
    }

    public function destroy(Audio $audio)
    {
        if ($audio->file_path) {
            Storage::disk('public')->delete($audio->file_path);
        }
        $audio->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Audio deleted successfully.',
        ]);
    }

    public function byCategory($category)
    {
        $audios = Audio::where('category', $category)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Audio::distinct()->pluck('category');

        return response()->json([
            'status' => 'success',
            'category' => $category,
            'audios' => $audios,
            'categories' => $categories,
        ]);
    }

    public function play(Audio $audio)
    {
        if (!Storage::disk('public')->exists($audio->file_path)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found'
            ], 404);
        }

        // Kirim URL publik (lebih praktis untuk API)
        $url = Storage::disk('public')->url($audio->file_path);

        return response()->json([
            'status' => 'success',
            'url' => $url,
        ]);
    }
}
