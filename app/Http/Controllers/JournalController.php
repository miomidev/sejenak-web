<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index()
    {
        // Hanya menampilkan jurnal milik user yang login
        $journals = Journal::where('user_id', Auth::id())
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        return view('journals.index', compact('journals'));
    }

    public function create()
    {
        // Tidak perlu mengambil semua user, karena user hanya bisa membuat jurnal untuk diri sendiri
        return view('journals.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'id'      => 'nullable|exists:journals,id', // kalau edit, id wajib valid
        'title'   => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    $validated['user_id'] = Auth::id();

    if (!empty($validated['id'])) {
        // UPDATE
        $journal = Journal::where('id', $validated['id'])
            ->where('user_id', Auth::id()) // biar aman, cuma owner bisa edit
            ->firstOrFail();

        $journal->update([
            'title'   => $validated['title'],
            'content' => $validated['content'],
        ]);

        $message = 'Journal updated successfully';
    } else {
        $journal = Journal::create([
            'user_id' => Auth::id(),
            'title'   => $validated['title'],
            'content' => $validated['content'],
        ]);

        $message = 'Journal created successfully';
    }

    return response()->json([
        'success' => true,
        'message' => $message,
        'data'    => $journal
    ], 200);
}
    public function show(Journal $journal)
    {
        // Pastikan user hanya bisa melihat jurnal miliknya
        $this->authorize('view', $journal);
        $journal->load('user');
        return view('journals.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        // Pastikan user hanya bisa mengedit jurnal miliknya
        $this->authorize('update', $journal);
        return view('journals.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        // Pastikan user hanya bisa mengupdate jurnal miliknya
        $this->authorize('update', $journal);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $journal->update($validated);
        return redirect()->route('journals.index')->with('success', 'Journal updated successfully.');
    }

    public function destroy(Journal $journal)
    {
        // Pastikan user hanya bisa menghapus jurnal miliknya
        $this->authorize('delete', $journal);
        $journal->delete();
        return redirect()->route('journals.index')->with('success', 'Journal deleted successfully.');
    }

    public function getJournal($id){
         $journal = Journal::where('id', $id)
        ->where('user_id', Auth::id()) // keamanan
        ->firstOrFail();
       return response()->json([
        'success' => true,
        'data'    => $journal
    ], 200);
    }

    public function user()
    {
        $month = 12; // Desember
    $year = now()->year;

    // Ambil semua jurnal bulan Desember milik user
    $journaledDays = Journal::where('user_id', Auth::id())
        ->whereMonth('updated_at', $month)
        ->whereYear('updated_at', $year)
        ->pluck('updated_at')
        ->map(function ($date) {
            return $date->day;
        })
        ->toArray();
        $user = Auth::user();
        $journals = $user->journals()->orderBy('created_at', 'desc')->paginate(10);
        $lastJournal = $journals->first();
        return view('journals.user', compact('user', 'journals','lastJournal','journaledDays', 'month', 'year'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $journals = Journal::with('user')
            ->where('user_id', Auth::id()) // Hanya mencari di jurnal milik user
            ->where(function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            $lastJournal = $journals->first();

        return view('journals.index', compact('journals', 'search','lastJournal'));
    }
}