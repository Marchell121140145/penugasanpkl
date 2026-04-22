<x-admin-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">📊 Analytics Pelaksana</h1>
                <p class="text-slate-500 mt-1">Rekap nilai tugas dan persentase kehadiran seluruh pelaksana PKL.</p>
            </div>
            
            <!-- Filter & Search Section -->
            <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-2">
                <form action="{{ route('laporan.index') }}" method="GET" class="flex items-center gap-2">
                    @if(Auth::user()->role_id == 1)
                    <select name="divisi_id" onchange="this.form.submit()" class="bg-slate-50 border-none text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block w-full p-2.5 min-w-[180px]">
                        <option value="">Seluruh Divisi</option>
                        @foreach($allDivisi as $divisi)
                            <option value="{{ $divisi->id }}" {{ $divisiId == $divisi->id ? 'selected' : '' }}>
                                {{ $divisi->nama }}
                            </option>
                        @endforeach
                    </select>
                    @else
                    <div class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-xl whitespace-nowrap">
                        Divisi: {{ Auth::user()->divisi->nama ?? 'Umum' }}
                    </div>
                    @endif
                    
                    @if($divisiId && Auth::user()->role_id == 1)
                        <a href="{{ route('laporan.index') }}" class="p-2 text-slate-400 hover:text-red-500 transition-colors" title="Clear Filter">
                            <span class="text-xl">✕</span>
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Summary Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Total Pelaksana -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-3xl">👥</div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Pelaksana</h3>
                    <div class="text-3xl font-extrabold text-slate-800 mt-1">{{ $summary['total_students'] }}</div>
                    <div class="text-xs text-slate-400 mt-1">Aktif di sistem</div>
                </div>
            </div>

            <!-- Average Grade -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-3xl">⭐</div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Rata-rata Nilai</h3>
                    <div class="text-3xl font-extrabold text-slate-800 mt-1">{{ $summary['avg_grade'] }}</div>
                    <div class="text-xs text-emerald-500 mt-1">Skala 0-100</div>
                </div>
            </div>

            <!-- Average Attendance -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl">📅</div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Avg Kehadiran</h3>
                    <div class="text-3xl font-extrabold text-slate-800 mt-1">{{ $summary['avg_attendance'] }}%</div>
                    <div class="text-xs text-indigo-500 mt-1">Target harian 100%</div>
                </div>
            </div>
        </div>

        <!-- Detailed Analytics Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-xl font-bold text-slate-800">Detail Performa Pelaksana</h2>
                <div class="text-sm text-slate-500">
                    Menampilkan {{ $pelaksanas->count() }} data
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-white text-slate-400 text-xs uppercase tracking-widest font-bold">
                            <th class="px-6 py-4">Pelaksana</th>
                            <th class="px-6 py-4">Divisi</th>
                            <th class="px-6 py-4 text-center">Rata-rata Nilai</th>
                            <th class="px-6 py-4">Kehadiran</th>
                            <th class="px-6 py-4">Detail Absensi</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pelaksanas as $student)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <!-- User Info -->
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-slate-100 bg-slate-200 shrink-0">
                                        @if($student['avatar'])
                                            <img src="{{ asset('storage/' . $student['avatar']) }}" alt="{{ $student['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-blue-500 text-white font-bold">
                                                {{ substr($student['name'], 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 leading-tight">{{ $student['name'] }}</div>
                                        <div class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                            <span>📋 {{ $student['total_tasks'] }} Tugas</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- Division -->
                            <td class="px-6 py-5 text-sm font-medium text-slate-600">
                                <span class="bg-slate-100 px-3 py-1 rounded-full">{{ $student['divisi'] }}</span>
                            </td>
                            <!-- Average Grade -->
                            <td class="px-6 py-5">
                                <div class="flex flex-col items-center">
                                    <div class="text-lg font-black {{ $student['avg_grade'] >= 80 ? 'text-emerald-500' : ($student['avg_grade'] >= 60 ? 'text-amber-500' : 'text-rose-500') }}">
                                        {{ $student['avg_grade'] }}
                                    </div>
                                    <div class="flex gap-1 mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                        <div class="w-1.5 h-1.5 rounded-full {{ $i <= round($student['avg_grade']/20) ? 'bg-current opacity-100' : 'bg-slate-200' }}"></div>
                                        @endfor
                                    </div>
                                </div>
                            </td>
                            <!-- Attendance % -->
                            <td class="px-6 py-5">
                                <div class="w-full max-w-[120px]">
                                    <div class="flex justify-between items-end mb-1.5">
                                        <span class="text-xs font-bold text-slate-700">{{ $student['attendance_percentage'] }}%</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $student['attendance_percentage'] >= 90 ? 'bg-emerald-500' : ($student['attendance_percentage'] >= 75 ? 'bg-blue-500' : ($student['attendance_percentage'] >= 50 ? 'bg-amber-500' : 'bg-rose-500')) }}" 
                                             style="width: {{ $student['attendance_percentage'] }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <!-- Attendance Details -->
                            <td class="px-6 py-5">
                                <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-[10px] uppercase font-bold tracking-wider">
                                    <div class="flex items-center gap-1 text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        <span>Hadir: {{ $student['attendance_details']['hadir'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-amber-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        <span>Lembat: {{ $student['attendance_details']['terlambat'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-violet-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        <span>Izin: {{ $student['attendance_details']['izin'] + $student['attendance_details']['sakit'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-rose-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        <span>Alpha: {{ $student['attendance_details']['alpha'] }}</span>
                                    </div>
                                </div>
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('absensi.history', $student['id']) }}" class="p-2 bg-slate-50 text-slate-400 hover:bg-blue-50 hover:text-blue-500 rounded-xl transition-all" title="Riwayat Absensi">
                                        <span class="text-xl">📅</span>
                                    </a>
                                    <a href="{{ route('pelaksana.show', $student['id']) }}" class="p-2 bg-slate-50 text-slate-400 hover:bg-blue-50 hover:text-blue-500 rounded-xl transition-all" title="Profil & Tugas">
                                        <span class="text-xl">📊</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="text-6xl mb-4">🔍</div>
                                    <h3 class="text-xl font-bold text-slate-800">Tidak ada data</h3>
                                    <p class="text-slate-400">Belum ada pelaksana yang terdaftar atau sesuai kriteria.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Additional Rich Styling -->
    <style>
        .rounded-3xl { border-radius: 1.5rem; }
        .font-black { font-weight: 900; }
        @keyframes slideIn {
            from { transform: translateY(10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        tbody tr { animation: slideIn 0.3s ease-out forwards; }
        @for($i = 1; $i <= 10; $i++)
        tbody tr:nth-child({{$i}}) { animation-delay: {{$i * 0.05}}s; }
        @endfor
    </style>
</x-admin-layout>
