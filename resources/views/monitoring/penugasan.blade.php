<x-admin-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Welcome Back {{ Auth::user()->name ?? 'Admin' }}</h1>
            <p class="text-slate-600">Monitoring penugasan PKL</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative cursor-pointer">
                <span class="text-xl">🔔</span>
                @if($lateTasks > 0)
                <div class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-[18px] h-[18px] text-[0.7rem] flex items-center justify-center">{{ $lateTasks }}</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-xl mb-6 text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl mb-6 text-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Penugasan</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $totalTasks }}</div>
            <div class="text-xs text-slate-500">Aktif dan selesai</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Selesai</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $completedTasks }}</div>
            <div class="text-xs text-slate-500">
                @if($totalTasks > 0)
                    {{ round(($completedTasks / $totalTasks) * 100) }}% completion rate
                @else
                    0% completion rate
                @endif
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-amber-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Aktif</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $activeTasks }}</div>
            <div class="text-xs text-slate-500">Dalam progres pengerjaan</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Keterlambatan</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $lateTasks }}</div>
            <div class="text-xs text-slate-500">Perlu tindak lanjut</div>
        </div>
    </div>

    <!-- Action Bar with Filters -->
    <form method="GET" action="{{ route('penugasan') }}" id="filterForm">
        {{-- Preserve sort params --}}
        <input type="hidden" name="sort_by" value="{{ request('sort_by', 'created_at') }}">
        <input type="hidden" name="sort_dir" value="{{ request('sort_dir', 'desc') }}">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
            <a href="{{ route('penugasan.create') }}" class="bg-red-500 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm">
                <span>📝</span> Buat Penugasan
            </a>
            <div class="flex flex-col md:flex-row gap-3 items-center w-full md:w-auto">
                <select name="status" onchange="document.getElementById('filterForm').submit()" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[140px] focus:outline-none focus:border-red-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Terlambat</option>
                </select>
                <select name="prioritas" onchange="document.getElementById('filterForm').submit()" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[140px] focus:outline-none focus:border-red-500">
                    <option value="">Semua Prioritas</option>
                    <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                </select>
                <select name="divisi_id" onchange="document.getElementById('filterForm').submit()" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[140px] focus:outline-none focus:border-red-500">
                    <option value="">Semua Divisi</option>
                    @foreach($divisis as $divisi)
                        <option value="{{ $divisi->id }}" {{ request('divisi_id') == $divisi->id ? 'selected' : '' }}>{{ $divisi->nama }}</option>
                    @endforeach
                </select>
                <div class="relative w-full md:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-[250px] text-sm focus:outline-none focus:border-red-500 pr-8" placeholder="Cari tugas atau mahasiswa...">
                    @if(request('search'))
                        <a href="{{ route('penugasan', request()->except('search', 'page')) }}" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-sm">✕</a>
                    @endif
                </div>
                <button type="submit" class="p-2.5 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 transition-colors px-4">Cari</button>
                @if(request()->hasAny(['status', 'prioritas', 'divisi_id', 'search']))
                    <a href="{{ route('penugasan') }}" class="p-2.5 border-2 border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition-colors px-4 whitespace-nowrap">Reset Filter</a>
                @endif
            </div>
        </div>
    </form>

    @php
        // Helper to build sort URL
        function taskSortUrl($column) {
            $currentSort = request('sort_by', 'created_at');
            $currentDir = request('sort_dir', 'desc');
            $newDir = ($currentSort === $column && $currentDir === 'asc') ? 'desc' : 'asc';
            return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_dir' => $newDir, 'page' => 1]);
        }
        function taskSortIcon($column) {
            $currentSort = request('sort_by', 'created_at');
            $currentDir = request('sort_dir', 'desc');
            if ($currentSort !== $column) return '<span class="text-slate-300 ml-1">↕</span>';
            return $currentDir === 'asc'
                ? '<span class="text-red-500 ml-1">↑</span>'
                : '<span class="text-red-500 ml-1">↓</span>';
        }
    @endphp

    <!-- Tasks Table -->
    <div class="bg-white rounded-xl p-8 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-slate-800 text-xl font-semibold">Tabel Tugas</h2>
            <div class="text-slate-500 text-sm">
                Menampilkan {{ $tasks->firstItem() ?? 0 }}-{{ $tasks->lastItem() ?? 0 }} dari {{ $tasks->total() }} tugas
            </div>
        </div>
        
        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ taskSortUrl('judul') }}" class="flex items-center hover:text-red-600 transition-colors">
                                Judul Tugas {!! taskSortIcon('judul') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Mahasiswa</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Divisi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ taskSortUrl('deadline_date') }}" class="flex items-center hover:text-red-600 transition-colors">
                                Deadline {!! taskSortIcon('deadline_date') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ taskSortUrl('prioritas') }}" class="flex items-center hover:text-red-600 transition-colors">
                                Prioritas {!! taskSortIcon('prioritas') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Progress</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">
                            <a href="{{ taskSortUrl('status') }}" class="flex items-center hover:text-red-600 transition-colors">
                                Status {!! taskSortIcon('status') !!}
                            </a>
                        </th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        @php
                            $totalSubmissions = $task->submissions->count();
                            $submittedCount = $task->submissions->whereIn('status', ['submitted', 'graded'])->count();
                            $progress = $totalSubmissions > 0 ? round(($submittedCount / $totalSubmissions) * 100) : 0;
                            
                            if ($progress >= 75) $progressColor = 'bg-emerald-500';
                            elseif ($progress >= 50) $progressColor = 'bg-amber-500';
                            else $progressColor = 'bg-red-500';

                            $isLate = $task->status === 'active' && $task->deadline_date->isPast();
                            if ($task->status === 'completed') {
                                $statusLabel = 'Selesai';
                                $statusClass = 'bg-emerald-100 text-emerald-600';
                            } elseif ($task->status === 'draft') {
                                $statusLabel = 'Draft';
                                $statusClass = 'bg-slate-100 text-slate-600';
                            } elseif ($isLate) {
                                $statusLabel = 'Terlambat';
                                $statusClass = 'bg-red-100 text-red-600';
                            } else {
                                $statusLabel = 'Aktif';
                                $statusClass = 'bg-red-100 text-red-600';
                            }

                            $prioritasColors = [
                                'tinggi' => 'text-red-500',
                                'sedang' => 'text-amber-500',
                                'rendah' => 'text-emerald-500',
                            ];
                        @endphp
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="p-4 text-sm">
                                <strong class="block text-slate-800">{{ $task->judul }}</strong>
                                <small class="text-slate-500">{{ Str::limit($task->deskripsi, 50) }}</small>
                            </td>
                            <td class="p-4 text-sm text-slate-800">
                                @if($task->assignees->count() > 0)
                                    <div class="flex flex-col gap-0.5">
                                        <span>{{ $task->assignees->first()->name }}</span>
                                        @if($task->assignees->count() > 1)
                                            <span class="text-xs text-slate-500">+{{ $task->assignees->count() - 1 }} lainnya</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Belum ditugaskan</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm">
                                @if($task->divisi)
                                    <span class="px-2 py-1 rounded-md bg-purple-50 text-purple-600 text-xs font-medium">{{ $task->divisi->nama }}</span>
                                @else
                                    <span class="text-slate-400 italic text-xs">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-slate-800">
                                <div class="flex flex-col">
                                    <span>{{ $task->deadline_date->translatedFormat('d M Y') }}</span>
                                    <span class="text-xs text-slate-500">{{ $task->deadline_time }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-sm font-semibold {{ $prioritasColors[$task->prioritas] ?? 'text-slate-500' }}">
                                {{ ucfirst($task->prioritas) }}
                            </td>
                            <td class="p-4 text-sm">
                                <div class="w-[100px] h-2 bg-slate-200 rounded-full overflow-hidden mb-1">
                                    <div class="h-full {{ $progressColor }} rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                                <small class="text-slate-600">{{ $submittedCount }}/{{ $totalSubmissions }} ({{ $progress }}%)</small>
                            </td>
                            <td class="p-4 text-sm">
                                <span class="px-3 py-1.5 rounded-full text-xs font-medium {{ $statusClass }} block w-fit text-center">{{ $statusLabel }}</span>
                            </td>
                            <td class="p-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('penugasan.show', $task->id) }}" class="px-3 py-1.5 rounded-md bg-slate-100 text-slate-800 text-xs font-medium hover:bg-slate-200 transition-colors hover:-translate-y-px text-center">Lihat</a>
                                    <a href="{{ route('penugasan.edit', $task->id) }}" class="px-3 py-1.5 rounded-md bg-red-100 text-red-600 text-xs font-medium hover:bg-red-200 transition-colors hover:-translate-y-px">Edit</a>
                                    <form action="{{ route('penugasan.destroy', $task->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus tugas ini secara permanen beserta semua filenya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-md bg-rose-100 text-rose-600 text-xs font-medium hover:bg-rose-200 transition-colors hover:-translate-y-px">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="text-4xl">📋</span>
                                    <div>
                                        @if(request()->hasAny(['status', 'prioritas', 'divisi_id', 'search']))
                                            <p class="font-medium text-slate-600">Tidak ada tugas yang cocok</p>
                                            <p class="text-sm">Coba ubah filter atau <a href="{{ route('penugasan') }}" class="text-red-500 hover:underline">reset filter</a>.</p>
                                        @else
                                            <p class="font-medium text-slate-600">Belum ada tugas</p>
                                            <p class="text-sm">Klik "Buat Penugasan" untuk membuat tugas pertama.</p>
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
        @if($tasks->hasPages())
        <div class="flex justify-between items-center mt-6 pt-5 border-t border-slate-200">
            <div class="text-slate-500 text-sm">
                Menampilkan {{ $tasks->firstItem() }}-{{ $tasks->lastItem() }} dari {{ $tasks->total() }} tugas
            </div>
            <div class="flex gap-2">
                @if($tasks->onFirstPage())
                    <span class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $tasks->previousPageUrl() }}" class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-700 hover:shadow-md transition-all">Sebelumnya</a>
                @endif

                @foreach($tasks->getUrlRange(1, $tasks->lastPage()) as $page => $url)
                    @if($page == $tasks->currentPage())
                        <span class="px-3 py-2 bg-red-500 rounded-lg text-sm text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-700 hover:shadow-md transition-all">{{ $page }}</a>
                    @endif
                @endforeach

                @if($tasks->hasMorePages())
                    <a href="{{ $tasks->nextPageUrl() }}" class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-700 hover:shadow-md transition-all">Selanjutnya</a>
                @else
                    <span class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>


