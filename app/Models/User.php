<?php

namespace App\Models;

// Enum Role yang kita buat sebelumnya
enum UserRole: string
{
    case ADMIN = 'admin';
    case MAHASISWA = 'mahasiswa';
}

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;  // <-- 1. PASTIKAN BARIS INI ADA

class User extends Authenticatable
{
    // 2. PASTIKAN 'HasApiTokens' ADA DI DALAM 'use' INI
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // role yang sudah kita tambahkan
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class, // cast untuk role
    ];
}