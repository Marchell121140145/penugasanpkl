<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Attendance;
use App\Models\AttendanceAssignee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Filtering & Scoping
        $divisiId = $request->input('divisi_id');
        $selectedMonth = $request->input('month'); // Expecting 'YYYY-MM'
        
        // Finalize Month filter
        $monthFilter = null;
        if ($selectedMonth) {
            try {
                $monthFilter = Carbon::parse($selectedMonth . '-01');
            } catch (\Exception $e) {
                $monthFilter = null;
            }
        }

        // Scope for Supervisor (Pembimbing)
        if ($user->role_id == 2) {
            $divisiId = $user->divisi_id;
        }

        $allDivisi = Divisi::orderBy('nama')->get();
        $selectedDivisi = $divisiId ? Divisi::find($divisiId) : null;

        // 2. Fetch Pelaksana with stats (Relationships filtered by month if selected)
        $pelaksanaQuery = User::with([
            'divisi',
            'submissions' => function($q) use ($monthFilter) {
                if ($monthFilter) {
                    $q->whereHas('task', function($q2) use ($monthFilter) {
                        $q2->whereYear('deadline_date', $monthFilter->year)
                           ->whereMonth('deadline_date', $monthFilter->month);
                    });
                }
            },
            'assignedAttendances' => function($q) use ($monthFilter) {
                if ($monthFilter) {
                    $q->whereHas('attendance', function($q2) use ($monthFilter) {
                        $q2->whereYear('deadline', $monthFilter->year)
                           ->whereMonth('deadline', $monthFilter->month);
                    });
                }
            }
        ])->where('role_id', 3);

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

        return view('admin.report.index', compact('pelaksanas', 'summary', 'allDivisi', 'divisiId', 'selectedDivisi', 'selectedMonth'));
    }

    public function show($id, Request $request)
    {
        $user = Auth::user();
        $pelaksana = User::with('divisi')->where('role_id', 3)->findOrFail($id);

        // Scope check for supervisor
        if ($user->role_id == 2) {
            if ($pelaksana->divisi_id != $user->divisi_id && $pelaksana->pembimbing_id != $user->id) {
                abort(403);
            }
        }

        // Fetch all task submissions with tasks for grade trend
        $submissions = TaskSubmission::with('task')
            ->where('user_id', $id)
            ->whereHas('task')
            ->get()
            ->sortBy('task.deadline_date');

        // Fetch all attendance for attendance trend
        $attendances = AttendanceAssignee::with('attendance')
            ->where('user_id', $id)
            ->whereHas('attendance')
            ->get()
            ->sortBy('attendance.deadline');

        // Prepare chart data: Grade Progression
        $gradeLabels = [];
        $gradeValues = [];
        foreach ($submissions as $sub) {
            if ($sub->nilai !== null) {
                $gradeLabels[] = $sub->task->deadline_date->format('d/m');
                $gradeValues[] = $sub->nilai;
            }
        }

        // Prepare chart data: Attendance Status Distro
        $attStats = [
            'Hadir' => $attendances->where('status', 'Hadir')->count(),
            'Terlambat' => $attendances->where('status', 'Terlambat')->count(),
            'Izin/Sakit' => $attendances->whereIn('status', ['Izin', 'Sakit'])->count(),
            'Alpha' => $attendances->where('status', 'Alpha')->count(),
            'Belum Mengisi' => $attendances->where('status', 'Belum Mengisi')->count(),
        ];

        return view('admin.report.show', compact('pelaksana', 'submissions', 'attendances', 'gradeLabels', 'gradeValues', 'attStats'));
    }

    public function exportCsv(Request $request)
    {
        $user = Auth::user();
        $divisiId = $request->input('divisi_id');
        $selectedMonth = $request->input('month');
        
        $monthFilter = null;
        if ($selectedMonth) {
            try { $monthFilter = Carbon::parse($selectedMonth . '-01'); } catch (\Exception $e) {}
        }

        if ($user->role_id == 2) { $divisiId = $user->divisi_id; }

        $pelaksanaQuery = User::with([
            'divisi',
            'submissions' => function($q) use ($monthFilter) {
                if ($monthFilter) {
                    $q->whereHas('task', function($q2) use ($monthFilter) {
                        $q2->whereYear('deadline_date', $monthFilter->year)
                           ->whereMonth('deadline_date', $monthFilter->month);
                    });
                }
            },
            'assignedAttendances' => function($q) use ($monthFilter) {
                if ($monthFilter) {
                    $q->whereHas('attendance', function($q2) use ($monthFilter) {
                        $q2->whereYear('deadline', $monthFilter->year)
                           ->whereMonth('deadline', $monthFilter->month);
                    });
                }
            }
        ])->where('role_id', 3);

        if ($divisiId) { $pelaksanaQuery->where('divisi_id', $divisiId); }

        $data = $pelaksanaQuery->get();

        $filename = "Laporan_Pelaksana_" . ($selectedMonth ?? 'Semua_Waktu') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama', 'Divisi', 'Avg Nilai', 'Kehadiran (%)', 'Hadir', 'Terlambat', 'Izin/Sakit', 'Alpha', 'Belum Diisi'];

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $student) {
                $graded = $student->submissions->whereNotNull('nilai');
                $avg = $graded->count() > 0 ? round($graded->avg('nilai'), 1) : 0;
                
                $att = $student->assignedAttendances;
                $total = $att->count();
                $present = $att->whereIn('status', ['Hadir', 'Terlambat'])->count();
                $pct = $total > 0 ? round(($present / $total) * 100, 1) : 0;

                fputcsv($file, [
                    $student->name,
                    $student->divisi->nama ?? 'Umum',
                    $avg,
                    $pct,
                    $att->where('status', 'Hadir')->count(),
                    $att->where('status', 'Terlambat')->count(),
                    $att->whereIn('status', ['Izin', 'Sakit'])->count(),
                    $att->where('status', 'Alpha')->count(),
                    $att->where('status', 'Belum Mengisi')->count(),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
