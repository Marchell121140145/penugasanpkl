<?php

namespace App\Http\Controllers;

use App\Models\TaskFile;
use App\Models\TaskSubmission;
use App\Models\AttendanceAssignee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileServeController extends Controller
{
    /**
     * Serve file pendukung tugas (task_files) secara private.
     * Akses: Admin, Pembimbing (pembuat tugas / divisi sama), Pelaksana (assignee).
     */
    public function serveTaskFile($id)
    {
        $taskFile = TaskFile::with('task')->findOrFail($id);
        $task = $taskFile->task;
        $user = Auth::user();

        // Cek akses berdasarkan role
        if ($user->role_id == 2) {
            // Pembimbing: harus pembuat tugas atau divisi sama
            if ($task->created_by != $user->id && $task->divisi_id != $user->divisi_id) {
                abort(403, 'Akses ditolak.');
            }
        } elseif ($user->role_id == 3) {
            // Pelaksana: harus di-assign ke tugas ini
            $isAssigned = $task->assignees()->where('users.id', $user->id)->exists();
            if (!$isAssigned) {
                abort(403, 'Akses ditolak.');
            }
        }
        // Admin (role_id == 1) selalu bisa akses

        if (!$taskFile->path || !Storage::disk('local')->exists($taskFile->path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('local')->response($taskFile->path, $taskFile->nama_file);
    }

    /**
     * Serve file submission mahasiswa secara private.
     * Akses: Admin, Pembimbing (pembuat tugas / divisi sama), Pelaksana (pemilik submission).
     */
    public function serveSubmissionFile($id)
    {
        $submission = TaskSubmission::with('task')->findOrFail($id);
        $task = $submission->task;
        $user = Auth::user();

        // Cek akses berdasarkan role
        if ($user->role_id == 2) {
            if ($task->created_by != $user->id && $task->divisi_id != $user->divisi_id) {
                abort(403, 'Akses ditolak.');
            }
        } elseif ($user->role_id == 3) {
            // Pelaksana hanya bisa akses submission miliknya sendiri
            if ($submission->user_id != $user->id) {
                abort(403, 'Akses ditolak.');
            }
        }

        if (!$submission->file_path || !Storage::disk('local')->exists($submission->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('local')->response($submission->file_path, $submission->file_nama ?? 'submission');
    }

    /**
     * Serve foto absensi (check-in / check-out) secara private.
     * Akses: Admin, Pembimbing (divisi/pembimbing sama), Pelaksana (pemilik absensi).
     * 
     * @param int $id AttendanceAssignee ID
     * @param string $type 'checkin' atau 'checkout'
     */
    public function serveAttendancePhoto($id, $type = 'checkin')
    {
        $assignee = AttendanceAssignee::with('user')->findOrFail($id);
        $user = Auth::user();

        // Cek akses berdasarkan role
        if ($user->role_id == 2) {
            $student = $assignee->user;
            if ($student && $student->pembimbing_id != $user->id && $student->divisi_id != $user->divisi_id) {
                abort(403, 'Akses ditolak.');
            }
        } elseif ($user->role_id == 3) {
            if ($assignee->user_id != $user->id) {
                abort(403, 'Akses ditolak.');
            }
        }

        // Tentukan path berdasarkan type
        $filePath = $type === 'checkout' ? $assignee->checkout_photo_path : $assignee->photo_path;

        if (!$filePath || !Storage::disk('local')->exists($filePath)) {
            abort(404, 'Foto tidak ditemukan.');
        }

        return Storage::disk('local')->response($filePath);
    }

    /**
     * Serve avatar user secara private.
     * Akses: Semua user yang terautentikasi (avatar ditampilkan di banyak halaman).
     * Mendukung backward compatibility: cek di local disk dulu, lalu public disk.
     *
     * @param int $id User ID
     */
    public function serveAvatar($id)
    {
        $targetUser = User::findOrFail($id);

        if (!$targetUser->avatar) {
            abort(404, 'Avatar tidak ditemukan.');
        }

        // Cek di local disk terlebih dahulu (avatar baru)
        if (Storage::disk('local')->exists($targetUser->avatar)) {
            return Storage::disk('local')->response($targetUser->avatar);
        }

        // Backward compatibility: cek di public disk (avatar lama)
        if (Storage::disk('public')->exists($targetUser->avatar)) {
            return Storage::disk('public')->response($targetUser->avatar);
        }

        abort(404, 'File avatar tidak ditemukan.');
    }
}

