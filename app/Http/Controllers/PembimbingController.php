<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Task;
use Illuminate\Http\Request;

class PembimbingController extends Controller
{
    /**
     * Tampilkan daftar pembimbing (admin view).
     */
    public function index(Request $request)
    {
        $query = User::where('role_id', 2)
            ->with(['divisi'])
            ->withCount([
                'bimbingan as jumlah_pelaksana',
                'createdTasks as tugas_selesai_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'createdTasks as tugas_aktif_count' => function ($q) {
                    $q->where('status', 'active');
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

        $pembimbings = $query->paginate(10)->appends($request->query());

        // Stats
        $totalPembimbing = User::where('role_id', 2)->count();
        $totalPelaksana = User::where('role_id', 3)->count();
        $totalTugas = Task::count();

        // Divisi list for filter dropdown
        $divisis = Divisi::orderBy('nama')->get();

        return view('monitoring.pembimbing', compact('pembimbings', 'totalPembimbing', 'totalPelaksana', 'totalTugas', 'divisis'));
    }

    /**
     * Tampilkan detail pembimbing.
     */
    public function show($id)
    {
        $pembimbing = User::where('role_id', 2)
            ->with(['divisi', 'bimbingan.divisi', 'createdTasks' => function ($q) {
                $q->orderBy('deadline_date', 'asc');
            }])
            ->withCount([
                'bimbingan as jumlah_pelaksana',
                'createdTasks as tugas_selesai_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'createdTasks as tugas_aktif_count' => function ($q) {
                    $q->where('status', 'active');
                },
            ])
            ->findOrFail($id);

        $divisis = Divisi::orderBy('nama')->get();

        return view('monitoring.pembimbing-detail', compact('pembimbing', 'divisis'));
    }

    /**
     * Update data pembimbing.
     */
    public function update(Request $request, $id)
    {
        $pembimbing = User::where('role_id', 2)->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'divisi_id' => 'nullable|exists:divisi,id',
        ]);

        $pembimbing->update([
            'name' => $request->name,
            'email' => $request->email,
            'divisi_id' => $request->divisi_id,
        ]);

        return redirect()->route('pembimbing.show', $id)->with('success', 'Data pembimbing berhasil diperbarui.');
    }
}
