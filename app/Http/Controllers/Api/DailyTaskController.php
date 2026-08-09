<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TaskGeneratorService;
use App\Models\DailyTask;
use App\Models\TaskTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DailyTaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskGeneratorService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * List semua daily tasks user untuk tanggal tertentu
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $date = $request->query('date', Carbon::today()->toDateString());

        $tasks = $this->taskService->getUserTasks($user->id, $date);
        $stats = $this->taskService->getUserStats($user->id);

        return response()->json([
            'status' => 'success',
            'data' => [
                'date' => $date,
                'tasks' => $tasks,
                'stats' => $stats,
            ],
        ]);
    }

    /**
     * Tandai task selesai
     */
    public function complete(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $userTask = $this->taskService->completeTask(
            $user->id,
            $id,
            $request->notes
        );

        if (!$userTask) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Task tidak ditemukan atau sudah diselesaikan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Task berhasil diselesaikan!',
            'data' => [
                'points_earned' => $userTask->points_earned,
                'completed_at' => $userTask->completed_at,
            ],
        ]);
    }

    /**
     * Generate tasks manual (trigger oleh user atau system)
     */
    public function generate(Request $request)
    {
        $user = Auth::user();

        $date = $request->input('date', Carbon::today()->toDateString());
        $generated = $this->taskService->generateForUser($user, $date);

        return response()->json([
            'status' => 'success',
            'message' => "{$generated} tasks berhasil di-generate.",
            'data' => [
                'date' => $date,
                'count' => $generated,
            ],
        ]);
    }

    /**
     * Statistik task user
     */
    public function stats()
    {
        $user = Auth::user();
        $stats = $this->taskService->getUserStats($user->id);

        return response()->json([
            'status' => 'success',
            'data' => $stats,
        ]);
    }

    /**
     * List task templates yang tersedia (untuk reference)
     */
    public function templates()
    {
        $templates = TaskTemplate::active()->get();

        return response()->json([
            'status' => 'success',
            'data' => $templates,
        ]);
    }
}
