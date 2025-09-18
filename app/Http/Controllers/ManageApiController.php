<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ManageApiController extends Controller
{
    public function index()
    {
        $apiRoutes = collect(Route::getRoutes())
            ->filter(function ($route) {
                return str_starts_with($route->uri(), 'api/') && in_array('GET', $route->methods());
            })
            ->map(function ($route) {
                return [
                    'uri' => $route->uri(),
                    'methods' => $route->methods(),
                    'name' => $route->getName(),
                ];
            })->values();

        return view('manage.api', [
            'apiRoutes' => $apiRoutes,
        ]);
    }

    public function test(Request $request)
    {
        $endpoint = $request->input('endpoint');
        $method = strtoupper($request->input('method', 'GET'));
        $headers = [];
        $body = [];
        $result = null;

        // Ambil daftar API routes
        $apiRoutes = collect(Route::getRoutes())
            ->filter(function ($route) {
                return str_starts_with($route->uri(), 'api/') && in_array('GET', $route->methods());
            })
            ->map(function ($route) {
                return [
                    'uri' => $route->uri(),
                    'methods' => $route->methods(),
                    'name' => $route->getName(),
                ];
            })->values();

        // Parse headers JSON
        if ($request->filled('headers')) {
            try {
                $headers = json_decode($request->input('headers'), true) ?: [];
            } catch (\Exception $e) {
                $result = 'Invalid headers JSON: ' . $e->getMessage();
            }
        }

        // Parse body JSON
        if ($request->filled('body')) {
            try {
                $body = json_decode($request->input('body'), true) ?: [];
            } catch (\Exception $e) {
                $result = 'Invalid body JSON: ' . $e->getMessage();
            }
        }

        if (!$result) {
            try {
                $http = Http::withHeaders($headers);
                $response = match ($method) {
                    'GET' => $http->get($endpoint, $body),
                    'POST' => $http->post($endpoint, $body),
                    'PUT' => $http->put($endpoint, $body),
                    'PATCH' => $http->patch($endpoint, $body),
                    'DELETE' => $http->delete($endpoint, $body),
                    default => $http->send($method, $endpoint, ['json' => $body]),
                };
                $result = "Status: {$response->status()}\n";
                $result .= "Headers: " . json_encode($response->headers(), JSON_PRETTY_PRINT) . "\n\n";
                $result .= $response->body();
            } catch (\Exception $e) {
                $result = 'Request error: ' . $e->getMessage();
            }
        }

        return view('manage.api', [
            'result' => $result,
            'input' => $request->all(),
            'apiRoutes' => $apiRoutes,
        ]);
    }
}
