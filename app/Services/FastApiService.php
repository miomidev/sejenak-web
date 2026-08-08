<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class FastApiService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('FASTAPI_URL', 'http://localhost:8000');
    }

    public function post(string $endpoint, array $data = [], ?string $token = null): JsonResponse
    {
        $headers = ['Content-Type' => 'application/json'];
        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        $response = Http::withHeaders($headers)
            ->timeout(30)
            ->post($this->baseUrl . '/api/v2' . $endpoint, $data);

        return $this->handleResponse($response);
    }

    public function get(string $endpoint, array $queryParams = [], ?string $token = null): JsonResponse
    {
        $headers = ['Content-Type' => 'application/json'];
        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        $response = Http::withHeaders($headers)
            ->timeout(30)
            ->get($this->baseUrl . '/api/v2' . $endpoint, $queryParams);

        return $this->handleResponse($response);
    }

    private function handleResponse($response): JsonResponse
    {
        if ($response->failed()) {
            $errorData = $response->json();
            return response()->json([
                'code' => $response->status(),
                'status' => 'error',
                'message' => $errorData['error'] ?? $errorData['message'] ?? 'FastAPI service error',
            ], $response->status());
        }

        $data = $response->json();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
