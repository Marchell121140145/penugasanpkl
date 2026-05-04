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
        if (!in_array(auth()->user()->role_id, [1, 2])) {
            abort(403, 'Akses terbatas untuk Admin dan Pembimbing.');
        }

        $users = collect();
        $roles = collect();
        $divisis = collect();
        $pembimbings = collect();
        $tables = [];
        $dbSize = 0;

        if (auth()->user()->role_id == 1) {
            $users = User::with(['role', 'divisi'])->orderBy('role_id')->paginate(20);
            $roles = Role::all();
            $divisis = \App\Models\Divisi::all();
            $pembimbings = User::where('role_id', 2)->get();
            
            // Database stats (MySQL specific)
            $tables = DB::select('SHOW TABLE STATUS');
            $dbSize = array_sum(array_column($tables, 'Data_length')) + array_sum(array_column($tables, 'Index_length'));
        }

        return view('settings.index', compact('users', 'roles', 'divisis', 'pembimbings', 'tables', 'dbSize'));
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

    /**
     * Update data user (Admin Only).
     */
    public function updateUser(Request $request, $id)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'divisi_id' => 'nullable|exists:divisi,id',
            'pembimbing_id' => 'nullable|exists:users,id',
            'pkl_start' => 'nullable|date',
            'pkl_end' => 'nullable|date|after_or_equal:pkl_start',
            'password' => 'nullable|min:8',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];
        $user->divisi_id = $validated['divisi_id'] ?? null;

        // Jika bukan pelaksana (role != 3), kosongkan field pelaksana
        if ($validated['role_id'] != 3) {
            $user->pembimbing_id = null;
            $user->pkl_start = null;
            $user->pkl_end = null;
        } else {
            $user->pembimbing_id = $validated['pembimbing_id'] ?? null;
            $user->pkl_start = $validated['pkl_start'] ?? null;
            $user->pkl_end = $validated['pkl_end'] ?? null;
        }

        if (!empty($validated['password'])) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Data user ' . $user->name . ' berhasil diperbarui.');
    }

    /**
     * Purge pelaksana yang lewat masa PKL (Admin Only).
     */
    public function purgePelaksana(Request $request)
    {
        if (auth()->user()->role_id != 1) abort(403);

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:soft,hard'
        ]);

        $query = User::where('role_id', 3)
            ->whereBetween('pkl_end', [$validated['start_date'], $validated['end_date']]);
            
        $count = $query->count();
        
        if ($count === 0) {
            return back()->with('error', 'Tidak ada akun pelaksana yang masa PKL-nya berakhir dalam rentang waktu tersebut.');
        }

        if ($validated['type'] === 'hard') {
            // Force delete untuk menghapus secara permanen dari database
            // Akan memicu foreign key cascade delete untuk data terkait
            $query->forceDelete();
            $msg = 'permanen beserta seluruh data terkaitnya (Hard Delete).';
        } else {
            // Soft delete hanya menandai deleted_at
            $query->delete();
            $msg = 'sementara, data history tetap disimpan (Soft Delete).';
        }

        return back()->with('success', "Berhasil menghapus $count akun pelaksana secara $msg");
    }
}
