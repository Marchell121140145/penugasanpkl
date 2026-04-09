<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;

class PelaksanaController extends Controller
{
    /**
     * Tampilkan daftar pelaksana (admin view).
     */
    public function index(Request $request)
    {
        $query = User::where('role_id', 3)
            ->with('divisi')
            ->withCount([
                'assignedTasks',
                'submissions as tugas_selesai_count' => function ($q) {
                    $q->whereIn('status', ['submitted', 'graded']);
                },
                'submissions as tugas_aktif_count' => function ($q) {
                    $q->where('status', 'pending');
                },
            ]);

        // Pembatasan akses bagi pembimbing
        if (auth()->check() && auth()->user()->role_id == 2) {
            $user = auth()->user();
            $query->where(function ($q) use ($user) {
                $q->where('divisi_id', $user->divisi_id)
                  ->orWhere('pembimbing_id', $user->id);
            });
        }

        // Filter: Divisi
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        // Filter: Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortDir = $request->get('sort_dir', 'asc');
        $allowedSorts = ['name', 'email', 'assigned_tasks_count', 'tugas_selesai_count', 'tugas_aktif_count'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'name';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'asc';

        $query->orderBy($sortBy, $sortDir);

        $pelaksanas = $query->paginate(10)->appends($request->query());

        // Stats (untuk admin lihat semua, untuk pembimbing lihat sesuai scope)
        if (auth()->check() && auth()->user()->role_id == 2) {
            $totalPelaksana = User::where('role_id', 3)
                ->where(function ($q) use ($user) {
                    $q->where('divisi_id', $user->divisi_id)
                      ->orWhere('pembimbing_id', $user->id);
                })->count();
        } else {
            $totalPelaksana = User::where('role_id', 3)->count();
        }

        // Divisi list for filter dropdown
        $divisis = Divisi::orderBy('nama')->get();

        return view('monitoring.pelaksana', compact('pelaksanas', 'totalPelaksana', 'divisis'));
    }

    /**
     * Tampilkan detail pelaksana.
     */
    public function show($id)
    {
        $query = User::where('role_id', 3)
            ->with(['divisi', 'pembimbing', 'assignedTasks' => function ($q) {
                $q->orderBy('deadline_date', 'asc');
            }, 'submissions'])
            ->withCount([
                'assignedTasks',
                'submissions as tugas_selesai_count' => function ($q) {
                    $q->whereIn('status', ['submitted', 'graded']);
                },
                'submissions as tugas_aktif_count' => function ($q) {
                    $q->where('status', 'pending');
                },
            ]);

        // Pembatasan akses
        if (auth()->check() && auth()->user()->role_id == 2) {
            $user = auth()->user();
            $query->where(function ($q) use ($user) {
                $q->where('divisi_id', $user->divisi_id)
                  ->orWhere('pembimbing_id', $user->id);
            });
        }

        $pelaksana = $query->findOrFail($id);

        $divisis = Divisi::orderBy('nama')->get();
        // Hanya tampilkan pembimbing, idealnya kita bisa filter per divisi tapi admin bisa bebas assign
        $pembimbings = User::where('role_id', 2)->orderBy('name')->get();

        return view('monitoring.pelaksana-detail', compact('pelaksana', 'divisis', 'pembimbings'));
    }

    /**
     * Update data pelaksana.
     */
    public function update(Request $request, $id)
    {
        $query = User::where('role_id', 3);

        // Pembatasan akses
        if (auth()->check() && auth()->user()->role_id == 2) {
            $user = auth()->user();
            $query->where(function ($q) use ($user) {
                $q->where('divisi_id', $user->divisi_id)
                  ->orWhere('pembimbing_id', $user->id);
            });
        }

        $pelaksana = $query->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'divisi_id' => 'nullable|exists:divisi,id',
            'pembimbing_id' => 'nullable|exists:users,id',
        ]);

        $pelaksana->update([
            'name' => $request->name,
            'email' => $request->email,
            'divisi_id' => $request->divisi_id,
            'pembimbing_id' => $request->pembimbing_id,
        ]);

        return redirect()->route('pelaksana.show', $id)->with('success', 'Data pelaksana berhasil diperbarui.');
    }
}
