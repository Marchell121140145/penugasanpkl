<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'name' => ['required', 'string', 'max:60', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'divisi_id' => 'nullable|exists:divisi,id',
        ], [
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'name.max' => 'Nama tidak boleh lebih dari 60 karakter.',
        ]);

        $pembimbing->update([
            'name' => $request->name,
            'email' => $request->email,
            'divisi_id' => $request->divisi_id,
        ]);

        return redirect()->route('pembimbing.show', $id)->with('success', 'Data pembimbing berhasil diperbarui.');
    }

    /**
     * Simpan pembimbing baru (Admin Only).
     */
    public function store(Request $request)
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Hanya Admin yang dapat menambah pembimbing baru.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:60', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'divisi_id' => 'nullable|exists:divisi,id',
        ], [
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'name.max' => 'Nama tidak boleh lebih dari 60 karakter.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'divisi_id' => $request->divisi_id,
        ]);
        $user->role_id = 2;
        $user->save();

        return redirect()->route('pembimbing.list')->with('success', 'Pembimbing baru berhasil ditambahkan.');
    }

    /**
     * Simpan divisi baru (Admin Only).
     */
    public function storeDivisi(Request $request)
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Hanya Admin yang dapat menambah divisi baru.');
        }

        $request->validate([
            'nama' => 'required|string|max:255|unique:divisi,nama',
        ]);

        Divisi::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('pembimbing.list')->with('success', 'Divisi baru "' . $request->nama . '" berhasil ditambahkan.');
    }
}
