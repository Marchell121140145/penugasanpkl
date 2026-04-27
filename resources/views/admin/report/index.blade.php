<x-admin-layout>
    <style>
        @media print {
            .no-print, nav, sidebar, button, .filter-bar, .actions-cell {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
            }
            .content-container {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .card {
                break-inside: avoid;
                border: 1px solid #e2e8f0 !important;
            }
            .print-header {
                display: block !important;
                text-align: center;
                margin-bottom: 2rem;
            }
            .report-title {
                font-size: 24pt !important;
                color: black !important;
            }
        }
        .print-header { display: none; }
    </style>

    <div class="py-6 px-4 sm:px-6 lg:px-8 content-container">
        <!-- Print Header (Visible only when printing) -->
        <div class="print-header">
            <h1 class="report-title font-bold">LAPORAN ANALITIK PELAKSANA PKL</h1>
            <p>Periode: {{ $selectedMonth ? \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') : 'Semua Waktu' }}</p>
            <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>
        </div>

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 no-print">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">📊 Analytics Pelaksana</h1>
                <p class="text-slate-500 mt-1">Rekap nilai tugas dan persentase kehadiran.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('laporan.export', request()->query()) }}" class="flex items-center gap-2 px-4 py-2.5 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-all shadow-sm font-semibold text-sm">
                    <span class="text-lg">Excel</span>
                </a>
                <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all shadow-sm font-semibold text-sm">
                    <span class="text-lg">Print PDF</span>
                </button>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-3xl shadow-sm border border-slate-100 mb-8 no-print flex flex-wrap items-center gap-4">
            <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap items-center gap-4 w-full">
                <!-- Divisi Filter -->
                @if(Auth::user()->role_id == 1)
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Divisi</label>
                    <select name="divisi_id" onchange="this.form.submit()" class="w-full bg-slate-50 border-slate-100 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-red-500 p-2.5">
                        <option value="">Seluruh Divisi</option>
                        @foreach($allDivisi as $divisi)
                            <option value="{{ $divisi->id }}" {{ $divisiId == $divisi->id ? 'selected' : '' }}>
                                {{ $divisi->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Month Filter -->
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1 ml-1">Periode Bulan</label>
                    <input type="month" name="month" value="{{ $selectedMonth }}" onchange="this.form.submit()" class="w-full bg-slate-50 border-slate-100 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-red-500 p-2.5">
                </div>

                <div class="flex items-end">
                    <a href="{{ route('laporan.index') }}" class="p-2.5 text-slate-400 hover:text-red-500 transition-colors" title="Reset Filter">
                        <span class="text-xl font-bold">✕</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Summary Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md card">
                <div class="w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center text-3xl">👥</div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Pelaksana</h3>
                    <div class="text-3xl font-extrabold text-slate-800 mt-1">{{ $summary['total_students'] }}</div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md card">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-3xl">⭐</div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Avg Nilai</h3>
                    <div class="text-3xl font-extrabold text-slate-800 mt-1">{{ $summary['avg_grade'] }}</div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md card">
                <div class="w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center text-3xl">📅</div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Avg Kehadiran</h3>
                    <div class="text-3xl font-extrabold text-slate-800 mt-1">{{ $summary['avg_attendance'] }}%</div>
                </div>
            </div>
        </div>

        <!-- Detailed Analytics Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden card">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-xl font-bold text-slate-800">Detail Performa Pelaksana</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white text-slate-400 text-xs uppercase tracking-widest font-bold border-b border-slate-100">
                            <th class="px-6 py-4">Pelaksana</th>
                            <th class="px-6 py-4 text-center">Avg Nilai</th>
                            <th class="px-6 py-4">Kehadiran</th>
                            <th class="px-6 py-4">Detail Status</th>
                            <th class="px-6 py-4 text-right no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pelaksanas as $student)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full overflow-hidden border border-slate-100 bg-slate-100 shrink-0">
                                        @if($student['avatar'])
                                            <img src="{{ asset('storage/' . $student['avatar']) }}" alt="{{ $student['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-red-500 text-white font-bold text-sm">
                                                {{ substr($student['name'], 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 leading-tight">{{ $student['name'] }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $student['divisi'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col items-center">
                                    <div class="text-lg font-black {{ $student['avg_grade'] >= 80 ? 'text-emerald-500' : ($student['avg_grade'] >= 60 ? 'text-amber-500' : 'text-rose-500') }}">
                                        {{ $student['avg_grade'] }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="w-full max-w-[100px]">
                                    <div class="text-xs font-bold text-slate-700 mb-1">{{ $student['attendance_percentage'] }}%</div>
                                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-red-500" style="width: {{ $student['attendance_percentage'] }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="grid grid-cols-2 gap-x-2 gap-y-1 text-[9px] uppercase font-bold tracking-tight">
                                    <span class="text-emerald-600">H:{{ $student['attendance_details']['hadir'] }}</span>
                                    <span class="text-amber-500">T:{{ $student['attendance_details']['terlambat'] }}</span>
                                    <span class="text-red-500">I:{{ $student['attendance_details']['izin'] + $student['attendance_details']['sakit'] }}</span>
                                    <span class="text-rose-500">A:{{ $student['attendance_details']['alpha'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right no-print">
                                <a href="{{ route('laporan.show', $student['id']) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Analisis Lengkap">
                                    <span class="text-lg">📈</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400">Tidak ada data ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>


