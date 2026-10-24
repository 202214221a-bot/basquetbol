<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
   {
       // Direcciones de los recursos en español: /equipos/crear y /equipos/1/editar
       Route::resourceVerbs([
           'create' => 'crear',
           'edit'   => 'editar',
       ]);
   }
}
