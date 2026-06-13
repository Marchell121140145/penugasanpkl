<x-pelaksana-layout>
    <div x-data="{ viewMode: localStorage.getItem('taskViewPref') || 'grid' }" x-init="$watch('viewMode', val => localStorage.setItem('taskViewPref', val))">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 md:mb-8 gap-4">
            <div>
                <h1 class="text-slate-800 dark:text-white text-2xl md:text-3xl font-bold mb-1">Daftar Tugas</h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm md:text-base">Pantau dan kerjakan tugas PKL kamu</p>
            </div>
            
            <!-- View Toggle -->
            <div class="flex bg-white dark:bg-slate-800 p-1 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700">
                <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-blue-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700'" class="px-3 py-1.5 rounded-md text-sm font-medium flex items-center gap-2 transition-all">
                    <span><i class="fi fi-rr-apps"></i></span> Grid
                </button>
                <button @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-blue-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700'" class="px-3 py-1.5 rounded-md text-sm font-medium flex items-center gap-2 transition-all">
                    <span><i class="fi fi-rr-list"></i></span> List
                </button>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
            <!-- Total Tasks -->
            <div class="bg-white dark:bg-slate-800 p-4 md:p-6 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-3 md:gap-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0">
                    <span class="text-lg md:text-xl"><i class="fi fi-rr-clipboard-list"></i></span>
                </div>
                <div class="min-w-0">
                    <p class="text-slate-500 dark:text-slate-400 text-[10px] md:text-sm font-medium uppercase tracking-wider">Total Tugas</p>
                    <h3 class="text-xl md:text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['total'] }}</h3>
                </div>
            </div>

            <!-- Completed Tasks -->
            <div class="bg-white dark:bg-slate-800 p-4 md:p-6 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-3 md:gap-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-50 dark:bg-emerald-900/30 rounded-full flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                    <span class="text-lg md:text-xl"><i class="fi fi-rr-check"></i></span>
                </div>
                <div class="min-w-0">
                    <p class="text-slate-500 dark:text-slate-400 text-[10px] md:text-sm font-medium uppercase tracking-wider">Selesai</p>
                    <h3 class="text-xl md:text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['selesai'] }}</h3>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="bg-white dark:bg-slate-800 p-4 md:p-6 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-3 md:gap-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-50 dark:bg-amber-900/30 rounded-full flex items-center justify-center text-amber-600 dark:text-amber-400 shrink-0">
                    <span class="text-lg md:text-xl"><i class="fi fi-rr-hourglass-end"></i></span>
                </div>
                <div class="min-w-0">
                    <p class="text-slate-500 dark:text-slate-400 text-[10px] md:text-sm font-medium uppercase tracking-wider">Belum Selesai</p>
                    <h3 class="text-xl md:text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['dalam_proses'] + $stats['belum_dikerjakan'] }}</h3>
                </div>
            </div>

            <!-- Late Tasks -->
            <div class="bg-white dark:bg-slate-800 p-4 md:p-6 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-3 md:gap-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-red-50 dark:bg-red-900/30 rounded-full flex items-center justify-center text-red-600 dark:text-red-400 shrink-0">
                    <span class="text-lg md:text-xl"><i class="fi fi-rr-triangle-warning"></i></span>
                </div>
                <div class="min-w-0">
                    <p class="text-slate-500 dark:text-slate-400 text-[10px] md:text-sm font-medium uppercase tracking-wider">Terlambat</p>
                    <h3 class="text-xl md:text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['terlambat'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('pelaksana.penugasan') }}" class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center mb-4 md:mb-6 bg-white dark:bg-slate-800 p-3 md:p-5 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 gap-3 md:gap-4">
            <div class="hidden sm:flex gap-4 w-auto">
                 <div class="text-sm font-medium text-slate-500 dark:text-slate-400 pt-2">Filter Tugas:</div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 md:gap-4 items-stretch sm:items-center w-full sm:w-auto">
                <select name="status" onchange="this.form.submit()" class="p-2.5 border-2 border-slate-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 dark:text-white cursor-pointer text-sm w-full sm:min-w-[150px] sm:w-auto focus:outline-none focus:border-blue-500 dark:focus:border-blue-500">
                    <option value="Semua Status" {{ request('status') == 'Semua Status' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Belum Dikerjakan" {{ request('status') == 'Belum Dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                    <option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <input type="text" name="search" value="{{ request('search') }}" onblur="this.form.submit()" class="p-2.5 border-2 border-slate-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 dark:text-white w-full sm:w-64 text-sm focus:outline-none focus:border-blue-500 dark:focus:border-blue-500" placeholder="Cari tugas...">
            </div>
        </form>

        <!-- Tasks Grid -->
        <div id="taskList" :class="viewMode === 'list' ? 'flex flex-col gap-4' : 'grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6'" class="mb-6">
            @forelse($tasks as $task)
                @php
                    $submission = $task->my_submission;
                    $isCompleted = in_array($submission->status ?? 'pending', ['submitted', 'graded']);
                    $isLate = !$isCompleted && \Carbon\Carbon::parse($task->deadline_date)->isPast();
                @endphp
                <!-- Task Card -->
                <div :class="viewMode === 'list' ? 'flex-row items-center p-4 lg:px-6' : 'flex-col'" class="task-card flex {{ $isCompleted ? 'opacity-75 hover:opacity-100' : '' }} bg-white dark:bg-slate-800 rounded-xl shadow-sm overflow-hidden border {{ $isLate ? 'border-red-200 dark:border-red-900/50' : 'border-slate-100 dark:border-slate-700' }} hover:shadow-md transition-shadow group">
                    <div :class="viewMode === 'list' ? 'p-0 w-full flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 lg:gap-8' : 'p-6 w-full flex flex-col'" class="w-full">
                        <div :class="viewMode === 'list' ? 'w-full lg:w-40 mb-0 flex-shrink-0 flex flex-col items-start' : 'mb-4 flex justify-between items-start'" class="task-header">
                            @if ($submission && $submission->status == 'graded')
                                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full">Dinilai</span>
                            @elseif($submission && $submission->status == 'returned')
                                <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 text-xs font-semibold rounded-full">Revisi</span>
                            @elseif ($isCompleted)
                                <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-xs font-semibold rounded-full">Selesai</span>
                            @elseif($isLate)
                                <span class="px-3 py-1 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 text-xs font-semibold rounded-full">Terlambat</span>
                            @else
                                <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-full">Baru</span>
                            @endif

                            <span :class="viewMode === 'list' ? 'text-left' : 'text-right flex-1 ml-2'" :style="viewMode === 'list' ? 'margin-top: 6px;' : ''" class="deadline-label text-slate-400 dark:text-slate-500 text-xs break-words">
                                @if($isCompleted)
                                    Submitted: {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d M') }}
                                @else
                                    Due: {{ \Carbon\Carbon::parse($task->deadline_date)->format('d M Y') }}
                                @endif
                            </span>
                        </div>
                        
                        <div :class="viewMode === 'list' ? 'flex-grow mb-0' : 'mb-4'" class="task-body">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-1" title="{{ $task->judul }}">{{ $task->judul }}</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2">{{ strip_tags($task->deskripsi) }}</p>
                        </div>
                        
                        <div :class="viewMode === 'list' ? 'w-full lg:w-48 mb-0 flex-shrink-0' : 'mb-4'" class="task-progress">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-600 dark:text-slate-400">Progress</span>
                                @if ($isCompleted)
                                    <span class="text-emerald-600 dark:text-emerald-400 font-medium">100%</span>
                                @elseif ($submission && $submission->status == 'working')
                                    <span class="text-blue-600 dark:text-blue-400 font-medium">50%</span>
                                @else
                                    <span class="text-slate-800 dark:text-slate-200 font-medium">0%</span>
                                @endif
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2">
                                @if ($isCompleted)
                                    <div class="bg-emerald-500 h-2 rounded-full" style="width: 100%"></div>
                                @elseif ($submission && $submission->status == 'working')
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 50%"></div>
                                @else
                                    <div class="bg-slate-300 dark:bg-slate-600 h-2 rounded-full" style="width: 0%"></div>
                                @endif
                            </div>
                        </div>

                        <div :class="viewMode === 'list' ? 'border-none pt-0 flex-shrink-0' : 'border-t border-slate-100 dark:border-slate-700 pt-4'" :style="viewMode === 'list' ? 'gap: 20px;' : ''" class="task-footer flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1 text-slate-400 dark:text-slate-500" title="Diskusi">
                                    <span class="text-sm"><i class="fi fi-rr-comment-alt"></i></span>
                                    <span class="text-xs font-medium">{{ $submission->comments_count ?? 0 }}</span>
                                </div>
                                @if($submission && $submission->status == 'graded')
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 uppercase font-bold leading-none">Nilai</span>
                                        <span class="text-lg font-black text-blue-600 dark:text-blue-400 leading-tight">{{ $submission->nilai ?? '-' }}</span>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('pelaksana.penugasan.show', $task->id) }}" class="px-4 py-2 {{ $isCompleted ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/50' : 'bg-blue-600 text-white hover:bg-blue-700' }} text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
                                {{ $submission && $submission->status == 'graded' ? 'Lihat Review' : ($isCompleted ? 'Detail' : 'Kerjakan') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 py-10 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-center border border-slate-100 dark:border-slate-700">
                    <p class="text-slate-500 dark:text-slate-400 text-lg mb-2">Tidak ada tugas yang ditemukan.</p>
                    <p class="text-sm text-slate-400 dark:text-slate-500">Silakan ubah filter pencarian Anda.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 text-center">
            {{ $tasks->links() }}
        </div>
    </div>
</x-pelaksana-layout>


