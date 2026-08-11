<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    /**
     * Submit a proposal to become a counselor.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $user = Auth::user();

        // Cek jika sudah ada proposal pending
        $existingProposal = Proposal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingProposal) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memiliki pengajuan yang sedang diproses.'
            ], 400);
        }

        // Cek jika user sudah menjadi konselor
        if ($user->role && $user->role->name === 'konselor') {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menjadi konselor.'
            ], 400);
        }

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('proposals', 'public');
        }

        $proposal = Proposal::create([
            'user_id' => $user->id,
            'document' => $documentPath,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan berhasil dikirim. Tim admin kami akan mereview dalam waktu dekat.',
            'data' => $proposal
        ]);
    }

    /**
     * Get user's current proposal status.
     */
    public function myProposal()
    {
        $user = Auth::user();

        $proposal = Proposal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return response()->json([
            'success' => true,
            'data' => $proposal
        ]);
    }
}
