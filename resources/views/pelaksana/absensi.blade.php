<x-pelaksana-layout>
     <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Riwayat Absensi</h1>
            <p class="text-slate-600">Laporan kehadiran magang kamu</p>
        </div>
        <div>
            <!-- Self Check-in button idea, disabling for now unless requested -->
            <!-- <button class="bg-blue-500 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 hover:-translate-y-0.5 transition-all shadow-blue-200 shadow-lg">
                <span>📍</span> Check-In Sekarang
            </button> -->
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-emerald-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Hadir Tepat Waktu</div>
            <div class="text-2xl font-bold text-slate-800">{{ $stats['hadirTepatWaktu'] ?? 0 }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-amber-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Terlambat</div>
            <div class="text-2xl font-bold text-slate-800">{{ $stats['terlambat'] ?? 0 }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-blue-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Izin / Sakit</div>
            <div class="text-2xl font-bold text-slate-800">{{ $stats['izinSakit'] ?? 0 }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-red-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Alpha</div>
            <div class="text-2xl font-bold text-slate-800">{{ $stats['alpha'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl p-8 shadow-sm">
            <h2 class="text-slate-800 text-xl font-semibold">Daftar Penugasan Absensi</h2>
            <div class="flex gap-2">
                 <!-- Disabling static filter for now -->
            </div>
        </div>
        
        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Tanggal</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Waktu Check-in</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Status</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Lokasi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @if(session('success'))
                        <tr>
                            <td colspan="5" class="p-4 bg-emerald-50 text-emerald-700 font-medium text-center border-b border-emerald-200">
                                ✅ {{ session('success') }}
                            </td>
                        </tr>
                    @endif
                    @if(session('error'))
                        <tr>
                            <td colspan="5" class="p-4 bg-red-50 text-red-700 font-medium text-center border-b border-red-200">
                                ❌ {{ session('error') }}
                            </td>
                        </tr>
                    @endif
                    
                    @forelse($assignees as $assignee)
                        @php
                            $statusColor = 'bg-slate-100 text-slate-600';
                            if ($assignee->status == 'Hadir') $statusColor = 'bg-emerald-100 text-emerald-600';
                            elseif ($assignee->status == 'Terlambat') $statusColor = 'bg-amber-100 text-amber-600';
                            elseif ($assignee->status == 'Alpha') $statusColor = 'bg-red-100 text-red-600';
                            elseif ($assignee->status == 'Izin' || $assignee->status == 'Sakit') $statusColor = 'bg-blue-100 text-blue-600';

                            $isToday = $assignee->attendance->deadline->isToday();
                            $isBelumAbsen = $assignee->status == 'Belum Mengisi';
                        @endphp
                        <tr class="border-b border-slate-200 {{ $isBelumAbsen ? 'bg-blue-50/50 hover:bg-blue-50' : 'hover:bg-slate-50' }} transition-colors">
                            <td class="p-4 text-sm text-slate-800 {{ $isBelumAbsen ? 'font-medium' : '' }}">
                                {{ $assignee->attendance->deadline->locale('id')->isoFormat('dddd, D MMM Y') }}
                                <br><span class="text-xs text-slate-500">{{ $assignee->attendance->title ?? 'Absensi Rutin' }}</span>
                                @if($isToday)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Hari Ini</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-slate-800 font-mono">
                                {{ $assignee->check_in_time ? $assignee->check_in_time->format('H:i') . ' WIB' : '--:-- WIB' }}
                                <br><span class="text-xs text-slate-500">Batas: {{ $assignee->attendance->deadline->format('H:i') }} WIB</span>
                            </td>
                            <td class="p-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }} inline-block w-24 text-center {{ $isBelumAbsen ? 'border border-slate-200' : '' }}">{{ $assignee->status }}</span>
                            </td>
                            <td class="p-4 text-sm text-slate-600">{{ $assignee->lokasi ?? '-' }}</td>
                            <td class="p-4 text-sm">
                                @if($isBelumAbsen)
                                    <a href="{{ route('pelaksana.absensi.create', $assignee->id) }}" class="inline-flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md active:scale-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-camera"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                                        Absen Sekarang
                                    </a>
                                @else
                                    {{ $assignee->keterangan ?? '-' }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-8 text-center text-slate-500 font-medium">Kamu belum memiliki tugas absensi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-pelaksana-layout>
