<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlumniController;
use App\Http\Controllers\Api\AuthController; // PANGGIL CONTROLLER BARU

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// === RUTE OTENTIKASI BARU (Publik) ===
// Rute ini tidak perlu token
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// === RUTE YANG DILINDUNGI (Perlu Token) ===
Route::middleware('auth:sanctum')->group(function () {

    // Rute untuk mendapatkan data user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // --- Rute CRUD Alumni ---
    
    // 1. READ (Get All & Get Single)
    Route::get('/alumni', [AlumniController::class, 'index'])
         ->middleware('can:canViewAlumni');
         
    Route::get('/alumni/{id}', [AlumniController::class, 'show'])
         ->middleware('can:canViewAlumni');

    // 2. CREATE (Store)
    Route::post('/alumni', [AlumniController::class, 'store'])
         ->middleware('can:isAdmin');

    // 3. UPDATE (Update)
    Route::put('/alumni/{id}', [AlumniController::class, 'update'])
         ->middleware('can:isAdmin');
    Route::patch('/alumni/{id}', [AlumniController::class, 'update'])
         ->middleware('can:isAdmin');

    // 4. DELETE (Destroy)
    Route::delete('/alumni/{id}', [AlumniController::class, 'destroy'])
         ->middleware('can:isAdmin');

});

// BARIS 'require __DIR__.'/auth.php';' SUDAH KITA HAPUS
// KARENA KITA SUDAH MEMBUAT RUTE /login & /register SENDIRI