<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // 1. Izin untuk Admin (Hanya admin)
        Gate::define('isAdmin', function (User $user) {
            return $user->role == 'admin';
        });

        // 2. Izin untuk Mahasiswa (Hanya mahasiswa)
        Gate::define('isMahasiswa', function (User $user) {
            return $user->role == 'mahasiswa';
        });

        // 3. Izin BARU: Untuk Melihat Data (Admin ATAU Mahasiswa)
        Gate::define('canViewAlumni', function (User $user) {
            return $user->role == 'admin' || $user->role == 'mahasiswa';
        });
    }
}