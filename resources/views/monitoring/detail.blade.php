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
    </style>

    <div class="task-detail-content">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <a href="{{ route('penugasan') }}" class="text-slate-500 hover:text-blue-600 mb-2 inline-block flex items-center gap-1">
                    <span>←</span> Kembali ke Daftar Tugas
                </a>
                <h1 class="text-slate-800 text-3xl font-bold mb-1">Detail Penugasan</h1>
                <p class="text-slate-600">Monitoring progres tugas mahasiswa</p>
            </div>
            <div class="flex items-center gap-3">
                 <a href="{{ route('penugasan.edit', $task->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">Edit Tugas</a>
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
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl mb-6 text-sm">
                ❌ {{ session('error') }}
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
                                    $statusClass = 'bg-blue-100 text-blue-600';
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
                            <span class="text-2xl">{{ strtolower($file->tipe) === 'pdf' ? '📄' : '📎' }}</span>
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
                                <button type="button" class="pdf-viewer-toggle view-btn" onclick="togglePdfViewer('pdf-file-{{ $file->id }}', '{{ asset('storage/' . $file->path) }}')">
                                    <span>👁️</span> Lihat PDF
                                </button>
                                <button type="button" class="pdf-viewer-toggle view-btn" onclick="openPdfModal('{{ $file->nama_file }}', '{{ asset('storage/' . $file->path) }}')" style="background: #f0fdf4; color: #16a34a;">
                                    <span>🔍</span> Fullscreen
                                </button>
                            @endif
                            <a href="{{ asset('storage/' . $file->path) }}" target="_blank" download class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-100 transition-colors flex items-center gap-2">
                                <span>⬇️</span> Download
                            </a>
                        </div>
                    </div>
                    @if(strtolower($file->tipe) === 'pdf')
                        <div class="pdf-viewer-container" id="pdf-file-{{ $file->id }}" style="display: none;">
                            <iframe data-src="{{ asset('storage/' . $file->path) }}" title="PDF Viewer - {{ $file->nama_file }}"></iframe>
                        </div>
                    @endif
                </div>
                @endforeach

                @foreach($taskLinks as $link)
                <div class="file-attachment">
                    <div class="flex items-center gap-4">
                        <span class="text-2xl">🔗</span>
                        <div>
                            <div class="font-semibold text-slate-800">{{ $link->nama_file }}</div>
                            <div class="text-xs text-slate-500">{{ $link->url }}</div>
                        </div>
                    </div>
                    <a href="{{ $link->url }}" target="_blank" class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-100 transition-colors flex items-center gap-2">
                        <span>🔗</span> Buka
                    </a>
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
                    <span>📅</span>
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
                            <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($task->submissions as $submission)
                            @php
                                $user = $submission->user;
                                $initials = $user ? collect(explode(' ', $user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('') : '??';

                                $avatarColors = [
                                    'bg-indigo-100 text-indigo-600',
                                    'bg-pink-100 text-pink-600',
                                    'bg-emerald-100 text-emerald-600',
                                    'bg-amber-100 text-amber-600',
                                    'bg-cyan-100 text-cyan-600',
                                    'bg-violet-100 text-violet-600',
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
                                        <div class="w-8 h-8 rounded-full {{ $avatarColor }} flex items-center justify-center text-xs font-bold">{{ $initials }}</div>
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
                                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                                            <span>📄</span> {{ $submission->file_nama ?? 'Download' }}
                                        </a>
                                        @if(Str::endsWith(strtolower($submission->file_nama ?? $submission->file_path), '.pdf'))
                                            <button type="button" class="pdf-viewer-toggle view-btn" style="font-size: 0.7rem; padding: 3px 8px;" onclick="openPdfModal('{{ $submission->file_nama ?? 'Submission' }}', '{{ asset('storage/' . $submission->file_path) }}')">
                                                👁️
                                            </button>
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
                                <td class="p-4 text-sm text-right">
                                    @if($submission->file_path)
                                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" download class="text-slate-500 hover:text-blue-600 transition-colors mr-2">Download</a>
                                    @else
                                        <span class="text-slate-400 cursor-not-allowed mr-2">Download</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="text-4xl">📋</span>
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

        // ESC key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closePdfModal();
        });
    </script>
</x-admin-layout>
