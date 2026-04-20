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

        $today = Carbon::today();
        
        $query = AttendanceAssignee::with(['user.divisi', 'attendance'])
            ->whereHas('attendance', function($q) use ($today) {
                // Untuk sekarang ambil yang dibuat hari ini, atau bisa di-sesuaikan
            });
            
        if ($user->role_id == 2) {
            $query->whereHas('user', function($q) use ($user) {
                $q->where('pembimbing_id', $user->id)
                  ->orWhere('divisi_id', $user->divisi_id);
            });
        }

        $assignees = $query->latest()->take(100)->get();

        return view('monitoring.absensi', compact('assignees'));
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
            'assign_type' => 'required|in:divisi,pelaksana',
            'divisi_ids' => 'required_if:assign_type,divisi|array',
            'pelaksana_ids' => 'required_if:assign_type,pelaksana|array',
        ]);

        $attendance = Attendance::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => Carbon::parse($request->deadline),
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
            'hadirTepatWaktu' => $assignees->where('status', 'Hadir')->count(),
            'terlambat' => $assignees->where('status', 'Terlambat')->count(),
            'izinSakit' => $assignees->whereIn('status', ['Izin', 'Sakit'])->count(),
            'alpha' => $assignees->where('status', 'Alpha')->count(),
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

        \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $image_base64);

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

        return redirect()->route('pelaksana.absensi')->with('success', 'Berhasil Absen!');
    }
}
