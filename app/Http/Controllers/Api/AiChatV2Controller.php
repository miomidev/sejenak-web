<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FastApiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AiChatV2Controller extends Controller
{
    private FastApiService $fastApi;

    public function __construct(FastApiService $fastApi)
    {
        $this->fastApi = $fastApi;
    }

    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $token = JWTAuth::parseToken()->getToken();

        return $this->fastApi->post('/ai-chat', [
            'message' => $request->message,
        ], $token);
    }
}
