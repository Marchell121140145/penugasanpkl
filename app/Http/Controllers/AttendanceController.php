<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceAssignee;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->role_id == 3) {
            return redirect()->route('pelaksana.absensi');
        }

        // Dapatkan daftar "Sesi Absensi" 
        $attendancesQuery = Attendance::withCount([
            'assignees as hadir_count' => function($q) {
                $q->whereIn('status', ['Hadir', 'Terlambat', 'Hadir - Selesai', 'Terlambat - Selesai']);
            },
            'assignees as checkout_count' => function($q) {
                $q->whereIn('status', ['Hadir - Selesai', 'Terlambat - Selesai']);
            },
            'assignees as total_assignees'
        ])->latest();

        if ($user->role_id == 2) {
            $attendancesQuery->whereHas('assignees.user', function($q) use ($user) {
                $q->where('pembimbing_id', $user->id)
                  ->orWhere('divisi_id', $user->divisi_id);
            });
        }
        $attendances = $attendancesQuery->take(15)->get();

        return view('monitoring.absensi', compact('attendances'));
    }

    public function sessionDetail($id)
    {
        $user = auth()->user();
        if ($user->role_id == 3) {
            return redirect()->route('pelaksana.absensi');
        }

        $attendance = Attendance::with('creator')->findOrFail($id);

        $assigneesQuery = AttendanceAssignee::with(['user.divisi'])
            ->where('attendance_id', $id);

        if ($user->role_id == 2) {
            $assigneesQuery->whereHas('user', function($q) use ($user) {
                $q->where('pembimbing_id', $user->id)
                  ->orWhere('divisi_id', $user->divisi_id);
            });
        }

        $assignees = $assigneesQuery->get();

        $stats = [
            'hadir' => $assignees->whereIn('status', ['Hadir', 'Hadir - Selesai'])->count(),
            'terlambat' => $assignees->whereIn('status', ['Terlambat', 'Terlambat - Selesai'])->count(),
            'selesai' => $assignees->whereIn('status', ['Hadir - Selesai', 'Terlambat - Selesai'])->count(),
            'tidakHadir' => $assignees->whereIn('status', ['Alpha', 'Izin', 'Sakit', 'Belum Mengisi'])->count(),
        ];

        $divisis = Divisi::orderBy('nama')->get();

        return view('monitoring.absensi-detail', compact('attendance', 'assignees', 'stats', 'divisis'));
    }

    public function create()
    {
        $user = auth()->user();
        
        if ($user->role_id == 1) {
            $divisis = Divisi::all();
            $pelaksanas = User::where('role_id', 3)->get();
        } else {
            $divisis = Divisi::where('id', $user->divisi_id)->get();
            $pelaksanas = User::where('role_id', 3)
                              ->where(function($q) use ($user) {
                                  $q->where('pembimbing_id', $user->id)
                                    ->orWhere('divisi_id', $user->divisi_id);
                              })->get();
        }

        return view('monitoring.absensi-create', compact('divisis', 'pelaksanas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
            'checkout_start' => 'nullable|date',
            'assign_type' => 'required|in:divisi,pelaksana',
            'divisi_ids' => 'required_if:assign_type,divisi|array',
            'pelaksana_ids' => 'required_if:assign_type,pelaksana|array',
        ]);

        $attendance = Attendance::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => Carbon::parse($request->deadline),
            'checkout_start' => $request->checkout_start ? Carbon::parse($request->checkout_start) : null,
            'created_by' => auth()->id(),
        ]);

        $userIdsToAssign = [];

        if ($request->assign_type === 'divisi') {
            $users = User::where('role_id', 3)
                         ->whereIn('divisi_id', $request->divisi_ids)
                         ->get();
            $userIdsToAssign = $users->pluck('id')->toArray();
        } else {
            $userIdsToAssign = $request->pelaksana_ids;
        }

        $userIdsToAssign = array_unique($userIdsToAssign);

        $assigneesData = [];
        $now = now();
        foreach ($userIdsToAssign as $userId) {
            $assigneesData[] = [
                'attendance_id' => $attendance->id,
                'user_id' => $userId,
                'status' => 'Belum Mengisi',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (count($assigneesData) > 0) {
            AttendanceAssignee::insert($assigneesData);
        }

        return redirect()->route('absensi')->with('success', 'Absensi berhasil dibuat dan ditugaskan.');
    }

    public function adminHistory($id)
    {
        $userActive = auth()->user();
        if ($userActive->role_id == 3) {
            return redirect()->route('pelaksana.absensi');
        }

        $pelaksana = User::with('divisi')->findOrFail($id);

        if ($userActive->role_id == 2) {
            if ($pelaksana->pembimbing_id != $userActive->id && $pelaksana->divisi_id != $userActive->divisi_id) {
                return redirect()->route('absensi')->with('error', 'Anda tidak memiliki akses ke riwayat mahasiswa ini.');
            }
        }

        $assignees = AttendanceAssignee::with('attendance')
            ->where('user_id', $id)
            ->oldest('created_at')
            ->get();

        $stats = [
            'totalHadir' => $assignees->whereIn('status', ['Hadir', 'Hadir - Selesai'])->count(),
            'terlambat' => $assignees->whereIn('status', ['Terlambat', 'Terlambat - Selesai'])->count(),
            'izinSakit' => $assignees->whereIn('status', ['Izin', 'Sakit'])->count(),
            'alpha' => $assignees->where('status', 'Alpha')->count(),
            'selesai' => $assignees->whereIn('status', ['Hadir - Selesai', 'Terlambat - Selesai'])->count(),
        ];

        return view('monitoring.absensi-history', compact('pelaksana', 'assignees', 'stats'));
    }

    public function updateStatus(Request $request, $id)
    {
        $userActive = auth()->user();
        if ($userActive->role_id == 3) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:Belum Mengisi,Hadir,Terlambat,Hadir - Selesai,Terlambat - Selesai,Izin,Sakit,Alpha',
        ]);

        $assignee = AttendanceAssignee::findOrFail($id);

        // Scope check for pembimbing
        if ($userActive->role_id == 2) {
            $student = User::find($assignee->user_id);
            if ($student && $student->pembimbing_id != $userActive->id && $student->divisi_id != $userActive->divisi_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $assignee->update([
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Status berhasil diubah menjadi: ' . $request->status]);
    }

    public function pelaksanaIndex()
    {
        $user = auth()->user();
        
        // Ambil data attendance_assignee miliknya
        $assignees = AttendanceAssignee::with('attendance')
                        ->where('user_id', $user->id)
                        ->latest('created_at')
                        ->get();

        // Hitung statistik
        $stats = [
            'hadirTepatWaktu' => $assignees->whereIn('status', ['Hadir', 'Hadir - Selesai'])->count(),
            'terlambat' => $assignees->whereIn('status', ['Terlambat', 'Terlambat - Selesai'])->count(),
            'izinSakit' => $assignees->whereIn('status', ['Izin', 'Sakit'])->count(),
            'alpha' => $assignees->where('status', 'Alpha')->count(),
            'selesai' => $assignees->whereIn('status', ['Hadir - Selesai', 'Terlambat - Selesai'])->count(),
        ];

        return view('pelaksana.absensi', compact('assignees', 'stats'));
    }

    public function pelaksanaShowUpload($id)
    {
        $assignee = AttendanceAssignee::with('attendance')->where('user_id', auth()->id())->findOrFail($id);
        
        if ($assignee->status !== 'Belum Mengisi') {
            return redirect()->route('pelaksana.absensi')->with('error', 'Absensi ini sudah diisi.');
        }

        return view('pelaksana.upload-absensi', compact('assignee'));
    }

    public function pelaksanaSubmit(Request $request, $id)
    {
        $assignee = AttendanceAssignee::with('attendance')->where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'image_data' => 'required|string',
            'lokasi' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $image_parts = explode(";base64,", $request->image_data);
        if (count($image_parts) != 2) {
            return back()->with('error', 'Format gambar tidak valid.');
        }
        
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = 'attendance_' . $assignee->id . '_' . time() . '.jpg';
        $filePath = 'attendances/' . $fileName;

        \Illuminate\Support\Facades\Storage::disk('local')->put($filePath, $image_base64);

        // Cek keterlambatan
        $status = 'Hadir';
        if ($assignee->attendance->deadline < now()) {
            $status = 'Terlambat';
        }

        $assignee->update([
            'photo_path' => $filePath,
            'check_in_time' => now(),
            'status' => $status,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('pelaksana.absensi')->with('success', 'Check-In berhasil!');
    }

    public function pelaksanaShowCheckout($id)
    {
        $assignee = AttendanceAssignee::with('attendance')->where('user_id', auth()->id())->findOrFail($id);

        // Hanya bisa checkout jika sudah check-in (status Hadir/Terlambat) dan belum checkout
        if (!in_array($assignee->status, ['Hadir', 'Terlambat'])) {
            return redirect()->route('pelaksana.absensi')->with('error', 'Anda belum bisa melakukan check-out.');
        }

        // Cek apakah waktu checkout sudah dimulai
        if ($assignee->attendance->checkout_start && $assignee->attendance->checkout_start > now()) {
            return redirect()->route('pelaksana.absensi')->with('error', 'Waktu check-out belum dimulai. Silakan tunggu hingga ' . $assignee->attendance->checkout_start->format('H:i') . ' WIB.');
        }

        return view('pelaksana.checkout-absensi', compact('assignee'));
    }

    public function pelaksanaSubmitCheckout(Request $request, $id)
    {
        $assignee = AttendanceAssignee::with('attendance')->where('user_id', auth()->id())->findOrFail($id);

        // Hanya bisa checkout jika sudah check-in dan belum checkout
        if (!in_array($assignee->status, ['Hadir', 'Terlambat'])) {
            return redirect()->route('pelaksana.absensi')->with('error', 'Anda belum bisa melakukan check-out.');
        }

        // Cek apakah waktu checkout sudah dimulai
        if ($assignee->attendance->checkout_start && $assignee->attendance->checkout_start > now()) {
            return redirect()->route('pelaksana.absensi')->with('error', 'Waktu check-out belum dimulai.');
        }

        $request->validate([
            'image_data' => 'required|string',
            'lokasi' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $image_parts = explode(";base64,", $request->image_data);
        if (count($image_parts) != 2) {
            return back()->with('error', 'Format gambar tidak valid.');
        }

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = 'checkout_' . $assignee->id . '_' . time() . '.jpg';
        $filePath = 'attendances/' . $fileName;

        \Illuminate\Support\Facades\Storage::disk('local')->put($filePath, $image_base64);

        // Update status menjadi Selesai
        $newStatus = $assignee->status === 'Terlambat' ? 'Terlambat - Selesai' : 'Hadir - Selesai';

        $assignee->update([
            'checkout_photo_path' => $filePath,
            'check_out_time' => now(),
            'status' => $newStatus,
            'checkout_lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan ?? $assignee->keterangan,
        ]);

        return redirect()->route('pelaksana.absensi')->with('success', 'Check-Out berhasil!');
    }
}
