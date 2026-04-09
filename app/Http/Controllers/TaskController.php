<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskFile;
use App\Models\TaskSubmission;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Tampilkan daftar semua tugas (admin view).
     */
    public function index(Request $request)
    {
        $query = Task::with(['assignees', 'submissions', 'divisi', 'creator']);

        // Filter: Status
        if ($request->filled('status')) {
            if ($request->status === 'late') {
                $query->where('status', 'active')
                      ->where('deadline_date', '<', now()->toDateString());
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter: Prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        // Filter: Divisi
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        // Filter: Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('assignees', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $allowedSorts = ['judul', 'deadline_date', 'prioritas', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'desc';

        $query->orderBy($sortBy, $sortDir);

        $tasks = $query->paginate(10)->appends($request->query());

        // Stats (unfiltered)
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $activeTasks = Task::where('status', 'active')->count();
        $draftTasks = Task::where('status', 'draft')->count();
        $lateTasks = Task::where('status', 'active')
            ->where('deadline_date', '<', now()->toDateString())
            ->count();

        // Divisi list for filter dropdown
        $divisis = Divisi::orderBy('nama')->get();

        return view('monitoring.penugasan', compact(
            'tasks', 'totalTasks', 'completedTasks', 'activeTasks', 'draftTasks', 'lateTasks', 'divisis'
        ));
    }

    /**
     * Tampilkan form buat tugas baru.
     * Kirim data divisi dan mahasiswa (pelaksana) ke view.
     */
    public function create()
    {
        $divisis = Divisi::orderBy('nama')->get();
        $mahasiswas = User::where('role_id', 3)->orderBy('name')->get();

        return view('monitoring.create', compact('divisis', 'mahasiswas'));
    }

    /**
     * Simpan tugas baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'jenis_tugas'   => 'required|in:individu,kelompok,proyek',
            'prioritas'     => 'required|in:rendah,sedang,tinggi',
            'divisi_id'     => 'required|exists:divisi,id',
            'deadline_date' => 'required|date|after_or_equal:today',
            'deadline_time' => 'required',
            'catatan'       => 'nullable|string',
            'assignees'     => 'required|array|min:1',
            'assignees.*'   => 'exists:users,id',
            'files'         => 'nullable|array',
            'files.*'       => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,rar',
            'links'         => 'nullable|array',
            'links.*.judul' => 'nullable|string|max:255',
            'links.*.url'   => 'nullable|url|max:500',
            'status'        => 'nullable|in:draft,active',
        ]);

        DB::beginTransaction();

        try {
            // 1. Buat task
            $task = Task::create([
                'judul'         => $validated['judul'],
                'deskripsi'     => $validated['deskripsi'],
                'jenis_tugas'   => $validated['jenis_tugas'],
                'prioritas'     => $validated['prioritas'],
                'divisi_id'     => $validated['divisi_id'],
                'deadline_date' => $validated['deadline_date'],
                'deadline_time' => $validated['deadline_time'],
                'catatan'       => $validated['catatan'] ?? null,
                'created_by'    => Auth::id(),
                'status'        => $request->input('status', 'active'),
            ]);

            // 2. Upload file pendukung (jika ada)
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('task_files', 'public');

                    TaskFile::create([
                        'task_id'   => $task->id,
                        'jenis'     => 'file',
                        'nama_file' => $file->getClientOriginalName(),
                        'path'      => $path,
                        'ukuran'    => $file->getSize(),
                        'tipe'      => $file->getClientOriginalExtension(),
                    ]);
                }
            }

            // 3. Simpan link pendukung (jika ada)
            if ($request->has('links')) {
                foreach ($request->input('links', []) as $link) {
                    if (!empty($link['url'])) {
                        TaskFile::create([
                            'task_id'   => $task->id,
                            'jenis'     => 'link',
                            'nama_file' => $link['judul'] ?? $link['url'],
                            'path'      => '',
                            'ukuran'    => 0,
                            'tipe'      => 'link',
                            'url'       => $link['url'],
                        ]);
                    }
                }
            }

            // 4. Assign mahasiswa ke task
            $task->assignees()->attach($validated['assignees']);

            // 5. Buat task_submissions untuk setiap assignee (status pending)
            foreach ($validated['assignees'] as $userId) {
                TaskSubmission::create([
                    'task_id' => $task->id,
                    'user_id' => $userId,
                    'status'  => 'pending',
                ]);
            }

            DB::commit();

            return redirect()->route('penugasan')
                ->with('success', 'Tugas "' . $task->judul . '" berhasil dibuat dan ditugaskan ke ' . count($validated['assignees']) . ' mahasiswa.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat tugas: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail tugas beserta progres mahasiswa.
     */
    public function show($id)
    {
        $task = Task::with(['assignees', 'submissions.user', 'files', 'divisi', 'creator'])
            ->findOrFail($id);

        // Calculate progress
        $totalAssignees = $task->assignees->count();
        $submittedCount = $task->submissions->whereIn('status', ['submitted', 'graded'])->count();
        $progress = $totalAssignees > 0 ? round(($submittedCount / $totalAssignees) * 100) : 0;

        return view('monitoring.detail', compact('task', 'totalAssignees', 'submittedCount', 'progress'));
    }

    /**
     * Tampilkan form edit tugas, pre-filled dengan data dari database.
     */
    public function edit($id)
    {
        $task = Task::with(['assignees', 'files', 'divisi'])->findOrFail($id);
        $divisis = Divisi::orderBy('nama')->get();
        $mahasiswas = User::where('role_id', 3)->orderBy('name')->get();

        return view('monitoring.edit', compact('task', 'divisis', 'mahasiswas'));
    }

    /**
     * Update tugas di database.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'jenis_tugas'   => 'required|in:individu,kelompok,proyek',
            'prioritas'     => 'required|in:rendah,sedang,tinggi',
            'divisi_id'     => 'required|exists:divisi,id',
            'deadline_date' => 'required|date',
            'deadline_time' => 'required',
            'catatan'       => 'nullable|string',
            'assignees'     => 'required|array|min:1',
            'assignees.*'   => 'exists:users,id',
            'files'         => 'nullable|array',
            'files.*'       => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,rar',
            'links'         => 'nullable|array',
            'links.*.judul' => 'nullable|string|max:255',
            'links.*.url'   => 'nullable|url|max:500',
            'status'        => 'nullable|in:draft,active,completed',
            'delete_files'  => 'nullable|array',
            'delete_files.*' => 'exists:task_files,id',
        ]);

        DB::beginTransaction();

        try {
            // 1. Update task fields
            $task->update([
                'judul'         => $validated['judul'],
                'deskripsi'     => $validated['deskripsi'],
                'jenis_tugas'   => $validated['jenis_tugas'],
                'prioritas'     => $validated['prioritas'],
                'divisi_id'     => $validated['divisi_id'],
                'deadline_date' => $validated['deadline_date'],
                'deadline_time' => $validated['deadline_time'],
                'catatan'       => $validated['catatan'] ?? null,
                'status'        => $request->input('status', $task->status),
            ]);

            // 2. Delete selected files
            if ($request->has('delete_files')) {
                $filesToDelete = TaskFile::where('task_id', $task->id)
                    ->whereIn('id', $request->delete_files)
                    ->get();
                foreach ($filesToDelete as $file) {
                    if ($file->jenis === 'file' && $file->path) {
                        Storage::disk('public')->delete($file->path);
                    }
                    $file->delete();
                }
            }

            // 3. Upload new files
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('task_files', 'public');

                    TaskFile::create([
                        'task_id'   => $task->id,
                        'jenis'     => 'file',
                        'nama_file' => $file->getClientOriginalName(),
                        'path'      => $path,
                        'ukuran'    => $file->getSize(),
                        'tipe'      => $file->getClientOriginalExtension(),
                    ]);
                }
            }

            // 4. Handle links: delete all existing links, re-add from form
            TaskFile::where('task_id', $task->id)->where('jenis', 'link')->delete();
            if ($request->has('links')) {
                foreach ($request->input('links', []) as $link) {
                    if (!empty($link['url'])) {
                        TaskFile::create([
                            'task_id'   => $task->id,
                            'jenis'     => 'link',
                            'nama_file' => $link['judul'] ?? $link['url'],
                            'path'      => '',
                            'ukuran'    => 0,
                            'tipe'      => 'link',
                            'url'       => $link['url'],
                        ]);
                    }
                }
            }

            // 5. Sync assignees
            $oldAssignees = $task->assignees->pluck('id')->toArray();
            $newAssignees = $validated['assignees'];
            $task->assignees()->sync($newAssignees);

            // Create submissions for newly added assignees
            $addedAssignees = array_diff($newAssignees, $oldAssignees);
            foreach ($addedAssignees as $userId) {
                TaskSubmission::firstOrCreate([
                    'task_id' => $task->id,
                    'user_id' => $userId,
                ], [
                    'status' => 'pending',
                ]);
            }

            // Remove submissions for removed assignees
            $removedAssignees = array_diff($oldAssignees, $newAssignees);
            if (!empty($removedAssignees)) {
                TaskSubmission::where('task_id', $task->id)
                    ->whereIn('user_id', $removedAssignees)
                    ->where('status', 'pending')
                    ->delete();
            }

            DB::commit();

            return redirect()->route('penugasan.show', $task->id)
                ->with('success', 'Tugas "' . $task->judul . '" berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui tugas: ' . $e->getMessage());
        }
    }

    /**
     * Hapus tugas dari database.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        DB::beginTransaction();
        try {
            // Delete associated files from storage
            foreach ($task->files()->where('jenis', 'file')->get() as $file) {
                if ($file->path) {
                    Storage::disk('public')->delete($file->path);
                }
            }

            $taskName = $task->judul;
            $task->delete(); // cascade will handle related records

            DB::commit();

            return redirect()->route('penugasan')
                ->with('success', 'Tugas "' . $taskName . '" berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus tugas: ' . $e->getMessage());
        }
    }
}
