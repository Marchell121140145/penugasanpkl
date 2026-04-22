<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use App\Models\TaskSubmission;
use App\Models\AttendanceAssignee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Filtering & Scoping
        $divisiId = $request->input('divisi_id');
        
        // Scope for Supervisor (Pembimbing)
        if ($user->role_id == 2) {
            $divisiId = $user->divisi_id;
        }

        $allDivisi = Divisi::orderBy('nama')->get();
        $selectedDivisi = $divisiId ? Divisi::find($divisiId) : null;

        // 2. Fetch Pelaksana with stats
        $pelaksanaQuery = User::with(['divisi', 'submissions', 'assignedAttendances'])
            ->where('role_id', 3); // Role 3 is pelaksana

        if ($divisiId) {
            $pelaksanaQuery->where('divisi_id', $divisiId);
        }

        $pelaksanas = $pelaksanaQuery->get()->map(function($student) {
            // Task Stats
            $gradedSubmissions = $student->submissions->whereNotNull('nilai');
            $avgGrade = $gradedSubmissions->count() > 0 ? round($gradedSubmissions->avg('nilai'), 1) : 0;

            // Attendance Stats
            $attendances = $student->assignedAttendances;
            $totalSessions = $attendances->count();
            $hadirCount = $attendances->where('status', 'Hadir')->count();
            $terlambatCount = $attendances->where('status', 'Terlambat')->count();
            $izinCount = $attendances->where('status', 'Izin')->count();
            $sakitCount = $attendances->where('status', 'Sakit')->count();
            $alphaCount = $attendances->where('status', 'Alpha')->count();
            $belumMengisiCount = $attendances->where('status', 'Belum Mengisi')->count();

            $presentCount = $hadirCount + $terlambatCount;
            $attendancePercentage = $totalSessions > 0 ? round(($presentCount / $totalSessions) * 100, 1) : 0;

            return [
                'id' => $student->id,
                'name' => $student->name,
                'avatar' => $student->avatar,
                'divisi' => $student->divisi->nama ?? 'Umum',
                'avg_grade' => $avgGrade,
                'attendance_percentage' => $attendancePercentage,
                'attendance_details' => [
                    'hadir' => $hadirCount,
                    'terlambat' => $terlambatCount,
                    'izin' => $izinCount,
                    'sakit' => $sakitCount,
                    'alpha' => $alphaCount,
                    'belum_mengisi' => $belumMengisiCount,
                ],
                'total_tasks' => $student->submissions->count(),
            ];
        });

        // 3. Global Stats
        $summary = [
            'total_students' => $pelaksanas->count(),
            'avg_grade' => $pelaksanas->count() > 0 ? round($pelaksanas->avg('avg_grade'), 1) : 0,
            'avg_attendance' => $pelaksanas->count() > 0 ? round($pelaksanas->avg('attendance_percentage'), 1) : 0,
        ];

        return view('admin.report.index', compact('pelaksanas', 'summary', 'allDivisi', 'divisiId', 'selectedDivisi'));
    }
}
