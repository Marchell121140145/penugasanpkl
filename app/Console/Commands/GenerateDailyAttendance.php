<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceAssignee;
use Carbon\Carbon;

class GenerateDailyAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate daily attendance for active pelaksana based on settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $enabled = Setting::get('auto_absensi_enabled', 'false');
        if ($enabled !== 'true') {
            $this->info('Auto-generate attendance is disabled.');
            return;
        }

        $activeDays = json_decode(Setting::get('auto_absensi_days', '[]'), true);
        $currentDayName = Carbon::now()->locale('id')->isoFormat('dddd');
        // Map common Indo day names
        $dayMap = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu'
        ];

        $todayMapped = $dayMap[$currentDayName] ?? $currentDayName;

        if (!empty($activeDays) && !in_array($todayMapped, $activeDays)) {
            $this->info('Today (' . $todayMapped . ') is not in active days setting. Skipping.');
            return;
        }

        $checkinStart = Setting::get('auto_absensi_checkin_start', '06:00');
        $checkinDeadline = Setting::get('auto_absensi_checkin_deadline', '08:00');
        $checkoutStart = Setting::get('auto_absensi_checkout_start', '17:00');

        $now = Carbon::now();
        $currentTime = $now->format('H:i');

        // Pastikan hanya berjalan jika waktu sekarang >= checkin_start
        if ($currentTime < $checkinStart) {
            $this->info("It's $currentTime, not yet checkin start time ($checkinStart). Skipping.");
            return;
        }
        
        // Define times
        $deadlineTime = Carbon::createFromFormat('H:i', $checkinDeadline)->setDate($now->year, $now->month, $now->day);
        $checkoutTime = Carbon::createFromFormat('H:i', $checkoutStart)->setDate($now->year, $now->month, $now->day);

        // Get active pelaksanas
        $pelaksanas = User::where('role_id', 3)
            ->whereNotNull('pkl_start')
            ->whereNotNull('pkl_end')
            ->whereDate('pkl_start', '<=', $now)
            ->whereDate('pkl_end', '>=', $now)
            ->get();

        if ($pelaksanas->isEmpty()) {
            $this->info('No active pelaksanas found for today.');
            return;
        }

        // Check if attendance already exists for today to prevent duplicates
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();
        $existing = Attendance::where('title', 'like', '%Absensi Rutin%')
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->first();

        if ($existing) {
            $this->info('Attendance already generated for today.');
            return;
        }

        // Create Attendance
        $attendance = Attendance::create([
            'title' => 'Absensi Rutin - ' . $now->translatedFormat('d M Y'),
            'description' => 'Absensi otomatis digenerate oleh sistem.',
            'deadline' => $deadlineTime,
            'checkout_start' => $checkoutTime,
            'created_by' => 1, // Default Admin ID
        ]);

        // Attach Pelaksanas
        foreach ($pelaksanas as $pelaksana) {
            AttendanceAssignee::create([
                'attendance_id' => $attendance->id,
                'user_id' => $pelaksana->id,
                'status' => 'Belum Mengisi',
            ]);
        }

        $this->info('Successfully generated attendance for ' . $pelaksanas->count() . ' pelaksanas.');
    }
}
