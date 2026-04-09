<x-admin-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Data Pelaksana</h1>
            <p class="text-slate-600">Daftar seluruh mahasiswa pelaksana PKL</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative cursor-pointer">
                <span class="text-xl">🔔</span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-blue-500">
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
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-violet-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Tugas</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $pelaksanas->sum('assigned_tasks_count') }}</div>
            <div class="text-xs text-violet-500">Semua tugas ditugaskan</div>
        </div>
    </div>

    <!-- Action Bar with Filters -->
    <form method="GET" action="{{ route('pelaksana.list') }}" id="filterForm">
        <input type="hidden" name="sort_by" value="{{ request('sort_by', 'name') }}">
        <input type="hidden" name="sort_dir" value="{{ request('sort_dir', 'asc') }}">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
            <div class="flex gap-4 w-full md:w-auto">
                <div class="text-sm font-medium text-slate-500 pt-2">Filter Pelaksana:</div>
            </div>
            <div class="flex flex-col md:flex-row gap-3 items-center w-full md:w-auto">
                <select name="divisi_id" onchange="document.getElementById('filterForm').submit()" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-blue-500">
                    <option value="">Semua Divisi</option>
                    @foreach($divisis as $divisi)
                        <option value="{{ $divisi->id }}" {{ request('divisi_id') == $divisi->id ? 'selected' : '' }}>{{ $divisi->nama }}</option>
                    @endforeach
                </select>
                <div class="relative w-full md:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-[250px] text-sm focus:outline-none focus:border-blue-500 pr-8" placeholder="Cari nama pelaksana...">
                    @if(request('search'))
                        <a href="{{ route('pelaksana.list', request()->except('search', 'page')) }}" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-sm">✕</a>
                    @endif
                </div>
                <button type="submit" class="p-2.5 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-colors px-4">Cari</button>
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
                ? '<span class="text-blue-500 ml-1">↑</span>'
                : '<span class="text-blue-500 ml-1">↓</span>';
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
                            <a href="{{ pelaksanaSortUrl('name') }}" class="flex items-center hover:text-blue-600 transition-colors">
                                Nama {!! pelaksanaSortIcon('name') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ pelaksanaSortUrl('email') }}" class="flex items-center hover:text-blue-600 transition-colors">
                                Email {!! pelaksanaSortIcon('email') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Divisi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ pelaksanaSortUrl('assigned_tasks_count') }}" class="flex items-center hover:text-blue-600 transition-colors">
                                Total Tugas {!! pelaksanaSortIcon('assigned_tasks_count') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ pelaksanaSortUrl('tugas_selesai_count') }}" class="flex items-center hover:text-blue-600 transition-colors">
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
                                'bg-indigo-100 text-indigo-600',
                                'bg-blue-100 text-blue-600',
                                'bg-pink-100 text-pink-600',
                                'bg-green-100 text-green-600',
                                'bg-amber-100 text-amber-600',
                                'bg-cyan-100 text-cyan-600',
                                'bg-rose-100 text-rose-600',
                                'bg-purple-100 text-purple-600',
                            ];
                            $colorIndex = $pelaksana->id % count($avatarColors);
                        @endphp
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="p-4 text-sm text-slate-800 text-center">{{ $pelaksanas->firstItem() + $index }}</td>
                            <td class="p-4 text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full {{ $avatarColors[$colorIndex] }} flex items-center justify-center text-xs font-bold">{{ $initials }}</div>
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
                            <td class="p-4 text-sm text-center">
                                <span class="px-2 py-1 rounded-md bg-blue-50 text-blue-600 text-xs font-medium">{{ $pelaksana->assigned_tasks_count }} tugas</span>
                            </td>
                            <td class="p-4 text-sm">
                                <div class="flex flex-col gap-1">
                                    <span class="text-emerald-600 font-medium text-xs">✅ Selesai: {{ $pelaksana->tugas_selesai_count }}</span>
                                    <span class="text-blue-500 font-medium text-xs">🔄 Aktif: {{ $pelaksana->tugas_aktif_count }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-sm">
                                <div class="flex gap-2">
                                    <button class="px-3 py-1.5 rounded-md bg-slate-100 text-slate-800 text-xs font-medium hover:bg-slate-200 transition-colors hover:-translate-y-px">Detail</button>
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
                                            <p class="text-sm">Coba ubah filter atau <a href="{{ route('pelaksana.list') }}" class="text-blue-500 hover:underline">reset filter</a>.</p>
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
                        <span class="px-3 py-2 bg-blue-500 rounded-lg text-sm text-white">{{ $page }}</span>
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
</x-admin-layout>
