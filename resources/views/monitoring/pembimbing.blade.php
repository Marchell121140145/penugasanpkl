<x-admin-layout>
    <div x-data="{ openAddPembimbing: false, openAddDivisi: false }">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Data Pembimbing</h1>
            <p class="text-slate-600">Daftar seluruh pembimbing PKL</p>
        </div>
        <div class="flex items-center gap-4">
            @if(auth()->user()->role_id == 1)
                <div class="flex gap-2">
                    <button @click="openAddDivisi = true" class="bg-white border-2 border-slate-200 hover:border-slate-300 text-slate-700 px-4 py-2.5 rounded-xl font-bold flex items-center gap-2 transition-all active:scale-95 text-sm">
                        <span class="text-lg">+</span> Divisi
                    </button>
                    <button @click="openAddPembimbing = true" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-red-200 transition-all active:scale-95 text-sm">
                        <span class="text-lg">+</span> Pembimbing
                    </button>
                </div>
            @endif

        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl shadow-sm flex items-center justify-between" x-data="{ show: true }" x-show="show">
            <div class="flex items-center">
                <span class="mr-3 text-xl"><i class="fi fi-rr-check-circle"></i></span>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700"><i class="fi fi-rr-cross"></i></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
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
            <select id="divisiFilter" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-red-500">
                <option value="">Semua Divisi</option>
                @foreach($divisis as $divisi)
                    <option value="{{ $divisi->nama }}">{{ $divisi->nama }}</option>
                @endforeach
            </select>
            <input type="text" id="searchInput" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-64 text-sm focus:outline-none focus:border-red-500" placeholder="Cari nama pembimbing...">
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
                                <span class="text-emerald-600 font-medium text-xs"><i class="fi fi-rr-check-circle text-[10px]"></i> Selesai: {{ $pembimbing->tugas_selesai_count }}</span>
                                <span class="text-red-500 font-medium text-xs"><i class="fi fi-rr-refresh text-[10px]"></i> Aktif: {{ $pembimbing->tugas_aktif_count }}</span>
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

    @if(auth()->user()->role_id == 1)
    <!-- Modal Add Pembimbing -->
    <div x-show="openAddPembimbing" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-slate-900/50 backdrop-blur-sm" @click="openAddPembimbing = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="openAddPembimbing" class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Tambah Pembimbing Baru</h3>
                    <button @click="openAddPembimbing = false" class="text-slate-400 hover:text-slate-600"><i class="fi fi-rr-cross"></i></button>
                </div>

                <form action="{{ route('pembimbing.store') }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-red-500 transition-colors" placeholder="Masukkan nama lengkap" maxlength="60" pattern="^[a-zA-Z\s]+$" title="Nama hanya boleh berisi huruf dan spasi.">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-red-500 transition-colors" placeholder="contoh@telkom.co.id">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Divisi (Opsional)</label>
                                <select name="divisi_id" class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-red-500 transition-colors bg-white">
                                    <option value="">Tidak ada divisi</option>
                                    @foreach($divisis as $divisi)
                                        <option value="{{ $divisi->id }}">{{ $divisi->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end pb-1">
                                <div class="px-4 py-2 bg-purple-50 text-purple-600 rounded-xl text-xs font-bold border border-purple-100 flex items-center gap-2">
                                    <span><i class="fi fi-rr-chalkboard-user"></i></span> Role: Pembimbing
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                                <input type="password" name="password" required class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-red-500 transition-colors" placeholder="Min. 8 karakter">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi</label>
                                <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-red-500 transition-colors" placeholder="Ulangi password">
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="openAddPembimbing = false" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-slate-800 transition-colors">Batal</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-red-200 transition-all active:scale-95">
                            Simpan Pembimbing
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Add Divisi -->
    <div x-show="openAddDivisi" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-slate-900/50 backdrop-blur-sm" @click="openAddDivisi = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="openAddDivisi" class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Tambah Divisi Baru</h3>
                    <button @click="openAddDivisi = false" class="text-slate-400 hover:text-slate-600"><i class="fi fi-rr-cross"></i></button>
                </div>

                <form action="{{ route('divisi.store') }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Divisi</label>
                            <input type="text" name="nama" required class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-red-500 transition-colors" placeholder="Contoh: Digital Service, Network, dsb.">
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="openAddDivisi = false" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-slate-800 transition-colors">Batal</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-red-200 transition-all active:scale-95">
                            Simpan Divisi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    </div>
</x-admin-layout>


