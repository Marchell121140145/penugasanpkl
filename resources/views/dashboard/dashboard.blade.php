<x-admin-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-5">
        <div class="welcome">
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Welcome Back, {{ Auth::user()->name ?? 'User' }}!</h1>
            <p class="text-slate-600">
                @if($divisiId && $selectedDivisi)
                    Overview Statistik <strong>{{ $selectedDivisi->nama }}</strong>
                @else
                    Overview sistem penugasan & absensi PKL
                @endif
            </p>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2.5 cursor-pointer relative" x-data="{ open: false }" @click.away="open = false" @click="open = !open">
                <!-- Gunakan inisial nama jika ada -->
                @if(Auth::user()->avatar)
                    <img src="{{ route('file.avatar', Auth::user()->id) }}" class="w-10 h-10 rounded-full object-cover">
                @else
                    <div class="w-10 h-10 rounded-full bg-red-500 text-white flex items-center justify-center font-bold">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</div>
                @endif
                <span class="font-medium text-slate-700">{{ Auth::user()->name ?? 'Guest' }}</span>
                <span class="ml-2 text-xs text-slate-500">▼</span>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute top-[120%] right-0 w-48 bg-white rounded-lg shadow-lg z-50 text-left py-2 border border-slate-100"
                     style="display: none;">
                    
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-slate-800 hover:bg-slate-100 transition-colors">
                        <i class="fi fi-rr-user mr-2"></i> Profile
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition-colors">
                            <i class="fi fi-rr-exit mr-2"></i> Log Out
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl p-6 shadow-sm mb-5">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-slate-800 text-xl font-semibold">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('penugasan.create') }}" class="bg-white border-2 border-slate-200 p-5 rounded-xl text-center cursor-pointer transition-all hover:border-red-500 hover:-translate-y-1 no-underline">
                <div class="text-2xl mb-2 text-red-500"><i class="fi fi-rr-clipboard-list"></i></div>
                <span class="text-slate-800 font-medium text-sm">Buat Penugasan</span>
            </a>
            <a href="{{ route('absensi') }}" class="bg-white border-2 border-slate-200 p-5 rounded-xl text-center cursor-pointer transition-all hover:border-red-500 hover:-translate-y-1 no-underline">
                <div class="text-2xl mb-2 text-red-500"><i class="fi fi-rr-chart-histogram"></i></div>
                <span class="text-slate-800 font-medium text-sm">Rekap Absensi</span>
            </a>
            <a href="{{ route('pelaksana.list') }}" class="bg-white border-2 border-slate-200 p-5 rounded-xl text-center cursor-pointer transition-all hover:border-red-500 hover:-translate-y-1 no-underline">
                <div class="text-2xl mb-2 text-red-500"><i class="fi fi-rr-users"></i></div>
                <span class="text-slate-800 font-medium text-sm">Pelaksana</span>
            </a>
            <a href="{{ route('penugasan') }}" class="bg-white border-2 border-slate-200 p-5 rounded-xl text-center cursor-pointer transition-all hover:border-red-500 hover:-translate-y-1 no-underline">
                <div class="text-2xl mb-2 text-red-500"><i class="fi fi-rr-chart-line-up"></i></div>
                <span class="text-slate-800 font-medium text-sm">Semua Tugas</span>
            </a>
        </div>
    </div>

    <!-- Filter Bar (Admin Only) -->
    @if(Auth::user()->role_id == 1)
    <div class="bg-white p-4 rounded-xl shadow-sm mb-5 border border-slate-100 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800">Filter Statistik</h4>
                <p class="text-xs text-slate-500">Pilih divisi untuk melihat data spesifik</p>
            </div>
        </div>
        <form action="{{ route('dashboard') }}" method="GET" id="filterForm" class="flex items-center gap-2 flex-wrap">
            <select name="time_range" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block p-2.5 min-w-[150px]">
                <option value="today" {{ request('time_range') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="7_days" {{ request('time_range', '7_days') == '7_days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="this_month" {{ request('time_range') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="this_year" {{ request('time_range') == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
            </select>
            <select name="divisi_id" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block p-2.5 min-w-[180px]">
                <option value="">Seluruh Divisi</option>
                @foreach($allDivisi as $divisi)
                    <option value="{{ $divisi->id }}" {{ $divisiId == $divisi->id ? 'selected' : '' }}>
                        {{ $divisi->nama }}
                    </option>
                @endforeach
            </select>
            @if($divisiId || (request('time_range') && request('time_range') != '7_days'))
                <a href="{{ route('dashboard') }}" class="p-2.5 text-slate-400 hover:text-red-500 transition-colors" title="Clear Filter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="12"></line></svg>
                </a>
            @endif
        </form>
    </div>
    @elseif(Auth::user()->role_id == 2)
    <div class="bg-red-50 border border-red-100 p-4 rounded-xl mb-5 flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-red-800">Mode Pembimbing: {{ Auth::user()->divisi->nama ?? 'Umum' }}</h4>
                <p class="text-xs text-red-600">Menampilkan statistik untuk divisi anda.</p>
            </div>
        </div>
        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
            <select name="time_range" onchange="this.form.submit()" class="bg-white border border-red-200 text-red-800 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block p-2.5 min-w-[150px]">
                <option value="today" {{ request('time_range') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="7_days" {{ request('time_range', '7_days') == '7_days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="this_month" {{ request('time_range') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="this_year" {{ request('time_range') == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
            </select>
        </form>
    </div>
    @endif

    <!-- Stats Grid - Penugasan & Absensi -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-5">
        <!-- Statistik Penugasan -->
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Penugasan</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $totalTasks }}</div>
            <div class="text-xs {{ $newTasksThisWeek > 0 ? 'text-emerald-500' : 'text-slate-400' }}">
                @if($newTasksThisWeek > 0)
                    ↑ {{ $newTasksThisWeek }} baru minggu ini
                @else
                    Tidak ada tugas baru minggu ini
                @endif
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Selesai</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $completedTasks }}</div>
            <div class="text-xs {{ $completionRate >= 50 ? 'text-emerald-500' : 'text-amber-500' }}">{{ $completionRate }}% completion rate</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-amber-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Aktif/Tertunda</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $pendingTasks }}</div>
            <div class="text-xs text-amber-500">{{ $totalTasks > 0 ? round(($pendingTasks / $totalTasks) * 100) : 0 }}% dari total tugas</div>
        </div>
        
        <!-- Statistik Absensi -->
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-violet-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">{{ $attendancePanelTitle ?? 'Kehadiran' }}</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $attendanceRate }}%</div>
            <div class="text-xs {{ $hadirCount > 0 ? 'text-emerald-500' : 'text-slate-400' }}">{{ $hadirCount }}/{{ $totalTodayAssigned }} mahasiswa</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Hadir Tepat Waktu</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $hadirTepatWaktu }}</div>
            <div class="text-xs {{ $onTimeRate >= 80 ? 'text-emerald-500' : 'text-amber-500' }}">{{ $onTimeRate }}% on-time rate</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Ketidakhadiran</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $tidakHadir }}</div>
            <div class="text-xs text-red-500">{{ $alphaCount }} alpha, {{ $izinCount }} izin/sakit</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-5">
        <div class="bg-white rounded-xl p-6 shadow-sm text-center">
            <h3 class="text-slate-800 mb-4 text-lg font-semibold">Statistik Penyelesaian Tugas</h3>
            <div class="h-[250px] relative">
                <canvas id="taskChart"></canvas>
            </div>
            <p class="text-slate-500 text-sm mt-2">
                Rata-rata penyelesaian: {{ $avgCompletionDays }} hari per tugas
            </p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm text-center">
            <h3 class="text-slate-800 mb-4 text-lg font-semibold">{{ $attendanceChartTitle ?? 'Trend Kehadiran Bulanan' }}</h3>
            <div class="h-[250px] relative">
                <canvas id="attendanceChart"></canvas>
            </div>
            <p class="text-slate-500 text-sm mt-2">
                Rata-rata kehadiran: {{ $avgAttendanceMonth }}% bulan ini
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const gridColor = isDark ? 'rgba(75, 85, 99, 0.5)' : '#f1f5f9';
            const tickColor = isDark ? '#9ca3af' : '#64748b';
            const legendColor = isDark ? '#d1d5db' : '#334155';

            // Task Completion Chart (Bar Chart) — 7 hari terakhir
            const taskCtx = document.getElementById('taskChart').getContext('2d');
            new Chart(taskCtx, {
                type: 'bar',
                data: {
                    labels: @json($taskChartLabels),
                    datasets: [{
                        label: 'Tugas Dikumpulkan',
                        data: @json($taskChartSubmitted),
                        backgroundColor: '#3b82f6',
                        borderRadius: 5,
                    }, {
                        label: 'Tugas Baru',
                        data: @json($taskChartCreated),
                        backgroundColor: isDark ? '#4b5563' : '#e2e8f0',
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: legendColor }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor },
                            ticks: { stepSize: 1, color: tickColor }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: tickColor }
                        }
                    }
                }
            });

            // Attendance Trend Chart (Line Chart) — 4 minggu terakhir
            const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(attendanceCtx, {
                type: 'line',
                data: {
                    labels: @json($attendanceChartLabels),
                    datasets: [{
                        label: 'Tingkat Kehadiran (%)',
                        data: @json($attendanceChartData),
                        borderColor: '#10b981',
                        backgroundColor: isDark ? 'rgba(16, 185, 129, 0.15)' : 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: isDark ? '#1f2937' : '#ffffff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 100,
                            grid: { color: gridColor },
                            ticks: {
                                color: tickColor,
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: tickColor }
                        }
                    }
                }
            });
        });
    </script>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 items-stretch">
        <!-- Left Column -->
        <div class="flex flex-col h-full">
            <!-- Recent Activity -->
            <div class="bg-white rounded-xl p-6 shadow-sm flex-1 flex flex-col">
                <div class="flex justify-between items-center mb-5 shrink-0">
                    <h2 class="text-slate-800 text-xl font-semibold">Aktivitas Terkini</h2>
                </div>
                @if($recentActivities->count() > 0)
                <ul class="list-none flex-1 overflow-y-auto">
                    @foreach($recentActivities as $activity)
                    <li class="flex items-center py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mr-4 text-red-500 text-lg shrink-0">{{ $activity['icon'] }}</div>
                        <div class="flex-1">
                            <h4 class="text-slate-800 text-sm font-semibold mb-1">{{ $activity['title'] }}</h4>
                            <p class="text-slate-500 text-xs">{{ $activity['description'] }}</p>
                        </div>
                        <div class="text-slate-400 text-xs text-right whitespace-nowrap ml-2">{{ $activity['time_human'] }}</div>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center flex-1 flex flex-col items-center justify-center py-8">
                    <div class="text-5xl mb-4 text-slate-200"><i class="fi fi-rr-envelope-open"></i></div>
                    <p class="text-slate-400 text-sm">Belum ada aktivitas terkini</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column -->
        <div class="flex flex-col gap-6 h-full">
            <!-- Recent Tasks -->
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-slate-800 text-xl font-semibold">Penugasan Terbaru</h2>
                    <a href="{{ route('penugasan') }}" class="text-red-500 text-sm font-medium hover:underline">Lihat Semua</a>
                </div>
                @if($recentTasks->count() > 0)
                <ul class="list-none">
                    @foreach($recentTasks as $task)
                    <li class="border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <a href="{{ route('penugasan.show', $task['id']) }}" class="flex justify-between items-center py-4 w-full h-full no-underline">
                            <div class="task-info">
                                <h4 class="text-slate-800 text-sm font-semibold mb-1">{{ $task['judul'] }}</h4>
                                <p class="text-slate-500 text-xs">Due: {{ $task['deadline'] }} - {{ $task['submissions_count'] }}/{{ $task['assignees_count'] }} submission</p>
                            </div>
                            <div class="px-3 py-1 rounded-full text-xs font-medium {{ $task['status_class'] }}">{{ $task['status_label'] }}</div>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-3 text-slate-200"><i class="fi fi-rr-clipboard-list"></i></div>
                    <p class="text-slate-400 text-sm">Belum ada penugasan</p>
                </div>
                @endif
            </div>

            <!-- Today's Attendance -->
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-slate-800 text-xl font-semibold">Absensi Hari Ini</h2>
                    <a href="{{ route('absensi') }}" class="text-red-500 text-sm font-medium hover:underline">Detail</a>
                </div>
                @if($todayAttendanceDetail->count() > 0)
                <ul class="list-none">
                    @foreach($todayAttendanceDetail as $att)
                    <li class="flex justify-between items-center py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <div class="student-info">
                            <h4 class="text-slate-800 text-sm font-semibold mb-1">{{ $att['name'] }}</h4>
                            <p class="text-slate-500 text-xs">Check-in: {{ $att['check_in'] }}</p>
                        </div>
                        <div class="px-3 py-1 rounded-full text-xs font-medium {{ $att['status_class'] }}">{{ $att['status_label'] }}</div>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-3 text-slate-200"><i class="fi fi-rr-calendar"></i></div>
                    <p class="text-slate-400 text-sm">Tidak ada sesi absensi hari ini</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>

