<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\MoodController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\Api\AudioController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\ChatBotController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\JournalController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Api\ComunityController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\MeditationController;
use App\Http\Controllers\Api\HumanCapacityController;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\SmartNotificationController;
use App\Http\Controllers\Api\AiChatV2Controller;
use App\Http\Controllers\Api\UserDailyChallengeController;
use App\Http\Controllers\Api\CounselorController;
use App\Http\Controllers\Api\ProposalController as ApiProposalController;
use App\Http\Controllers\Api\TransactionController as ApiTransactionController;
use App\Http\Controllers\Api\DailyTaskController;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);
Route::post('/refresh',[AuthController::class,'refresh']);
Route::post('/logout',[AuthController::class,'logout']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/googleAuth',[GoogleAuthController::class,'login']);

Route::post('/verify-code', [AuthController::class, 'verify']);
Route::post('/resend-verification', [AuthController::class, 'resendVerification']);

Route::post('/miomipay/webhook', [TransactionController::class, 'miomipayWebhook']);
Route::middleware('auth:api')->group(function () {
    Route::get('profile', [ProfileController::class, 'show']);
    Route::get('me', [AuthController::class, 'profile']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::prefix('audios')->group(function () {
        Route::get('/', [AudioController::class, 'index']);
        Route::post('/', [AudioController::class, 'store']);
        Route::get('/category/{category}', [AudioController::class, 'byCategory']);
        Route::get('/{audio}', [AudioController::class, 'show']);
        Route::put('/{audio}', [AudioController::class, 'update']);
        Route::delete('/{audio}', [AudioController::class, 'destroy']);
        Route::get('/{audio}/play', [AudioController::class, 'play']);
    });
    Route::prefix('journal')->group(function () {
        Route::get('/', [JournalController::class, 'index']);
        Route::post('/', [JournalController::class, 'store']);
        Route::put('/{id}', [JournalController::class, 'update']); // PUT method
        Route::patch('/{id}', [JournalController::class, 'update']);
        Route::get('/search', [JournalController::class, 'search']);
        Route::get('/stats', [JournalController::class, 'stats']);
        Route::get('/{id}', [JournalController::class, 'show']);
        Route::delete('/{id}', [JournalController::class, 'destroy']);
    });
    Route::prefix('moods')->group(function () {
        Route::get('/', [MoodController::class, 'index']);
        Route::post('/', [MoodController::class, 'store']);
        Route::get('/statistics', [MoodController::class, 'statistics']);
        Route::get('/{id}', [MoodController::class, 'show']);
        Route::delete('/{id}', [MoodController::class, 'destroy']);
    });
    Route::prefix('comunity')->group(function () {
        Route::get('/', [ComunityController::class, 'index']);
        Route::get('/getPost', [PostController::class, 'index']);
        Route::prefix('likes')->group(function () {
            Route::get('/', [LikeController::class, 'index']);
            Route::post('/', [LikeController::class, 'store']);
            Route::delete('/{id}', [LikeController::class, 'destroy']);
            Route::post('/toggle', [LikeController::class, 'toggleLike']);
        });
        
        Route::prefix('posts')->group(function () {
            Route::get('/my-posts', [PostController::class, 'getAllMyPost']);
            Route::get('/', [PostController::class, 'index']);
            Route::post('/', [PostController::class, 'store']);
            Route::get('/{id}', [PostController::class, 'show']);
            Route::put('/{id}', [PostController::class, 'update']);
            Route::delete('/{id}', [PostController::class, 'destroy']);
        });
        Route::prefix('comments')->group(function () {
            Route::get('/', [CommentController::class, 'index']);
            Route::post('/', [CommentController::class, 'store']);
            Route::get('/post/{postId}', [CommentController::class, 'getByPost']);
            Route::get('/{comment}', [CommentController::class, 'show']);
            Route::put('/{comment}', [CommentController::class, 'update']);
            Route::delete('/{comment}', [CommentController::class, 'destroy']);
        });
        Route::prefix('replies')->group(function () {
            Route::get('/', [ReplyController::class, 'index']);
            Route::post('/', [ReplyController::class, 'store']);
            Route::get('/{reply}', [ReplyController::class, 'show']);
            Route::put('/{reply}', [ReplyController::class, 'update']);
            Route::delete('/{reply}', [ReplyController::class, 'destroy']);
        });
    });
    Route::prefix('proposals')->group(function () {
        Route::post('/', [ApiProposalController::class, 'submit']);
        Route::get('/my', [ApiProposalController::class, 'myProposal']);
    });

    Route::prefix('counselors')->group(function () {
        Route::get('/', [CounselorController::class, 'index']);
    });

    Route::prefix('sessions')->group(function () {
        Route::get('/price', [CounselorController::class, 'getSessionPrice']);
        Route::post('/request', [CounselorController::class, 'requestSession']);
        Route::get('/', [CounselorController::class, 'mySessions']);
    });

    Route::prefix('transactions')->group(function () {
        Route::get('/token-packages', [ApiTransactionController::class, 'getPackages']);
        Route::post('/checkout', [ApiTransactionController::class, 'checkout']);
        Route::get('/', [ApiTransactionController::class, 'history']);
    });
    Route::prefix('daily-challenges')->group(function () {
        Route::get('/', [UserDailyChallengeController::class, 'listChallenges']);
        Route::post('/choose', [UserDailyChallengeController::class, 'chooseChallenge']);
        Route::put('/{id}/complete', [UserDailyChallengeController::class, 'completeChallenge']);
        Route::get('/my', [UserDailyChallengeController::class, 'myChallenges']);
    });

    Route::prefix('daily-tasks')->group(function () {
        Route::get('/', [DailyTaskController::class, 'index']);
        Route::post('/generate', [DailyTaskController::class, 'generate']);
        Route::get('/stats', [DailyTaskController::class, 'stats']);
        Route::get('/templates', [DailyTaskController::class, 'templates']);
        Route::put('/{id}/complete', [DailyTaskController::class, 'complete']);
    });
    Route::post('/chat-bot', [ChatBotController::class, 'chat']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/meditation/daily', [MeditationController::class, 'daily']);
    Route::get('/meditation/audios', [MeditationController::class, 'audios']);

    // ============================================
    // V2 Routes - Human Capacity AI Engine (FastAPI)
    // ============================================
    Route::prefix('v2/human-capacity')->group(function () {
        Route::post('/sync-sensors', [HumanCapacityController::class, 'syncSensors']);
        Route::get('/index', [HumanCapacityController::class, 'getCapacityIndex']);
        Route::get('/explain', [HumanCapacityController::class, 'explain']);
        Route::get('/forecast', [HumanCapacityController::class, 'forecast']);
    });

    Route::prefix('v2/recommendations')->group(function () {
        Route::get('/adaptive', [RecommendationController::class, 'getAdaptive']);
    });

    Route::prefix('v2/notifications')->group(function () {
        Route::get('/smart', [SmartNotificationController::class, 'getSmartNotifications']);
    });

    Route::post('/v2/ai-chat', [AiChatV2Controller::class, 'chat']);
});
