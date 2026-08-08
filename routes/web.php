<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComunityController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MeditationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Konselor\KonselorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verify-code', [VerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

// Rute ini juga untuk user yang sudah login
Route::post('/verify-code', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.verify');

// Rute ini juga untuk user yang sudah login
Route::post('/resend-code', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

// Rute untuk Login dengan Google
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::get('/dev', function () {
    return view('developer');
});
Route::get('/syarat-dan-ketentuan', function () {
    return view('terms-of-service');
});
Route::get('/kebijakan-privasi', function () {
    return view('privacy-policy');
});
Route::get('/kebijakan-pengembalian-dana', function () {
    return view('refund-policy');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('user.dashboard');
    Route::get('/weather', [DashboardController::class, 'getWeather'])->name('weather.get')->middleware('auth');
    Route::get('/blog', [BlogController::class, 'view'])->name('user.blog');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('user.blog.show');
    Route::get('/comunity', [ComunityController::class,'user'])->name('user.comunity');
    Route::post('/comunity', [PostController::class,'store'])->name('user.comunity.store');
    Route::get('/posts/{post}/comments', [PostController::class,'loadComment'])->name('posts.comments');
    Route::post('/replies', [ReplyController::class, 'store'])->name('replies.store');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/post/{post}/like', [PostController::class, 'toggleLike'])->name('post.toggleLike');
    Route::post('/comment/{comment}/like', [PostController::class, 'toggleLike'])->name('comment.like');
    Route::get('/comunity/edit/{id}', [PostController::class,'edit'])->name('user.comunity.edit');
    Route::delete('/comunity/edit/{id}', [PostController::class,'destroy'])->name('user.comunity.destroy');
    
    Route::get('/journal', [JournalController::class,'user'])->name('user.journal');
    Route::post('/journal', [JournalController::class,'store'])->name('user.journal.store');
    Route::get('/journal/{id}', [JournalController::class,'getJournal'])->name('user.journal.get');
    Route::post('/mood', [MoodController::class,'store'])->name('user.mood');
    
    Route::get('/history', [HistoryController::class,'user'])->name('user.history');
    Route::get('/meditation', [MeditationController::class,'user'])->name('user.meditation');
    Route::get('/exercise', [ExerciseController::class,'user'])->name('user.exercise');
    Route::get('/meditation/white-noise', [MeditationController::class,'meditasi'])->name('user.meditation.meditasi');
    Route::get('/chat',[MessagesController::class, 'index'])->name('chat');
    Route::get('/chat/bot',[KonselingController::class, 'user'])->name('chat.bot');
    Route::post('/chat/gemini', [MessagesController::class, 'proxyToGemini'])->name('chat.gemini');
    Route::get('/profile', [DashboardController::class,'index'])->name('user.profile');
    // Route::get('/exercise', [DashboardController::class,'index'])->name('user.exercise');
    Route::get('/setting', [DashboardController::class,'index'])->name('user.setting');
    Route::get('/token', [TransactionController::class, 'showTokenPage'])->name('user.token');
    Route::get('/challenges',function(){
        return view('challenges.user');
    })->name('user.challenges');
    Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::get('/payment/success', [TransactionController::class, 'success'])->name('payment.success');
    Route::get('/payment/pending', [TransactionController::class, 'pending'])->name('payment.pending');
    Route::get('/payment/failed', [TransactionController::class, 'failed'])->name('payment.failed');
    Route::get('/profile', [ProfileController::class,'show'])->name('user.profiles');
    Route::get('/profile/edit/{name}', [ProfileController::class,'edit'])->name('user.profiles.edit');
    Route::patch('/profile/edit', [ProfileController::class,'update'])->name('user.profiles.update');
});
Route::group(['prefix' => 'chat', 'middleware' => 'auth'], function() {
    Route::get('/', [MessagesController::class, 'index'])->name('chat');
    Route::get('{id}', [MessagesController::class, 'show'])->name('chat.show');
    Route::get('users/list', [MessagesController::class, 'getUsers'])->name('chat.users');
    Route::get('messages/{id}', [MessagesController::class, 'getMessages'])->name('chat.messages');
    Route::post('send', [MessagesController::class, 'sendMessage'])->name('chat.send');
    Route::post('mark-read/{id}', [MessagesController::class, 'markAsRead'])->name('chat.markRead');
    Route::get('search-users', [MessagesController::class, 'searchUsers'])->name('chat.search');
});
// // Resource Routes
// Route::resource('users', UserController::class);
// Route::resource('roles', RoleController::class);
// Route::resource('proposals', ProposalController::class);
// Route::resource('sessions', SessionController::class);
// Route::resource('messages', MessageController::class);
// Route::resource('transactions', TransactionController::class);
// Route::resource('posts', PostController::class);
// Route::resource('comments', CommentController::class);
// Route::resource('replies', ReplyController::class);
// Route::resource('likes', LikeController::class);
// Route::resource('moods', MoodController::class);
// Route::resource('journals', JournalController::class);
// Route::resource('audios', AudioController::class);
// Route::resource('challenges', ChallengeController::class);
// Route::resource('circles', CircleController::class);
// Route::resource('exercises', ExerciseController::class);

// // Custom Routes
// Route::post('proposals/{proposal}/approve', [ProposalController::class, 'approve'])->name('proposals.approve');
// Route::post('proposals/{proposal}/reject', [ProposalController::class, 'reject'])->name('proposals.reject');
// Route::post('sessions/{session}/close', [SessionController::class, 'close'])->name('sessions.close');
// Route::post('likes/toggle', [LikeController::class, 'toggleLike'])->name('likes.toggle');
// Route::get('moods/user/{user}', [MoodController::class, 'userMoods'])->name('moods.user');
// Route::get('moods/user/{user}/statistics', [MoodController::class, 'moodStatistics'])->name('moods.statistics');
// Route::get('journals/user/{user}', [JournalController::class, 'userJournals'])->name('journals.user');
// Route::get('audios/category/{category}', [AudioController::class, 'byCategory'])->name('audios.category');
// Route::get('audios/{audio}/play', [AudioController::class, 'play'])->name('audios.play');
// Route::post('challenges/{challenge}/join/{user}', [ChallengeController::class, 'join'])->name('challenges.join');
// Route::post('challenges/{challenge}/complete/{user}', [ChallengeController::class, 'complete'])->name('challenges.complete');
// Route::post('challenges/{challenge}/leave/{user}', [ChallengeController::class, 'leave'])->name('challenges.leave');
// Route::get('challenges/{challenge}/participants', [ChallengeController::class, 'participants'])->name('challenges.participants');
// Route::post('circles/{circle}/add-member', [CircleController::class, 'addMember'])->name('circles.add-member');
// Route::post('circles/{circle}/remove-member/{user}', [CircleController::class, 'removeMember'])->name('circles.remove-member');
// Route::post('circles/{circle}/update-role/{user}', [CircleController::class, 'updateMemberRole'])->name('circles.update-role');
// Route::get('circles/user/{user}', [CircleController::class, 'myCircles'])->name('circles.my-circles');
// Route::post('exercises/{exercise}/start/{user}', [ExerciseController::class, 'startExercise'])->name('exercises.start');
// Route::post('exercises/{exercise}/complete/{user}', [ExerciseController::class, 'completeExercise'])->name('exercises.complete');
// Route::get('exercises/type/{type}', [ExerciseController::class, 'byType'])->name('exercises.by-type');
// Route::get('exercises/user/{user}/progress', [ExerciseController::class, 'userProgress'])->name('exercises.progress');

// // Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,super_admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/users/{user}/suspend', [AdminController::class, 'suspendUser'])->name('users.suspend');
    Route::post('/users/{user}/unsuspend', [AdminController::class, 'unsuspendUser'])->name('users.unsuspend');
    Route::get('/users/{user}/activity', [AdminController::class, 'userActivity'])->name('users.activity');
    
    // Proposal Management
    Route::get('/proposals', [AdminController::class, 'proposals'])->name('proposals');
    Route::get('/proposals/{proposal}/review', [AdminController::class, 'reviewProposal'])->name('proposals.review');
    Route::post('/proposals/{proposal}/approve', [AdminController::class, 'approveProposal'])->name('proposals.approve');
    Route::post('/proposals/{proposal}/reject', [AdminController::class, 'rejectProposal'])->name('proposals.reject');
    
    // Moderation
    Route::get('/moderation/posts', [AdminController::class, 'moderationPosts'])->name('moderation.posts');
    Route::get('/moderation/comments', [AdminController::class, 'moderationComments'])->name('moderation.comments');
    Route::delete('/posts/{post}', [AdminController::class, 'deletePost'])->name('posts.delete');
    Route::delete('/comments/{comment}', [AdminController::class, 'deleteComment'])->name('comments.delete');
    Route::post('/posts/{post}/pin', [AdminController::class, 'pinPost'])->name('posts.pin');
    Route::post('/posts/{post}/unpin', [AdminController::class, 'unpinPost'])->name('posts.unpin');
    
    // Counseling Monitoring
    Route::get('/counseling/stats', [AdminController::class, 'counselingStats'])->name('counseling.stats');
    
    // Transaction Management
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/export', [AdminController::class, 'exportTransactions'])->name('transactions.export');
    
    // Audio Management
    Route::get('/audios', [AdminController::class, 'audios'])->name('audios');
    Route::get('/audios/create', [AdminController::class, 'createAudio'])->name('audios.create');
    Route::post('/audios', [AdminController::class, 'storeAudio'])->name('audios.store');
    Route::get('/audios/{audio}/edit', [AdminController::class, 'editAudio'])->name('audios.edit');
    Route::put('/audios/{audio}', [AdminController::class, 'updateAudio'])->name('audios.update');
    Route::delete('/audios/{audio}', [AdminController::class, 'deleteAudio'])->name('audios.delete');
    
    // Challenge Management
    Route::get('/challenges', [AdminController::class, 'challenges'])->name('challenges');
    Route::get('/challenges/{challenge}/participants', [AdminController::class, 'challengeParticipants'])->name('challenges.participants');
    
    // Circle Management (Super Admin only)
    Route::get('/circles', [AdminController::class, 'circles'])->name('circles');
    Route::delete('/circles/{circle}', [AdminController::class, 'deleteCircle'])->name('circles.delete');

    // Blog Management
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{blog}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});

// // Konselor Routes
Route::prefix('konselor')->name('konselor.')->middleware(['auth', 'role:konselor'])->group(function () {
    Route::get('/dashboard', [KonselorController::class, 'dashboard'])->name('dashboard');

    // Audio Management
    Route::get('/audios', [KonselorController::class, 'audios'])->name('audios');
    Route::get('/audios/create', [KonselorController::class, 'createAudio'])->name('audios.create');
    Route::post('/audios', [KonselorController::class, 'storeAudio'])->name('audios.store');
    Route::get('/audios/{audio}/edit', [KonselorController::class, 'editAudio'])->name('audios.edit');
    Route::put('/audios/{audio}', [KonselorController::class, 'updateAudio'])->name('audios.update');
    Route::delete('/audios/{audio}', [KonselorController::class, 'deleteAudio'])->name('audios.delete');
});

// Rute ini akan menghasilkan error 404
Route::get('/not-found-test', function () {
    abort(404, 'Halaman yang Anda cari tidak ada.');
});

// Rute ini akan menghasilkan error 503 (Service Unavailable)
Route::get('/server-error-test', function () {
    abort(503, 'Layanan sedang tidak tersedia.');
});

// Rute ini xakan menghasilkan error 403 (Forbidden)
Route::get('/forbidden-test', function () {
    abort(403, 'Anda tidak memiliki akses ke halaman ini.');
});
// routes/web.php
Route::get('/test-404', function () {
    abort(404);
});

Route::get('/test-500', function () {
    abort(500);
});
