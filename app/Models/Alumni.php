<?php

// app/Models/Alumni.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Definisikan Enum
enum Jenjang: string
{
    case D3 = 'D3';
    case S1 = 'S1';
}

enum StatusPekerjaan: string
{
    case BEKERJA = 'Bekerja';
    case BELUM_BEKERJA = 'Belum Bekerja';
    case LANJUT_KULIAH = 'Lanjut Kuliah';
    case LAINNYA = 'Lainnya';
}

class Alumni extends Model
{
    use HasFactory;
    protected $table = 'alumni';
    // Kolom yang boleh diisi melalui API (Mass Assignment)
    protected $fillable = [
        'nim',
        'nama',
        'jurusan',
        'lulusan',
        'jenjang',
        'status_pekerjaan',
        'bekerja_di',
        'posisi_pekerjaan',
        'lanjut_kuliah_di',
        'nomor_hp',
        'email',
    ];

    // Casting untuk Enum
    protected $casts = [
        'jenjang' => Jenjang::class,
        'status_pekerjaan' => StatusPekerjaan::class,
    ];
}
