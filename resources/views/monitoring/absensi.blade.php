<x-admin-layout>
    <div x-data="{ openAutoSettings: false }">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-slate-800 text-3xl font-bold mb-1">Monitoring Absensi</h1>
                <p class="text-slate-600">Kelola dan pantau kehadiran mahasiswa PKL</p>
            </div>
            <div class="flex items-center gap-4">

            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-200 flex items-start gap-3">
                <span class="text-xl"><i class="fi fi-rr-check-circle"></i></span>
                <div>
                    <h4 class="font-bold text-sm">Berhasil!</h4>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-xl border border-red-200 flex items-start gap-3">
                <span class="text-xl"><i class="fi fi-rr-cross-circle"></i></span>
                <div>
                    <h4 class="font-bold text-sm">Gagal!</h4>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Action Bar -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
            <div class="flex gap-4 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                <a href="{{ route('absensi.create') }}" class="bg-red-500 text-white px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap">
                    <span><i class="fi fi-rr-edit"></i></span> Buat Absensi
                </a>
                @if(auth()->user()->role_id == 1)
                <button @click="openAutoSettings = true" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap">
                    <span><i class="fi fi-rr-settings-sliders"></i></span> Pengaturan Otomatisasi
                </button>
                @endif
                <button class="bg-emerald-500 text-white px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap">
                    <span><i class="fi fi-rr-download"></i></span> Download
                </button>
                <button onclick="location.reload()" class="bg-white text-slate-800 border-2 border-slate-200 px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap hover:border-red-300">
                    <span><i class="fi fi-rr-refresh"></i></span> Refresh
                </button>
            </div>
            <div class="flex gap-4 items-center w-full md:w-auto">
                <input type="text" id="searchInput" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-[250px] text-sm focus:outline-none focus:border-red-500" placeholder="Cari judul sesi...">
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-slate-400">
                <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Sesi</h3>
                <div class="text-3xl font-bold text-slate-800 mb-1">{{ count($attendances) }}</div>
                <div class="text-xs text-slate-500">Sesi terdata</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
                <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Sudah Check-In</h3>
                <div class="text-3xl font-bold text-slate-800 mb-1">{{ collect($attendances)->sum('hadir_count') }}</div>
                <div class="text-xs text-emerald-500">Dari {{ collect($attendances)->sum('total_assignees') }} total peserta</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-blue-500">
                <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Sudah Check-Out</h3>
                <div class="text-3xl font-bold text-slate-800 mb-1">{{ collect($attendances)->sum('checkout_count') }}</div>
                <div class="text-xs text-blue-500">Selesai</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
                <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Belum Check-In</h3>
                <div class="text-3xl font-bold text-slate-800 mb-1">{{ collect($attendances)->sum('total_assignees') - collect($attendances)->sum('hadir_count') }}</div>
                <div class="text-xs text-red-500">Belum mengisi</div>
            </div>
        </div>

        <!-- Daftar Sesi Absensi -->
        <div class="bg-white rounded-xl p-8 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-slate-800 text-xl font-semibold">Daftar Sesi Absensi</h2>
                <div class="text-slate-500 text-sm">
                    Menampilkan <span class="font-medium text-slate-800">{{ count($attendances) }}</span> sesi terbaru
                </div>
            </div>
            
            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-left">
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Judul Sesi</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Batas Check-In</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Mulai Check-Out</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Pembuat</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Check-In</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Check-Out</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $att)
                            <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors session-row" data-title="{{ strtolower($att->title ?? 'absensi rutin') }}">
                                <td class="p-4 text-sm text-slate-800 font-medium">{{ $att->title ?? 'Absensi Rutin' }}</td>
                                <td class="p-4 text-sm text-slate-800 font-medium {{ $att->deadline < now() ? 'text-red-500' : 'text-emerald-500' }}">
                                    {{ $att->deadline->format('d M Y, H:i') }}
                                </td>
                                <td class="p-4 text-sm text-slate-800">
                                    @if($att->checkout_start)
                                        <span class="font-medium {{ $att->checkout_start < now() ? 'text-blue-500' : 'text-slate-400' }}">{{ $att->checkout_start->format('d M Y, H:i') }}</span>
                                    @else
                                        <span class="text-slate-400 italic text-xs">Bebas</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-slate-600">{{ $att->creator->name ?? 'Admin' }}</td>
                                <td class="p-4 text-sm text-slate-600">
                                    <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded text-xs font-medium">{{ $att->hadir_count }} / {{ $att->total_assignees }}</span>
                                </td>
                                <td class="p-4 text-sm text-slate-600">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-medium">{{ $att->checkout_count }} / {{ $att->total_assignees }}</span>
                                </td>
                                <td class="p-4 text-sm">
                                    <a href="{{ route('absensi.detail', $att->id) }}" class="px-3 py-1.5 rounded-md bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition-colors hover:-translate-y-px inline-block">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-500 font-medium">Belum ada sesi absensi yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(auth()->user()->role_id == 1)
        <!-- Modal Auto Settings -->
        <div x-show="openAutoSettings" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="openAutoSettings" class="fixed inset-0 transition-opacity bg-slate-900/50 backdrop-blur-sm" @click="openAutoSettings = false"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

                <div x-show="openAutoSettings" class="relative inline-block w-full max-w-xl px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:p-6"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                            <span><i class="fi fi-rr-settings-sliders text-blue-600"></i></span> Pengaturan Absensi Otomatis
                        </h3>
                        <button @click="openAutoSettings = false" class="text-slate-400 hover:text-slate-600"><i class="fi fi-rr-cross"></i></button>
                    </div>

                    <form action="{{ route('absensi.settings.update') }}" method="POST" onsubmit="return confirm('Simpan pengaturan otomatisasi ini? Pastikan Cron Job sudah berjalan di server agar otomatisasi ini berfungsi.')">
                        @csrf
                        <div class="space-y-6">
                            <!-- Toggle -->
                            <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                <div>
                                    <div class="font-bold text-slate-800">Aktifkan Auto-Generate</div>
                                    <div class="text-xs text-slate-500">Sistem akan otomatis membuat sesi absensi setiap jam 00:01 tengah malam.</div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enabled" class="sr-only peer" {{ $autoSettings['enabled'] ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <!-- Waktu -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1">Mulai Check-In</label>
                                        <input type="time" name="checkin_start" value="{{ $autoSettings['checkin_start'] }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <div class="text-[10px] text-slate-400 mt-1">Waktu terawal absen.</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1">Batas Check-In (Terlambat)</label>
                                        <input type="time" name="checkin_deadline" value="{{ $autoSettings['checkin_deadline'] }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <div class="text-[10px] text-slate-400 mt-1">Lewat jam ini ditandai terlambat.</div>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1">Mulai Check-Out</label>
                                        <input type="time" name="checkout_start" value="{{ $autoSettings['checkout_start'] }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <div class="text-[10px] text-slate-400 mt-1">Waktu diperbolehkan pulang.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hari Aktif -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Hari Aktif (Generate pada hari apa saja?)</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                    @php $hariArr = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp
                                    @foreach($hariArr as $hari)
                                    <label class="flex items-center gap-2 p-2 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                                        <input type="checkbox" name="days[]" value="{{ $hari }}" class="rounded text-blue-600 focus:ring-blue-500" {{ in_array($hari, $autoSettings['days']) ? 'checked' : '' }}>
                                        <span class="text-sm font-medium text-slate-700">{{ $hari }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" @click="openAutoSettings = false" class="px-4 py-2 bg-white text-slate-700 border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50 font-bold text-sm">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 font-bold text-sm">Simpan Pengaturan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        // Search functionality for session table
        const searchInput = document.getElementById('searchInput');
        const sessionRows = document.querySelectorAll('.session-row');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            sessionRows.forEach(row => {
                const title = row.getAttribute('data-title');
                row.style.display = title.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</x-admin-layout>
