<x-admin-layout>
    <div class="w-full pb-12">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
            <div>
                <a href="{{ route('penugasan') }}" class="text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 mb-2 inline-flex items-center gap-2 font-medium transition-colors">
                    <i class="fi fi-rr-arrow-left"></i> Kembali ke Daftar Tugas
                </a>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">Detail Penugasan</h1>
                <p class="text-slate-600 dark:text-slate-400">Monitoring progres tugas mahasiswa</p>
            </div>
            <div class="flex items-center gap-3">
                 <a href="{{ route('penugasan.edit', $task->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-sm shadow-blue-500/30 transition-all flex items-center gap-2">
                     <i class="fi fi-rr-edit"></i> Edit Tugas
                 </a>
                 <form action="{{ route('penugasan.destroy', $task->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus tugas ini? Semua data terkait akan ikut terhapus.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-50 hover:bg-red-500 text-red-600 hover:text-white dark:bg-red-500/10 dark:hover:bg-red-600 dark:text-red-500 dark:hover:text-white px-5 py-2.5 rounded-xl font-medium transition-all flex items-center gap-2">
                        <i class="fi fi-rr-trash"></i> Hapus
                    </button>
                 </form>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800 rounded-xl p-4 mb-6 flex items-center gap-2 font-medium">
                <i class="fi fi-rr-check-circle text-lg"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800 rounded-xl p-4 mb-6 flex items-center gap-2 font-medium">
                <i class="fi fi-rr-cross-circle text-lg"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Task Info Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-8">
            <div class="p-6 md:p-8">
                <div class="flex flex-col lg:flex-row justify-between items-start gap-6 mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white mb-4">{{ $task->judul }}</h1>
                        <div class="flex flex-wrap gap-x-8 gap-y-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Total Ditugaskan</span>
                                <span class="font-medium text-slate-800 dark:text-white">{{ $totalAssignees }} Mahasiswa</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Deadline</span>
                                <span class="font-medium text-slate-800 dark:text-white flex items-center gap-1"><i class="fi fi-rr-calendar text-slate-400"></i> {{ $task->deadline_date->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Waktu</span>
                                <span class="font-medium text-slate-800 dark:text-white flex items-center gap-1"><i class="fi fi-rr-clock text-slate-400"></i> {{ $task->deadline_time }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Prioritas</span>
                                @php
                                    $prioritasColors = [
                                        'tinggi' => 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20',
                                        'sedang' => 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20',
                                        'rendah' => 'text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $prioritasColors[$task->prioritas] ?? 'bg-slate-100 text-slate-800' }}">{{ ucfirst($task->prioritas) }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Jenis Tugas</span>
                                <span class="font-medium text-slate-800 dark:text-white">{{ ucfirst($task->jenis_tugas) }}</span>
                            </div>
                            @if($task->divisi)
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Divisi</span>
                                <span class="font-medium text-slate-800 dark:text-white">{{ $task->divisi->nama }}</span>
                            </div>
                            @endif
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Status</span>
                                @php
                                    $isLate = $task->status === 'active' && $task->deadline_date->isPast();
                                    if ($task->status === 'completed') {
                                        $statusLabel = 'Selesai';
                                        $statusClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400';
                                    } elseif ($task->status === 'draft') {
                                        $statusLabel = 'Draft';
                                        $statusClass = 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300';
                                    } elseif ($isLate) {
                                        $statusLabel = 'Terlambat';
                                        $statusClass = 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400';
                                    } else {
                                        $statusLabel = 'Aktif';
                                        $statusClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $statusClass }}">{{ $statusLabel }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800 shrink-0 min-w-[150px]">
                        <div class="text-right w-full">
                            <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Progres</div>
                            <span class="text-3xl font-bold text-slate-800 dark:text-white">{{ $submittedCount }}</span>
                            <span class="text-slate-500 dark:text-slate-400 text-sm">/ {{ $totalAssignees }}</span>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-1.5 mt-1 mb-2">
                            @php
                                if ($progress >= 75) $progressColor = 'bg-emerald-500';
                                elseif ($progress >= 50) $progressColor = 'bg-amber-500';
                                else $progressColor = 'bg-blue-500';
                            @endphp
                            <div class="{{ $progressColor }} h-1.5 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded w-full text-center {{ $progress >= 75 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : ($progress >= 50 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400') }}">{{ $progress }}% Selesai</span>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 pb-2 border-b border-slate-100 dark:border-slate-700">Deskripsi</h2>
                    <div class="bg-blue-50/50 dark:bg-slate-900/50 p-5 rounded-xl border-l-4 border-blue-500">
                        <p class="text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed">{{ $task->deskripsi }}</p>
                    </div>
                </div>

                <!-- File Pendukung -->
                @php
                    $taskFiles = $task->files->where('jenis', 'file');
                    $taskLinks = $task->files->where('jenis', 'link');
                @endphp

                @if($taskFiles->count() > 0 || $taskLinks->count() > 0)
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 pb-2 border-b border-slate-100 dark:border-slate-700">File & Link Pendukung</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($taskFiles as $file)
                        <div>
                            <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:border-blue-500 dark:hover:border-blue-500 hover:shadow-md transition-all group">
                                <div class="flex items-center gap-4 overflow-hidden mr-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 text-xl">
                                        {!! strtolower($file->tipe) === 'pdf' ? '<i class="fi fi-rr-document"></i>' : '<i class="fi fi-rr-clip"></i>' !!}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-slate-800 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $file->nama_file }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ strtoupper($file->tipe) }} •
                                            @if($file->ukuran >= 1048576)
                                                {{ number_format($file->ukuran / 1048576, 1) }} MB
                                            @elseif($file->ukuran >= 1024)
                                                {{ number_format($file->ukuran / 1024, 1) }} KB
                                            @else
                                                {{ $file->ukuran }} Bytes
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    @if(strtolower($file->tipe) === 'pdf')
                                        <button type="button" class="bg-purple-50 hover:bg-purple-100 text-purple-700 dark:bg-purple-900/20 dark:hover:bg-purple-900/40 dark:text-purple-400 p-2 rounded-lg transition-colors" onclick="togglePdfViewer('pdf-file-{{ $file->id }}', '{{ route('file.task', $file->id) }}')" title="Toggle Preview">
                                            <i class="fi fi-rr-eye"></i>
                                        </button>
                                        <button type="button" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 dark:text-emerald-400 p-2 rounded-lg transition-colors" onclick="openPdfModal('{{ $file->nama_file }}', '{{ route('file.task', $file->id) }}')" title="Fullscreen">
                                            <i class="fi fi-rr-expand"></i>
                                        </button>
                                    @elseif(in_array(strtolower($file->tipe), ['xls', 'xlsx']))
                                        <a href="{{ route('excel.editor', ['type' => 'task_file', 'id' => $file->id]) }}" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 dark:text-emerald-400 p-2 rounded-lg transition-colors" title="Edit di Web">
                                            <i class="fi fi-rr-edit"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('file.task', $file->id) }}" target="_blank" download class="bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 dark:text-blue-400 p-2 rounded-lg transition-colors" title="Download">
                                        <i class="fi fi-rr-download"></i>
                                    </a>
                                </div>
                            </div>
                            @if(strtolower($file->tipe) === 'pdf')
                                <div class="hidden mt-3 border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden bg-slate-50 dark:bg-slate-900" id="pdf-file-{{ $file->id }}">
                                    <iframe data-src="{{ route('file.task', $file->id) }}" title="PDF Viewer - {{ $file->nama_file }}" class="w-full h-[500px] border-none"></iframe>
                                </div>
                            @endif
                        </div>
                        @endforeach

                        @foreach($taskLinks as $link)
                        <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:border-blue-500 dark:hover:border-blue-500 hover:shadow-md transition-all group">
                            <div class="flex items-center gap-4 overflow-hidden mr-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 text-xl">
                                    <i class="fi fi-rr-link"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-800 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $link->nama_file }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $link->url }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                @if(str_contains(strtolower($link->url), 'docs.google.com/spreadsheets'))
                                    <button type="button" onclick="openPdfModal('{{ $link->nama_file }}', '{{ $link->url }}')" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 dark:text-emerald-400 p-2 rounded-lg transition-colors" title="Live Sheet">
                                        <i class="fi fi-rr-chart-histogram"></i>
                                    </button>
                                @endif
                                <a href="{{ $link->url }}" target="_blank" class="bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 dark:text-blue-400 p-2 rounded-lg transition-colors" title="Kunjungi Link">
                                    <i class="fi fi-rr-link-alt"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Catatan Tambahan -->
                @if($task->catatan)
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 pb-2 border-b border-slate-100 dark:border-slate-700">Catatan Tambahan</h2>
                    <div class="bg-amber-50/50 dark:bg-slate-900/50 p-5 rounded-xl border-l-4 border-amber-500">
                        <p class="text-slate-700 dark:text-slate-300 whitespace-pre-line">{{ $task->catatan }}</p>
                    </div>
                </div>
                @endif

                <!-- Info Pembuat -->
                <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 pt-6 border-t border-slate-100 dark:border-slate-700">
                    <i class="fi fi-rr-info"></i>
                    <span>Dibuat {{ $task->created_at->translatedFormat('d M Y, H:i') }}
                        @if($task->creator)
                            oleh <strong class="text-slate-700 dark:text-slate-300 font-semibold">{{ $task->creator->name }}</strong>
                        @endif
                    </span>
                    @if($task->updated_at->gt($task->created_at))
                        <span class="text-slate-300 dark:text-slate-600 mx-1">•</span>
                        <span>Diperbarui {{ $task->updated_at->translatedFormat('d M Y, H:i') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Monitoring Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
             <div class="p-6 md:p-8 border-b border-slate-100 dark:border-slate-700">
                <h2 class="text-xl font-bold text-slate-800 dark:text-white">Progres Mahasiswa <span class="text-blue-600 dark:text-blue-400">({{ $submittedCount }}/{{ $totalAssignees }})</span></h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 text-left">
                            <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 text-sm whitespace-nowrap">Nama Mahasiswa</th>
                            <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 text-sm whitespace-nowrap">Tanggal Submit</th>
                            <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 text-sm whitespace-nowrap">File</th>
                            <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 text-sm whitespace-nowrap">Status</th>
                            <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 text-sm text-center whitespace-nowrap">Nilai</th>
                            <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 text-sm text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($task->submissions as $submission)
                            @php
                                $user = $submission->user;
                                $initials = $user ? collect(explode(' ', $user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('') : '??';

                                $avatarColors = [
                                    'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                    'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                    'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                    'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                    'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400',
                                    'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                    'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
                                    'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400',
                                ];
                                $colorIndex = $user ? ($user->id % count($avatarColors)) : 0;
                                $avatarColor = $avatarColors[$colorIndex];

                                $isSubmissionLate = $submission->submitted_at && $submission->submitted_at->gt($task->deadline_date->setTimeFromTimeString($task->deadline_time));
                            @endphp
                            <tr class="border-b border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-800 dark:text-white">
                                    <div class="flex items-center gap-3">
                                        @if($user->avatar)
                                            <img src="{{ route('file.avatar', $user->id) }}" class="w-8 h-8 rounded-full object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-full {{ $avatarColor }} flex items-center justify-center text-xs font-bold">{{ $initials }}</div>
                                        @endif
                                        {{ $user->name ?? 'Unknown' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 whitespace-nowrap">
                                    @if($submission->submitted_at)
                                        {{ $submission->submitted_at->translatedFormat('d M Y, H:i') }}
                                        @if($isSubmissionLate)
                                            <span class="text-xs text-red-500 font-medium ml-1 bg-red-50 dark:bg-red-900/20 px-1.5 py-0.5 rounded">(Terlambat)</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($submission->file_path)
                                        <div class="flex items-center gap-2">
                                        <a href="{{ route('file.submission', $submission->id) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium flex items-center gap-1.5 max-w-[200px] truncate" title="{{ $submission->file_nama }}">
                                            <i class="fi fi-rr-document"></i> <span class="truncate">{{ $submission->file_nama ?? 'Download File' }}</span>
                                        </a>
                                        <div class="flex gap-1 shrink-0">
                                            @if(Str::endsWith(strtolower($submission->file_nama ?? $submission->file_path), '.pdf'))
                                                <button type="button" class="bg-purple-50 hover:bg-purple-100 text-purple-600 dark:bg-purple-900/20 dark:hover:bg-purple-900/40 dark:text-purple-400 p-1.5 rounded transition-colors" onclick="openPdfModal('{{ $submission->file_nama ?? 'Submission' }}', '{{ route('file.submission', $submission->id) }}')" title="View PDF">
                                                    <i class="fi fi-rr-eye"></i>
                                                </button>
                                            @elseif(Str::endsWith(strtolower($submission->file_nama ?? $submission->file_path), '.xlsx') || Str::endsWith(strtolower($submission->file_nama ?? $submission->file_path), '.xls'))
                                                <a href="{{ route('excel.editor', ['type' => 'submission', 'id' => $submission->id]) }}" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 dark:text-emerald-400 p-1.5 rounded transition-colors block" title="Edit di Web">
                                                    <i class="fi fi-rr-edit"></i>
                                                </a>
                                            @endif
                                        </div>
                                        </div>
                                    @else
                                        <span class="text-slate-400 dark:text-slate-500 italic">Belum submit file</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($submission->status === 'graded')
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Dinilai</span>
                                    @elseif($submission->status === 'submitted')
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">Menunggu Review</span>
                                    @elseif($submission->status === 'pending' && $task->deadline_date->isPast())
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">Terlambat</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300">Belum Submit</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-slate-800 dark:text-white text-center">
                                    @if($submission->status === 'graded' && $submission->nilai !== null)
                                        <span class="text-emerald-600 dark:text-emerald-400">{{ $submission->nilai }}</span>
                                    @else
                                        <span class="text-slate-400 dark:text-slate-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <button type="button" 
                                            onclick="openEvaluationModal({{ json_encode([
                                                'id' => $submission->id,
                                                'nama' => $user->name ?? 'Unknown',
                                                'nilai' => $submission->nilai,
                                                'status' => $submission->status,
                                                'komentar' => $submission->komentar,
                                                'comments' => $submission->comments->map(function($c) {
                                                    return [
                                                        'user_name' => $c->user->name,
                                                        'avatar' => $c->user->avatar ? route('file.avatar', $c->user->id) : null,
                                                        'pesan' => e($c->pesan),
                                                        'is_admin' => $c->user->role_id != 3,
                                                        'time' => $c->created_at->translatedFormat('d M, H:i')
                                                    ];
                                                })
                                            ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }})"
                                            class="bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white dark:bg-indigo-900/30 dark:hover:bg-indigo-600 dark:text-indigo-400 dark:hover:text-white px-3 py-1.5 rounded-lg font-medium transition-colors inline-flex items-center gap-1.5 border border-indigo-200 dark:border-indigo-800 hover:border-transparent">
                                        <i class="fi fi-rr-comment-alt"></i> Review
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400 dark:text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-3 py-6">
                                        <div class="w-16 h-16 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-2xl text-slate-300 dark:text-slate-600">
                                            <i class="fi fi-rr-clipboard-list-check"></i>
                                        </div>
                                        <p class="font-medium text-slate-600 dark:text-slate-400">Belum ada data submission</p>
                                        <p class="text-sm">Mahasiswa belum ditugaskan ke tugas ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- PDF Modal -->
    <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity hidden" id="pdfModalOverlay" onclick="closePdfModal(event)" style="display: none;">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden shadow-2xl scale-95 transition-transform" id="pdfModalContent" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80">
                <h3 class="font-bold text-slate-800 dark:text-white flex items-center gap-2"><i class="fi fi-rr-document"></i> <span id="pdfModalTitle">PDF Viewer</span></h3>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 transition-colors" onclick="closePdfModal()">
                    <i class="fi fi-rr-cross"></i>
                </button>
            </div>
            <div class="flex-1 bg-slate-100 dark:bg-slate-900">
                <iframe id="pdfModalIframe" src="" title="PDF Viewer" class="w-full h-full border-none"></iframe>
            </div>
        </div>
    </div>

    <!-- Evaluation Modal -->
    <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity hidden" id="evaluationModal" onclick="closeEvaluationModal(event)" style="display: none;">
        <div class="bg-white dark:bg-slate-800 rounded-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden shadow-2xl scale-95 transition-transform" id="evalModalContent" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80 shrink-0">
                <h3 class="font-bold text-slate-800 dark:text-white flex items-center gap-2"><i class="fi fi-rr-clipboard-list-check"></i> <span id="evalModalTitle">Review Submission</span></h3>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 transition-colors" onclick="closeEvaluationModal()">
                    <i class="fi fi-rr-cross"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 h-full">
                    <!-- Left: Review Form -->
                    <div class="flex flex-col">
                        <h4 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-700">
                            <i class="fi fi-rr-edit text-blue-500"></i> Form Penilaian
                        </h4>
                        <form id="evalForm" method="POST" action="" class="flex flex-col gap-4 flex-1">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Status Submission</label>
                                <select name="status" id="evalStatus" class="w-full rounded-xl border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                    <option value="submitted">Menunggu Review</option>
                                    <option value="graded">Dinilai (Selesai)</option>
                                    <option value="returned">Dikembalikan (Perlu Revisi)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nilai (0-100)</label>
                                <input type="number" name="nilai" id="evalNilai" min="0" max="100" class="w-full rounded-xl border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 85">
                            </div>
                            <div class="flex-1 flex flex-col">
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Komentar Utama / Feedback Internal</label>
                                <textarea name="komentar" id="evalKomentar" rows="4" class="w-full flex-1 rounded-xl border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 focus:border-blue-500 resize-none" placeholder="Berikan feedback singkat..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 mt-4">
                                <i class="fi fi-rr-disk"></i> Simpan Penilaian
                            </button>
                        </form>
                    </div>

                    <!-- Right: Dialogue / Chat -->
                    <div class="flex flex-col h-full border-t md:border-t-0 md:border-l border-slate-200 dark:border-slate-700 pt-6 md:pt-0 md:pl-8">
                        <h4 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2 pb-2 border-b border-slate-100 dark:border-slate-700">
                            <i class="fi fi-rr-messages text-indigo-500"></i> Diskusi & Komunikasi
                        </h4>
                        <div class="flex-1 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700 p-4 mb-4 overflow-y-auto min-h-[300px]" id="commentFeed">
                            <!-- Comments will be injected here -->
                        </div>
                        <form id="commentForm" method="POST" action="" class="shrink-0">
                            @csrf
                            <div class="relative flex items-center">
                                <input type="text" name="pesan" id="commentInput" placeholder="Ketik pesan..." 
                                       class="w-full rounded-full border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white pl-4 pr-12 py-3 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                                <button type="submit" class="absolute right-1.5 w-9 h-9 flex items-center justify-center bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-md">
                                    <i class="fi fi-rr-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle inline PDF viewer
        function togglePdfViewer(containerId, pdfUrl) {
            const container = document.getElementById(containerId);
            if (!container) return;

            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                // Lazy load: set src only on first open
                const iframe = container.querySelector('iframe');
                if (iframe && !iframe.src) {
                    iframe.src = iframe.dataset.src;
                }
            } else {
                container.classList.add('hidden');
            }
        }

        // Open PDF in fullscreen modal
        function openPdfModal(title, pdfUrl) {
            document.getElementById('pdfModalTitle').textContent = title;
            document.getElementById('pdfModalIframe').src = pdfUrl;
            const overlay = document.getElementById('pdfModalOverlay');
            const content = document.getElementById('pdfModalContent');
            
            overlay.style.display = 'flex';
            // Slight delay for animation
            setTimeout(() => {
                overlay.classList.remove('hidden');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        // Close PDF modal
        function closePdfModal(event) {
            const overlay = document.getElementById('pdfModalOverlay');
            const content = document.getElementById('pdfModalContent');
            
            if (event && event.target !== overlay && !event.target.closest('.pdf-modal-close')) return;
            
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            overlay.classList.add('hidden');
            
            setTimeout(() => {
                overlay.style.display = 'none';
                document.getElementById('pdfModalIframe').src = '';
                document.body.style.overflow = '';
            }, 300); // match tailwind transition duration if any, or just 300ms
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function openEvaluationModal(data) {
            document.getElementById('evalModalTitle').textContent = "Review: " + data.nama;
            document.getElementById('evalForm').action = "/penugasan/grade/" + data.id;
            document.getElementById('commentForm').action = "/penugasan/comment/" + data.id;
            
            document.getElementById('evalStatus').value = data.status;
            document.getElementById('evalNilai').value = data.nilai || '';
            document.getElementById('evalKomentar').value = data.komentar || '';

            // Render comments
            const feed = document.getElementById('commentFeed');
            feed.innerHTML = '';
            
            if (data.comments.length === 0) {
                feed.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-slate-400 dark:text-slate-500 gap-2 opacity-70">
                        <i class="fi fi-rr-comments text-3xl"></i>
                        <span class="text-sm font-medium">Belum ada diskusi.</span>
                    </div>`;
            } else {
                data.comments.forEach(c => {
                    const initials = c.user_name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                    const isAdmin = c.is_admin;
                    
                    const flexAlign = isAdmin ? 'justify-end' : 'justify-start';
                    const bubbleBg = isAdmin ? 'bg-indigo-100 text-indigo-900 dark:bg-indigo-900/40 dark:text-indigo-100 rounded-br-none' : 'bg-white text-slate-800 dark:bg-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-700 rounded-bl-none';
                    const avatarColor = isAdmin ? 'bg-indigo-600 text-white' : 'bg-slate-300 text-slate-700 dark:bg-slate-600 dark:text-slate-200';
                    
                    let avatarHtml = `<div class="w-8 h-8 rounded-full ${avatarColor} flex items-center justify-center text-xs font-bold shrink-0 shadow-sm">${initials}</div>`;
                    if (c.avatar) {
                        avatarHtml = `<img src="${c.avatar}" class="w-8 h-8 rounded-full object-cover shrink-0 shadow-sm">`;
                    }
                    
                    feed.innerHTML += `
                        <div class="flex gap-3 mb-4 ${flexAlign}">
                            ${!isAdmin ? avatarHtml : ''}
                            <div class="flex flex-col ${isAdmin ? 'items-end' : 'items-start'} max-w-[85%]">
                                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1 font-medium px-1">${escapeHtml(c.user_name)}</span>
                                <div class="px-4 py-2.5 rounded-2xl ${bubbleBg} shadow-sm text-sm">
                                    ${escapeHtml(c.pesan)}
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 px-1">${c.time}</span>
                            </div>
                            ${isAdmin ? avatarHtml : ''}
                        </div>
                    `;
                });
            }

            const overlay = document.getElementById('evaluationModal');
            const content = document.getElementById('evalModalContent');
            
            overlay.style.display = 'flex';
            setTimeout(() => {
                overlay.classList.remove('hidden');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
            
            // Scroll to bottom of chat
            setTimeout(() => {
                feed.scrollTop = feed.scrollHeight;
            }, 100);
        }

        function closeEvaluationModal(event) {
            const overlay = document.getElementById('evaluationModal');
            const content = document.getElementById('evalModalContent');
            
            if (event && event.target !== overlay && !event.target.closest('.pdf-modal-close')) return;
            
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            overlay.classList.add('hidden');
            
            setTimeout(() => {
                overlay.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        }

        // ESC key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const pdfOverlay = document.getElementById('pdfModalOverlay');
                const evalOverlay = document.getElementById('evaluationModal');
                
                if (pdfOverlay && pdfOverlay.style.display === 'flex') closePdfModal();
                if (evalOverlay && evalOverlay.style.display === 'flex') closeEvaluationModal();
            }
        });
    </script>
</x-admin-layout>
