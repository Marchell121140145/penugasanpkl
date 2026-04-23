<x-admin-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs / Back Button -->
        <div class="mb-6">
            <a href="{{ route('laporan.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
                <span class="mr-2">←</span> Kembali ke Rekap Laporan
            </a>
        </div>

        <!-- Individual Header -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50 -mr-32 -mt-32"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                <!-- Avatar -->
                <div class="w-32 h-32 rounded-3xl overflow-hidden shadow-xl border-4 border-white shrink-0">
                    @if($pelaksana->avatar)
                        <img src="{{ asset('storage/' . $pelaksana->avatar) }}" alt="{{ $pelaksana->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-blue-600 text-white text-4xl font-bold">
                            {{ substr($pelaksana->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2">
                        <h1 class="text-3xl font-black text-slate-800">{{ $pelaksana->name }}</h1>
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold uppercase rounded-full self-center">
                            {{ $pelaksana->divisi->nama ?? 'Umum' }}
                        </span>
                    </div>
                    <p class="text-slate-500 mb-4 max-w-2xl">Analisis performa mendalam berdasarkan penugasan dan absensi selama periode PKL.</p>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-4">
                        <div class="px-4 py-2 bg-slate-50 rounded-2xl border border-slate-100 text-sm">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-widest">Email</span>
                            <span class="text-slate-700 font-semibold">{{ $pelaksana->email }}</span>
                        </div>
                        <div class="px-4 py-2 bg-slate-50 rounded-2xl border border-slate-100 text-sm">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-widest">Pembimbing</span>
                            <span class="text-slate-700 font-semibold">{{ $pelaksana->pembimbing->name ?? 'Belum Ditentukan' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Print Action -->
                <div class="shrink-0 no-print">
                    <button onclick="window.print()" class="px-6 py-3 bg-slate-800 text-white rounded-2xl hover:bg-slate-900 transition-all font-bold shadow-lg">
                        Cetak Laporan
                    </button>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Grade Trend -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    📈 Tren Nilai Tugas
                </h3>
                <div class="h-[300px]">
                    <canvas id="gradeTrendChart"></canvas>
                </div>
            </div>

            <!-- Attendance Distribution -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    📊 Distribusi Kehadiran
                </h3>
                <div class="h-[300px] flex items-center justify-center">
                    <canvas id="attendanceDistroChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Logs -->
        <div class="grid grid-cols-1 gap-8">
            <!-- Task Log -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 bg-slate-50/50 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">Riwayat Penugasan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 bg-white">
                                <th class="px-6 py-4">Tugas</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($submissions as $sub)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-700 text-sm">{{ $sub->task->judul }}</div>
                                    <div class="text-[10px] text-slate-400 uppercase">{{ $sub->task->deadline_date->translatedFormat('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $sub->status == 'graded' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                        {{ $sub->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($sub->nilai !== null)
                                        <span class="font-black text-lg {{ $sub->nilai >= 80 ? 'text-emerald-500' : 'text-slate-800' }}">{{ $sub->nilai }}</span>
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Grade Trend Line Chart
            const gradeCtx = document.getElementById('gradeTrendChart').getContext('2d');
            new Chart(gradeCtx, {
                type: 'line',
                data: {
                    labels: @json($gradeLabels),
                    datasets: [{
                        label: 'Nilai Tugas',
                        data: @json($gradeValues),
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderWidth: 4,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 3,
                        pointRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { min: 0, max: 100, border: { dash: [5, 5] } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Attendance Distribution Doughnut Chart
            const attCtx = document.getElementById('attendanceDistroChart').getContext('2d');
            new Chart(attCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Hadir', 'Terlambat', 'Izin/Sakit', 'Alpha', 'Pending'],
                    datasets: [{
                        data: [
                            {{ $attStats['Hadir'] }},
                            {{ $attStats['Terlambat'] }},
                            {{ $attStats['Izin/Sakit'] }},
                            {{ $attStats['Alpha'] }},
                            {{ $attStats['Belum Mengisi'] }}
                        ],
                        backgroundColor: ['#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#94a3b8'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
