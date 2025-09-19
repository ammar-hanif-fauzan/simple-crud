<?php

namespace App\Http\Controllers\Api\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SwaggerDocumentationController extends Controller
{
    /**
     * Get Swagger documentation configuration
     * 
     * Mengambil konfigurasi dokumentasi Swagger untuk mengatur tampilan
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
            'documentation_url' => '/docs',
            'base_url' => config('app.url') . '/api/v1'
        ]);
    }

    /**
     * Get filtered endpoints for Swagger
     * 
     * Mengambil endpoint berdasarkan filter yang diberikan untuk Swagger
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
     * Save selected endpoints for Swagger documentation
     * 
     * Menyimpan endpoint yang dipilih untuk ditampilkan di /docs (Swagger)
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
        
        // Simpan ke file untuk Swagger
        $configPath = storage_path('app/selected_endpoints_swagger.json');
        file_put_contents($configPath, json_encode($selectedEndpoints));

        // Update konfigurasi l5-swagger
        $this->updateSwaggerConfig($selectedEndpoints);

        return response()->json([
            'message' => 'Swagger selection saved successfully',
            'selected_count' => count($selectedEndpoints),
            'selected_endpoints' => $selectedEndpoints
        ]);
    }

    /**
     * Get selected endpoints for Swagger
     * 
     * Mengambil endpoint yang sudah dipilih untuk Swagger
     * @tags Documentation
     */
    public function getSelection()
    {
        $configPath = storage_path('app/selected_endpoints_swagger.json');
        
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

    /**
     * Update Swagger configuration based on selected endpoints
     */
    private function updateSwaggerConfig($selectedEndpoints)
    {
        // Buat file konfigurasi custom untuk Swagger
        $configContent = [
            'selected_endpoints' => $selectedEndpoints,
            'updated_at' => now()->toISOString()
        ];

        $configPath = storage_path('app/swagger_custom_config.json');
        file_put_contents($configPath, json_encode($configContent, JSON_PRETTY_PRINT));

        // Update file api-docs.json dengan endpoint yang dipilih
        $this->updateSwaggerJson($selectedEndpoints);
    }

    /**
     * Update Swagger JSON file with selected endpoints
     */
    private function updateSwaggerJson($selectedEndpoints)
    {
        // Baca file JSON yang sudah ada
        $jsonPath = storage_path('api-docs/api-docs.json');
        $swaggerData = json_decode(file_get_contents($jsonPath), true);

        // Filter paths berdasarkan endpoint yang dipilih
        $filteredPaths = [];
        
        foreach ($selectedEndpoints as $endpoint) {
            // Parse endpoint string (contoh: "GET /api/v1/people")
            $parts = explode(' ', $endpoint);
            if (count($parts) >= 2) {
                $method = strtolower($parts[0]);
                $path = $parts[1];
                
                // Cari path yang sesuai di swaggerData
                if (isset($swaggerData['paths'][$path])) {
                    $filteredPaths[$path] = $swaggerData['paths'][$path];
                }
            }
        }

        // Update paths dengan yang sudah difilter
        $swaggerData['paths'] = $filteredPaths;

        // Simpan file yang sudah diupdate
        file_put_contents($jsonPath, json_encode($swaggerData, JSON_PRETTY_PRINT));
    }

    /**
     * Generate Swagger documentation
     */
    private function generateSwaggerDocs()
    {
        try {
            // Clear cache terlebih dahulu
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            
            // Generate dokumentasi Swagger
            \Artisan::call('l5-swagger:generate');
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to generate Swagger docs: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get Swagger documentation status
     * 
     * Mengambil status dokumentasi Swagger
     * @tags Documentation
     */
    public function getStatus()
    {
        $swaggerJsonPath = storage_path('api-docs/api-docs.json');
        $customConfigPath = storage_path('app/swagger_custom_config.json');
        
        $hasSwaggerDocs = file_exists($swaggerJsonPath);
        $hasCustomConfig = file_exists($customConfigPath);
        
        $swaggerDocsSize = $hasSwaggerDocs ? filesize($swaggerJsonPath) : 0;
        $lastModified = $hasSwaggerDocs ? filemtime($swaggerJsonPath) : null;
        
        return response()->json([
            'has_swagger_docs' => $hasSwaggerDocs,
            'has_custom_config' => $hasCustomConfig,
            'swagger_docs_size' => $swaggerDocsSize,
            'last_modified' => $lastModified ? date('Y-m-d H:i:s', $lastModified) : null,
            'swagger_url' => '/docs',
            'swagger_json_url' => '/docs/api-docs.json'
        ]);
    }
}
