<x-pelaksana-layout>
    <!-- HEADER & BANNER PROFIL (FULL WIDTH) -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div class="welcome">
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Dashboard</h1>
            <p class="text-slate-500 text-sm">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white p-2 pr-4 rounded-full shadow-sm border border-slate-100">
            <div class="flex items-center gap-2 cursor-pointer relative" x-data="{ open: false }" @click.away="open = false" @click="open = !open">
                @if(Auth::user()->avatar)
                    <img src="{{ route('file.avatar', Auth::user()->id) }}" class="w-10 h-10 rounded-full object-cover">
                @else
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">{{ substr(Auth::user()->name ?? 'P', 0, 1) }}</div>
                @endif
                <div class="text-left hidden sm:block">
                    <span class="block font-bold text-slate-800 text-sm leading-none">{{ Auth::user()->name ?? 'Pelaksana' }}</span>
                    <span class="text-xs text-slate-500">{{ Auth::user()->divisi->nama ?? 'Mahasiswa' }}</span>
                </div>
                <i class="fi fi-rr-angle-small-down text-slate-400 ml-2"></i>
                
                <!-- Dropdown Menu -->
                <div x-show="open" 
                     class="absolute top-[120%] right-0 w-48 bg-white rounded-xl shadow-lg z-50 py-2 border border-slate-100"
                     style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profile</a>
                    <div class="border-t border-slate-100 my-1"></div>
                     <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Log Out</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- ========================================== -->
        <!-- KOLOM KIRI (LEBAR 2/3) -->
        <!-- ========================================== -->
        <div class="xl:col-span-2 flex flex-col gap-6">

            <!-- HERO BANNER -->
            <div class="w-full bg-blue-600 rounded-2xl shadow-lg overflow-hidden relative p-8 flex flex-col md:flex-row items-center justify-between gap-6 min-h-[220px]">
                <!-- Dekorasi Background -->
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute left-1/2 bottom-0 w-32 h-32 bg-cyan-400 opacity-20 rounded-full blur-xl"></div>
                
                <div class="relative z-10 text-white flex-1">
                    <h2 class="text-3xl font-bold mb-2">Halo, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                    <p class="text-blue-100 text-sm mb-6 max-w-md leading-relaxed">
                        @if($priorityTask)
                            Ada tugas prioritas yang menantimu. Cek detailnya dan kerjakan agar performamu tetap memuaskan!
                        @else
                            Kerja bagus! Kamu sudah menyelesaikan semua tugas. Terus tingkatkan kehadiran dan nilaimu di dasbor ini.
                        @endif
                    </p>
                    @if($priorityTask)
                        <a href="{{ route('pelaksana.penugasan.show', $priorityTask->id) }}" class="inline-block bg-white text-blue-600 hover:bg-blue-50 px-6 py-2.5 rounded-lg font-bold text-sm shadow-sm transition-transform hover:-translate-y-0.5">
                            Lihat Tugas Prioritas
                        </a>
                    @else
                        <a href="{{ route('pelaksana.penugasan') }}" class="inline-block bg-blue-700 hover:bg-blue-800 border border-blue-500 text-white px-6 py-2.5 rounded-lg font-bold text-sm shadow-sm transition-transform hover:-translate-y-0.5">
                            Lihat Semua Tugas
                        </a>
                    @endif
                </div>
                
                <!-- Ilustrasi (Fixed Icon) -->
                <div class="relative z-10 shrink-0 hidden md:block">
                    <div class="w-40 h-32 bg-blue-500/50 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-blue-400/30">
                        <i class="fi fi-rr-book-alt text-6xl text-white opacity-90 transform -rotate-6"></i>
                    </div>
                </div>
            </div>

            <!-- USER INFO BANNER -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x divide-slate-100">
                <div class="flex-1 flex items-center gap-4 px-6 py-2">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-lg shrink-0">
                        <i class="fi fi-rr-briefcase"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Divisi</div>
                        <div class="text-sm font-bold text-slate-800">{{ Auth::user()->divisi->nama ?? 'Belum Ada Divisi' }}</div>
                    </div>
                </div>
                <div class="flex-1 flex items-center gap-4 px-6 py-2">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 text-lg shrink-0">
                        <i class="fi fi-rr-user-tie"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Pembimbing</div>
                        <div class="text-sm font-bold text-slate-800">{{ Auth::user()->pembimbing->name ?? 'Belum Ada Pembimbing' }}</div>
                    </div>
                </div>
                <div class="flex-1 flex items-center gap-4 px-6 py-2">
                    <div class="w-10 h-10 rounded-full {{ $daysLeft <= 3 && $daysLeft > 0 ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600' }} flex items-center justify-center text-lg shrink-0">
                        <i class="fi fi-rr-hourglass-end"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Sisa Masa PKL</div>
                        <div class="text-sm font-bold {{ $daysLeft <= 3 && $daysLeft > 0 ? 'text-red-600' : 'text-slate-800' }}">{{ $daysLeft > 0 ? round($daysLeft) . ' Hari Lagi' : 'Selesai' }}</div>
                    </div>
                </div>
            </div>

            <!-- STATS BOXES -->
            @php
                $nearestTask = collect($recentTasks)->filter(function($t) {
                    $sub = $t->submissions->first();
                    return !$sub || !in_array($sub->status, ['submitted', 'graded']);
                })->sortBy('deadline_date')->first();
                $nearestDeadlineText = $nearestTask ? \Carbon\Carbon::parse($nearestTask->deadline_date)->translatedFormat('d M Y') : '-';
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-600 text-xl mb-3"><i class="fi fi-rr-list"></i></div>
                    <div class="text-sm font-bold text-slate-500 mb-1 uppercase tracking-wider">Active Tasks</div>
                    <div class="text-3xl font-black text-slate-800 mb-3">{{ $pendingTasks }}</div>
                    <p class="text-xs text-slate-500 leading-relaxed px-2">Anda memiliki <strong class="text-slate-700">{{ $pendingTasks }}</strong> tugas aktif. Deadline terdekat: <strong class="text-slate-700">{{ $nearestDeadlineText }}</strong>.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-xl mb-3"><i class="fi fi-rr-checkbox"></i></div>
                    <div class="text-sm font-bold text-slate-500 mb-1 uppercase tracking-wider">Completed</div>
                    <div class="text-3xl font-black text-slate-800 mb-3">{{ $totalTasks - $pendingTasks }}</div>
                    <p class="text-xs text-slate-500 leading-relaxed px-2">Anda sudah menyelesaikan <strong class="text-blue-600">{{ $totalTasks - $pendingTasks }}</strong> tugas dari total <strong class="text-slate-700">{{ $totalTasks }}</strong> tugas yang diberikan.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 text-xl mb-3"><i class="fi fi-rr-star"></i></div>
                    <div class="text-sm font-bold text-slate-500 mb-1 uppercase tracking-wider">Avg Score</div>
                    <div class="text-3xl font-black text-slate-800 mb-3">{{ $averageScore }}</div>
                    <p class="text-xs text-slate-500 leading-relaxed px-2">Rata-rata nilai Anda dari seluruh tugas yang telah dinilai oleh pembimbing.</p>
                </div>
            </div>

            <!-- ATTENDANCE DONUT CHART -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 w-full">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">My Progress (Kehadiran)</h3>
                    <p class="text-sm text-slate-500 mb-6">Distribusi status kehadiranmu selama PKL</p>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-emerald-500"></div> Hadir Tepat Waktu</span>
                            <span class="font-bold text-slate-700">{{ $attendanceBreakdown['hadir'] }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-amber-500"></div> Terlambat</span>
                            <span class="font-bold text-slate-700">{{ $attendanceBreakdown['terlambat'] }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-blue-500"></div> Izin / Sakit</span>
                            <span class="font-bold text-slate-700">{{ $attendanceBreakdown['izin_sakit'] }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-red-500"></div> Alpha</span>
                            <span class="font-bold text-slate-700">{{ $attendanceBreakdown['alpha'] }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('pelaksana.absensi') }}" class="text-sm text-blue-600 hover:underline font-semibold">Lihat Riwayat Absensi <i class="fi fi-rr-arrow-right text-xs"></i></a>
                    </div>
                </div>
                <div class="relative w-48 h-48 shrink-0">
                    <canvas id="attendanceDonut"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-3xl font-black text-slate-800">{{ $attendanceRate }}%</span>
                        <span class="text-xs text-slate-500">Hadir</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- KOLOM KANAN (LEBAR 1/3) -->
        <!-- ========================================== -->
        <div class="flex flex-col gap-6">
            
            <!-- ALPINE CALENDAR -->
            <div x-data="calendarData()" x-init="initCal()" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 h-auto md:min-h-[220px]">
                <!-- Header Kalender -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-slate-800 text-lg" x-text="monthNames[currentMonth] + ' ' + currentYear"></h3>
                    <div class="flex gap-2">
                        <button @click="prevMonth()" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors"><i class="fi fi-rr-angle-small-left"></i></button>
                        <button @click="nextMonth()" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors"><i class="fi fi-rr-angle-small-right"></i></button>
                    </div>
                </div>

                <!-- Nama Hari -->
                <div class="grid grid-cols-7 gap-1 mb-2 text-center">
                    <template x-for="day in ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']">
                        <div class="text-xs font-bold text-slate-400 uppercase" x-text="day"></div>
                    </template>
                </div>

                <!-- Grid Tanggal -->
                <div class="grid grid-cols-7 gap-1 text-center">
                    <!-- Kotak Kosong -->
                    <template x-for="blank in blankDays">
                        <div class="aspect-square"></div>
                    </template>

                    <!-- Tanggal -->
                    <template x-for="(day, index) in days" :key="index">
                        <div class="aspect-square flex flex-col items-center justify-center rounded-xl text-sm relative transition-colors cursor-pointer group"
                             :class="{
                                 'bg-blue-600 text-white font-bold shadow-md shadow-blue-600/30': day.isToday,
                                 'hover:bg-slate-100 text-slate-700': !day.isToday,
                                 'text-slate-800 font-bold': day.hasTasks && !day.isToday
                             }"
                             @click="selectedDate = day.date">
                            <span x-text="day.date"></span>
                            
                            <!-- Indikator Tugas -->
                            <template x-if="day.hasTasks">
                                <div class="absolute bottom-1.5 flex gap-0.5">
                                    <template x-for="(task, i) in day.tasks">
                                        <template x-if="i < 3">
                                            <div class="w-1.5 h-1.5 rounded-full" :class="day.isToday ? 'bg-white' : 'bg-red-500'"></div>
                                        </template>
                                    </template>
                                </div>
                            </template>

                            <!-- Tooltip Hover -->
                            <template x-if="day.hasTasks">
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max max-w-[200px] sm:max-w-xs bg-slate-800 text-white text-xs rounded-lg p-2.5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 shadow-xl pointer-events-none">
                                    <div class="font-bold mb-1.5 pb-1 border-b border-slate-600/60 text-center text-slate-200" x-text="day.date + ' ' + monthNames[currentMonth]"></div>
                                    <ul class="text-left space-y-1">
                                        <template x-for="task in day.tasks">
                                            <li class="flex justify-between items-start gap-3">
                                                <span class="truncate font-medium text-blue-200" x-text="task.judul"></span>
                                                <span class="opacity-75 shrink-0" x-text="task.deadline_date.includes('T') ? task.deadline_date.split('T')[1].substring(0,5) : (task.deadline_date.includes(' ') ? task.deadline_date.split(' ')[1].substring(0,5) : '')"></span>
                                            </li>
                                        </template>
                                    </ul>
                                    <!-- Segitiga Panah Tooltip -->
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-[5px] border-transparent border-t-slate-800"></div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <!-- ABSEN AKTIF (REPLACES MY SCHEDULE) -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-slate-800 text-lg">Absen Aktif</h3>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500"><i class="fi fi-rr-calendar-clock"></i></div>
                </div>
                
                @php
                    // Cari absensi hari ini dari list recentAttendances
                    $todayAttendance = null;
                    if(isset($recentAttendances)) {
                        foreach($recentAttendances as $att) {
                            if($att->attendance && $att->attendance->deadline->isToday()) {
                                $todayAttendance = $att;
                                break;
                            }
                        }
                    }
                @endphp

                @if($todayAttendance)
                    @php
                        $isBelumAbsen = $todayAttendance->status == 'Belum Mengisi';
                        $isCheckedIn = in_array($todayAttendance->status, ['Hadir', 'Terlambat']);
                        $isSelesai = in_array($todayAttendance->status, ['Hadir - Selesai', 'Terlambat - Selesai', 'Izin', 'Sakit', 'Alpha']);
                        
                        $canCheckout = $isCheckedIn;
                        if ($canCheckout && $todayAttendance->attendance->checkout_start && $todayAttendance->attendance->checkout_start > now()) {
                            $canCheckout = false;
                        }
                    @endphp
                    
                    <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $isSelesai ? 'bg-slate-400' : 'bg-emerald-400' }} opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 {{ $isSelesai ? 'bg-slate-500' : 'bg-emerald-500' }}"></span>
                            </span>
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Sesi Hari Ini</span>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm mb-1">{{ $todayAttendance->attendance->title ?? 'Absensi Rutin' }}</h4>
                        <div class="text-xs text-slate-500 mb-4 flex flex-col gap-1">
                            <span><i class="fi fi-rr-sign-in-alt mr-1 text-slate-400"></i> Check-in max: <strong class="text-slate-700">{{ $todayAttendance->attendance->deadline->format('H:i') }} WIB</strong></span>
                            @if($todayAttendance->attendance->checkout_start)
                                <span><i class="fi fi-rr-sign-out-alt mr-1 text-slate-400"></i> Check-out mulai: <strong class="text-slate-700">{{ $todayAttendance->attendance->checkout_start->format('H:i') }} WIB</strong></span>
                            @endif
                        </div>

                        @if($isBelumAbsen)
                            <a href="{{ route('pelaksana.absensi.create', $todayAttendance->id) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-bold shadow-sm transition-colors">
                                Check-in Sekarang
                            </a>
                        @elseif($isCheckedIn && $canCheckout)
                            <a href="{{ route('pelaksana.absensi.checkout', $todayAttendance->id) }}" class="block w-full text-center bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg text-sm font-bold shadow-sm transition-colors">
                                Check-out Sekarang
                            </a>
                        @elseif($isCheckedIn && !$canCheckout)
                            <div class="text-center text-xs font-medium text-amber-600 bg-amber-50 py-2 rounded-lg border border-amber-100">
                                Sudah Check-in. Tunggu jadwal Check-out.
                            </div>
                        @else
                            <div class="text-center text-xs font-medium text-emerald-600 bg-emerald-50 py-2 rounded-lg border border-emerald-100">
                                Sesi absensi hari ini selesai! <i class="fi fi-rr-check-circle ml-1"></i>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8 text-slate-400 text-sm italic border-2 border-dashed border-slate-100 rounded-xl">
                        Tidak ada sesi absensi hari ini.
                    </div>
                @endif
            </div>

            <!-- UPCOMING DEADLINES WIDGET -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-slate-800 text-lg">Mendekati Tenggat</h3>
                    <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-red-500"><i class="fi fi-rr-alarm-clock"></i></div>
                </div>
                <div class="space-y-4">
                    @php
                        // Ambil 3 tugas terdekat yang belum selesai
                        $upcomingTasks = collect($recentTasks)->filter(function($t) {
                            $submission = $t->submissions->first();
                            return !$submission || !in_array($submission->status, ['submitted', 'graded']);
                        })->sortBy('deadline_date')->take(3);
                    @endphp

                    @forelse($upcomingTasks as $task)
                        @php
                            $daysRemaining = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($task->deadline_date), false);
                            $isUrgent = $daysRemaining <= 2;
                        @endphp
                        <a href="{{ route('pelaksana.penugasan.show', $task->id) }}" class="block p-3 rounded-xl border border-slate-100 hover:border-blue-300 hover:shadow-md transition-all group bg-slate-50/30">
                            <h4 class="text-sm font-bold text-slate-800 group-hover:text-blue-600 mb-1 truncate" title="{{ $task->judul }}">{{ $task->judul }}</h4>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-500"><i class="fi fi-rr-calendar mr-1"></i>{{ \Carbon\Carbon::parse($task->deadline_date)->translatedFormat('d M') }}</span>
                                <span class="{{ $isUrgent ? 'text-red-500 font-bold bg-red-50 px-2 py-0.5 rounded-md border border-red-100' : 'text-slate-400 font-medium' }}">
                                    {{ $daysRemaining == 0 ? 'Hari Ini!' : ($daysRemaining < 0 ? 'Terlewat' : $daysRemaining . ' Hari Lagi') }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-sm italic border-2 border-dashed border-slate-100 rounded-xl">
                            Hore! Tidak ada tugas mendesak.
                        </div>
                    @endforelse
                </div>
                @if($upcomingTasks->count() > 0)
                <div class="mt-4 text-center">
                    <a href="{{ route('pelaksana.penugasan') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua Tugas &rarr;</a>
                </div>
                @endif
            </div>

        </div>
    </div>

    <!-- ========================================== -->
    <!-- KOLOM BAWAH FULL (ASSIGNMENTS) -->
    <!-- ========================================== -->
    <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-xl font-bold text-slate-800">Assignments</h2>
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2">
                <i class="fi fi-rr-search text-slate-400"></i>
                <input type="text" placeholder="Search task..." class="bg-transparent border-none focus:ring-0 text-sm text-slate-700 w-32 sm:w-48 p-0">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="pb-4 font-semibold w-2/5">Judul Tugas</th>
                        <th class="pb-4 font-semibold">Tenggat Waktu</th>
                        <th class="pb-4 font-semibold">Status</th>
                        <th class="pb-4 font-semibold text-center">Nilai</th>
                        <th class="pb-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentTasks as $task)
                    @php
                        $userSubmission = $task->submissions->first();
                        $status = $userSubmission ? $userSubmission->status : 'pending';
                        
                        $statusBg = 'bg-slate-100 text-slate-600';
                        $statusLabel = 'Pending';
                        if (in_array($status, ['submitted', 'graded'])) {
                            $statusBg = 'bg-emerald-100 text-emerald-700';
                            $statusLabel = 'Selesai';
                        }
                        
                        $nilai = $userSubmission && $userSubmission->nilai !== null ? $userSubmission->nilai : '-';
                        $isNearing = \Carbon\Carbon::parse($task->deadline_date)->isBefore(now()->addDays(3));
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="py-4 pr-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ in_array($status, ['submitted', 'graded']) ? 'bg-emerald-50 text-emerald-500 border border-emerald-100' : 'bg-blue-50 text-blue-500 border border-blue-100' }}">
                                    <i class="fi {{ in_array($status, ['submitted', 'graded']) ? 'fi-rr-check-circle' : 'fi-rr-document' }}"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition-colors">{{ $task->judul }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5">Prioritas: {{ ucfirst($task->prioritas ?? 'Normal') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="text-sm font-medium {{ $isNearing && $status == 'pending' ? 'text-red-600' : 'text-slate-600' }}">
                                {{ \Carbon\Carbon::parse($task->deadline_date)->translatedFormat('d M Y') }}
                            </div>
                            @if($isNearing && $status == 'pending')
                                <div class="text-xs text-red-500 mt-0.5">Segera Berakhir</div>
                            @endif
                        </td>
                        <td class="py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusBg }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="py-4 text-center">
                            <span class="font-bold {{ $nilai != '-' ? 'text-slate-800' : 'text-slate-400' }}">{{ $nilai }}</span>
                            @if($nilai != '-')
                                <span class="text-xs text-slate-400">/100</span>
                            @endif
                        </td>
                        <td class="py-4 text-right">
                            <a href="{{ route('pelaksana.penugasan.show', $task->id) }}" class="inline-block px-4 py-2 border {{ in_array($status, ['submitted', 'graded']) ? 'border-slate-200 text-slate-600 hover:bg-slate-50' : 'border-blue-500 text-blue-600 hover:bg-blue-50' }} rounded-lg text-sm font-bold transition-colors">
                                {{ in_array($status, ['submitted', 'graded']) ? 'Lihat' : 'Kerjakan' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-slate-400 text-sm">Belum ada tugas yang diberikan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SCRIPTS -->
    <!-- ========================================== -->
    <script>
        // Alpine.js Calendar Component
        document.addEventListener('alpine:init', () => {
            Alpine.data('calendarData', () => ({
                today: new Date(),
                currentMonth: new Date().getMonth(),
                currentYear: new Date().getFullYear(),
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                days: [],
                blankDays: [],
                tasks: @json($calendarTasks),
                selectedDate: null,
                
                initCal() {
                    this.generateCalendar();
                },
                
                nextMonth() {
                    if (this.currentMonth === 11) {
                        this.currentMonth = 0;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                    this.generateCalendar();
                },
                
                prevMonth() {
                    if (this.currentMonth === 0) {
                        this.currentMonth = 11;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                    this.generateCalendar();
                },
                
                generateCalendar() {
                    let firstDay = new Date(this.currentYear, this.currentMonth, 1).getDay();
                    let daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                    
                    // Adjust to start on Monday (0=Sun -> 6, 1=Mon -> 0, 2=Tue -> 1)
                    let startDay = firstDay === 0 ? 6 : firstDay - 1;
                    
                    this.blankDays = Array.from({ length: startDay });
                    this.days = [];
                    
                    for (let i = 1; i <= daysInMonth; i++) {
                        let dateString = this.currentYear + '-' + String(this.currentMonth + 1).padStart(2, '0') + '-' + String(i).padStart(2, '0');
                        let dayTasks = this.tasks.filter(t => {
                            if (!t.deadline_date) return false;
                            // Extract just the YYYY-MM-DD part from ISO or standard format
                            let d = t.deadline_date.split('T')[0].split(' ')[0];
                            return d === dateString;
                        });
                        
                        this.days.push({ 
                            date: i, 
                            isToday: i === this.today.getDate() && this.currentMonth === this.today.getMonth() && this.currentYear === this.today.getFullYear(),
                            hasTasks: dayTasks.length > 0,
                            tasks: dayTasks
                        });
                    }
                }
            }))
        });

        // Chart.js Donut
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('attendanceDonut').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Hadir Tepat Waktu', 'Terlambat', 'Izin / Sakit', 'Alpha'],
                    datasets: [{
                        data: [
                            {{ $attendanceBreakdown['hadir'] }}, 
                            {{ $attendanceBreakdown['terlambat'] }}, 
                            {{ $attendanceBreakdown['izin_sakit'] }}, 
                            {{ $attendanceBreakdown['alpha'] }}
                        ],
                        backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    cutout: '75%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.raw + ' Hari';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-pelaksana-layout>
