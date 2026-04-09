<x-admin-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Data Pembimbing</h1>
            <p class="text-slate-600">Daftar seluruh pembimbing PKL</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative cursor-pointer">
                <span class="text-xl">🔔</span>
                <div class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-[18px] h-[18px] text-[0.7rem] flex items-center justify-center">2</div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-blue-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Pembimbing</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $totalPembimbing }}</div>
            <div class="text-xs text-slate-500">Terdaftar aktif</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Pelaksana Dibimbing</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $totalPelaksana }}</div>
            <div class="text-xs text-emerald-500">Rata-rata {{ $totalPembimbing > 0 ? round($totalPelaksana / $totalPembimbing) : 0 }} per pembimbing</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-amber-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Keseluruhan</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $totalTugas }}</div>
            <div class="text-xs text-amber-500">Total penugasan aktif & selesai</div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
        <div class="flex gap-4 w-full md:w-auto">
            <div class="text-sm font-medium text-slate-500 pt-2">Filter Pembimbing:</div>
        </div>
        <div class="flex flex-col md:flex-row gap-4 items-center w-full md:w-auto">
            <select id="divisiFilter" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-blue-500">
                <option value="">Semua Divisi</option>
                @foreach($divisis as $divisi)
                    <option value="{{ $divisi->nama }}">{{ $divisi->nama }}</option>
                @endforeach
            </select>
            <input type="text" id="searchInput" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-[250px] text-sm focus:outline-none focus:border-blue-500" placeholder="Cari nama pembimbing...">
        </div>
    </div>

    <!-- Pembimbing Table -->
    <div class="bg-white rounded-xl p-8 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-slate-800 text-xl font-semibold">Tabel Pembimbing</h2>
            <div class="text-slate-500 text-sm">
                Menampilkan {{ $pembimbings->count() }} pembimbing
            </div>
        </div>
        
        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">No</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Nama Pembimbing</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Divisi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">NIP</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Jumlah Pelaksana</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Tugas Dibuat</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembimbings as $index => $pembimbing)
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors pembimbing-row" data-divisi="{{ $pembimbing->divisi->nama ?? '-' }}" data-name="{{ $pembimbing->name }}">
                        <td class="p-4 text-sm text-slate-800 text-center">{{ $pembimbings->firstItem() + $index }}</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-3">
                                @php
                                    $initials = collect(explode(' ', $pembimbing->name))->map(function($segment) {
                                        return strtoupper(substr($segment, 0, 1));
                                    })->take(2)->join('');
                                    $colors = ['blue', 'pink', 'emerald', 'amber', 'violet'];
                                    $color = $colors[$pembimbing->id % count($colors)];
                                @endphp
                                <div class="w-9 h-9 rounded-full bg-{{ $color }}-100 flex items-center justify-center text-{{ $color }}-600 text-xs font-bold">{{ $initials }}</div>
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $pembimbing->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $pembimbing->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm"><span class="px-2 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-medium">{{ $pembimbing->divisi->nama ?? 'Belum ada divisi' }}</span></td>
                        <td class="p-4 text-sm text-slate-800">-</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-slate-800">{{ $pembimbing->jumlah_pelaksana }}</span>
                                <span class="text-xs text-slate-500">pelaksana</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex flex-col gap-1">
                                <span class="text-emerald-600 font-medium text-xs">✅ Selesai: {{ $pembimbing->tugas_selesai_count }}</span>
                                <span class="text-blue-500 font-medium text-xs">🔄 Aktif: {{ $pembimbing->tugas_aktif_count }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('pembimbing.show', $pembimbing->id) }}" class="px-3 py-1.5 rounded-md bg-slate-100 text-slate-800 text-xs font-medium hover:bg-slate-200 transition-colors hover:-translate-y-px">Detail</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-500">Tidak ada data pembimbing.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 pt-5 border-t border-slate-200">
            {{ $pembimbings->links() }}
        </div>
    </div>

    <script>
        // Search and Filter Functionality
        const searchInput = document.getElementById('searchInput');
        const divisiFilter = document.getElementById('divisiFilter');
        const rows = document.querySelectorAll('.pembimbing-row');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const divisiValue = divisiFilter.value;

            rows.forEach(row => {
                const name = row.getAttribute('data-name').toLowerCase();
                const divisi = row.getAttribute('data-divisi');

                const matchesSearch = name.includes(searchTerm);
                const matchesDivisi = divisiValue === '' || divisi === divisiValue;

                if (matchesSearch && matchesDivisi) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterTable);
        divisiFilter.addEventListener('change', filterTable);
    </script>
</x-admin-layout>
