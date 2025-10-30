<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserRole; // Panggil Enum dari User.php
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        // Gate untuk Admin (Bisa CRUD)
        Gate::define('isAdmin', function (User $user) {
            return $user->role === UserRole::ADMIN;
        });

        // Gate untuk Mahasiswa (Hanya Read)
        Gate::define('isMahasiswa', function (User $user) {
            return $user->role === UserRole::MAHASISWA;
        });
    }
}
