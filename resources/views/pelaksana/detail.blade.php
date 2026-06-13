<x-pelaksana-layout>
    <div class="w-full pb-12">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 md:gap-4 mb-6 md:mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white mb-1 md:mb-2">Welcome Back, {{ Auth::user()->name }}</h1>
                <p class="text-slate-600 dark:text-slate-400">Berikut adalah detail tugas Anda.</p>
            </div>
            <a href="{{ route('pelaksana.penugasan') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-xl text-slate-700 dark:text-slate-300 font-semibold hover:border-blue-500 hover:text-blue-600 dark:hover:border-blue-500 dark:hover:text-blue-400 transition-colors shadow-sm">
                <i class="fi fi-rr-arrow-left"></i> Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800 rounded-xl p-4 mb-6 flex items-center gap-3 font-medium shadow-sm">
                <i class="fi fi-rr-check-circle text-xl shrink-0"></i> 
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if($errors->any() || session('error'))
            <div class="bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800 rounded-xl p-4 mb-6 flex items-center gap-3 font-medium shadow-sm">
                <i class="fi fi-rr-cross-circle text-xl shrink-0"></i> 
                <span>{{ session('error') ?? 'Terdapat kesalahan pada input form.' }}</span>
            </div>
        @endif

        @php
            $isSubmitted = in_array($submission->status, ['submitted', 'graded']);
            $isLate = !$isSubmitted && \Carbon\Carbon::parse($task->deadline_date)->isPast();
        @endphp

        <!-- Result & Review Section (Only if graded) -->
        @if($submission->status == 'graded' || $submission->komentar)
        <div class="bg-blue-50 dark:bg-slate-800/80 border-l-4 border-blue-500 rounded-r-2xl shadow-sm mb-6 md:mb-8 overflow-hidden">
            <div class="p-4 md:p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-3 mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-1">Hasil Review Admin</h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Admin telah meninjau hasil pekerjaan Anda.</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Nilai Akhir</div>
                        <div class="text-4xl font-black text-blue-600 dark:text-blue-400 leading-none">{{ $submission->nilai ?? '-' }}</div>
                    </div>
                </div>
                
                @if($submission->komentar)
                <div class="bg-white dark:bg-slate-900/50 p-5 rounded-xl border border-blue-100 dark:border-slate-700 shadow-sm">
                    <div class="font-bold text-blue-600 dark:text-blue-400 text-sm mb-2 flex items-center gap-2">
                        <i class="fi fi-rr-bullhorn"></i> Pesan Utama dari Admin:
                    </div>
                    <p class="text-slate-700 dark:text-slate-300 leading-relaxed">{{ $submission->komentar }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Task Detail Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-8">
            <div class="p-4 md:p-6 lg:p-8">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3 md:gap-4 mb-6 md:mb-8">
                    <div>
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-800 dark:text-white mb-3 md:mb-4">{{ $task->judul }}</h1>
                        <div class="flex flex-wrap gap-4 md:gap-6 text-sm">
                            <div class="flex flex-col">
                                <span class="font-semibold text-slate-500 dark:text-slate-400 mb-1">Pemberi Tugas</span>
                                <span class="font-medium text-slate-800 dark:text-white">{{ $task->creator->name ?? 'Admin' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-semibold text-slate-500 dark:text-slate-400 mb-1">Divisi</span>
                                <span class="font-medium text-slate-800 dark:text-white">{{ $task->divisi->nama ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-semibold text-slate-500 dark:text-slate-400 mb-1">Jenis Tugas</span>
                                <span class="font-medium text-slate-800 dark:text-white">{{ ucfirst($task->jenis_tugas) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="shrink-0">
                        @if($submission->status == 'graded')
                            <span class="inline-flex px-4 py-2 rounded-full text-sm font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 shadow-sm border border-blue-200 dark:border-blue-800/50">Dinilai: {{ $submission->nilai ?? '0' }}</span>
                        @elseif($isSubmitted)
                            <span class="inline-flex px-4 py-2 rounded-full text-sm font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 shadow-sm border border-emerald-200 dark:border-emerald-800/50">Telah Disubmit</span>
                        @elseif($isLate)
                            <span class="inline-flex px-4 py-2 rounded-full text-sm font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 shadow-sm border border-red-200 dark:border-red-800/50">Terlambat</span>
                        @else
                            <span class="inline-flex px-4 py-2 rounded-full text-sm font-bold bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300 shadow-sm border border-slate-200 dark:border-slate-600">Belum Disubmit</span>
                        @endif
                    </div>
                </div>

                <!-- Deskripsi Tugas Section -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 pb-2 border-b border-slate-100 dark:border-slate-700">Deskripsi Tugas</h2>
                    <div class="bg-slate-50 dark:bg-slate-900/50 p-5 rounded-xl border-l-4 border-blue-500">
                        <p class="text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed">{!! nl2br(e($task->deskripsi)) !!}</p>
                    </div>
                </div>

                <!-- File Pendukung Section -->
                @php
                    $taskFiles = $task->files->where('jenis', 'file');
                    $taskLinks = $task->files->where('jenis', 'link');
                @endphp

                @if($taskFiles->count() > 0 || $taskLinks->count() > 0)
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 pb-2 border-b border-slate-100 dark:border-slate-700">File & Link Pendukung</h2>
                    
                    <div class="space-y-3">
                        @foreach($taskFiles as $file)
                        <div>
                            <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:border-blue-500 dark:hover:border-blue-500 hover:shadow-md transition-all group">
                                <div class="flex items-center gap-4 overflow-hidden mr-3">
                                    <div class="text-2xl text-slate-400 group-hover:text-blue-500 transition-colors shrink-0">
                                        {!! strtolower($file->tipe) === 'pdf' ? '<i class="fi fi-rr-document"></i>' : '<i class="fi fi-rr-paperclip"></i>' !!}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-slate-800 dark:text-white truncate">{{ $file->nama_file }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ strtoupper($file->tipe) . ' • ' . round($file->ukuran / 1024, 2) . ' KB' }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    @if(strtolower($file->tipe) === 'pdf')
                                        <button type="button" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-900/20 dark:hover:bg-indigo-900/40 dark:text-indigo-400 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5" onclick="togglePdfViewer('pdf-file-{{ $file->id }}', '{{ route('file.task', $file->id) }}')">
                                            <i class="fi fi-rr-eye"></i> <span class="hidden sm:inline">Lihat</span>
                                        </button>
                                        <button type="button" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 dark:text-emerald-400 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5" onclick="openPdfModal('{{ $file->nama_file }}', '{{ route('file.task', $file->id) }}')">
                                            <i class="fi fi-rr-expand"></i> <span class="hidden sm:inline">Fullscreen</span>
                                        </button>
                                    @elseif(in_array(strtolower($file->tipe), ['xls', 'xlsx']))
                                        <a href="{{ route('excel.editor', ['type' => 'task_file', 'id' => $file->id]) }}" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 dark:text-emerald-400 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                                            <i class="fi fi-rr-pencil"></i> <span class="hidden sm:inline">Edit di Web</span>
                                        </a>
                                    @endif
                                    <a href="{{ route('file.task', $file->id) }}" target="_blank" download class="bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 dark:text-blue-400 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                                        <i class="fi fi-rr-download"></i> <span class="hidden sm:inline">Download</span>
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
                                <div class="text-2xl text-slate-400 group-hover:text-blue-500 transition-colors shrink-0">
                                    <i class="fi fi-rr-link"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-800 dark:text-white truncate">{{ $link->nama_file }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">Tautan Luar</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                @if(str_contains(strtolower($link->url), 'docs.google.com/spreadsheets'))
                                    <button type="button" onclick="openPdfModal('{{ $link->nama_file }}', '{{ $link->url }}')" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 dark:text-emerald-400 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                                        <i class="fi fi-rr-chart-histogram"></i> <span class="hidden sm:inline">Live Sheet</span>
                                    </button>
                                @endif
                                <a href="{{ $link->url }}" target="_blank" class="bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 dark:text-blue-400 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                                    <i class="fi fi-rr-arrow-up-right-from-square"></i> <span class="hidden sm:inline">Buka</span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Catatan Tambahan Section -->
                @if($task->catatan)
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4 pb-2 border-b border-slate-100 dark:border-slate-700">Catatan Tambahan</h2>
                    <div class="bg-amber-50/50 dark:bg-slate-900/50 p-5 rounded-xl border-l-4 border-amber-500">
                        <p class="text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed">{{ $task->catatan }}</p>
                    </div>
                </div>
                @endif

                <!-- Deadline Section -->
                <div class="mb-6 md:mb-8">
                    <div class="bg-orange-50 dark:bg-orange-900/10 border-l-4 border-orange-500 rounded-r-xl p-4 md:p-5 shadow-sm">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-3">
                            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Deadline</h2>
                            @if($isLate)
                                <div class="text-red-600 dark:text-red-400 font-bold flex items-center gap-2 bg-red-100 dark:bg-red-900/30 px-3 py-1 rounded-full text-sm"><i class="fi fi-rr-triangle-warning"></i> Terlambat</div>
                            @else
                                <div class="text-emerald-700 dark:text-emerald-400 font-bold flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 px-3 py-1 rounded-full text-sm"><i class="fi fi-rr-hourglass-end"></i> {{ \Carbon\Carbon::parse($task->deadline_date)->diffForHumans() }}</div>
                            @endif
                        </div>
                        <div class="text-orange-600 dark:text-orange-400 font-bold text-base md:text-lg flex items-center gap-2 flex-wrap">
                            <i class="fi fi-rr-calendar"></i> {{ \Carbon\Carbon::parse($task->deadline_date)->format('d F Y') }} - {{ $task->deadline_time }} WIB
                        </div>
                    </div>
                </div>

                <!-- Form Upload Tugas -->
                <form id="submissionForm" action="{{ route('pelaksana.penugasan.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-10 pt-8 border-t-2 border-dashed border-slate-200 dark:border-slate-700">
                        <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Upload Penugasan Anda</h2>
                        
                        @if($submission->status != 'graded')
                            <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-2xl p-8 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 dark:hover:border-blue-500 dark:hover:bg-slate-800/50 transition-all group" onclick="document.getElementById('fileInput').click()">
                                <div class="text-4xl text-slate-400 group-hover:text-blue-500 mb-4 transition-colors">
                                    <i class="fi fi-rr-folder-upload"></i>
                                </div>
                                <div class="text-slate-700 dark:text-slate-300 mb-2" id="uploadText">
                                    <strong class="font-bold">Klik di sini untuk upload file jawaban</strong>
                                </div>
                                <div class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                                    Format: PDF, DOC, DOCX, ZIP, XLS, JPG, dll (Maks 20MB)
                                </div>
                                <input type="file" name="file" id="fileInput" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.zip,.rar" onchange="updateFileName(this)">
                                <div class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-xl transition-colors shadow-sm gap-2">
                                    <i class="fi fi-rr-upload"></i> Pilih File
                                </div>
                            </div>
                        @endif

                        <!-- Submitted Files -->
                        @if($submission->file_path)
                        <div class="mt-8">
                            <h3 class="font-bold text-slate-800 dark:text-white mb-4">File Terakhir Disubmit</h3>
                            
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl gap-4">
                                <div class="flex items-center gap-4 overflow-hidden">
                                    <div class="w-12 h-12 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 text-xl">
                                        <i class="fi fi-rr-document-signed"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-800 dark:text-white truncate">{{ $submission->file_nama }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                            {{ round($submission->file_ukuran / 1024, 2) }} KB • Disubmit: {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="shrink-0 flex justify-end">
                                    <a href="{{ route('file.submission', $submission->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 font-semibold rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                                        <i class="fi fi-rr-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($submission->status != 'graded')
                        <!-- Submit Section -->
                        <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700 flex flex-col-reverse sm:flex-row justify-end gap-3">
                            <a href="{{ route('pelaksana.penugasan') }}" class="px-6 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-600 transition-all text-center">
                                Batal
                            </a>
                            <button type="button" id="submitTaskBtn" onclick="confirmSubmitTask()" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 transition-all flex items-center justify-center gap-2">
                                <i class="fi fi-rr-check"></i> Submit Tugas / Update
                            </button>
                        </div>
                        @else
                        <!-- If already submitted but we want a back button here -->
                        <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700 flex justify-end">
                            <a href="{{ route('pelaksana.penugasan') }}" class="px-6 py-3 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-blue-500 hover:text-blue-600 dark:hover:border-blue-500 dark:hover:text-blue-400 transition-all flex items-center justify-center gap-2">
                                <i class="fi fi-rr-arrow-left"></i> Kembali ke Daftar Tugas
                            </a>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Dialogue Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-8">
            <div class="p-4 md:p-6 border-b border-slate-100 dark:border-slate-700">
                <h2 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fi fi-rr-comment-alt text-indigo-500"></i> <span class="text-base md:text-xl">Diskusi dengan Admin</span>
                </h2>
            </div>
            
            <div class="p-4 md:p-6 bg-slate-50 dark:bg-slate-900/50">
                <div class="max-h-[400px] md:max-h-[500px] overflow-y-auto mb-4 md:mb-6 pr-1 md:pr-2 space-y-3 md:space-y-4" id="pelaksanaCommentFeed">
                    @forelse($submission->comments as $comment)
                        @php
                            $isAdmin = $comment->user->role_id != 3;
                            $initials = collect(explode(' ', $comment->user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                            $avatarColor = $isAdmin ? 'bg-indigo-600 text-white' : 'bg-slate-300 text-slate-700 dark:bg-slate-600 dark:text-slate-200';
                            
                            $flexAlign = !$isAdmin ? 'justify-end' : 'justify-start';
                            $bubbleBg = !$isAdmin ? 'bg-blue-600 text-white rounded-br-none shadow-sm shadow-blue-500/20' : 'bg-white text-slate-800 dark:bg-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-700 rounded-bl-none shadow-sm';
                        @endphp
                        
                        <div class="flex gap-3 {{ $flexAlign }}">
                            @if($isAdmin)
                                @if($comment->user->avatar)
                                    <img src="{{ route('file.avatar', $comment->user->id) }}" class="w-10 h-10 rounded-full object-cover shrink-0 shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-full {{ $avatarColor }} flex items-center justify-center text-sm font-bold shrink-0 shadow-sm">{{ $initials }}</div>
                                @endif
                            @endif
                            
                            <div class="flex flex-col {{ !$isAdmin ? 'items-end' : 'items-start' }} max-w-[90%] sm:max-w-[85%]">
                                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1 font-medium px-1">{{ $comment->user->name }}</span>
                                <div class="px-3 py-2 md:px-5 md:py-3 rounded-2xl {{ $bubbleBg }} text-sm leading-relaxed">
                                    {{ $comment->pesan }}
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 px-1">{{ $comment->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </div>

                            @if(!$isAdmin)
                                @if($comment->user->avatar)
                                    <img src="{{ route('file.avatar', $comment->user->id) }}" class="w-10 h-10 rounded-full object-cover shrink-0 shadow-sm border-2 border-white dark:border-slate-800">
                                @else
                                    <div class="w-10 h-10 rounded-full {{ $avatarColor }} flex items-center justify-center text-sm font-bold shrink-0 shadow-sm border-2 border-white dark:border-slate-800">{{ $initials }}</div>
                                @endif
                            @endif
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 text-slate-400 dark:text-slate-500">
                            <i class="fi fi-rr-comment-alt text-5xl mb-4 opacity-50"></i>
                            <p class="font-medium text-slate-600 dark:text-slate-400 text-lg mb-1">Belum ada diskusi</p>
                            <p class="text-sm">Kirim pesan di bawah untuk bertanya ke admin.</p>
                        </div>
                    @endforelse
                </div>

                <form action="{{ route('pelaksana.comment', $submission->id) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="flex items-center gap-3 relative">
                        <input type="text" name="pesan" placeholder="Ketik pesan balasan..." 
                               required
                               class="w-full bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-full pl-5 pr-14 py-3.5 text-slate-800 dark:text-white focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white rounded-full transition-colors shadow-md">
                            <i class="fi fi-rr-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- PDF Modal -->
    <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-2 md:p-4 transition-opacity hidden" id="pdfModalOverlay" onclick="closePdfModal(event)" style="display: none;">
        <div class="bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl w-full max-w-5xl h-[95vh] md:h-[85vh] flex flex-col overflow-hidden shadow-2xl scale-95 transition-transform" id="pdfModalContent" onclick="event.stopPropagation()">
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

    <script>
        function updateFileName(input) {
            if (input.files && input.files[0]) {
                const textEl = document.getElementById('uploadText');
                textEl.innerHTML = 'File terpilih: <strong class="text-blue-600 dark:text-blue-400 font-bold block mt-2 text-lg">' + input.files[0].name + '</strong>';
                textEl.parentElement.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-slate-800/80');
            }
        }

        function confirmSubmitTask() {
            var fileInput = document.getElementById('fileInput');
            let confirmMessage = '';

            // Blokir file exe
            if (fileInput.files && fileInput.files[0]) {
                const ext = fileInput.files[0].name.split('.').pop().toLowerCase();
                const blocked = ['exe', 'bat', 'cmd', 'msi', 'com', 'scr', 'pif', 'vbs', 'js', 'wsf', 'sh'];
                if (blocked.includes(ext)) {
                    alert('File dengan ekstensi .' + ext + ' tidak diperbolehkan!\nFormat yang diterima: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG, GIF, ZIP, RAR');
                    fileInput.value = '';
                    document.getElementById('uploadText').innerHTML = '<strong class="font-bold">Klik di sini untuk upload file jawaban</strong>';
                    return;
                }
            }

            if (!fileInput.value && !{{ $submission->file_path ? 'true' : 'false' }}) {
                confirmMessage = 'Anda tidak memilih file apa pun.\nTugas akan ditandai sebagai Selesai tanpa file tambahan.\n\nApakah Anda yakin ingin mensubmit tugas ini?';
            } else if (!fileInput.value && {{ $submission->file_path ? 'true' : 'false' }}) {
                confirmMessage = 'Anda menggunakan file yang sudah diupload sebelumnya.\nTugas akan ditandai sebagai Selesai.\n\nApakah Anda yakin ingin mensubmit tugas ini?';
            } else {
                confirmMessage = 'Apakah Anda yakin ingin mensubmit file jawaban ini?\n\nMenambahkan file baru akan menimpa file lama sebelum dinilai.';
            }

            const confirmed = confirm(confirmMessage);

            if (confirmed) {
                const submitBtn = document.getElementById('submitTaskBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fi fi-rr-spinner animate-spin"></i> Mengunggah...';
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                
                document.getElementById('submissionForm').submit();
            }
        }

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
            }, 300);
        }

        // ESC key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const pdfOverlay = document.getElementById('pdfModalOverlay');
                if (pdfOverlay && pdfOverlay.style.display === 'flex') closePdfModal();
            }
        });

        // Auto scroll to bottom of chat
        const chatContainer = document.getElementById('pelaksanaCommentFeed');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    </script>
</x-pelaksana-layout>
