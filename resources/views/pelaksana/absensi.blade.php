<x-pelaksana-layout>
     <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Riwayat Absensi</h1>
            <p class="text-slate-600">Laporan kehadiran magang kamu (Check-In & Check-Out)</p>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-emerald-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Hadir Tepat Waktu</div>
            <div class="text-2xl font-bold text-slate-800">{{ $stats['hadirTepatWaktu'] ?? 0 }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-amber-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Terlambat</div>
            <div class="text-2xl font-bold text-slate-800">{{ $stats['terlambat'] ?? 0 }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-blue-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Selesai (Check-Out)</div>
            <div class="text-2xl font-bold text-slate-800">{{ $stats['selesai'] ?? 0 }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-red-500">
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
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Check-In</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Check-Out</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Status</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(session('success'))
                        <tr>
                            <td colspan="5" class="p-4 bg-emerald-50 text-emerald-700 font-medium text-center border-b border-emerald-200">
                                <i class="fi fi-rr-check-circle mr-1"></i> {{ session('success') }}
                            </td>
                        </tr>
                    @endif
                    @if(session('error'))
                        <tr>
                            <td colspan="5" class="p-4 bg-red-50 text-red-700 font-medium text-center border-b border-red-200">
                                <i class="fi fi-rr-cross-circle mr-1"></i> {{ session('error') }}
                            </td>
                        </tr>
                    @endif
                    
                    @forelse($assignees as $assignee)
                        @php
                            $statusColor = 'bg-slate-100 text-slate-600';
                            if (in_array($assignee->status, ['Hadir', 'Hadir - Selesai'])) $statusColor = 'bg-emerald-100 text-emerald-600';
                            elseif (in_array($assignee->status, ['Terlambat', 'Terlambat - Selesai'])) $statusColor = 'bg-amber-100 text-amber-600';
                            elseif ($assignee->status == 'Alpha') $statusColor = 'bg-red-100 text-red-600';
                            elseif ($assignee->status == 'Izin' || $assignee->status == 'Sakit') $statusColor = 'bg-red-100 text-red-600';

                            $isToday = $assignee->attendance->deadline->isToday();
                            $isBelumAbsen = $assignee->status == 'Belum Mengisi';
                            $isCheckedIn = in_array($assignee->status, ['Hadir', 'Terlambat']);
                            $isSelesai = in_array($assignee->status, ['Hadir - Selesai', 'Terlambat - Selesai']);

                            // Check if checkout is available
                            $canCheckout = $isCheckedIn;
                            if ($canCheckout && $assignee->attendance->checkout_start && $assignee->attendance->checkout_start > now()) {
                                $canCheckout = false;
                            }
                        @endphp
                        <tr class="border-b border-slate-200 {{ $isBelumAbsen ? 'bg-red-50/50 hover:bg-red-50' : ($isCheckedIn ? 'bg-blue-50/30 hover:bg-blue-50/50' : 'hover:bg-slate-50') }} transition-colors">
                            <td class="p-4 text-sm text-slate-800 {{ $isBelumAbsen ? 'font-medium' : '' }}">
                                {{ $assignee->attendance->deadline->locale('id')->isoFormat('dddd, D MMM Y') }}
                                <br><span class="text-xs text-slate-500">{{ $assignee->attendance->title ?? 'Absensi Rutin' }}</span>
                                @if($isToday)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Hari Ini</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-slate-800">
                                @if($assignee->check_in_time)
                                    <span class="font-mono text-emerald-600 font-medium">{{ $assignee->check_in_time->format('H:i') }}</span>
                                    <span class="text-xs text-slate-400">WIB</span>
                                @else
                                    <span class="font-mono text-slate-400">--:-- WIB</span>
                                @endif
                                <br><span class="text-xs text-slate-500">Batas: {{ $assignee->attendance->deadline->format('H:i') }} WIB</span>
                            </td>
                            <td class="p-4 text-sm text-slate-800">
                                @if($assignee->check_out_time)
                                    <span class="font-mono text-blue-600 font-medium">{{ $assignee->check_out_time->format('H:i') }}</span>
                                    <span class="text-xs text-slate-400">WIB</span>
                                @else
                                    <span class="font-mono text-slate-400">--:-- WIB</span>
                                @endif
                                @if($assignee->attendance->checkout_start)
                                    <br><span class="text-xs text-slate-500">Mulai: {{ $assignee->attendance->checkout_start->format('H:i') }} WIB</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }} inline-block text-center whitespace-nowrap {{ $isBelumAbsen ? 'border border-slate-200' : '' }}">{{ $assignee->status }}</span>
                            </td>
                            <td class="p-4 text-sm">
                                @if($isBelumAbsen)
                                    <a href="{{ route('pelaksana.absensi.create', $assignee->id) }}" class="inline-flex items-center justify-center gap-1.5 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md active:scale-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                        Check-In
                                    </a>
                                @elseif($isCheckedIn && $canCheckout)
                                    <a href="{{ route('pelaksana.absensi.checkout', $assignee->id) }}" class="inline-flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md active:scale-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                        Check-Out
                                    </a>
                                @elseif($isCheckedIn && !$canCheckout)
                                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-500 bg-slate-100 px-3 py-2 rounded-lg">
                                        <i class="fi fi-rr-hourglass-start"></i> Check-out mulai {{ $assignee->attendance->checkout_start->format('H:i') }}
                                    </span>
                                @elseif($isSelesai)
                                    <span class="inline-flex items-center gap-1.5 text-xs text-emerald-600 bg-emerald-50 px-3 py-2 rounded-lg font-medium">
                                        <i class="fi fi-rr-check"></i> Selesai
                                    </span>
                                @else
                                    @if($assignee->keterangan)
                                        <div class="text-xs text-slate-500 bg-slate-50 p-2 rounded border border-slate-100 italic w-48">
                                            <span class="font-semibold text-slate-600 block mb-0.5"><i class="fi fi-rr-comment-alt mr-1"></i> Keterangan:</span>
                                            {{ $assignee->keterangan }}
                                        </div>
                                    @else
                                        <span class="text-slate-400 text-xs italic">- Tidak ada aksi -</span>
                                    @endif
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
