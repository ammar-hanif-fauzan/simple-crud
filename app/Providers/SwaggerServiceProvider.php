<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Route;

class SwaggerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Konfigurasi custom untuk Swagger berdasarkan pilihan user
        $this->configureSwaggerRoutes();
    }

    /**
     * Configure Swagger routes based on user selection
     */
    private function configureSwaggerRoutes()
    {
        // Cek apakah ada konfigurasi custom untuk Swagger
        $configPath = storage_path('app/selected_endpoints_swagger.json');
        
        if (file_exists($configPath)) {
            $selectedEndpoints = json_decode(file_get_contents($configPath), true);
            
            if (!empty($selectedEndpoints)) {
                // Update konfigurasi l5-swagger untuk hanya memproses endpoint yang dipilih
                config([
                    'l5-swagger.defaults.scanOptions.exclude' => $this->getExcludedPaths($selectedEndpoints)
                ]);
            }
        }
    }

    /**
     * Get excluded paths based on selected endpoints
     */
    private function getExcludedPaths($selectedEndpoints)
    {
        $excludedPaths = [];
        
        // Dapatkan semua controller yang ada
        $controllerPaths = [
            base_path('app/Http/Controllers/Api/Controller'),
            base_path('app/Http/Controllers')
        ];
        
        foreach ($controllerPaths as $controllerPath) {
            if (is_dir($controllerPath)) {
                $files = glob($controllerPath . '/*.php');
                
                foreach ($files as $file) {
                    $fileName = basename($file);
                    $className = str_replace('.php', '', $fileName);
                    
                    // Cek apakah controller ini memiliki endpoint yang dipilih
                    if (!$this->hasSelectedEndpoints($className, $selectedEndpoints)) {
                        $excludedPaths[] = $file;
                    }
                }
            }
        }
        
        return $excludedPaths;
    }

    /**
     * Check if controller has selected endpoints
     */
    private function hasSelectedEndpoints($className, $selectedEndpoints)
    {
        // Mapping class name ke endpoint patterns
        $classEndpointMap = [
            'PeopleApiController' => ['/api/v1/people'],
            'HobbyApiController' => ['/api/v1/hobbies'],
            'PhoneNumberApiController' => ['/api/v1/phone-number'],
            'AuthController' => ['/api/v1/register', '/api/v1/login', '/api/v1/logout'],
        ];
        
        if (!isset($classEndpointMap[$className])) {
            return true; // Include by default if not in map
        }
        
        $controllerEndpoints = $classEndpointMap[$className];
        
        foreach ($selectedEndpoints as $selectedEndpoint) {
            foreach ($controllerEndpoints as $controllerEndpoint) {
                if (strpos($selectedEndpoint, $controllerEndpoint) !== false) {
                    return true;
                }
            }
        }
        
        return false;
    }
}
