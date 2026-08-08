<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function index()
    {
        $audios = Audio::orderBy('created_at', 'desc')->paginate(12);
        $categories = Audio::distinct()->pluck('category');
        return view('audios.index', compact('audios', 'categories'));
    }

    public function create()
    {
        $categories = ['rain', 'forest', 'piano', 'ocean', 'white-noise', 'meditation', 'nature', 'ambient'];
        return view('audios.create', compact('categories'));
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

        Audio::create($validated);
        return redirect()->route('audios.index')->with('success', 'Audio uploaded successfully.');
    }

    public function show(Audio $audio)
    {
        return view('audios.show', compact('audio'));
    }

    public function edit(Audio $audio)
    {
        $categories = ['rain', 'forest', 'piano', 'ocean', 'white-noise', 'meditation', 'nature', 'ambient'];
        return view('audios.edit', compact('audio', 'categories'));
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
        return redirect()->route('audios.index')->with('success', 'Audio updated successfully.');
    }

    public function destroy(Audio $audio)
    {
        if ($audio->file_path) {
            Storage::disk('public')->delete($audio->file_path);
        }
        $audio->delete();
        return redirect()->route('audios.index')->with('success', 'Audio deleted successfully.');
    }

    public function byCategory($category)
    {
        $audios = Audio::where('category', $category)->orderBy('created_at', 'desc')->paginate(12);
        $categories = Audio::distinct()->pluck('category');
        return view('audios.index', compact('audios', 'categories', 'category'));
    }

    public function play(Audio $audio)
    {
        return response()->file(storage_path('app/public/' . $audio->file_path));
    }
}