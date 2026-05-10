<x-admin-layout>
    <style>
        :root {
            --primary: #3b82f6;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
        }

        .task-detail-content * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .task-detail-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .task-title-section h1 {
            color: var(--dark);
            font-size: 1.8rem;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .task-meta {
            display: flex;
            gap: 20px;
            color: var(--secondary);
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 0.8rem;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        .meta-value {
            font-weight: 600;
            color: var(--dark);
        }

        .task-section {
            margin-bottom: 25px;
        }

        .task-section h2 {
            color: var(--dark);
            font-size: 1.3rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
        }

        .description-box {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid var(--primary);
        }

        .description-box p {
            color: var(--dark);
            line-height: 1.6;
            font-size: 0.95rem;
            white-space: pre-line;
        }

        .monitoring-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .monitoring-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .monitoring-header h2 {
            color: var(--dark);
            font-size: 1.3rem;
            margin: 0;
            font-weight: 600;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-submitted { background: #dbf4ff; color: #0284c7; }
        .status-graded { background: #dcfce7; color: #16a34a; }
        .status-late { background: #fee2e2; color: #dc2626; }
        .status-pending { background: #f1f5f9; color: #64748b; }

        .file-attachment {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            margin-bottom: 8px;
            transition: all 0.2s;
        }
        .file-attachment:hover {
            border-color: #3b82f6;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
        }

        .delete-form {
            display: inline;
        }

        /* PDF Viewer */
        .pdf-viewer-container {
            margin-top: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            background: #f1f5f9;
        }
        .pdf-viewer-container iframe {
            width: 100%;
            height: 500px;
            border: none;
        }
        .pdf-viewer-toggle {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }
        .pdf-viewer-toggle.view-btn {
            background: #ede9fe;
            color: #7c3aed;
        }
        .pdf-viewer-toggle.view-btn:hover {
            background: #ddd6fe;
        }

        /* PDF Modal */
        .pdf-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .pdf-modal-overlay.active {
            display: flex;
        }
        .pdf-modal {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 900px;
            height: 85vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .pdf-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .pdf-modal-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        .pdf-modal-close {
            background: #f1f5f9;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: all 0.2s;
        }
        .pdf-modal-close:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
        .pdf-modal-body {
            flex: 1;
            overflow: hidden;
        }
        .pdf-modal-body iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Comment & Evaluation Styles */
        .comment-item {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }
        .comment-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            flex-shrink: 0;
        }
        .comment-bubble {
            background: #f1f5f9;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 0.9rem;
            max-width: 85%;
            position: relative;
        }
        .comment-bubble.admin {
            background: #dbeafe;
            color: #1e40af;
        }
        .comment-time {
            font-size: 0.7rem;
            color: #94a3b8;
            margin-top: 4px;
        }
        .dialogue-container {
            max-height: 400px;
            overflow-y: auto;
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-bottom: 16px;
        }

        /* Dark Mode Overrides */
        .dark {
            --dark: #f8fafc;
            --secondary: #94a3b8;
        }

        .dark .task-detail-card {
            background: #1f2937;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        .dark .description-box {
            background: #374151;
            border-left-color: var(--primary);
        }

        .dark .description-box p {
            color: #e5e7eb;
        }

        .dark .monitoring-section {
            background: #1f2937;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        .dark .file-attachment {
            background: #374151;
            border-color: #4b5563;
        }

        .dark .file-attachment:hover {
            border-color: #3b82f6;
        }

        .dark .file-attachment .font-semibold {
            color: #e5e7eb;
        }

        .dark .dialogue-container {
            background: #1f2937;
            border-color: #4b5563;
        }

        .dark .comment-bubble {
            background: #374151;
            color: #e5e7eb;
        }

        .dark .comment-bubble.admin {
            background: #1e3a8a;
            color: #93c5fd;
        }

        .dark .comment-time {
            color: #6b7280;
        }

        .dark .pdf-modal {
            background: #1f2937;
        }

        .dark .pdf-modal-header {
            background: #374151;
            border-bottom-color: #4b5563;
        }

        .dark .pdf-modal-header h3 {
            color: #e5e7eb;
        }

        .dark .pdf-modal-close {
            background: #4b5563;
            color: #d1d5db;
        }

        .dark .pdf-modal-close:hover {
            background: #374151;
            color: #f3f4f6;
        }
        
        .dark .task-section h2 {
            border-bottom-color: #374151;
            color: #e5e7eb;
        }
        
        .dark .task-header h1 {
            color: #f8fafc;
        }
        
        .dark .meta-value {
            color: #e5e7eb;
        }
        
        .dark .pdf-viewer-container {
            background: #374151;
            border-color: #4b5563;
        }
        
        .dark table {
            color: #e5e7eb;
        }
        
        .dark tr.bg-slate-50 {
            background: #374151;
        }
        
        .dark th {
            color: #e5e7eb !important;
            border-bottom-color: #4b5563 !important;
        }
        
        .dark td {
            border-bottom-color: #374151;
            color: #e5e7eb;
        }
        
        .dark tr.hover\:bg-slate-50:hover {
            background: #374151;
        }
        
        .dark input[type="text"], .dark input[type="number"], .dark select, .dark textarea {
            background: #374151;
            color: #f3f4f6;
            border-color: #4b5563;
        }
        
        .dark input[type="text"]::placeholder, .dark textarea::placeholder {
            color: #9ca3af;
        }

        .dark .text-slate-800 {
            color: #f8fafc;
        }

        .dark .text-slate-600 {
            color: #cbd5e1;
        }

        .dark .text-slate-700 {
            color: #cbd5e1;
        }
    </style>

    <div class="task-detail-content">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <a href="{{ route('penugasan') }}" class="text-slate-500 hover:text-red-600 mb-2 inline-block flex items-center gap-1">
                    <span><i class="fi fi-rr-arrow-left"></i></span> Kembali ke Daftar Tugas
                </a>
                <h1 class="text-slate-800 text-3xl font-bold mb-1">Detail Penugasan</h1>
                <p class="text-slate-600">Monitoring progres tugas mahasiswa</p>
            </div>
            <div class="flex items-center gap-3">
                 <a href="{{ route('penugasan.edit', $task->id) }}" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">Edit Tugas</a>
                 <form action="{{ route('penugasan.destroy', $task->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Yakin ingin menghapus tugas ini? Semua data terkait akan ikut terhapus.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition-colors">Hapus</button>
                 </form>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-xl mb-6 text-sm">
                <i class="fi fi-rr-check-circle mr-1"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl mb-6 text-sm">
                <i class="fi fi-rr-cross-circle mr-1"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Task Info Card -->
        <div class="task-detail-card">
            <div class="task-header">
                <div class="task-title-section">
                    <h1>{{ $task->judul }}</h1>
                    <div class="task-meta">
                        <div class="meta-item">
                            <span class="meta-label">Total Ditugaskan</span>
                            <span class="meta-value">{{ $totalAssignees }} Mahasiswa</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Deadline</span>
                            <span class="meta-value">{{ $task->deadline_date->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Waktu</span>
                            <span class="meta-value">{{ $task->deadline_time }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Prioritas</span>
                            @php
                                $prioritasColors = [
                                    'tinggi' => 'text-red-500',
                                    'sedang' => 'text-amber-500',
                                    'rendah' => 'text-emerald-500',
                                ];
                            @endphp
                            <span class="meta-value {{ $prioritasColors[$task->prioritas] ?? '' }}">{{ ucfirst($task->prioritas) }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Jenis Tugas</span>
                            <span class="meta-value">{{ ucfirst($task->jenis_tugas) }}</span>
                        </div>
                        @if($task->divisi)
                        <div class="meta-item">
                            <span class="meta-label">Divisi</span>
                            <span class="meta-value">{{ $task->divisi->nama }}</span>
                        </div>
                        @endif
                        <div class="meta-item">
                            <span class="meta-label">Status</span>
                            @php
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
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <div class="text-right">
                        <span class="text-3xl font-bold text-slate-800">{{ $submittedCount }}</span>
                        <span class="text-slate-500 text-sm">/ {{ $totalAssignees }}</span>
                    </div>
                    @php
                        if ($progress >= 75) $progressBg = 'bg-emerald-50 text-emerald-600';
                        elseif ($progress >= 50) $progressBg = 'bg-amber-50 text-amber-600';
                        else $progressBg = 'bg-red-50 text-red-600';
                    @endphp
                    <span class="{{ $progressBg }} text-xs font-bold px-2 py-1 rounded">{{ $progress }}% Selesai</span>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="task-section">
                <h2>Deskripsi</h2>
                <div class="description-box">
                    <p>{{ $task->deskripsi }}</p>
                </div>
            </div>

            <!-- File Pendukung -->
            @php
                $taskFiles = $task->files->where('jenis', 'file');
                $taskLinks = $task->files->where('jenis', 'link');
            @endphp

            @if($taskFiles->count() > 0 || $taskLinks->count() > 0)
            <div class="task-section">
                <h2>File & Link Pendukung</h2>

                @foreach($taskFiles as $file)
                <div>
                    <div class="file-attachment">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl">{!! strtolower($file->tipe) === 'pdf' ? '<i class="fi fi-rr-document"></i>' : '<i class="fi fi-rr-clip"></i>' !!}</span>
                            <div>
                                <div class="font-semibold text-slate-800">{{ $file->nama_file }}</div>
                                <div class="text-xs text-slate-500">
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
                        <div class="flex items-center gap-2">
                            @if(strtolower($file->tipe) === 'pdf')
                                <button type="button" class="pdf-viewer-toggle view-btn" onclick="togglePdfViewer('pdf-file-{{ $file->id }}', '{{ route('file.task', $file->id) }}')">
                                    <span><i class="fi fi-rr-eye"></i></span> Lihat PDF
                                </button>
                                <button type="button" class="pdf-viewer-toggle view-btn" onclick="openPdfModal('{{ $file->nama_file }}', '{{ route('file.task', $file->id) }}')" style="background: #f0fdf4; color: #16a34a;">
                                    <span><i class="fi fi-rr-search"></i></span> Fullscreen
                                </button>
                            @elseif(in_array(strtolower($file->tipe), ['xls', 'xlsx']))
                                <a href="{{ route('excel.editor', ['type' => 'task_file', 'id' => $file->id]) }}" class="pdf-viewer-toggle view-btn" style="background: #ecfdf5; color: #059669; text-decoration: none;">
                                    <span><i class="fi fi-rr-edit"></i></span> Edit di Web
                                </a>
                            @endif
                            <a href="{{ route('file.task', $file->id) }}" target="_blank" download class="bg-red-50 text-red-600 px-3 py-1.5 rounded-md text-sm font-medium hover:bg-red-100 transition-colors flex items-center gap-2">
                                <span><i class="fi fi-rr-download"></i></span> Download
                            </a>
                        </div>
                    </div>
                    @if(strtolower($file->tipe) === 'pdf')
                        <div class="pdf-viewer-container" id="pdf-file-{{ $file->id }}" style="display: none;">
                            <iframe data-src="{{ route('file.task', $file->id) }}" title="PDF Viewer - {{ $file->nama_file }}"></iframe>
                        </div>
                    @endif
                </div>
                @endforeach

                @foreach($taskLinks as $link)
                <div class="file-attachment">
                    <div class="flex items-center gap-4">
                        <span class="text-2xl"><i class="fi fi-rr-link"></i></span>
                        <div>
                            <div class="font-semibold text-slate-800">{{ $link->nama_file }}</div>
                            <div class="text-xs text-slate-500">{{ $link->url }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if(str_contains(strtolower($link->url), 'docs.google.com/spreadsheets'))
                            <!-- Append ?rm=minimal to gsheets URL for embedding if not present, though normal URL works too -->
                            <button type="button" onclick="openPdfModal('{{ $link->nama_file }}', '{{ $link->url }}')" class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-md text-sm font-medium hover:bg-emerald-100 transition-colors flex items-center gap-2">
                                <span><i class="fi fi-rr-chart-histogram"></i></span> Live Sheet
                            </button>
                        @endif
                        <a href="{{ $link->url }}" target="_blank" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-md text-sm font-medium hover:bg-red-100 transition-colors flex items-center gap-2">
                            <span><i class="fi fi-rr-link-alt"></i></span> Kunjungi
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Catatan Tambahan -->
            @if($task->catatan)
            <div class="task-section">
                <h2>Catatan Tambahan</h2>
                <div class="description-box" style="border-left-color: #f59e0b;">
                    <p>{{ $task->catatan }}</p>
                </div>
            </div>
            @endif

            <!-- Info Pembuat -->
            <div class="task-section" style="margin-bottom: 0;">
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span><i class="fi fi-rr-calendar"></i></span>
                    <span>Dibuat {{ $task->created_at->translatedFormat('d M Y, H:i') }}
                        @if($task->creator)
                            oleh <strong class="text-slate-700">{{ $task->creator->name }}</strong>
                        @endif
                    </span>
                    @if($task->updated_at->gt($task->created_at))
                        <span class="text-slate-300">•</span>
                        <span>Diperbarui {{ $task->updated_at->translatedFormat('d M Y, H:i') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Monitoring Section -->
        <div class="monitoring-section">
             <div class="monitoring-header">
                <h2>Progres Mahasiswa ({{ $submittedCount }}/{{ $totalAssignees }})</h2>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-left">
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Nama Mahasiswa</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Tanggal Submit</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">File</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Status</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Nilai</th>
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($task->submissions as $submission)
                            @php
                                $user = $submission->user;
                                $initials = $user ? collect(explode(' ', $user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('') : '??';

                                $avatarColors = [
                                    'bg-red-100 text-red-600',
                                    'bg-pink-100 text-pink-600',
                                    'bg-emerald-100 text-emerald-600',
                                    'bg-amber-100 text-amber-600',
                                    'bg-red-100 text-red-600',
                                    'bg-red-100 text-red-600',
                                    'bg-rose-100 text-rose-600',
                                    'bg-teal-100 text-teal-600',
                                ];
                                $colorIndex = $user ? ($user->id % count($avatarColors)) : 0;
                                $avatarColor = $avatarColors[$colorIndex];

                                $isSubmissionLate = $submission->submitted_at && $submission->submitted_at->gt($task->deadline_date->setTimeFromTimeString($task->deadline_time));
                            @endphp
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="p-4 text-sm font-medium text-slate-800">
                                    <div class="flex items-center gap-3">
                                        @if($user->avatar)
                                            <img src="{{ route('file.avatar', $user->id) }}" class="w-8 h-8 rounded-full object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-full {{ $avatarColor }} flex items-center justify-center text-xs font-bold">{{ $initials }}</div>
                                        @endif
                                        {{ $user->name ?? 'Unknown' }}
                                    </div>
                                </td>
                                <td class="p-4 text-sm text-slate-600">
                                    @if($submission->submitted_at)
                                        {{ $submission->submitted_at->translatedFormat('d M Y, H:i') }}
                                        @if($isSubmissionLate)
                                            <span class="text-xs text-red-500 font-medium ml-1">(Terlambat)</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-4 text-sm">
                                    @if($submission->file_path)
                                        <div class="flex items-center gap-2">
                                        <a href="{{ route('file.submission', $submission->id) }}" target="_blank" class="text-red-600 hover:underline flex items-center gap-1">
                                            <span><i class="fi fi-rr-document"></i></span> {{ $submission->file_nama ?? 'Download' }}
                                        </a>
                                        @if(Str::endsWith(strtolower($submission->file_nama ?? $submission->file_path), '.pdf'))
                                            <button type="button" class="pdf-viewer-toggle view-btn" style="font-size: 0.7rem; padding: 3px 8px;" onclick="openPdfModal('{{ $submission->file_nama ?? 'Submission' }}', '{{ route('file.submission', $submission->id) }}')">
                                                <i class="fi fi-rr-eye"></i>
                                            </button>
                                        @elseif(Str::endsWith(strtolower($submission->file_nama ?? $submission->file_path), '.xlsx') || Str::endsWith(strtolower($submission->file_nama ?? $submission->file_path), '.xls'))
                                            <a href="{{ route('excel.editor', ['type' => 'submission', 'id' => $submission->id]) }}" class="pdf-viewer-toggle view-btn" style="font-size: 0.7rem; padding: 3px 8px; background: #ecfdf5; color: #059669; text-decoration: none;" title="Edit di Web">
                                                <i class="fi fi-rr-edit"></i>
                                            </a>
                                        @endif
                                        </div>
                                    @else
                                        <span class="text-slate-400">Belum ada file</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm">
                                    @if($submission->status === 'graded')
                                        <span class="status-badge status-graded">Dinilai{{ $submission->nilai ? ' (' . $submission->nilai . ')' : '' }}</span>
                                    @elseif($submission->status === 'submitted')
                                        <span class="status-badge status-submitted">Menunggu Review</span>
                                    @elseif($submission->status === 'pending' && $task->deadline_date->isPast())
                                        <span class="status-badge status-late">Belum Submit (Terlambat)</span>
                                    @else
                                        <span class="status-badge status-pending">Belum Submit</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm font-bold text-slate-800 text-center">
                                    {{ $submission->nilai ?? '-' }}
                                </td>
                                <td class="p-4 text-sm text-right">
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
                                                        'pesan' => $c->pesan,
                                                        'is_admin' => $c->user->role_id != 3,
                                                        'time' => $c->created_at->translatedFormat('d M, H:i')
                                                    ];
                                                })
                                            ]) }})"
                                            class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-red-700 transition-colors">
                                        Review & Nilai
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="text-4xl"><i class="fi fi-rr-clipboard-list"></i></span>
                                        <p class="font-medium text-slate-600">Belum ada data submission</p>
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
    <div class="pdf-modal-overlay" id="pdfModalOverlay" onclick="closePdfModal(event)">
        <div class="pdf-modal" onclick="event.stopPropagation()">
            <div class="pdf-modal-header">
                <h3 id="pdfModalTitle">PDF Viewer</h3>
                <button class="pdf-modal-close" onclick="closePdfModal()">&times;</button>
            </div>
            <div class="pdf-modal-body">
                <iframe id="pdfModalIframe" src="" title="PDF Viewer"></iframe>
            </div>
        </div>
    </div>

    <!-- Evaluation Modal -->
    <div class="pdf-modal-overlay" id="evaluationModal" onclick="closeEvaluationModal(event)">
        <div class="pdf-modal" style="max-width: 800px; height: 90vh;" onclick="event.stopPropagation()">
            <div class="pdf-modal-header">
                <h3 id="evalModalTitle">Review Submission: Nama Mahasiswa</h3>
                <button class="pdf-modal-close" onclick="closeEvaluationModal()">&times;</button>
            </div>
            <div class="pdf-modal-body p-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left: Review Form -->
                    <div>
                        <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <span><i class="fi fi-rr-edit"></i></span> Form Penilaian
                        </h4>
                        <form id="evalForm" method="POST" action="">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Status Submission</label>
                                <select name="status" id="evalStatus" class="w-full rounded-lg border-slate-300 text-sm">
                                    <option value="submitted">Menunggu Review</option>
                                    <option value="graded">Dinilai (Selesai)</option>
                                    <option value="returned">Dikembalikan (Perlu Revisi)</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Nilai (0-100)</label>
                                <input type="number" name="nilai" id="evalNilai" min="0" max="100" class="w-full rounded-lg border-slate-300 text-sm" placeholder="Contoh: 85">
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Komentar Utama / Feedback Internal</label>
                                <textarea name="komentar" id="evalKomentar" rows="3" class="w-full rounded-lg border-slate-300 text-sm" placeholder="Berikan feedback singkat..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-red-600 text-white font-bold py-2 rounded-lg hover:bg-red-700 transition-colors">
                                Simpan Penilaian
                            </button>
                        </form>
                    </div>

                    <!-- Right: Dialogue / Chat -->
                    <div class="flex flex-col h-full">
                        <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <span>💬</span> Diskusi & Komunikasi
                        </h4>
                        <div class="dialogue-container flex-1" id="commentFeed">
                            <!-- Comments will be injected here -->
                        </div>
                        <form id="commentForm" method="POST" action="">
                            @csrf
                            <div class="relative">
                                <input type="text" name="pesan" id="commentInput" placeholder="Ketik pesan ke mahasiswa..." 
                                       class="w-full rounded-full border-slate-300 pr-12 text-sm focus:ring-red-500 focus:border-red-500">
                                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-red-600 text-white p-1.5 rounded-full hover:bg-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-2-9-18-9 18 9 2zm0 0v-8"></path></svg>
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

            if (container.style.display === 'none') {
                container.style.display = 'block';
                // Lazy load: set src only on first open
                const iframe = container.querySelector('iframe');
                if (iframe && !iframe.src) {
                    iframe.src = iframe.dataset.src;
                }
            } else {
                container.style.display = 'none';
            }
        }

        // Open PDF in fullscreen modal
        function openPdfModal(title, pdfUrl) {
            document.getElementById('pdfModalTitle').textContent = title;
            document.getElementById('pdfModalIframe').src = pdfUrl;
            document.getElementById('pdfModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close PDF modal
        function closePdfModal(event) {
            if (event && event.target !== document.getElementById('pdfModalOverlay')) return;
            document.getElementById('pdfModalOverlay').classList.remove('active');
            document.getElementById('pdfModalIframe').src = '';
            document.body.style.overflow = '';
        }

        function openEvaluationModal(data) {
            document.getElementById('evalModalTitle').textContent = "Review Submission: " + data.nama;
            document.getElementById('evalForm').action = "/penugasan/grade/" + data.id;
            document.getElementById('commentForm').action = "/penugasan/comment/" + data.id;
            
            document.getElementById('evalStatus').value = data.status;
            document.getElementById('evalNilai').value = data.nilai || '';
            document.getElementById('evalKomentar').value = data.komentar || '';

            // Render comments
            const feed = document.getElementById('commentFeed');
            feed.innerHTML = '';
            
            if (data.comments.length === 0) {
                feed.innerHTML = '<div class="text-center text-slate-400 text-xs py-8">Belum ada diskusi.</div>';
            } else {
                data.comments.forEach(c => {
                    const initials = c.user_name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                    const avatarColor = c.is_admin ? 'bg-red-100 text-red-600' : 'bg-slate-200 text-slate-600';
                    const bubbleClass = c.is_admin ? 'admin' : '';
                    
                    let avatarHtml = `<div class="comment-avatar ${avatarColor}">${initials}</div>`;
                    if (c.avatar) {
                        avatarHtml = `<img src="${c.avatar}" class="comment-avatar object-cover">`;
                    }
                    
                    feed.innerHTML += `
                        <div class="comment-item">
                            ${avatarHtml}
                            <div class="flex-1">
                                <div class="comment-bubble ${bubbleClass}">
                                    ${c.pesan}
                                </div>
                                <div class="comment-time">${c.time}</div>
                            </div>
                        </div>
                    `;
                });
            }

            document.getElementById('evaluationModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Scroll to bottom of chat
            setTimeout(() => {
                feed.scrollTop = feed.scrollHeight;
            }, 100);
        }

        function closeEvaluationModal(event) {
            if (event && event.target !== document.getElementById('evaluationModal')) return;
            document.getElementById('evaluationModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // ESC key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePdfModal();
                closeEvaluationModal();
            }
        });
    </script>
</x-admin-layout>


