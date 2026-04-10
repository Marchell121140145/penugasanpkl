<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskFile;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExcelEditorController extends Controller
{
    /**
     * Tampilkan Halaman Web Excel Editor
     */
    public function edit(Request $request)
    {
        $type = $request->query('type');
        $id = $request->query('id');

        if (!$type || !$id) {
            abort(404, 'Parameter tidak valid');
        }

        $filePath = null;
        $fileName = null;
        $task = null;

        // Mendapatkan Path dan Authentikasi Akses
        if ($type === 'task_file') {
            $taskFile = TaskFile::findOrFail($id);
            $task = $taskFile->task;
            $filePath = $taskFile->path;
            $fileName = $taskFile->nama_file;
        } elseif ($type === 'submission') {
            $submission = TaskSubmission::findOrFail($id);
            $task = $submission->task;
            $filePath = $submission->file_path;
            $fileName = $submission->file_nama ?? 'submission.xlsx';
        } else {
            abort(404, 'Tipe file tidak valid');
        }

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'File fisik tidak ditemukan di server.');
        }

        // Cek Hak Akses
        // Admin (Role 1), Pembimbing (Role 2) pembuat tugas, atau Pelaksana penerima tugas.
        $user = Auth::user();
        if ($user->role_id == 2 && $task->created_by != $user->id) {
            abort(403, 'Akses Ditolak: Anda bukan pembuat tugas ini.');
        }
        if ($user->role_id == 3) {
            $isAssigned = $task->assignees()->where('users.id', $user->id)->exists();
            if (!$isAssigned) {
                abort(403, 'Akses Ditolak: Tugas ini tidak ditugaskan kepada Anda.');
            }
        }

        // Generate URL full
        $fileUrl = asset('storage/' . $filePath);

        return view('monitoring.excel-editor', compact('fileUrl', 'fileName', 'task', 'type', 'id'));
    }

    /**
     * Simpan file Excel yang sudah di-edit lalu override file fisiknya
     */
    public function save(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');

        // Pastikan ada file yang diunggah dari client JS
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'Tidak ada file stream yang diterima'], 400);
        }

        $filePath = null;
        $task = null;

        if ($type === 'task_file') {
            $taskFile = TaskFile::findOrFail($id);
            $task = $taskFile->task;
            $filePath = $taskFile->path;
        } elseif ($type === 'submission') {
            $submission = TaskSubmission::findOrFail($id);
            $task = $submission->task;
            $filePath = $submission->file_path;
        } else {
            return response()->json(['success' => false, 'message' => 'Tipe tidak valid'], 400);
        }

        // Cek Akses
        $user = Auth::user();
        if ($user->role_id == 2 && $task->created_by != $user->id) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki hak untuk overwrite'], 403);
        }
        if ($user->role_id == 3) {
            $isAssigned = $task->assignees()->where('users.id', $user->id)->exists();
            if (!$isAssigned) {
                return response()->json(['success' => false, 'message' => 'Anda tidak di-assign ke tugas ini'], 403);
            }
        }

        try {
            $newFile = $request->file('file');
            // Overwrite the existing file
            Storage::disk('public')->put($filePath, file_get_contents($newFile));

            return response()->json([
                'success' => true, 
                'message' => 'File berhasil ditimpa'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }
}
