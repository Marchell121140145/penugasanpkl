<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceAssignee;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Redirect pelaksana ke dashboard mereka sendiri
        if ($user->role_id == 3) {
            return redirect()->route('pelaksana.dashboard');
        }

        // ============================
        // 0. FILTERING LOGIC
        // ============================
        $divisiId = $request->input('divisi_id');
        
        // Scoping for Supervisor (Pembimbing)
        if ($user->role_id == 2) {
            $divisiId = $user->divisi_id;
        }

        $allDivisi = Divisi::all();
        $selectedDivisi = $divisiId ? Divisi::find($divisiId) : null;

        // ============================
        // 1. STATISTIK PENUGASAN
        // ============================
        $taskQuery = Task::query();
        if ($divisiId) {
            $taskQuery->where('divisi_id', $divisiId);
        }
        
        $totalTasks = (clone $taskQuery)->count();
        $completedTasks = (clone $taskQuery)->where('status', 'completed')->count();
        $pendingTasks = (clone $taskQuery)->whereIn('status', ['active', 'draft'])->count();
        $newTasksThisWeek = (clone $taskQuery)->where('created_at', '>=', now()->startOfWeek())->count();

        // Completion rate
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // ============================
        // 2. STATISTIK ABSENSI HARI INI
        // ============================
        // Filter attendance by those assigned to users in the selected division
        $todayAttendances = Attendance::whereDate('deadline', today())->pluck('id');
        $todayAssigneesQuery = AttendanceAssignee::whereIn('attendance_id', $todayAttendances);
        
        if ($divisiId) {
            $todayAssigneesQuery->whereHas('user', function($q) use ($divisiId) {
                $q->where('divisi_id', $divisiId);
            });
        }

        $studentQuery = User::where('role_id', 3);
        if ($divisiId) {
            $studentQuery->where('divisi_id', $divisiId);
        }
        $totalStudents = $studentQuery->count();
        
        $totalTodayAssigned = (clone $todayAssigneesQuery)->count();
        $hadirCount = (clone $todayAssigneesQuery)->whereIn('status', ['Hadir', 'Terlambat'])->count();
        $hadirTepatWaktu = (clone $todayAssigneesQuery)->where('status', 'Hadir')->count();
        $terlambatCount = (clone $todayAssigneesQuery)->where('status', 'Terlambat')->count();
        $alphaCount = (clone $todayAssigneesQuery)->where('status', 'Alpha')->count();
        $izinCount = (clone $todayAssigneesQuery)->whereIn('status', ['Izin', 'Sakit'])->count();
        $belumMengisi = (clone $todayAssigneesQuery)->where('status', 'Belum Mengisi')->count();
        $tidakHadir = $alphaCount + $izinCount + $belumMengisi;

        $attendanceRate = $totalTodayAssigned > 0 ? round(($hadirCount / $totalTodayAssigned) * 100) : 0;
        $onTimeRate = $hadirCount > 0 ? round(($hadirTepatWaktu / $hadirCount) * 100) : 0;

        // ============================
        // 3. CHART: Statistik Penyelesaian Tugas per Hari (7 hari terakhir)
        // ============================
        $taskChartLabels = [];
        $taskChartSubmitted = [];
        $taskChartCreated = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayName = $date->translatedFormat('D d/m');
            $taskChartLabels[] = $dayName;

            // Tugas yang di-submit pada hari ini
            $submittedQuery = TaskSubmission::whereIn('status', ['submitted', 'graded'])
                ->whereDate('submitted_at', $date->toDateString());
            
            if ($divisiId) {
                $submittedQuery->whereHas('user', function($q) use ($divisiId) {
                    $q->where('divisi_id', $divisiId);
                });
            }
            $taskChartSubmitted[] = $submittedQuery->count();

            // Tugas baru dibuat pada hari ini
            $createdQuery = Task::whereDate('created_at', $date->toDateString());
            if ($divisiId) {
                $createdQuery->where('divisi_id', $divisiId);
            }
            $taskChartCreated[] = $createdQuery->count();
        }

        // ============================
        // 4. CHART: Trend Kehadiran 4 Minggu Terakhir
        // ============================
        $attendanceChartLabels = [];
        $attendanceChartData = [];

        for ($i = 3; $i >= 0; $i--) {
            $weekStart = now()->subWeeks($i)->startOfWeek();
            $weekEnd = now()->subWeeks($i)->endOfWeek();
            $weekLabel = 'Minggu ' . (4 - $i);
            $attendanceChartLabels[] = $weekLabel;

            $weekAttendanceIds = Attendance::whereBetween('deadline', [$weekStart, $weekEnd])->pluck('id');
            $weekAssigneesQuery = AttendanceAssignee::whereIn('attendance_id', $weekAttendanceIds);
            
            if ($divisiId) {
                $weekAssigneesQuery->whereHas('user', function($q) use ($divisiId) {
                    $q->where('divisi_id', $divisiId);
                });
            }
            
            $weekTotal = (clone $weekAssigneesQuery)->count();
            $weekHadir = (clone $weekAssigneesQuery)->whereIn('status', ['Hadir', 'Terlambat'])->count();

            $attendanceChartData[] = $weekTotal > 0 ? round(($weekHadir / $weekTotal) * 100) : 0;
        }

        // Rata-rata kehadiran bulan ini
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();
        $monthAttendanceIds = Attendance::whereBetween('deadline', [$monthStart, $monthEnd])->pluck('id');
        $monthAssigneesQuery = AttendanceAssignee::whereIn('attendance_id', $monthAttendanceIds);
        
        if ($divisiId) {
            $monthAssigneesQuery->whereHas('user', function($q) use ($divisiId) {
                $q->where('divisi_id', $divisiId);
            });
        }
        
        $monthTotal = (clone $monthAssigneesQuery)->count();
        $monthHadir = (clone $monthAssigneesQuery)->whereIn('status', ['Hadir', 'Terlambat'])->count();
        $avgAttendanceMonth = $monthTotal > 0 ? round(($monthHadir / $monthTotal) * 100) : 0;

        // ============================
        // 5. AKTIVITAS TERKINI
        // ============================
        $submissionQuery = TaskSubmission::with(['user', 'task'])
            ->whereIn('status', ['submitted', 'graded'])
            ->whereNotNull('submitted_at');
        
        if ($divisiId) {
            $submissionQuery->whereHas('user', function($q) use ($divisiId) {
                $q->where('divisi_id', $divisiId);
            });
        }
        
        $recentSubmissions = $submissionQuery->latest('submitted_at')
            ->take(5)
            ->get()
            ->map(function ($sub) {
                $nilaiText = $sub->nilai ? ' - Nilai: ' . $sub->nilai : '';
                return [
                    'icon' => '📝',
                    'title' => ($sub->user->name ?? 'Unknown') . ' mengumpulkan tugas',
                    'description' => ($sub->task->judul ?? '') . $nilaiText,
                    'time' => $sub->submitted_at,
                    'time_human' => $sub->submitted_at->diffForHumans(),
                ];
            });

        $attendanceActQuery = AttendanceAssignee::with(['user', 'attendance'])
            ->whereIn('status', ['Hadir', 'Terlambat'])
            ->whereNotNull('check_in_time');
            
        if ($divisiId) {
            $attendanceActQuery->whereHas('user', function($q) use ($divisiId) {
                $q->where('divisi_id', $divisiId);
            });
        }

        $recentAttendanceActivity = $attendanceActQuery->latest('check_in_time')
            ->take(5)
            ->get()
            ->map(function ($att) {
                $statusText = $att->status === 'Hadir' ? 'hadir tepat waktu' : 'hadir terlambat';
                return [
                    'icon' => '✅',
                    'title' => ($att->user->name ?? 'Unknown') . ' ' . $statusText,
                    'description' => ($att->attendance->title ?? 'Absensi') . ' - ' . $att->check_in_time->format('H:i'),
                    'time' => $att->check_in_time,
                    'time_human' => $att->check_in_time->diffForHumans(),
                ];
            });

        $recentActivities = $recentSubmissions->concat($recentAttendanceActivity)
            ->sortByDesc('time')
            ->take(5)
            ->values();

        // ============================
        // 6. PENUGASAN TERBARU
        // ============================
        $recentTaskQuery = Task::withCount([
            'submissions',
            'submissions as graded_count' => function ($q) {
                $q->where('status', 'graded');
            },
            'assignees',
        ]);
        
        if ($divisiId) {
            $recentTaskQuery->where('divisi_id', $divisiId);
        }
        
        $recentTasks = $recentTaskQuery->latest()
            ->take(5)
            ->get()
            ->map(function ($task) {
                // Determine status display
                if ($task->status === 'completed') {
                    $statusLabel = 'Selesai';
                    $statusClass = 'bg-emerald-100 text-emerald-600';
                } elseif ($task->deadline_date && $task->deadline_date->isPast()) {
                    $statusLabel = 'Overdue';
                    $statusClass = 'bg-red-100 text-red-600';
                } elseif ($task->status === 'draft') {
                    $statusLabel = 'Draft';
                    $statusClass = 'bg-slate-100 text-slate-600';
                } else {
                    $statusLabel = 'Aktif';
                    $statusClass = 'bg-blue-100 text-blue-600';
                }

                return [
                    'id' => $task->id,
                    'judul' => $task->judul,
                    'deadline' => $task->deadline_date ? $task->deadline_date->translatedFormat('d M Y') : '-',
                    'submissions_count' => $task->submissions_count,
                    'assignees_count' => $task->assignees_count,
                    'status_label' => $statusLabel,
                    'status_class' => $statusClass,
                ];
            });

        // ============================
        // 7. ABSENSI HARI INI (Detail per mahasiswa)
        // ============================
        $todayAttendanceDetailQuery = AttendanceAssignee::with(['user', 'attendance'])
            ->whereIn('attendance_id', $todayAttendances);
            
        if ($divisiId) {
            $todayAttendanceDetailQuery->whereHas('user', function($q) use ($divisiId) {
                $q->where('divisi_id', $divisiId);
            });
        }
            
        $todayAttendanceDetail = $todayAttendanceDetailQuery->latest('updated_at')
            ->take(10)
            ->get()
            ->map(function ($assignee) {
                if ($assignee->status === 'Hadir') {
                    $statusLabel = 'Hadir';
                    $statusClass = 'bg-emerald-100 text-emerald-600';
                } elseif ($assignee->status === 'Terlambat') {
                    $statusLabel = 'Terlambat';
                    $statusClass = 'bg-amber-100 text-amber-600';
                } elseif ($assignee->status === 'Alpha') {
                    $statusLabel = 'Alpha';
                    $statusClass = 'bg-red-100 text-red-600';
                } elseif (in_array($assignee->status, ['Izin', 'Sakit'])) {
                    $statusLabel = $assignee->status;
                    $statusClass = 'bg-violet-100 text-violet-600';
                } else {
                    $statusLabel = 'Belum Mengisi';
                    $statusClass = 'bg-slate-100 text-slate-600';
                }

                $checkInTime = $assignee->check_in_time ? $assignee->check_in_time->format('H:i') : '-';

                return [
                    'name' => $assignee->user->name ?? 'Unknown',
                    'check_in' => $checkInTime,
                    'status_label' => $statusLabel,
                    'status_class' => $statusClass,
                ];
            });

        // ============================
        // 8. RATA-RATA PENYELESAIAN TUGAS
        // ============================
        $avgCompletionDays = 0;
        $gradedSubmissionsQuery = TaskSubmission::whereNotNull('submitted_at')
            ->whereIn('status', ['submitted', 'graded'])
            ->with('task');
            
        if ($divisiId) {
            $gradedSubmissionsQuery->whereHas('user', function($q) use ($divisiId) {
                $q->where('divisi_id', $divisiId);
            });
        }
            
        $gradedSubmissions = $gradedSubmissionsQuery->get();
        
        if ($gradedSubmissions->count() > 0) {
            $totalDays = 0;
            $validCount = 0;
            foreach ($gradedSubmissions as $sub) {
                if ($sub->task && $sub->task->created_at && $sub->submitted_at) {
                    $totalDays += $sub->task->created_at->diffInDays($sub->submitted_at);
                    $validCount++;
                }
            }
            $avgCompletionDays = $validCount > 0 ? round($totalDays / $validCount, 1) : 0;
        }

        return view('dashboard.dashboard', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'newTasksThisWeek',
            'completionRate',
            'attendanceRate',
            'totalTodayAssigned',
            'hadirCount',
            'hadirTepatWaktu',
            'terlambatCount',
            'alphaCount',
            'izinCount',
            'tidakHadir',
            'onTimeRate',
            'taskChartLabels',
            'taskChartSubmitted',
            'taskChartCreated',
            'attendanceChartLabels',
            'attendanceChartData',
            'avgAttendanceMonth',
            'recentActivities',
            'recentTasks',
            'todayAttendanceDetail',
            'avgCompletionDays',
            'totalStudents',
            'allDivisi',
            'divisiId',
            'selectedDivisi'
        ));
    }
}
