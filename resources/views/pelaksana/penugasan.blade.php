<x-pelaksana-layout>
    <style>
        .view-toggle-btn.active {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        
        /* List View Styles */
        .task-list-container.view-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .task-list-container.view-list .task-card {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 1rem 1.5rem;
        }

        .task-list-container.view-list .task-card .p-6 {
            padding: 0;
            width: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .task-list-container.view-list .task-card .task-header {
            width: 150px;
            margin-bottom: 0;
            flex-shrink: 0;
        }

        .task-list-container.view-list .task-card .task-body {
            flex-grow: 1;
        }

        .task-list-container.view-list .task-card .task-progress {
            width: 200px;
            margin-bottom: 0;
            flex-shrink: 0;
        }

        .task-list-container.view-list .task-card .task-footer {
            border-top: none;
            padding-top: 0;
            flex-shrink: 0;
        }

        @media (max-width: 1024px) {
            .task-list-container.view-list .task-card .p-6 {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            .task-list-container.view-list .task-card .task-header,
            .task-list-container.view-list .task-card .task-progress {
                width: 100%;
            }
        }
    </style>

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Daftar Tugas</h1>
            <p class="text-slate-600">Pantau dan kerjakan tugas PKL kamu</p>
        </div>
        
        <!-- View Toggle -->
        <div class="flex bg-white p-1 rounded-lg shadow-sm border border-slate-200">
            <button id="viewGrid" onclick="changeView('grid')" class="view-toggle-btn px-3 py-1.5 rounded-md text-sm font-medium flex items-center gap-2 transition-all">
                <span>Grid</span>
            </button>
            <button id="viewList" onclick="changeView('list')" class="view-toggle-btn px-3 py-1.5 rounded-md text-sm font-medium flex items-center gap-2 transition-all">
                <span>List</span>
            </button>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Tasks -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                <span class="text-xl">📋</span>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Total Tugas</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</h3>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600">
                <span class="text-xl">✅</span>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Selesai</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['selesai'] }}</h3>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center text-amber-600">
                <span class="text-xl">⏳</span>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Belum Selesai</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['dalam_proses'] + $stats['belum_dikerjakan'] }}</h3>
            </div>
        </div>

        <!-- Late Tasks -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-600">
                <span class="text-xl">⚠️</span>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Terlambat</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['terlambat'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('pelaksana.penugasan') }}" class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
        <div class="flex gap-4 w-full md:w-auto">
             <div class="text-sm font-medium text-slate-500 pt-2">Filter Tugas:</div>
        </div>
        <div class="flex flex-col md:flex-row gap-4 items-center w-full md:w-auto">
            <select name="status" onchange="this.form.submit()" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-blue-500">
                <option value="Semua Status" {{ request('status') == 'Semua Status' ? 'selected' : '' }}>Semua Status</option>
                <option value="Belum Dikerjakan" {{ request('status') == 'Belum Dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                <option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" onblur="this.form.submit()" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-[250px] text-sm focus:outline-none focus:border-blue-500" placeholder="Cari tugas...">
        </div>
    </form>

    <!-- Tasks Grid -->
    <div id="taskList" class="task-list-container grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
        @forelse($tasks as $task)
            @php
                $submission = $task->my_submission;
                $isCompleted = in_array($submission->status ?? 'pending', ['submitted', 'graded']);
                $isLate = !$isCompleted && \Carbon\Carbon::parse($task->deadline_date)->isPast();
            @endphp
            <!-- Task Card -->
            <div class="task-card {{ $isCompleted ? 'opacity-75 hover:opacity-100' : '' }} bg-white rounded-xl shadow-sm overflow-hidden border {{ $isLate ? 'border-red-200' : 'border-slate-100' }} hover:shadow-md transition-shadow group">
                <div class="p-6">
                    <div class="task-header flex justify-between items-start mb-4">
                        @if ($submission && $submission->status == 'graded')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Dinilai</span>
                        @elseif($submission && $submission->status == 'returned')
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">Revisi</span>
                        @elseif ($isCompleted)
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">Selesai</span>
                        @elseif($isLate)
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Terlambat</span>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-semibold rounded-full">Baru</span>
                        @endif

                        <span class="deadline-label text-slate-400 text-xs text-right break-words flex-1 ml-2">
                            @if($isCompleted)
                                Submitted: {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d M') }}
                            @else
                                Due: {{ \Carbon\Carbon::parse($task->deadline_date)->format('d M Y') }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="task-body mb-4">
                        <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors line-clamp-1" title="{{ $task->judul }}">{{ $task->judul }}</h3>
                        <p class="text-slate-500 text-sm line-clamp-2">{{ strip_tags($task->deskripsi) }}</p>
                    </div>
                    
                    <div class="task-progress mb-4">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-600">Progress</span>
                            @if ($isCompleted)
                                <span class="text-emerald-600 font-medium">100%</span>
                            @elseif ($submission && $submission->status == 'working')
                                <span class="text-blue-600 font-medium">50%</span>
                            @else
                                <span class="text-slate-800 font-medium">0%</span>
                            @endif
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            @if ($isCompleted)
                                <div class="bg-emerald-500 h-2 rounded-full" style="width: 100%"></div>
                            @elseif ($submission && $submission->status == 'working')
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 50%"></div>
                            @else
                                <div class="bg-slate-300 h-2 rounded-full" style="width: 0%"></div>
                            @endif
                        </div>
                    </div>

                    <div class="task-footer flex justify-between items-center pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1 text-slate-400" title="Diskusi">
                                <span class="text-sm">💬</span>
                                <span class="text-xs font-medium">{{ $submission->comments_count ?? 0 }}</span>
                            </div>
                            @if($submission && $submission->status == 'graded')
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-slate-400 uppercase font-bold leading-none">Nilai</span>
                                    <span class="text-lg font-black text-blue-600 leading-tight">{{ $submission->nilai ?? '-' }}</span>
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('pelaksana.penugasan.show', $task->id) }}" class="px-4 py-2 {{ $isCompleted ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-blue-600 text-white hover:bg-blue-700' }} text-sm font-medium rounded-lg transition-colors">
                            {{ $submission && $submission->status == 'graded' ? 'Lihat Review' : ($isCompleted ? 'Detail' : 'Kerjakan') }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 xl:col-span-3 py-10 bg-white rounded-xl shadow-sm text-center border border-slate-100">
                <p class="text-slate-500 text-lg mb-2">Tidak ada tugas yang ditemukan.</p>
                <p class="text-sm text-slate-400">Silakan ubah filter pencarian Anda.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 text-center">
        {{ $tasks->links() }}
    </div>

    <script>
        function changeView(viewType) {
            const container = document.getElementById('taskList');
            const gridBtn = document.getElementById('viewGrid');
            const listBtn = document.getElementById('viewList');
            
            if (viewType === 'list') {
                container.classList.add('view-list');
                container.classList.remove('grid', 'grid-cols-1', 'md:grid-cols-2', 'xl:grid-cols-3');
                listBtn.classList.add('active');
                gridBtn.classList.remove('active');
                localStorage.setItem('taskViewPref', 'list');
            } else {
                container.classList.remove('view-list');
                container.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2', 'xl:grid-cols-3');
                gridBtn.classList.add('active');
                listBtn.classList.remove('active');
                localStorage.setItem('taskViewPref', 'grid');
            }
        }

        // Initialize view based on preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('taskViewPref') || 'grid';
            changeView(savedView);
        });
    </script>
</x-pelaksana-layout>
