<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

    public function boot(): void
    {

        $storagePath = storage_path('app/public');
        $publicPath = public_path('storage');

        // Si no existe la carpeta public/storage, la creamos
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0777, true);
        }
        if (app()->environment('local')) {
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
        }
        // Obtener todos los archivos y carpetas dentro de storage/app/public
        $files = Storage::allFiles('public');
   
        foreach ($files as $file) {
            $destination = $publicPath . '/' . str_replace('public/', '', $file);
            $destinationFolder = dirname($destination);

            // Crear la carpeta si no existe
            if (!file_exists($destinationFolder)) {
                mkdir($destinationFolder, 0777, true);
            }

            // Copiar el archivo si no existe en public/storage
            if (!file_exists($destination)) {
                copy($storagePath . '/' . str_replace('public/', '', $file), $destination);
            }
        }
    }
}
