<x-admin-layout>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
            body {
                width: 100%;
                margin: 0;
                padding: 0;
                background: #ffffff !important;
                color: #0f172a !important;
                font-family: system-ui, -apple-system, sans-serif !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            /* Hide UI components like sidebar, navigation header, and action buttons */
            .no-print, 
            aside, 
            nav, 
            header,
            [role="navigation"],
            button,
            .sidebar {
                display: none !important;
            }
            /* Reset margins and wrappers to use the full printable A4 page width */
            .py-6, .px-4, .sm:px-6, .lg:px-8 {
                padding: 0 !important;
                margin: 0 !important;
            }
            /* Keep original centered layout from header, just clean background & border */
            .bg-white, .bg-slate-50 {
                background-color: #ffffff !important;
                box-shadow: none !important;
                border: none !important;
            }
            
            /* Center student dossier header and reduce margins */
            .flex.flex-col.md\:flex-row {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
                gap: 12px !important;
            }
            .flex-1.text-center.md\:text-left {
                text-align: center !important;
            }
            .flex.flex-col.md\:flex-row.md\:items-center.gap-3 {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 8px !important;
            }
            .flex.flex-wrap.justify-center.md\:justify-start {
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                gap: 8px !important;
                margin-top: 8px !important;
            }
            
            /* Shrink avatar size to fit cleanly on A4 Page 1 */
            .w-32.h-32 {
                width: 64px !important;
                height: 64px !important;
                border-radius: 12px !important;
                border-width: 2px !important;
            }
            .w-32.h-32 div {
                font-size: 24px !important;
            }
            
            .bg-white.rounded-3xl.p-8 {
                padding: 12px !important;
                margin-bottom: 16px !important;
                border-bottom: 2px solid #f1f5f9 !important;
                border-radius: 16px !important;
            }
            
            /* Put both charts vertically stacked (full width) and allow natural page flowing */
            .grid-cols-1.lg:grid-cols-2 {
                display: block !important;
                margin-bottom: 0 !important;
            }
            .grid-cols-1.lg:grid-cols-2 > div {
                display: block !important;
                padding: 16px 20px !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 16px !important;
                background: #ffffff !important;
                width: 100% !important;
                margin-bottom: 24px !important;
                page-break-inside: avoid !important;
            }
            /* Generous height so data points don't squash */
            .h-\[300px\] {
                height: 230px !important;
            }
            
            /* Detailed logs: Flow naturally without massive gaps */
            .grid-cols-1.gap-8 {
                margin-top: 0 !important;
                display: block !important;
            }
            .grid-cols-1.gap-8 .bg-white {
                border: 1px solid #e2e8f0 !important;
                border-radius: 16px !important;
                overflow: hidden !important;
            }
            
            /* Table optimization for print */
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            tr {
                page-break-inside: avoid !important;
            }
            th {
                background-color: #f8fafc !important;
                color: #475569 !important;
                font-weight: 700 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            th, td {
                padding: 10px 14px !important;
                border-bottom: 1px solid #e2e8f0 !important;
            }
            
            /* Hide absolute decoration blur spheres */
            .absolute.blur-3xl {
                display: none !important;
            }
        }
    </style>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs / Back Button -->
        <div class="mb-6 no-print">
            <a href="{{ route('laporan.index') }}" class="inline-flex items-center text-slate-500 hover:text-slate-800 transition-colors font-medium">
                <span class="mr-2"><i class="fi fi-rr-arrow-left"></i></span> Kembali ke Rekap Laporan
            </a>
        </div>

        <!-- Individual Header -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-red-50 rounded-full blur-3xl opacity-50 -mr-32 -mt-32"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                <!-- Avatar -->
                <div class="w-32 h-32 rounded-3xl overflow-hidden shadow-xl border-4 border-white shrink-0">
                    @if($pelaksana->avatar)
                        <img src="{{ route('file.avatar', $pelaksana->id) }}" alt="{{ $pelaksana->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-red-600 text-white text-4xl font-bold">
                            {{ substr($pelaksana->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2">
                        <h1 class="text-3xl font-black text-slate-800">{{ $pelaksana->name }}</h1>
                        <span class="px-3 py-1 bg-red-50 text-red-600 text-xs font-bold uppercase rounded-full self-center">
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
                        <div class="px-4 py-2 bg-emerald-50 rounded-2xl border border-emerald-100 text-sm">
                            <span class="text-emerald-500 block text-[10px] uppercase font-bold tracking-widest">Rata-rata Nilai</span>
                            <span class="text-emerald-700 font-extrabold text-base flex items-center gap-1">
                                <i class="fi fi-rr-graduation-cap"></i> {{ $avgGrade }}
                            </span>
                        </div>
                        <div class="px-4 py-2 bg-blue-50 rounded-2xl border border-blue-100 text-sm">
                            <span class="text-blue-500 block text-[10px] uppercase font-bold tracking-widest">Kehadiran</span>
                            <span class="text-blue-700 font-extrabold text-base flex items-center gap-1">
                                <i class="fi fi-rr-calendar-check"></i> {{ $attendancePercentage }}%
                            </span>
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
                    <i class="fi fi-rr-chart-line-up"></i> Tren Nilai Tugas
                </h3>
                <div class="h-[300px]">
                    <canvas id="gradeTrendChart"></canvas>
                </div>
            </div>

            <!-- Attendance Distribution -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fi fi-rr-chart-histogram"></i> Distribusi Kehadiran
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
            const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const gridColor = isDark ? 'rgba(75, 85, 99, 0.5)' : undefined;
            const tickColor = isDark ? '#9ca3af' : '#64748b';
            const legendColor = isDark ? '#d1d5db' : '#334155';

            // Custom plugins to show values/percentages directly in print & screen
            const lineDataLabelsPlugin = {
                id: 'lineDataLabels',
                afterDatasetsDraw(chart) {
                    const { ctx, data } = chart;
                    ctx.save();
                    ctx.font = 'bold 13px system-ui, -apple-system, sans-serif';
                    ctx.fillStyle = '#1e3a8a';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    
                    chart.getDatasetMeta(0).data.forEach((datapoint, index) => {
                        const value = data.datasets[0].data[index];
                        if (value !== null && value !== undefined) {
                            ctx.fillText(value, datapoint.x, datapoint.y - 10);
                        }
                    });
                    ctx.restore();
                }
            };

            const doughnutDataLabelsPlugin = {
                id: 'doughnutDataLabels',
                afterDatasetsDraw(chart) {
                    const { ctx, data } = chart;
                    ctx.save();
                    ctx.font = 'bold 12px system-ui, -apple-system, sans-serif';
                    ctx.fillStyle = '#ffffff';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    
                    const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                    chart.getDatasetMeta(0).data.forEach((datapoint, index) => {
                        const value = data.datasets[0].data[index];
                        if (value > 0 && total > 0) {
                            const percent = Math.round((value / total) * 100);
                            if (percent >= 5) {
                                const { x, y } = datapoint.tooltipPosition();
                                ctx.fillText(`${percent}%`, x, y);
                            }
                        }
                    });
                    ctx.restore();
                }
            };

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
                        pointBackgroundColor: isDark ? '#1f2937' : '#fff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 3,
                        pointRadius: 6
                    }]
                },
                plugins: [lineDataLabelsPlugin],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { min: 0, max: 100, border: { dash: [5, 5] }, grid: { color: gridColor }, ticks: { color: tickColor } },
                        x: { grid: { display: false }, ticks: { color: tickColor } }
                    }
                }
            });

            // Attendance Distribution Doughnut Chart
            const attCtx = document.getElementById('attendanceDistroChart').getContext('2d');
            const attData = [
                {{ $attStats['Hadir'] }},
                {{ $attStats['Terlambat'] }},
                {{ $attStats['Izin/Sakit'] }},
                {{ $attStats['Alpha'] }},
                {{ $attStats['Belum Mengisi'] }}
            ];
            const attLabels = ['Hadir', 'Terlambat', 'Izin/Sakit', 'Alpha', 'Pending'];
            const totalAtt = attData.reduce((a, b) => a + b, 0);

            // Format legend labels to display percentage alongside status
            const attLabelsWithPercent = attLabels.map((label, idx) => {
                if (totalAtt === 0) return `${label} (0%)`;
                const percent = Math.round((attData[idx] / totalAtt) * 100);
                return `${label} (${percent}%)`;
            });

            new Chart(attCtx, {
                type: 'doughnut',
                data: {
                    labels: attLabelsWithPercent,
                    datasets: [{
                        data: attData,
                        backgroundColor: ['#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#94a3b8'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                plugins: [doughnutDataLabelsPlugin],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { usePointStyle: true, padding: 12, color: legendColor } 
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    if (totalAtt === 0) return ` ${context.label}: ${value} hari (0%)`;
                                    const percent = Math.round((value / totalAtt) * 100);
                                    const cleanLabel = context.label.split(' (')[0];
                                    return ` ${cleanLabel}: ${value} hari (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>


