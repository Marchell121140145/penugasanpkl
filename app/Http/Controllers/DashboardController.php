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

        $timeRange = $request->input('time_range', '7_days');
        
        $startDate = match ($timeRange) {
            'today' => now()->startOfDay(),
            'this_month' => now()->startOfMonth(),
            'this_year' => now()->startOfYear(),
            default => now()->subDays(6)->startOfDay(),
        };
        $endDate = now()->endOfDay();

        $allDivisi = Divisi::all();
        $selectedDivisi = $divisiId ? Divisi::find($divisiId) : null;

        // ============================
        // 1. STATISTIK PENUGASAN
        // ============================
        $taskQuery = Task::whereBetween('created_at', [$startDate, $endDate]);
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
        // 2. STATISTIK ABSENSI
        // ============================
        $attendancePanelTitle = match ($timeRange) {
            'today' => 'Absensi Hari Ini',
            'this_month' => 'Absensi Bulan Ini',
            'this_year' => 'Absensi Tahun Ini',
            default => 'Absensi 7 Hari Terakhir',
        };

        // Filter attendance by those assigned to users in the selected division and within time range
        $attendances = Attendance::whereBetween('deadline', [$startDate, $endDate])->pluck('id');
        $assigneesQuery = AttendanceAssignee::whereIn('attendance_id', $attendances);
        
        if ($divisiId) {
            $assigneesQuery->whereHas('user', function($q) use ($divisiId) {
                $q->where('divisi_id', $divisiId);
            });
        }

        $studentQuery = User::where('role_id', 3);
        if ($divisiId) {
            $studentQuery->where('divisi_id', $divisiId);
        }
        $totalStudents = $studentQuery->count();
        
        $totalTodayAssigned = (clone $assigneesQuery)->count();
        $hadirCount = (clone $assigneesQuery)->whereIn('status', ['Hadir', 'Terlambat', 'Hadir - Selesai', 'Terlambat - Selesai'])->count();
        $hadirTepatWaktu = (clone $assigneesQuery)->whereIn('status', ['Hadir', 'Hadir - Selesai'])->count();
        $terlambatCount = (clone $assigneesQuery)->whereIn('status', ['Terlambat', 'Terlambat - Selesai'])->count();
        $alphaCount = (clone $assigneesQuery)->where('status', 'Alpha')->count();
        $izinCount = (clone $assigneesQuery)->whereIn('status', ['Izin', 'Sakit'])->count();
        $belumMengisi = (clone $assigneesQuery)->where('status', 'Belum Mengisi')->count();
        $tidakHadir = $alphaCount + $izinCount + $belumMengisi;

        $attendanceRate = $totalTodayAssigned > 0 ? round(($hadirCount / $totalTodayAssigned) * 100) : 0;
        $onTimeRate = $hadirCount > 0 ? round(($hadirTepatWaktu / $hadirCount) * 100) : 0;

        // ============================
        // 3. CHART: Statistik Penyelesaian Tugas
        // ============================
        $taskChartLabels = [];
        $taskChartSubmitted = [];
        $taskChartCreated = [];

        if ($timeRange == 'today') {
            for ($i = 0; $i < 24; $i++) {
                $startHour = now()->startOfDay()->addHours($i);
                $endHour = (clone $startHour)->endOfHour();
                $taskChartLabels[] = $startHour->format('H:00');
                
                $submittedQuery = TaskSubmission::whereNotNull('submitted_at')
                    ->whereBetween('submitted_at', [$startHour, $endHour]);
                if ($request->filled('divisi_id') && $divisiId) {
                    $submittedQuery->whereHas('user', function($q) use ($divisiId) {
                        $q->where('divisi_id', $divisiId);
                    });
                }
                $taskChartSubmitted[] = $submittedQuery->count();

                $createdQuery = Task::whereBetween('created_at', [$startHour, $endHour]);
                if ($request->filled('divisi_id') && $divisiId) {
                    $createdQuery->where('divisi_id', $divisiId);
                }
                $taskChartCreated[] = $createdQuery->count();
            }
        } elseif ($timeRange == 'this_month') {
            $daysInMonth = now()->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $date = now()->startOfMonth()->addDays($i - 1);
                $taskChartLabels[] = $date->format('d/m');

                $submittedQuery = TaskSubmission::whereNotNull('submitted_at')
                    ->whereDate('submitted_at', $date->toDateString());
                if ($request->filled('divisi_id') && $divisiId) {
                    $submittedQuery->whereHas('user', function($q) use ($divisiId) {
                        $q->where('divisi_id', $divisiId);
                    });
                }
                $taskChartSubmitted[] = $submittedQuery->count();

                $createdQuery = Task::whereDate('created_at', $date->toDateString());
                if ($request->filled('divisi_id') && $divisiId) {
                    $createdQuery->where('divisi_id', $divisiId);
                }
                $taskChartCreated[] = $createdQuery->count();
            }
        } elseif ($timeRange == 'this_year') {
            for ($i = 1; $i <= 12; $i++) {
                $date = now()->startOfYear()->addMonths($i - 1);
                $taskChartLabels[] = $date->translatedFormat('M');
                
                $startMonth = (clone $date)->startOfMonth();
                $endMonth = (clone $date)->endOfMonth();

                $submittedQuery = TaskSubmission::whereNotNull('submitted_at')
                    ->whereBetween('submitted_at', [$startMonth, $endMonth]);
                if ($request->filled('divisi_id') && $divisiId) {
                    $submittedQuery->whereHas('user', function($q) use ($divisiId) {
                        $q->where('divisi_id', $divisiId);
                    });
                }
                $taskChartSubmitted[] = $submittedQuery->count();

                $createdQuery = Task::whereBetween('created_at', [$startMonth, $endMonth]);
                if ($request->filled('divisi_id') && $divisiId) {
                    $createdQuery->where('divisi_id', $divisiId);
                }
                $taskChartCreated[] = $createdQuery->count();
            }
        } else {
            // 7 days
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $dayName = $date->translatedFormat('D d/m');
                $taskChartLabels[] = $dayName;

                $submittedQuery = TaskSubmission::whereNotNull('submitted_at')
                    ->whereDate('submitted_at', $date->toDateString());
                
                if ($request->filled('divisi_id') && $divisiId) {
                    $submittedQuery->whereHas('user', function($q) use ($divisiId) {
                        $q->where('divisi_id', $divisiId);
                    });
                }
                $taskChartSubmitted[] = $submittedQuery->count();

                $createdQuery = Task::whereDate('created_at', $date->toDateString());
                if ($request->filled('divisi_id') && $divisiId) {
                    $createdQuery->where('divisi_id', $divisiId);
                }
                $taskChartCreated[] = $createdQuery->count();
            }
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
            $weekHadir = (clone $weekAssigneesQuery)->whereIn('status', ['Hadir', 'Terlambat', 'Hadir - Selesai', 'Terlambat - Selesai'])->count();

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
        $monthHadir = (clone $monthAssigneesQuery)->whereIn('status', ['Hadir', 'Terlambat', 'Hadir - Selesai', 'Terlambat - Selesai'])->count();
        $avgAttendanceMonth = $monthTotal > 0 ? round(($monthHadir / $monthTotal) * 100) : 0;

        // ============================
        // 5. AKTIVITAS TERKINI
        // ============================
        $submissionQuery = TaskSubmission::with(['user', 'task'])
            ->whereNotNull('submitted_at')
            ->whereBetween('submitted_at', [$startDate, $endDate]);
        
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
            ->whereIn('status', ['Hadir', 'Terlambat', 'Hadir - Selesai', 'Terlambat - Selesai'])
            ->whereNotNull('check_in_time')
            ->whereBetween('check_in_time', [$startDate, $endDate]);
            
        if ($divisiId) {
            $attendanceActQuery->whereHas('user', function($q) use ($divisiId) {
                $q->where('divisi_id', $divisiId);
            });
        }

        $recentAttendanceActivity = $attendanceActQuery->latest('check_in_time')
            ->take(5)
            ->get()
            ->map(function ($att) {
                $statusText = in_array($att->status, ['Hadir', 'Hadir - Selesai']) ? 'hadir tepat waktu' : 'hadir terlambat';
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
        $recentTaskQuery = Task::whereBetween('created_at', [$startDate, $endDate])->withCount([
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
        // 7. ABSENSI (Detail per mahasiswa)
        // ============================
        $todayAttendanceDetailQuery = AttendanceAssignee::with(['user', 'attendance'])
            ->whereIn('attendance_id', $attendances);
            
        if ($divisiId) {
            $todayAttendanceDetailQuery->whereHas('user', function($q) use ($divisiId) {
                $q->where('divisi_id', $divisiId);
            });
        }
            
        $todayAttendanceDetail = $todayAttendanceDetailQuery->latest('updated_at')
            ->take(10)
            ->get()
            ->map(function ($assignee) {
                if (in_array($assignee->status, ['Hadir', 'Hadir - Selesai'])) {
                    $statusLabel = $assignee->status;
                    $statusClass = 'bg-emerald-100 text-emerald-600';
                } elseif (in_array($assignee->status, ['Terlambat', 'Terlambat - Selesai'])) {
                    $statusLabel = $assignee->status;
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
