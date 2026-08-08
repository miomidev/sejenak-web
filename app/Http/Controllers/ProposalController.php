<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::with('user')->paginate(10);
        return view('proposals.index', compact('proposals'));
    }

    public function create()
    {
        $users = User::where('role_id', 2)->get(); // Only counselors can submit proposals
        return view('proposals.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'document' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('document')) {
            $validated['document'] = $request->file('document')->store('proposals', 'public');
        }

        $validated['status'] = 'pending';
        Proposal::create($validated);

        return redirect()->route('proposals.index')->with('success', 'Proposal submitted successfully.');
    }

    public function show(Proposal $proposal)
    {
        $proposal->load('user');
        return view('proposals.show', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        $users = User::where('role_id', 2)->get();
        return view('proposals.edit', compact('proposal', 'users'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,approved,rejected',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('document')) {
            if ($proposal->document) {
                Storage::disk('public')->delete($proposal->document);
            }
            $validated['document'] = $request->file('document')->store('proposals', 'public');
        }

        $proposal->update($validated);
        return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully.');
    }

    public function destroy(Proposal $proposal)
    {
        if ($proposal->document) {
            Storage::disk('public')->delete($proposal->document);
        }
        $proposal->delete();
        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully.');
    }

    public function approve(Proposal $proposal)
    {
        $proposal->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Proposal approved successfully.');
    }

    public function reject(Proposal $proposal)
    {
        $proposal->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Proposal rejected successfully.');
    }
}