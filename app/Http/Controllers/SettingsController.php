<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Tampilkan halaman pengaturan umum.
     */
    public function index()
    {
        return view('settings.index');
    }
}
