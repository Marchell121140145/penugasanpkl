<x-admin-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div class="welcome">
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Welcome Back, {{ Auth::user()->name ?? 'User' }}!</h1>
            <p class="text-slate-600">Overview sistem penugasan & absensi PKL</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative cursor-pointer">
                <span class="text-xl">🔔</span>
                <div class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-[18px] h-[18px] text-[0.7rem] flex items-center justify-center">5</div>
            </div>
            <div class="flex items-center gap-2.5 cursor-pointer relative" x-data="{ open: false }" @click.away="open = false" @click="open = !open">
                <!-- Gunakan inisial nama jika ada -->
                <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</div>
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
                        👤 Profile
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition-colors">
                            🚪 Log Out
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid - Penugasan & Absensi -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <!-- Statistik Penugasan -->
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-blue-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Penugasan</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">24</div>
            <div class="text-xs text-emerald-500">↑ 3 baru minggu ini</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Selesai</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">18</div>
            <div class="text-xs text-emerald-500">75% completion rate</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-amber-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Tertunda</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">4</div>
            <div class="text-xs text-red-500">↑ 1 dari kemarin</div>
        </div>
        
        <!-- Statistik Absensi -->
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-violet-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Kehadiran Hari Ini</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">89%</div>
            <div class="text-xs text-emerald-500">45/50 mahasiswa</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Hadir Tepat Waktu</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">42</div>
            <div class="text-xs text-emerald-500">93% on-time rate</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Ketidakhadiran</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">5</div>
            <div class="text-xs text-red-500">3 alpha, 2 izin</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl p-6 shadow-sm text-center">
            <h3 class="text-slate-800 mb-4 text-lg font-semibold">Statistik Penyelesaian Tugas</h3>
            <div class="h-[250px] relative">
                <canvas id="taskChart"></canvas>
            </div>
            <p class="text-slate-500 text-sm mt-2">
                Rata-rata penyelesaian: 4.2 hari per tugas
            </p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm text-center">
            <h3 class="text-slate-800 mb-4 text-lg font-semibold">Trend Kehadiran Bulanan</h3>
            <div class="h-[250px] relative">
                <canvas id="attendanceChart"></canvas>
            </div>
            <p class="text-slate-500 text-sm mt-2">
                Average attendance: 87% this month
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Task Completion Chart (Bar Chart)
            const taskCtx = document.getElementById('taskChart').getContext('2d');
            new Chart(taskCtx, {
                type: 'bar',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                    datasets: [{
                        label: 'Tugas Selesai',
                        data: [12, 19, 15, 17, 14],
                        backgroundColor: '#3b82f6',
                        borderRadius: 5,
                    }, {
                        label: 'Tugas Baru',
                        data: [15, 10, 12, 15, 8],
                        backgroundColor: '#e2e8f0',
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Attendance Trend Chart (Line Chart)
            const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(attendanceCtx, {
                type: 'line',
                data: {
                    labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                    datasets: [{
                        label: 'Tingkat Kehadiran (%)',
                        data: [85, 88, 87, 89],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
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
                            min: 80,
                            max: 100,
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6">
        <!-- Left Column -->
        <div>
            <!-- Recent Activity -->
            <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-slate-800 text-xl font-semibold">Aktivitas Terkini</h2>
                    <a href="#" class="text-blue-500 text-sm font-medium hover:underline">Lihat Semua</a>
                </div>
                <ul class="list-none">
                    <li class="flex items-center py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mr-4 text-blue-500 text-lg shrink-0">📝</div>
                        <div class="flex-1">
                            <h4 class="text-slate-800 text-sm font-semibold mb-1">Andi Wijaya mengumpulkan tugas</h4>
                            <p class="text-slate-500 text-xs">Analisis Requirement System - Nilai: A</p>
                        </div>
                        <div class="text-slate-400 text-xs text-right whitespace-nowrap ml-2">2 jam lalu</div>
                    </li>
                    <li class="flex items-center py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mr-4 text-blue-500 text-lg shrink-0">✅</div>
                        <div class="flex-1">
                            <h4 class="text-slate-800 text-sm font-semibold mb-1">Absensi pagi telah ditutup</h4>
                            <p class="text-slate-500 text-xs">45 mahasiswa hadir, 5 tidak hadir</p>
                        </div>
                        <div class="text-slate-400 text-xs text-right whitespace-nowrap ml-2">4 jam lalu</div>
                    </li>
                    <li class="flex items-center py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mr-4 text-blue-500 text-lg shrink-0">👥</div>
                        <div class="flex-1">
                            <h4 class="text-slate-800 text-sm font-semibold mb-1">Mahasiswa baru terdaftar</h4>
                            <p class="text-slate-500 text-xs">Budi Santoso - TI2024001</p>
                        </div>
                        <div class="text-slate-400 text-xs text-right whitespace-nowrap ml-2">1 hari lalu</div>
                    </li>
                </ul>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-slate-800 text-xl font-semibold">Quick Actions</h2>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-white border-2 border-slate-200 p-5 rounded-xl text-center cursor-pointer transition-all hover:border-blue-500 hover:-translate-y-1">
                        <div class="text-2xl mb-2 text-blue-500">📋</div>
                        <span class="text-slate-800 font-medium text-sm">Buat Penugasan</span>
                    </div>
                    <div class="bg-white border-2 border-slate-200 p-5 rounded-xl text-center cursor-pointer transition-all hover:border-blue-500 hover:-translate-y-1">
                        <div class="text-2xl mb-2 text-blue-500">📊</div>
                        <span class="text-slate-800 font-medium text-sm">Rekap Absensi</span>
                    </div>
                    <div class="bg-white border-2 border-slate-200 p-5 rounded-xl text-center cursor-pointer transition-all hover:border-blue-500 hover:-translate-y-1">
                        <div class="text-2xl mb-2 text-blue-500">👤</div>
                        <span class="text-slate-800 font-medium text-sm">Tambah User</span>
                    </div>
                    <div class="bg-white border-2 border-slate-200 p-5 rounded-xl text-center cursor-pointer transition-all hover:border-blue-500 hover:-translate-y-1">
                        <div class="text-2xl mb-2 text-blue-500">📈</div>
                        <span class="text-slate-800 font-medium text-sm">Generate Report</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <!-- Recent Tasks -->
            <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-slate-800 text-xl font-semibold">Penugasan Terbaru</h2>
                    <a href="#" class="text-blue-500 text-sm font-medium hover:underline">Lihat Semua</a>
                </div>
                <ul class="list-none">
                    <li class="border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <a href="{{ route('penugasan.show', 1) }}" class="flex justify-between items-center py-4 w-full h-full">
                            <div class="task-info">
                                <h4 class="text-slate-800 text-sm font-semibold mb-1">UI/UX Design</h4>
                                <p class="text-slate-500 text-xs">Due: 15 Des 2024 - 12 submissions</p>
                            </div>
                            <div class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-600">In Progress</div>
                        </a>
                    </li>
                    <li class="flex justify-between items-center py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <div class="task-info">
                            <h4 class="text-slate-800 text-sm font-semibold mb-1">Database Design</h4>
                            <p class="text-slate-500 text-xs">Due: 18 Des 2024 - 8 submissions</p>
                        </div>
                        <div class="px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-600">Pending</div>
                    </li>
                    <li class="flex justify-between items-center py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <div class="task-info">
                            <h4 class="text-slate-800 text-sm font-semibold mb-1">System Analysis</h4>
                            <p class="text-slate-500 text-xs">Due: 10 Des 2024 - 15 submissions</p>
                        </div>
                        <div class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-600">Completed</div>
                    </li>
                </ul>
            </div>

            <!-- Today's Attendance -->
            <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-slate-800 text-xl font-semibold">Absensi Hari Ini</h2>
                    <a href="#" class="text-blue-500 text-sm font-medium hover:underline">Detail</a>
                </div>
                <ul class="list-none">
                    <li class="flex justify-between items-center py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <div class="student-info">
                            <h4 class="text-slate-800 text-sm font-semibold mb-1">Siti Rahayu</h4>
                            <p class="text-slate-500 text-xs">Check-in: 07:45</p>
                        </div>
                        <div class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-600">Hadir</div>
                    </li>
                    <li class="flex justify-between items-center py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <div class="student-info">
                            <h4 class="text-slate-800 text-sm font-semibold mb-1">Budi Santoso</h4>
                            <p class="text-slate-500 text-xs">Check-in: 08:15</p>
                        </div>
                        <div class="px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-600">Terlambat</div>
                    </li>
                    <li class="flex justify-between items-center py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors rounded-lg px-2">
                        <div class="student-info">
                            <h4 class="text-slate-800 text-sm font-semibold mb-1">Andi Wijaya</h4>
                            <p class="text-slate-500 text-xs">Check-in: -</p>
                        </div>
                        <div class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600">Alpha</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-admin-layout>
