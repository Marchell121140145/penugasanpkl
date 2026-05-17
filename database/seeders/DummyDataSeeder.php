<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\AttendanceAssignee;
use App\Models\Divisi;
use App\Models\Task;
use App\Models\TaskFile;
use App\Models\TaskSubmission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \Illuminate\Support\Facades\DB::table('task_submissions')->truncate();
        \Illuminate\Support\Facades\DB::table('tasks')->truncate();
        \Illuminate\Support\Facades\DB::table('attendance_assignees')->truncate();
        \Illuminate\Support\Facades\DB::table('attendances')->truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = \Faker\Factory::create('id_ID');

        // Retrieve existing users and divisions
        $pembimbings = User::where('role_id', 2)->get();
        $pelaksanas = User::where('role_id', 3)->get();
        $divisis = Divisi::all();

        if ($pembimbings->isEmpty() || $pelaksanas->isEmpty() || $divisis->isEmpty()) {
            $this->command->error('Please make sure you have divisions, pembimbing, and pelaksana data first.');
            return;
        }

        $this->command->info('Creating Attendances...');
        $this->createAttendances($pelaksanas, $faker);

        $this->command->info('Creating Tasks & Submissions...');
        $this->createTasks($pembimbings, $pelaksanas, $faker);
    }

    private function createAttendances($pelaksanas, $faker)
    {
        // 14 days ago up to today
        $startDate = Carbon::now()->subDays(14)->startOfDay();
        $endDate = Carbon::now()->startOfDay();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if ($date->isWeekend()) {
                continue;
            }

            // Create attendance session
            $attendance = Attendance::create([
                'title' => 'Absensi Harian ' . $date->format('d M Y'),
                'description' => 'Silakan isi absensi untuk hari ' . $date->translatedFormat('l'),
                'deadline' => $date->copy()->setTime(8, 30, 0),
                'checkout_start' => $date->copy()->setTime(17, 0, 0),
                'created_by' => 1, // Admin
                'created_at' => $date->copy()->subHours(2),
                'updated_at' => $date->copy()->subHours(2),
            ]);

            // Assign to all pelaksana
            foreach ($pelaksanas as $pelaksana) {
                $rand = rand(1, 100);
                
                $status = 'Belum Mengisi';
                $checkInTime = null;
                $checkOutTime = null;
                
                $isToday = $date->isToday();
                
                if ($isToday) {
                    if ($rand <= 70) {
                        $status = 'Hadir';
                        $checkInTime = $date->copy()->setTime(rand(7, 8), rand(0, 25), rand(0, 59));
                    } elseif ($rand <= 80) {
                        $status = 'Terlambat';
                        $checkInTime = $date->copy()->setTime(rand(8, 10), rand(31, 59), rand(0, 59));
                    } elseif ($rand <= 85) {
                        $status = 'Izin';
                    } elseif ($rand <= 90) {
                        $status = 'Sakit';
                    } elseif ($rand <= 95) {
                        $status = 'Alpha';
                    } else {
                        $status = 'Belum Mengisi';
                    }
                } else {
                    if ($rand <= 75) {
                        $status = 'Hadir - Selesai';
                        $checkInTime = $date->copy()->setTime(rand(7, 8), rand(0, 25), rand(0, 59));
                        $checkOutTime = $date->copy()->setTime(rand(17, 18), rand(0, 59), rand(0, 59));
                    } elseif ($rand <= 85) {
                        $status = 'Terlambat - Selesai';
                        $checkInTime = $date->copy()->setTime(rand(8, 10), rand(31, 59), rand(0, 59));
                        $checkOutTime = $date->copy()->setTime(rand(17, 18), rand(0, 59), rand(0, 59));
                    } elseif ($rand <= 90) {
                        $status = 'Izin';
                    } elseif ($rand <= 95) {
                        $status = 'Sakit';
                    } else {
                        $status = 'Alpha';
                    }
                }

                AttendanceAssignee::create([
                    'attendance_id' => $attendance->id,
                    'user_id' => $pelaksana->id,
                    'status' => $status,
                    'check_in_time' => $checkInTime,
                    'check_out_time' => $checkOutTime,
                    'photo_path' => $checkInTime ? 'attendances/dummy.jpg' : null,
                    'checkout_photo_path' => $checkOutTime ? 'attendances/dummy_checkout.jpg' : null,
                    'lokasi' => $checkInTime ? '-5.' . rand(3000, 4000) . ', 105.' . rand(2000, 3000) : null,
                    'checkout_lokasi' => $checkOutTime ? '-5.' . rand(3000, 4000) . ', 105.' . rand(2000, 3000) : null,
                    'keterangan' => in_array($status, ['Izin', 'Sakit']) ? $faker->sentence() : null,
                    'created_at' => $checkInTime ?: clone $date,
                    'updated_at' => $checkOutTime ?: ($checkInTime ?: clone $date),
                ]);
            }
        }
    }

    private function createTasks($pembimbings, $pelaksanas, $faker)
    {
        $taskTitles = [
            'Mapping Data Sekolah Bandar Lampung',
            'Rekapitulasi Tagihan Pelanggan Area Natar',
            'Visiting Pelanggan Indihome Tunggakan',
            'Input Data Prospek Sales B2B',
            'Update Database Perangkat Jaringan',
            'Caring Pelanggan Prioritas VIP',
            'Survey Kepuasan Pelanggan (CSAT)',
            'Pengecekan ODP Area Kedaton',
            'Migrasi Data Layanan Telkomsel',
            'Follow Up Tiket Gangguan Internet',
            'Pembuatan Laporan Kinerja Mingguan',
            'Desain Materi Promosi Produk',
            'Analisis Data Churn Rate',
            'Inventarisasi Aset Kantor',
            'Koordinasi dengan Teknisi Lapangan',
            'Review Dokumen SLA Pelanggan Korporat',
            'Pemasaran Indihome Paket Jitu',
            'Troubleshoot Jaringan FO Telkom Akses',
            'Audit Keamanan Data Pelanggan',
            'Penyusunan Materi Briefing Pagi'
        ];

        // Let's create about 30 tasks
        for ($i = 0; $i < 30; $i++) {
            $pembimbing = $pembimbings->random();
            $divisi_id = $pembimbing->divisi_id;
            
            $availablePelaksanas = $pelaksanas->where('divisi_id', $divisi_id);
            if ($availablePelaksanas->isEmpty()) {
                $availablePelaksanas = $pelaksanas; // Fallback
                $divisi_id = $availablePelaksanas->first()->divisi_id;
            }
            
            $assigneeCount = rand(1, min(3, $availablePelaksanas->count()));
            $assignees = $availablePelaksanas->random($assigneeCount);

            $createdAt = Carbon::now()->subDays(rand(1, 30))->subHours(rand(1, 23));
            $deadlineDate = (clone $createdAt)->addDays(rand(2, 10));
            
            $status = 'active';
            $rand = rand(1, 10);
            
            if ($rand <= 1) {
                $status = 'draft';
                $deadlineDate = Carbon::now()->addDays(rand(5, 10));
            } elseif ($deadlineDate->isPast()) {
                $status = rand(1, 10) <= 8 ? 'completed' : 'active';
            } else {
                $status = 'active';
            }

            $task = Task::create([
                'judul' => $faker->randomElement($taskTitles) . ' ' . rand(1, 100),
                'deskripsi' => $faker->paragraphs(rand(2, 4), true),
                'jenis_tugas' => $faker->randomElement(['individu', 'kelompok', 'proyek']),
                'prioritas' => $faker->randomElement(['rendah', 'sedang', 'tinggi']),
                'divisi_id' => $divisi_id,
                'deadline_date' => $deadlineDate->toDateString(),
                'deadline_time' => sprintf('%02d:00', rand(12, 17)),
                'catatan' => rand(1,10) > 5 ? $faker->sentence() : null,
                'created_by' => $pembimbing->id,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $task->assignees()->attach($assignees->pluck('id'));

            foreach ($assignees as $pelaksana) {
                $subStatus = 'pending';
                $nilai = null;
                $komentar = null;
                $submittedAt = null;

                if ($status === 'completed') {
                    $subStatus = 'graded';
                    $nilai = rand(70, 100);
                    $komentar = rand(1,10) > 3 ? $faker->sentence() : null;
                    $submittedAt = (clone $deadlineDate)->subHours(rand(1, 48));
                } elseif ($status === 'active' && $deadlineDate->isPast()) {
                    $subStatus = rand(1, 10) <= 5 ? 'pending' : 'submitted';
                    if ($subStatus === 'submitted') {
                        $submittedAt = (clone $deadlineDate)->addHours(rand(1, 24));
                    }
                } elseif ($status === 'active' && $deadlineDate->isFuture()) {
                    $r = rand(1, 10);
                    if ($r <= 3) {
                        $subStatus = 'submitted';
                        $submittedAt = Carbon::now()->subHours(rand(1, 24));
                    } elseif ($r <= 5) {
                        $subStatus = 'working';
                    } else {
                        $subStatus = 'pending';
                    }
                } elseif ($status === 'draft') {
                    $subStatus = 'pending';
                }

                TaskSubmission::create([
                    'task_id' => $task->id,
                    'user_id' => $pelaksana->id,
                    'status' => $subStatus,
                    'nilai' => $nilai,
                    'komentar' => $komentar,
                    'file_nama' => ($subStatus === 'submitted' || $subStatus === 'graded' || $subStatus === 'returned') ? 'laporan_tugas_' . rand(100,999) . '.pdf' : null,
                    'file_path' => ($subStatus === 'submitted' || $subStatus === 'graded' || $subStatus === 'returned') ? 'submissions/dummy.pdf' : null,
                    'file_ukuran' => ($subStatus === 'submitted' || $subStatus === 'graded' || $subStatus === 'returned') ? rand(1024, 50000) : 0,
                    'submitted_at' => $submittedAt,
                    'created_at' => $createdAt,
                    'updated_at' => $submittedAt ?: clone $createdAt,
                ]);
            }
        }
    }
}
