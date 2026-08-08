<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Proposal;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Session;
use App\Models\Transaction;
use App\Models\Audio;
use App\Models\Challenge;
use App\Models\Circle;
use App\Models\Mood;
use App\Models\Journal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_counselors' => User::whereHas('role', function($q) {
                $q->where('name', 'konselor');
            })->count(),
            'total_sessions' => Session::count(),
            'ongoing_sessions' => Session::where('status', 'ongoing')->count(),
            'total_posts' => Post::count(),
            'total_transactions' => Transaction::sum('price'),
            'pending_proposals' => Proposal::where('status', 'pending')->count(),
            'total_audios' => Audio::count(),
        ];

        // Weekly mood statistics
        $moodStats = Mood::where('created_at', '>=', Carbon::now()->subWeek())
            ->selectRaw('mood, COUNT(*) as count')
            ->groupBy('mood')
            ->get()
            ->pluck('count', 'mood');

        // Recent activities
        $recentUsers = User::with('role')->latest()->take(5)->get();
        $recentProposals = Proposal::with('user')->where('status', 'pending')->latest()->take(5)->get();
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'moodStats', 'recentUsers', 'recentProposals', 'recentTransactions'));
    }

    /**
     * Manajemen User & Role
     */
    public function users(Request $request)
    {
        $query = User::with('role');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->has('role')) {
            $query->whereHas('role', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->paginate(20);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'tokens_balance' => 'required|integer|min:0',
            'is_suspended' => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function suspendUser(User $user)
    {
        $user->update(['is_suspended' => true]);
        return redirect()->back()->with('success', 'User suspended successfully.');
    }

    public function unsuspendUser(User $user)
    {
        $user->update(['is_suspended' => false]);
        return redirect()->back()->with('success', 'User unsuspended successfully.');
    }

    public function userActivity(User $user)
    {
        $user->load(['posts', 'comments', 'replies', 'moods', 'transactions']);
        
        $activities = collect()
            ->merge($user->posts->map(function($post) {
                return [
                    'type' => 'post',
                    'content' => Str::limit($post->content, 100),
                    'created_at' => $post->created_at,
                    'url' => null
                    // 'url' => route('posts.show', $post)
                ];
            }))
            ->merge($user->comments->map(function($comment) {
                return [
                    'type' => 'comment',
                    'content' => Str::limit($comment->content, 100),
                    'created_at' => $comment->created_at,
                    'url' => null
                    // 'url' => route('posts.show', $comment->post) . '#comment-' . $comment->id
                ];
            }))
            ->merge($user->moods->map(function($mood) {
                return [
                    'type' => 'mood',
                    'content' => 'Mood: ' . $mood->mood . ($mood->note ? ' - ' . Str::limit($mood->note, 50) : ''),
                    'created_at' => $mood->created_at,
                    'url' => null
                ];
            }))
            ->sortByDesc('created_at');

        return view('admin.users.activity', compact('user', 'activities'));
    }

    /**
     * Manajemen Proposal Konselor
     */
    public function proposals()
    {
        $proposals = Proposal::with('user')->latest()->paginate(15);
        return view('admin.proposals.index', compact('proposals'));
    }

    public function reviewProposal(Proposal $proposal)
    {
        $proposal->load('user');
        return view('admin.proposals.review', compact('proposal'));
    }

    public function approveProposal(Proposal $proposal)
    {
        $proposal->update(['status' => 'approved']);
        
        // Update user role to counselor
        $proposal->user->update(['role_id' => Role::where('name', 'konselor')->first()->id]);

        // TODO: Send notification to user

        return redirect()->route('admin.proposals')->with('success', 'Proposal approved successfully.');
    }

    public function rejectProposal(Proposal $proposal, Request $request)
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $proposal->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        // TODO: Send notification to user with rejection reason

        return redirect()->route('admin.proposals')->with('success', 'Proposal rejected successfully.');
    }

    /**
     * Moderasi Komunitas
     */
    public function moderationPosts()
    {
        $posts = Post::with(['user', 'comments', 'likes'])
                    ->whereHas('user', function($q) {
                        $q->where('is_suspended', false);
                    })
                    ->latest()
                    ->paginate(20);

        return view('admin.moderation.posts', compact('posts'));
    }

    public function deletePost(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully.');
    }

    public function moderationComments()
    {
        $comments = Comment::with(['user', 'post'])
                        ->whereHas('user', function($q) {
                            $q->where('is_suspended', false);
                        })
                        ->latest()
                        ->paginate(20);

        return view('admin.moderation.comments', compact('comments'));
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    public function pinPost(Post $post)
    {
        // Unpin all other posts first
        Post::where('is_pinned', true)->update(['is_pinned' => false]);
        
        $post->update(['is_pinned' => true]);
        return redirect()->back()->with('success', 'Post pinned successfully.');
    }

    public function unpinPost(Post $post)
    {
        $post->update(['is_pinned' => false]);
        return redirect()->back()->with('success', 'Post unpinned successfully.');
    }

    /**
     * Monitoring Konseling
     */
    public function counselingStats()
    {
        $stats = [
            'total_sessions' => Session::count(),
            'ongoing_sessions' => Session::where('status', 'ongoing')->count(),
            'closed_sessions' => Session::where('status', 'closed')->count(),
            'avg_session_duration' => Session::where('status', 'closed')
                ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, updated_at)) as avg_duration')
                ->first()->avg_duration ?? 0,
        ];

        $counselorPerformance = User::whereHas('role', function($q) {
            $q->where('name', 'konselor');
        })->withCount(['counselorSessions as total_sessions', 
                      'counselorSessions as closed_sessions' => function($q) {
                          $q->where('status', 'closed');
                      }])
        ->get();

        $weeklySessions = Session::where('created_at', '>=', Carbon::now()->subWeek())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.counseling.stats', compact('stats', 'counselorPerformance', 'weeklySessions'));
    }

    /**
     * Manajemen Token & Transaksi
     */
    public function transactions(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->latest()->paginate(20);
        $totalAmount = $query->sum('price');

        return view('admin.transactions.index', compact('transactions', 'totalAmount'));
    }

    public function exportTransactions(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->get();

        // TODO: Implement export to CSV/Excel
        return response()->streamDownload(function() use ($transactions) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'User', 'Type', 'Amount', 'Description']);

            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    $transaction->created_at->format('Y-m-d H:i'),
                    $transaction->user->name,
                    $transaction->type,
                    $transaction->amount,
                    $transaction->description
                ]);
            }

            fclose($handle);
        }, 'transactions-' . date('Y-m-d') . '.csv');
    }

    /**
     * Manajemen Audio
     */
    public function audios()
    {
        $audios = Audio::latest()->paginate(12);
        $categories = Audio::distinct()->pluck('category');
        return view('admin.audios.index', compact('audios', 'categories'));
    }

    public function createAudio()
    {
        $categories = ['rain', 'forest', 'piano', 'ocean', 'white-noise', 'meditation', 'nature', 'ambient'];
        return view('admin.audios.create', compact('categories'));
    }

    public function storeAudio(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:mp3,wav,ogg|max:10240',
            'category' => 'required|string|max:100',
            'is_premium' => 'boolean',
        ]);

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('audios', 'public');
        }

        Audio::create($validated);
        return redirect()->route('admin.audios')->with('success', 'Audio uploaded successfully.');
    }

    public function editAudio(Audio $audio)
    {
        $categories = ['rain', 'forest', 'piano', 'ocean', 'white-noise', 'meditation', 'nature', 'ambient'];
        return view('admin.audios.edit', compact('audio', 'categories'));
    }

    public function updateAudio(Request $request, Audio $audio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'category' => 'required|string|max:100',
            'is_premium' => 'boolean',
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
        return redirect()->route('admin.audios')->with('success', 'Audio updated successfully.');
    }

    public function deleteAudio(Audio $audio)
    {
        if ($audio->file_path) {
            Storage::disk('public')->delete($audio->file_path);
        }
        $audio->delete();
        return redirect()->route('admin.audios')->with('success', 'Audio deleted successfully.');
    }

    /**
     * Manajemen Daily Challenge
     */
    public function challenges()
    {
        $challenges = Challenge::withCount('users')->latest()->paginate(10);
        return view('admin.challenges.index', compact('challenges'));
    }

    public function challengeParticipants(Challenge $challenge)
    {
        $participants = $challenge->users()->withPivot('status')->paginate(15);
        return view('admin.challenges.participants', compact('challenge', 'participants'));
    }

    /**
     * Manajemen Support Circle (Super Admin only)
     */
    public function circles()
    {
        $circles = Circle::with(['owner', 'members'])->withCount('members')->latest()->paginate(10);
        return view('admin.circles.index', compact('circles'));
    }

    public function deleteCircle(Circle $circle)
    {
        $circle->delete();
        return redirect()->back()->with('success', 'Circle deleted successfully.');
    }

    /**
     * Reports and Statistics
     */
    public function reports()
    {
        // User growth statistics
        $userGrowth = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Mood statistics
        $moodStats = Mood::selectRaw('mood, COUNT(*) as count')
            ->groupBy('mood')
            ->get();

        // Session statistics
        $sessionStats = Session::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return view('admin.reports.index', compact('userGrowth', 'moodStats', 'sessionStats'));
    }
}