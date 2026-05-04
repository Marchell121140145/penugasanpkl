<x-admin-layout>
    <div x-data="{ openAddUser: false }">
    @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl shadow-sm flex items-center justify-between" x-data="{ show: true }" x-show="show">
            <div class="flex items-center">
                <span class="mr-3 text-xl">✅</span>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">✕</button>
        </div>
    @endif
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Data Pelaksana</h1>
            <p class="text-slate-600">Daftar seluruh mahasiswa pelaksana PKL</p>
        </div>
        <div class="flex items-center gap-4">
            @if(auth()->user()->role_id == 1)
                <button @click="openAddUser = true" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-red-200 transition-all active:scale-95">
                    <span class="text-xl">+</span> Tambah User
                </button>
            @endif
            <div class="relative cursor-pointer">
                <span class="text-xl">🔔</span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Pelaksana</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $totalPelaksana }}</div>
            <div class="text-xs text-slate-500">Terdaftar aktif</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Selesai</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $pelaksanas->sum('tugas_selesai_count') }}</div>
            <div class="text-xs text-emerald-500">Total pengumpulan selesai</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-amber-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Aktif</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $pelaksanas->sum('tugas_aktif_count') }}</div>
            <div class="text-xs text-amber-500">Sedang dikerjakan</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Tugas</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $pelaksanas->sum('assigned_tasks_count') }}</div>
            <div class="text-xs text-red-500">Semua tugas ditugaskan</div>
        </div>
    </div>

    <!-- Panel Persetujuan Pendaftaran (Khusus Admin) -->
    @if(auth()->check() && auth()->user()->role_id == 1 && isset($pendingUsers) && $pendingUsers->count() > 0)
    <div class="bg-amber-50 border-l-4 border-amber-500 rounded-xl p-6 shadow-sm mb-8">
        <div class="flex items-start gap-4">
            <div class="text-3xl">⚠️</div>
            <div class="flex-1">
                <h2 class="text-amber-800 text-lg font-bold mb-1">Pendaftaran Menunggu Persetujuan ({{ $pendingUsers->count() }})</h2>
                <p class="text-amber-700 text-sm mb-4">Pelaksana berikut telah mendaftar namun belum memiliki divisi. Mereka tidak dapat login sebelum Anda menempatkannya di suatu divisi.</p>
                
                <div class="bg-white rounded-lg border border-amber-200 overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-amber-100/50 text-amber-800">
                            <tr>
                                <th class="p-3 font-semibold">Nama & Email</th>
                                <th class="p-3 font-semibold">Durasi PKL</th>
                                <th class="p-3 font-semibold">Waktu Daftar</th>
                                <th class="p-3 font-semibold w-[350px]">Pilih Divisi & Setujui</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-100">
                            @foreach($pendingUsers as $pendingUser)
                            <tr>
                                <td class="p-3">
                                    <div class="font-bold text-slate-800">{{ $pendingUser->name }}</div>
                                    <div class="text-slate-500 text-xs">{{ $pendingUser->email }}</div>
                                </td>
                                <td class="p-3">
                                    @if($pendingUser->pkl_start && $pendingUser->pkl_end)
                                        <div class="text-slate-700 text-xs font-medium">
                                            {{ \Carbon\Carbon::parse($pendingUser->pkl_start)->format('d M Y') }}
                                        </div>
                                        <div class="text-slate-500 text-xs">
                                            s/d {{ \Carbon\Carbon::parse($pendingUser->pkl_end)->format('d M Y') }}
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic text-xs">Belum diatur</span>
                                    @endif
                                </td>
                                <td class="p-3 text-slate-600">
                                    {{ $pendingUser->created_at->diffForHumans() }}
                                </td>
                                <td class="p-3 bg-amber-50/30">
                                    <div class="flex gap-2">
                                        <form action="{{ route('pelaksana.approve', $pendingUser->id) }}" method="POST" class="flex flex-1 gap-2">
                                            @csrf
                                            <select name="divisi_id" required class="flex-1 px-3 py-1.5 border border-amber-300 rounded-md text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 bg-white">
                                                <option value="">Pilih Divisi...</option>
                                                @foreach($divisis as $divisi)
                                                    <option value="{{ $divisi->id }}">{{ $divisi->nama }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-1.5 rounded-md font-semibold text-sm transition-colors shadow-sm whitespace-nowrap">
                                                Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('pelaksana.reject', $pendingUser->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak dan menghapus pendaftaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-1.5 rounded-md font-semibold text-sm transition-colors shadow-sm">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Action Bar with Filters -->
    <form method="GET" action="{{ route('pelaksana.list') }}" id="filterForm">
        <input type="hidden" name="sort_by" value="{{ request('sort_by', 'name') }}">
        <input type="hidden" name="sort_dir" value="{{ request('sort_dir', 'asc') }}">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
            <div class="flex gap-4 w-full md:w-auto">
                <div class="text-sm font-medium text-slate-500 pt-2">Filter Pelaksana:</div>
            </div>
            <div class="flex flex-col md:flex-row gap-3 items-center w-full md:w-auto">
                <select name="divisi_id" onchange="document.getElementById('filterForm').submit()" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-red-500">
                    <option value="">Semua Divisi</option>
                    @foreach($divisis as $divisi)
                        <option value="{{ $divisi->id }}" {{ request('divisi_id') == $divisi->id ? 'selected' : '' }}>{{ $divisi->nama }}</option>
                    @endforeach
                </select>
                <div class="relative w-full md:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-[250px] text-sm focus:outline-none focus:border-red-500 pr-8" placeholder="Cari nama pelaksana...">
                    @if(request('search'))
                        <a href="{{ route('pelaksana.list', request()->except('search', 'page')) }}" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-sm">✕</a>
                    @endif
                </div>
                <button type="submit" class="p-2.5 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 transition-colors px-4">Cari</button>
                @if(request()->hasAny(['divisi_id', 'search']))
                    <a href="{{ route('pelaksana.list') }}" class="p-2.5 border-2 border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition-colors px-4 whitespace-nowrap">Reset Filter</a>
                @endif
            </div>
        </div>
    </form>

    @php
        function pelaksanaSortUrl($column) {
            $currentSort = request('sort_by', 'name');
            $currentDir = request('sort_dir', 'asc');
            $newDir = ($currentSort === $column && $currentDir === 'asc') ? 'desc' : 'asc';
            return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_dir' => $newDir, 'page' => 1]);
        }
        function pelaksanaSortIcon($column) {
            $currentSort = request('sort_by', 'name');
            $currentDir = request('sort_dir', 'asc');
            if ($currentSort !== $column) return '<span class="text-slate-300 ml-1">↕</span>';
            return $currentDir === 'asc'
                ? '<span class="text-red-500 ml-1">↑</span>'
                : '<span class="text-red-500 ml-1">↓</span>';
        }
    @endphp

    <!-- Pelaksana Table -->
    <div class="bg-white rounded-xl p-8 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-slate-800 text-xl font-semibold">Tabel Pelaksana</h2>
            <div class="text-slate-500 text-sm">
                Menampilkan {{ $pelaksanas->firstItem() ?? 0 }}-{{ $pelaksanas->lastItem() ?? 0 }} dari {{ $pelaksanas->total() }} pelaksana
            </div>
        </div>
        
        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm w-12">No</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ pelaksanaSortUrl('name') }}" class="flex items-center hover:text-red-600 transition-colors">
                                Nama {!! pelaksanaSortIcon('name') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ pelaksanaSortUrl('email') }}" class="flex items-center hover:text-red-600 transition-colors">
                                Email {!! pelaksanaSortIcon('email') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Divisi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm w-32">Durasi PKL</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ pelaksanaSortUrl('assigned_tasks_count') }}" class="flex items-center hover:text-red-600 transition-colors">
                                Total Tugas {!! pelaksanaSortIcon('assigned_tasks_count') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ pelaksanaSortUrl('tugas_selesai_count') }}" class="flex items-center hover:text-red-600 transition-colors">
                                Tugas {!! pelaksanaSortIcon('tugas_selesai_count') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelaksanas as $index => $pelaksana)
                        @php
                            $initials = collect(explode(' ', $pelaksana->name))
                                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                ->take(2)
                                ->join('');
                            
                            $avatarColors = [
                                'bg-red-100 text-red-600',
                                'bg-red-100 text-red-600',
                                'bg-pink-100 text-pink-600',
                                'bg-green-100 text-green-600',
                                'bg-amber-100 text-amber-600',
                                'bg-red-100 text-red-600',
                                'bg-rose-100 text-rose-600',
                                'bg-purple-100 text-purple-600',
                            ];
                            $colorIndex = $pelaksana->id % count($avatarColors);
                        @endphp
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="p-4 text-sm text-slate-800 text-center">{{ $pelaksanas->firstItem() + $index }}</td>
                            <td class="p-4 text-sm">
                                <div class="flex items-center gap-3">
                                    @if($pelaksana->avatar)
                                        <img src="{{ asset('storage/' . $pelaksana->avatar) }}" class="w-9 h-9 rounded-full object-cover">
                                    @else
                                        <div class="w-9 h-9 rounded-full {{ $avatarColors[$colorIndex] }} flex items-center justify-center text-xs font-bold">{{ $initials }}</div>
                                    @endif
                                    <div class="font-semibold text-slate-800">{{ $pelaksana->name }}</div>
                                </div>
                            </td>
                            <td class="p-4 text-sm text-slate-800">{{ $pelaksana->email }}</td>
                            <td class="p-4 text-sm">
                                @if($pelaksana->divisi)
                                    <span class="px-2 py-1 rounded-md bg-purple-50 text-purple-600 text-xs font-medium">{{ $pelaksana->divisi->nama }}</span>
                                @else
                                    <span class="text-slate-400 italic text-xs">Belum ditentukan</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm">
                                @if($pelaksana->pkl_start && $pelaksana->pkl_end)
                                    <div class="font-medium text-slate-700 text-[11px] whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($pelaksana->pkl_start)->format('d M') }} - {{ \Carbon\Carbon::parse($pelaksana->pkl_end)->format('d M y') }}
                                    </div>
                                    @php
                                        $end = \Carbon\Carbon::parse($pelaksana->pkl_end)->endOfDay();
                                        $isOverdue = $end->isPast();
                                        $daysLeft = now()->startOfDay()->diffInDays($end->startOfDay(), false);
                                    @endphp
                                    @if($isOverdue)
                                        <div class="text-[10px] text-red-500 font-bold mt-0.5">Berakhir</div>
                                    @else
                                        <div class="text-[10px] text-emerald-600 font-bold mt-0.5">Sisa {{ ceil($daysLeft) }} hari</div>
                                    @endif
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Belum diatur</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-center">
                                <span class="px-2 py-1 rounded-md bg-red-50 text-red-600 text-xs font-medium">{{ $pelaksana->assigned_tasks_count }} tugas</span>
                            </td>
                            <td class="p-4 text-sm">
                                <div class="flex flex-col gap-1">
                                    <span class="text-emerald-600 font-medium text-xs">✅ Selesai: {{ $pelaksana->tugas_selesai_count }}</span>
                                    <span class="text-red-500 font-medium text-xs">🔄 Aktif: {{ $pelaksana->tugas_aktif_count }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('pelaksana.show', $pelaksana->id) }}" class="px-3 py-1.5 rounded-md bg-slate-100 text-slate-800 text-xs font-medium hover:bg-slate-200 transition-colors hover:-translate-y-px">Detail</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="text-4xl">👤</span>
                                    <div>
                                        @if(request()->hasAny(['divisi_id', 'search']))
                                            <p class="font-medium text-slate-600">Tidak ada pelaksana yang cocok</p>
                                            <p class="text-sm">Coba ubah filter atau <a href="{{ route('pelaksana.list') }}" class="text-red-500 hover:underline">reset filter</a>.</p>
                                        @else
                                            <p class="font-medium text-slate-600">Belum ada data pelaksana</p>
                                            <p class="text-sm">Pelaksana akan muncul setelah user dengan role "pelaksana" terdaftar.</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($pelaksanas->hasPages())
        <div class="flex justify-between items-center mt-6 pt-5 border-t border-slate-200">
            <div class="text-slate-500 text-sm">
                Menampilkan {{ $pelaksanas->firstItem() }}-{{ $pelaksanas->lastItem() }} dari {{ $pelaksanas->total() }} pelaksana
            </div>
            <div class="flex gap-2">
                @if($pelaksanas->onFirstPage())
                    <span class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $pelaksanas->previousPageUrl() }}" class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-700 hover:shadow-md transition-all">Sebelumnya</a>
                @endif

                @foreach($pelaksanas->getUrlRange(1, $pelaksanas->lastPage()) as $page => $url)
                    @if($page == $pelaksanas->currentPage())
                        <span class="px-3 py-2 bg-red-500 rounded-lg text-sm text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-700 hover:shadow-md transition-all">{{ $page }}</a>
                    @endif
                @endforeach

                @if($pelaksanas->hasMorePages())
                    <a href="{{ $pelaksanas->nextPageUrl() }}" class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-700 hover:shadow-md transition-all">Selanjutnya</a>
                @else
                    <span class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
        @endif
    </div>

    @if(auth()->user()->role_id == 1)
    <!-- Modal Add User -->
    <div x-show="openAddUser" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity bg-slate-900/50 backdrop-blur-sm" @click="openAddUser = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Tambah User Baru</h3>
                    <button @click="openAddUser = false" class="text-slate-400 hover:text-slate-600">✕</button>
                </div>

                <form action="{{ route('pelaksana.store') }}" method="POST">
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
                                <div class="px-4 py-2 bg-red-50 text-red-600 rounded-xl text-xs font-bold border border-red-100 flex items-center gap-2">
                                    <span>👤</span> Role: Pelaksana
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
                        <button type="button" @click="openAddUser = false" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-slate-800 transition-colors">Batal</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-red-200 transition-all active:scale-95">
                            Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</x-admin-layout>


