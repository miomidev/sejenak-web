<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FastApiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class HumanCapacityController extends Controller
{
    private FastApiService $fastApi;

    public function __construct(FastApiService $fastApi)
    {
        $this->fastApi = $fastApi;
    }

    public function syncSensors(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'sleep_hours' => 'required|numeric|min:0',
            'deep_sleep_hours' => 'nullable|numeric|min:0',
            'screen_on_hours' => 'required|numeric|min:0',
            'late_night_screen_minutes' => 'nullable|integer|min:0',
            'step_count' => 'required|integer|min:0',
            'active_minutes' => 'nullable|integer|min:0',
            'calendar_events_count' => 'nullable|integer|min:0',
        ]);

        $token = JWTAuth::parseToken()->getToken();
        $user = JWTAuth::parseToken()->authenticate();

        $payload = [
            'date' => $request->date,
            'sleep_hours' => (float) $request->sleep_hours,
            'deep_sleep_hours' => (float) ($request->deep_sleep_hours ?? 0),
            'screen_on_hours' => (float) $request->screen_on_hours,
            'late_night_screen_minutes' => (int) ($request->late_night_screen_minutes ?? 0),
            'step_count' => (int) $request->step_count,
            'active_minutes' => (int) ($request->active_minutes ?? 0),
            'calendar_events_count' => (int) ($request->calendar_events_count ?? 0),
        ];

        return $this->fastApi->post('/human-capacity/sync-sensors', $payload, $token);
    }

    public function getCapacityIndex(Request $request): JsonResponse
    {
        $token = JWTAuth::parseToken()->getToken();
        $queryParams = [];
        if ($request->has('date')) {
            $queryParams['date'] = $request->date;
        }

        return $this->fastApi->get('/human-capacity/index', $queryParams, $token);
    }

    public function explain(Request $request): JsonResponse
    {
        $token = JWTAuth::parseToken()->getToken();
        $queryParams = [];
        if ($request->has('date')) {
            $queryParams['target_date'] = $request->date;
        }

        return $this->fastApi->get('/human-capacity/explain', $queryParams, $token);
    }

    public function forecast(): JsonResponse
    {
        $token = JWTAuth::parseToken()->getToken();
        return $this->fastApi->get('/human-capacity/forecast', [], $token);
    }
}
