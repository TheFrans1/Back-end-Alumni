<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // Kita butuh ini untuk validasi update

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
   {
        $alumni = Alumni::all();
        return response()->json([
            'status' => true,
            'message' => 'Data alumni berhasil didapatkan',
            'data' => $alumni
        ], 200);
    }
/**
     * CREATE: Menyimpan data alumni baru. (Hanya Admin)
     */
    public function store(Request $request)
    {
        // Validasi data (Skema Baru)
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|unique:alumni',
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string',
            'lulusan' => 'required|numeric|digits:4',
            'jenjang' => 'required|in:D3,S1',
            'status_pekerjaan' => 'required|in:Bekerja,Belum Bekerja,Lanjut Kuliah,Lainnya',
            'bekerja_di' => 'nullable|string',
            'posisi_pekerjaan' => 'nullable|string',
            'lanjut_kuliah_di' => 'nullable|string',
            'nomor_hp' => 'nullable|string',
            'email' => 'nullable|email|unique:alumni',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $alumni = Alumni::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data alumni berhasil ditambahkan',
            'data' => $alumni
        ], 201);
    }

    /**
     * READ ONE: Menampilkan data alumni tunggal.
     */
    public function show(string $id)
    {
        $alumni = Alumni::find($id);

        if (!$alumni) {
            return response()->json(['message' => 'Data alumni tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $alumni
        ], 200);
    }

    /**
     * UPDATE: Memperbarui data alumni. (Hanya Admin)
     */
    public function update(Request $request, string $id)
    {
        $alumni = Alumni::find($id);

        if (!$alumni) {
            return response()->json(['message' => 'Data alumni tidak ditemukan'], 404);
        }
        
        // Validasi data (Skema Baru)
        $validator = Validator::make($request->all(), [
            'nim' => [
                'sometimes', 'required', 'string',
                Rule::unique('alumni')->ignore($alumni->id), // Abaikan ID saat ini
            ],
            'nama' => 'sometimes|required|string|max:255',
            'jurusan' => 'sometimes|required|string',
            'lulusan' => 'sometimes|required|numeric|digits:4',
            'jenjang' => 'sometimes|required|in:D3,S1',
            'status_pekerjaan' => 'sometimes|required|in:Bekerja,Belum Bekerja,Lanjut Kuliah,Lainnya',
            'email' => [
                'sometimes', 'nullable', 'email',
                Rule::unique('alumni')->ignore($alumni->id), // Abaikan ID saat ini
            ],
            'bekerja_di' => 'nullable|string',
            'posisi_pekerjaan' => 'nullable|string',
            'lanjut_kuliah_di' => 'nullable|string',
            'nomor_hp' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $alumni->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data alumni berhasil diperbarui',
            'data' => $alumni
        ], 200);
    }

    /**
     * DELETE: Menghapus data alumni. (Hanya Admin)
     */
    public function destroy(string $id)
    {
        $alumni = Alumni::find($id);

        if (!$alumni) {
            return response()->json(['message' => 'Data alumni tidak ditemukan'], 404);
        }

        $alumni->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data alumni berhasil dihapus'
        ], 200);
    }
}