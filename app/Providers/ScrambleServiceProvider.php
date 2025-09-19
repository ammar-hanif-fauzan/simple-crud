<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;

class ScrambleServiceProvider extends ServiceProvider
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
        // Konfigurasi custom untuk Scramble
        Scramble::routes(function (Route $route) {
            // Hanya tampilkan route yang dimulai dengan /api/v1
            if ($route->uri() === null || !str_starts_with($route->uri(), 'api/v1')) {
                return false;
            }

            // Cek apakah endpoint dipilih untuk ditampilkan
            $configPath = storage_path('app/selected_endpoints.json');
            if (file_exists($configPath)) {
                $selectedEndpoints = json_decode(file_get_contents($configPath), true);
                if (empty($selectedEndpoints)) {
                    return true; // Jika tidak ada pilihan, tampilkan semua
                }

                // Buat endpoint string dari route
                $method = $route->methods()[0] ?? 'GET';
                $uri = $route->uri();
                $endpointString = $method . ' /' . $uri;

                // Cek apakah endpoint ini dipilih
                return in_array($endpointString, $selectedEndpoints);
            }

            return true; // Default tampilkan semua jika tidak ada konfigurasi
        });

        // Scramble akan otomatis menggunakan tag dari @tags annotation di controller
    }
}
