<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Tampilkan halaman pengaturan umum.
     */
    public function index()
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Akses terbatas untuk Admin saja.');
        }

        $users = User::with(['role', 'divisi'])->orderBy('role_id')->paginate(20);
        $roles = Role::all();
        
        // Database stats (MySQL specific)
        $tables = DB::select('SHOW TABLE STATUS');
        $dbSize = array_sum(array_column($tables, 'Data_length')) + array_sum(array_column($tables, 'Index_length'));

        return view('settings.index', compact('users', 'roles', 'tables', 'dbSize'));
    }

    /**
     * Hapus user (Admin Only).
     */
    public function destroyUser($id)
    {
        if (auth()->user()->role_id != 1) {
            abort(403);
        }

        $user = User::findOrFail($id);
        
        // Cegah hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return back()->with('success', 'User ' . $user->name . ' berhasil dihapus dari sistem.');
    }
}
