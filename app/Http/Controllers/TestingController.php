<?php
namespace App\Http\Controllers;

use App\Models\User; // Pastikan Model di-import di atas

class TestingController extends Controller
{
    public function index()
    {
        // 1. Ambil data dari database menggunakan Eloquent ORM
        // Ini akan mengambil SEMUA baris di tabel users
        $dataDariDatabase = User::all(); 

        // [Alternatif]: Jika ingin difilter, misalnya cuma ambil 5 data terbaru:
        // $dataDariDatabase = User::orderBy('created_at', 'desc')->take(5)->get();

        // 2. Kirim datanya ke View
        return view('testing', [
            'users' => $dataDariDatabase
        ]);
    }
}
