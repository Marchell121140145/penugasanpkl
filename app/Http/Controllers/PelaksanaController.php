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

        // Stats
        $totalPelaksana = User::where('role_id', 3)->count();

        // Divisi list for filter dropdown
        $divisis = Divisi::orderBy('nama')->get();

        return view('monitoring.pelaksana', compact('pelaksanas', 'totalPelaksana', 'divisis'));
    }
}
