<?php

namespace App\Http\Controllers\Api\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiDocumentationController extends Controller
{
    /**
     * Get API documentation configuration
     * 
     * Mengambil konfigurasi dokumentasi API untuk mengatur tampilan
     * @tags Documentation
     */
    public function getConfig()
    {
        return response()->json([
            'available_endpoints' => [
                'Authentication' => [
                    'POST /api/v1/register' => 'Register user baru',
                    'POST /api/v1/login' => 'Login user',
                    'POST /api/v1/logout' => 'Logout user'
                ],
                'People' => [
                    'GET /api/v1/people' => 'Daftar semua orang',
                    'POST /api/v1/people' => 'Buat orang baru',
                    'GET /api/v1/people/{id}' => 'Detail orang',
                    'PUT /api/v1/people/{id}' => 'Update orang',
                    'DELETE /api/v1/people/{id}' => 'Hapus orang'
                ],
                'Hobbies' => [
                    'GET /api/v1/hobbies' => 'Daftar semua hobby',
                    'POST /api/v1/hobbies' => 'Buat hobby baru',
                    'GET /api/v1/hobbies/{id}' => 'Detail hobby',
                    'PUT /api/v1/hobbies/{id}' => 'Update hobby',
                    'DELETE /api/v1/hobbies/{id}' => 'Hapus hobby'
                ],
                'Phone Numbers' => [
                    'GET /api/v1/phone-number' => 'Daftar semua nomor telepon',
                    'POST /api/v1/phone-number' => 'Buat nomor telepon baru',
                    'GET /api/v1/phone-number/{id}' => 'Detail nomor telepon',
                    'PUT /api/v1/phone-number/{id}' => 'Update nomor telepon',
                    'DELETE /api/v1/phone-number/{id}' => 'Hapus nomor telepon'
                ],
                'Test' => [
                    'GET /api/v1/hello' => 'Test endpoint'
                ]
            ],
            'documentation_url' => '/docs/api',
            'base_url' => config('app.url') . '/api/v1'
        ]);
    }

    /**
     * Get filtered endpoints
     * 
     * Mengambil endpoint berdasarkan filter yang diberikan
     * @tags Documentation
     * @param string category Kategori endpoint (Authentication, People, Hobbies, Phone Numbers, Test)
     */
    public function getFilteredEndpoints(Request $request)
    {
        $category = $request->get('category', 'all');
        
        $allEndpoints = [
            'Authentication' => [
                'POST /api/v1/register' => 'Register user baru',
                'POST /api/v1/login' => 'Login user',
                'POST /api/v1/logout' => 'Logout user'
            ],
            'People' => [
                'GET /api/v1/people' => 'Daftar semua orang',
                'POST /api/v1/people' => 'Buat orang baru',
                'GET /api/v1/people/{id}' => 'Detail orang',
                'PUT /api/v1/people/{id}' => 'Update orang',
                'DELETE /api/v1/people/{id}' => 'Hapus orang'
            ],
            'Hobbies' => [
                'GET /api/v1/hobbies' => 'Daftar semua hobby',
                'POST /api/v1/hobbies' => 'Buat hobby baru',
                'GET /api/v1/hobbies/{id}' => 'Detail hobby',
                'PUT /api/v1/hobbies/{id}' => 'Update hobby',
                'DELETE /api/v1/hobbies/{id}' => 'Hapus hobby'
            ],
            'Phone Numbers' => [
                'GET /api/v1/phone-number' => 'Daftar semua nomor telepon',
                'POST /api/v1/phone-number' => 'Buat nomor telepon baru',
                'GET /api/v1/phone-number/{id}' => 'Detail nomor telepon',
                'PUT /api/v1/phone-number/{id}' => 'Update nomor telepon',
                'DELETE /api/v1/phone-number/{id}' => 'Hapus nomor telepon'
            ],
            'Test' => [
                'GET /api/v1/hello' => 'Test endpoint'
            ]
        ];

        if ($category === 'all') {
            return response()->json($allEndpoints);
        }

        if (isset($allEndpoints[$category])) {
            return response()->json([
                $category => $allEndpoints[$category]
            ]);
        }

        return response()->json(['error' => 'Category not found'], 404);
    }

    /**
     * Save selected endpoints for Scramble documentation
     * 
     * Menyimpan endpoint yang dipilih untuk ditampilkan di /docs/api
     * @tags Documentation
     * @param array selected_endpoints Array endpoint yang dipilih
     */
    public function saveSelection(Request $request)
    {
        $request->validate([
            'selected_endpoints' => 'required|array',
            'selected_endpoints.*' => 'string'
        ]);

        $selectedEndpoints = $request->selected_endpoints;
        
        // Simpan ke file atau database (untuk sementara kita simpan ke file)
        $configPath = storage_path('app/selected_endpoints.json');
        file_put_contents($configPath, json_encode($selectedEndpoints));

        return response()->json([
            'message' => 'Selection saved successfully',
            'selected_count' => count($selectedEndpoints),
            'selected_endpoints' => $selectedEndpoints
        ]);
    }

    /**
     * Get selected endpoints
     * 
     * Mengambil endpoint yang sudah dipilih
     * @tags Documentation
     */
    public function getSelection()
    {
        $configPath = storage_path('app/selected_endpoints.json');
        
        if (file_exists($configPath)) {
            $selectedEndpoints = json_decode(file_get_contents($configPath), true);
        } else {
            $selectedEndpoints = [];
        }

        return response()->json([
            'selected_endpoints' => $selectedEndpoints,
            'count' => count($selectedEndpoints)
        ]);
    }
}
