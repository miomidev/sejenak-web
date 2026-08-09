<?php

namespace App\Http\Controllers;

use App\Services\TaskGeneratorService;
use App\Models\DailyTask;
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
     * Halaman daily tasks user
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $date = $request->query('date', Carbon::today()->toDateString());

        $tasks = $this->taskService->getUserTasks($user->id, $date);
        $stats = $this->taskService->getUserStats($user->id);

        return view('tasks.user', compact('tasks', 'stats', 'date'));
    }

    /**
     * Tandai task selesai via web
     */
    public function complete(Request $request, $id)
    {
        $user = Auth::user();

        $userTask = $this->taskService->completeTask(
            $user->id,
            $id,
            $request->input('notes')
        );

        if (!$userTask) {
            return redirect()->back()->with('error', 'Task tidak ditemukan atau sudah diselesaikan.');
        }

        return redirect()->back()->with('success', "Task berhasil diselesaikan! +{$userTask->points_earned} poin");
    }

    /**
     * Generate tasks manual via web
     */
    public function generate(Request $request)
    {
        $user = Auth::user();
        $date = $request->input('date', Carbon::today()->toDateString());

        $generated = $this->taskService->generateForUser($user, $date);

        return redirect()->back()->with('success', "{$generated} tasks baru berhasil di-generate!");
    }
}
