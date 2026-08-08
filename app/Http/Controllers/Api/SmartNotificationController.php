<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FastApiService;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class SmartNotificationController extends Controller
{
    private FastApiService $fastApi;

    public function __construct(FastApiService $fastApi)
    {
        $this->fastApi = $fastApi;
    }

    public function getSmartNotifications(): JsonResponse
    {
        $token = JWTAuth::parseToken()->getToken();
        return $this->fastApi->get('/notifications/smart', [], $token);
    }
}
