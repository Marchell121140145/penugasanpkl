<x-admin-layout>
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

    <!-- Action Bar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
        <div class="flex gap-4 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
            <a href="{{ route('absensi.create') }}" class="bg-red-500 text-white px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap">
                <span><i class="fi fi-rr-edit"></i></span> Buat Absensi
            </a>
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
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $attendances->sum('hadir_count') }}</div>
            <div class="text-xs text-emerald-500">Dari {{ $attendances->sum('total_assignees') }} total peserta</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-blue-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Sudah Check-Out</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $attendances->sum('checkout_count') }}</div>
            <div class="text-xs text-blue-500">Selesai</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Belum Check-In</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $attendances->sum('total_assignees') - $attendances->sum('hadir_count') }}</div>
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
