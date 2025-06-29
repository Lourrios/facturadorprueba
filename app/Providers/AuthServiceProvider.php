<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
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

        //agregamos el usuario Super Admin
        // Otorga implícitamente todos los permisos a la función "Superadministrador"       
        Gate::before(function ($user, $ability) {
            return $user->email == 'admin@gmail.com' ?? null;
        });
    }
}
