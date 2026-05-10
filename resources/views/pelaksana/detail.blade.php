<x-pelaksana-layout>
    <style>
        /* Scoped Styles for Task Detail Content mainly */
        :root {
            --primary: #3b82f6;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            /* --light: #f8fafc; */ /* Conflict with tailwind maybe? */
        }

        /* Reusing user's CSS classes but ensuring they don't break layout */
        .task-detail-content * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .welcome h1 {
            color: var(--dark);
            font-size: 2rem;
            margin-bottom: 5px;
            font-weight: bold; /* Added for matching tailwind bold usually */
        }

        .welcome p {
            color: var(--secondary);
            font-size: 1.1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification {
            position: relative;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Task Detail Card */
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

        .task-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .status-active {
            background: #dbeafe;
            color: var(--primary);
        }

        .status-completed {
            background: #dcfce7;
            color: var(--success);
        }

        /* Task Sections */
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
        }

        /* Deadline Section */
        .deadline-section {
            background: #fff7ed;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid var(--warning);
            margin-bottom: 25px;
        }

        .deadline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .deadline-header h2 {
            color: var(--dark);
            font-size: 1.3rem;
            margin: 0;
            border: none;
            padding: 0;
            font-weight: 600;
        }

        .deadline-date {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--warning);
            margin-bottom: 10px;
        }

        .deadline-warning {
            color: var(--danger);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Upload Section */
        .upload-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .upload-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .upload-header h2 {
            color: var(--dark);
            font-size: 1.3rem;
            margin: 0;
            font-weight: 600;
        }

        .upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .upload-area:hover {
            border-color: var(--primary);
            background: #f8fafc;
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 15px;
        }

        .upload-text {
            color: var(--secondary);
            margin-bottom: 10px;
        }

        .upload-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .upload-btn:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        /* Submitted Files */
        .submitted-files {
            margin-top: 25px;
        }

        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .file-icon {
            font-size: 1.2rem;
            color: var(--primary);
        }

        .file-name {
            font-weight: 500;
            color: var(--dark);
        }

        .file-size {
            color: var(--secondary);
            font-size: 0.8rem;
        }

        .file-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s;
        }

        .action-btn.download {
            background: #dbeafe;
            color: var(--primary);
        }

        .action-btn.delete {
            background: #fee2e2;
            color: var(--danger);
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        /* Submit Button Section */
        .submit-section {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 2px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transition: all 0.3s;
        }

        .btn-submit:hover:not(:disabled) {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        }

        .btn-submit:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            box-shadow: none;
        }

        .btn-cancel {
            background: white;
            color: var(--secondary);
            border: 2px solid #e2e8f0;
            padding: 14px 32px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Success Message */
        .success-message {
            background: #dcfce7;
            border: 2px solid #86efac;
            color: #166534;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .success-message.show {
            display: flex;
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
            text-decoration: none;
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

        /* Dialogue Styles */
        .comment-item {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }
        .comment-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
            flex-shrink: 0;
        }
        .comment-bubble {
            background: #f1f5f9;
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 0.95rem;
            max-width: 85%;
            position: relative;
        }
        .comment-bubble.admin {
            background: #dbeafe;
            color: #1e40af;
        }
        .comment-time {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 4px;
        }
        .dialogue-container {
            max-height: 500px;
            overflow-y: auto;
            padding: 25px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 20px;
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

        .dark .upload-section {
            background: #1f2937;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        .dark .upload-area {
            border-color: #4b5563;
        }

        .dark .upload-area:hover {
            background: #374151;
            border-color: var(--primary);
        }

        .dark .file-item {
            background: #374151;
            border-color: #4b5563;
        }

        .dark .file-name {
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

        .dark .btn-cancel {
            background: #1f2937;
            color: #d1d5db;
            border-color: #4b5563;
        }

        .dark .btn-cancel:hover {
            border-color: var(--primary);
            color: var(--primary);
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
        
        .dark .deadline-section {
            background: rgba(251, 146, 60, 0.1);
            border-left-color: var(--warning);
        }
        
        .dark .deadline-header h2 {
            color: #e5e7eb;
        }
        
        .dark input[type="text"] {
            background: #374151;
            color: #f3f4f6;
            border-color: #4b5563 !important;
        }
        
        .dark input[type="text"]::placeholder {
            color: #9ca3af;
        }
        
        .dark .pdf-viewer-container {
            background: #374151;
            border-color: #4b5563;
        }
        
        .dark .task-header h1 {
            color: #f8fafc;
        }
        
        .dark .meta-value {
            color: #e5e7eb;
        }
        
        .dark select {
            background: #374151;
            color: #f3f4f6;
            border-color: #4b5563;
        }

        .dark .file-attachment-item {
            background: #374151 !important;
            border-color: #4b5563 !important;
            color: #e5e7eb;
        }
    </style>

    <div class="task-detail-content">
        <!-- Header (Adapted to fit inside layout) -->
        <div class="header-section">
            <div class="welcome">
                <h1>Welcome Back {{ Auth::user()->name }}</h1>
                <p>Berikut adalah detail tugas Anda.</p>
            </div>
        </div>

        @if(session('success'))
        <div class="success-message show" style="margin-bottom: 20px; display:flex;">
            <span style="font-size: 1.5rem;"><i class="fi fi-rr-check-circle"></i></span>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @if($errors->any() || session('error'))
        <div class="success-message show" style="margin-bottom: 20px; background: #fee2e2; border-color: #fca5a5; color: #991b1b; display:flex;">
            <span style="font-size: 1.5rem;"><i class="fi fi-rr-cross-circle"></i></span>
            <span>{{ session('error') ?? 'Terdapat kesalahan pada input form.' }}</span>
        </div>
        @endif

        @php
            $isSubmitted = in_array($submission->status, ['submitted', 'graded']);
            $isLate = !$isSubmitted && \Carbon\Carbon::parse($task->deadline_date)->isPast();
        @endphp

        <!-- Result & Review Section (Only if graded) -->
        @if($submission->status == 'graded' || $submission->komentar)
        <div class="task-detail-card" style="border-left: 6px solid var(--primary); background: #f0f9ff;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                <div>
                    <h2 style="color: var(--dark); font-size: 1.2rem; font-weight: 700; margin-bottom: 5px;">Hasil Review Admin</h2>
                    <p style="color: var(--secondary); font-size: 0.9rem;">Admin telah meninjau hasil pekerjaan Anda.</p>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.8rem; color: var(--secondary); margin-bottom: 2px;">Nilai Akhir</div>
                    <div style="font-size: 2.2rem; font-weight: 800; color: var(--primary); line-height: 1;">{{ $submission->nilai ?? '-' }}</div>
                </div>
            </div>
            
            @if($submission->komentar)
            <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #bae6fd;">
                <div style="font-weight: 600; font-size: 0.85rem; color: var(--primary); margin-bottom: 5px; display: flex; align-items: center; gap: 5px;">
                    <span><i class="fi fi-rr-bullhorn"></i></span> Pesan Utama dari Admin:
                </div>
                <p style="color: var(--dark); font-size: 0.95rem; line-height: 1.5; margin: 0;">{{ $submission->komentar }}</p>
            </div>
            @endif
        </div>

        @endif

        <!-- Dialogue Section -->
        <div class="task-detail-card">
            <div class="upload-header" style="margin-bottom: 20px;">
                <h2><i class="fi fi-rr-comment-alt"></i> Diskusi dengan Admin</h2>
            </div>
            
            <div class="dialogue-container" id="pelaksanaCommentFeed">
                @forelse($submission->comments as $comment)
                    @php
                        $isAdmin = $comment->user->role_id != 3;
                        $initials = collect(explode(' ', $comment->user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                        $avatarColor = $isAdmin ? 'bg-red-100 text-red-600' : 'bg-slate-200 text-slate-600';
                        $bubbleClass = $isAdmin ? 'admin' : '';
                    @endphp
                    <div class="comment-item">
                        @if($comment->user->avatar)
                            <img src="{{ route('file.avatar', $comment->user->id) }}" class="comment-avatar object-cover">
                        @else
                            <div class="comment-avatar {{ $avatarColor }}">{{ $initials }}</div>
                        @endif
                        <div class="flex-1">
                            <div class="comment-bubble {{ $bubbleClass }}">
                                {{ $comment->pesan }}
                            </div>
                            <div class="comment-time">{{ $comment->created_at->translatedFormat('d M Y, H:i') }}</div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: var(--secondary); padding: 40px 0;">
                        <span style="font-size: 3rem; display: block; margin-bottom: 10px;"><i class="fi fi-rr-comment-alt"></i></span>
                        <p>Belum ada diskusi untuk tugas ini.</p>
                        <p style="font-size: 0.85rem;">Gunakan kolom di bawah untuk bertanya atau memberikan kabar progres.</p>
                    </div>
                @endforelse
            </div>

            <form action="{{ route('pelaksana.comment', $submission->id) }}" method="POST">
                @csrf
                <div style="display: flex; gap: 15px;">
                    <input type="text" name="pesan" placeholder="Tulis pesan atau balasan ke admin..." 
                           required
                           style="flex: 1; padding: 12px 20px; border: 2px solid #e2e8f0; border-radius: 30px; font-size: 0.95rem; outline: none; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--primary)'"
                           onblur="this.style.borderColor='#e2e8f0'">
                    <button type="submit" class="upload-btn" style="border-radius: 30px; padding: 0 25px; display: flex; align-items: center; gap: 8px;">
                        <span>Kirim</span>
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-2-9-18-9 18 9 2zm0 0v-8"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Task Detail Card -->
        <div class="task-detail-card">
            <div class="task-header">
                <div class="task-title-section">
                    <h1>{{ $task->judul }}</h1>
                    <div class="task-meta">
                        <div class="meta-item">
                            <span class="meta-label">Pemberi Tugas</span>
                            <span class="meta-value">{{ $task->creator->name ?? 'Admin' }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Divisi</span>
                            <span class="meta-value">{{ $task->divisi->nama ?? '-' }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Jenis Tugas</span>
                            <span class="meta-value">{{ ucfirst($task->jenis_tugas) }}</span>
                        </div>
                    </div>
                </div>
                @if($submission->status == 'graded')
                    <div class="task-status" style="background:#dbeafe; color:#1e40af;">Dinilai: {{ $submission->nilai ?? '0' }}</div>
                @elseif($isSubmitted)
                    <div class="task-status status-completed">Telah Disubmit</div>
                @elseif($isLate)
                    <div class="task-status" style="background:#fee2e2; color:#b91c1c;">Terlambat</div>
                @else
                    <div class="task-status status-active">Belum Disubmit</div>
                @endif
            </div>

            <!-- Deskripsi Tugas Section -->
            <div class="task-section">
                <h2>Deskripsi Tugas</h2>
                <div class="description-box">
                    <p>{!! nl2br(e($task->deskripsi)) !!}</p>
                </div>
            </div>

            <!-- File Pendukung Section -->
            @php
                $taskFiles = $task->files->where('jenis', 'file');
                $taskLinks = $task->files->where('jenis', 'link');
            @endphp

            @if($taskFiles->count() > 0 || $taskLinks->count() > 0)
            <div class="task-section">
                <h2>File & Link Pendukung</h2>
                
                @foreach($taskFiles as $file)
                <div class="mb-4">
                    <div class="file-attachment-item" style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span style="font-size: 1.5rem;">{!! strtolower($file->tipe) === 'pdf' ? '<i class="fi fi-rr-document"></i>' : '<i class="fi fi-rr-paperclip"></i>' !!}</span>
                            <div>
                                <div style="font-weight: 600; color: var(--dark);">{{ $file->nama_file }}</div>
                                <div style="font-size: 0.8rem; color: var(--secondary);">{{ strtoupper($file->tipe) . ' • ' . round($file->ukuran / 1024, 2) . ' KB' }}</div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            @if(strtolower($file->tipe) === 'pdf')
                                <button type="button" class="pdf-viewer-toggle view-btn" onclick="togglePdfViewer('pdf-file-{{ $file->id }}', '{{ route('file.task', $file->id) }}')">
                                    <span><i class="fi fi-rr-eye"></i></span> Lihat
                                </button>
                                <button type="button" class="pdf-viewer-toggle view-btn" onclick="openPdfModal('{{ $file->nama_file }}', '{{ route('file.task', $file->id) }}')" style="background: #f0fdf4; color: #16a34a;">
                                    <span><i class="fi fi-rr-expand"></i></span> Fullscreen
                                </button>
                            @elseif(in_array(strtolower($file->tipe), ['xls', 'xlsx']))
                                <a href="{{ route('excel.editor', ['type' => 'task_file', 'id' => $file->id]) }}" class="pdf-viewer-toggle view-btn" style="background: #ecfdf5; color: #059669;">
                                    <span><i class="fi fi-rr-pencil"></i></span> Edit di Web
                                </a>
                            @endif
                            <a href="{{ route('file.task', $file->id) }}" target="_blank" class="action-btn download" style="display: flex; align-items: center; gap: 5px; text-decoration: none;">
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
                <div class="file-attachment-item" style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span style="font-size: 1.5rem;"><i class="fi fi-rr-link"></i></span>
                        <div>
                            <div style="font-weight: 600; color: var(--dark);">{{ $link->nama_file }}</div>
                            <div style="font-size: 0.8rem; color: var(--secondary);">Tautan Luar</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if(str_contains(strtolower($link->url), 'docs.google.com/spreadsheets'))
                            <button type="button" onclick="openPdfModal('{{ $link->nama_file }}', '{{ $link->url }}')" class="pdf-viewer-toggle view-btn" style="background: #f0fdf4; color: #16a34a;">
                                <span><i class="fi fi-rr-chart-histogram"></i></span> Live Sheet
                            </button>
                        @endif
                        <a href="{{ $link->url }}" target="_blank" class="action-btn download" style="display: flex; align-items: center; gap: 5px; text-decoration: none;">
                            <span><i class="fi fi-rr-arrow-up-right-from-square"></i></span> Buka
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Catatan Tambahan Section -->
            @if($task->catatan)
            <div class="task-section">
                <h2>Catatan Tambahan</h2>
                <div class="description-box" style="border-left-color: var(--warning);">
                    <p>{{ $task->catatan }}</p>
                </div>
            </div>
            @endif

            <!-- Deadline Section -->
            <div class="deadline-section">
                <div class="deadline-header">
                    <h2>Deadline</h2>
                    @if($isLate)
                        <div class="deadline-warning"><i class="fi fi-rr-triangle-warning"></i> Terlambat</div>
                    @else
                        <div class="deadline-warning" style="color: #047857;"><i class="fi fi-rr-hourglass-end"></i> {{ \Carbon\Carbon::parse($task->deadline_date)->diffForHumans() }}</div>
                    @endif
                </div>
                <div class="deadline-date"><i class="fi fi-rr-calendar"></i> {{ \Carbon\Carbon::parse($task->deadline_date)->format('d F Y') }} - {{ $task->deadline_time }} WIB</div>
            </div>

            <!-- Form Upload Tugas -->
            <form id="submissionForm" action="{{ route('pelaksana.penugasan.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="upload-section">
                    <div class="upload-header">
                        <h2>Upload Penugasan Anda</h2>
                    </div>
                    
                    @if(!$isSubmitted)
                        <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                            <div class="upload-icon"><i class="fi fi-rr-folder"></i></div>
                            <div class="upload-text" id="uploadText">
                                <strong>Klik di sini untuk upload file jawaban</strong>
                            </div>
                            <div style="color: var(--secondary); font-size: 0.8rem; margin-bottom: 15px;">
                                Format: PDF, DOC, DOCX, ZIP, XLS, JPG, dll (Maks 20MB)
                            </div>
                            <input type="file" name="file" id="fileInput" style="display:none" onchange="updateFileName(this)">
                            <div class="upload-btn" style="display:inline-block">Pilih File</div>
                        </div>
                    @endif

                    <!-- Submitted Files -->
                    @if($submission->file_path)
                    <div class="submitted-files" style="margin-top: 20px;">
                        <h3 style="color: var(--dark); margin-bottom: 15px; font-size: 1.1rem;">File Terakhir Disubmit</h3>
                        
                        <div class="file-item">
                            <div class="file-info">
                                <span class="file-icon"><i class="fi fi-rr-document"></i></span>
                                <div>
                                    <div class="file-name">{{ $submission->file_nama }}</div>
                                    <div class="file-size">{{ round($submission->file_ukuran / 1024, 2) }} KB - Disubmit: {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d M Y H:i') }}</div>
                                </div>
                            </div>
                            <div class="file-actions">
                                <a href="{{ route('file.submission', $submission->id) }}" target="_blank" class="action-btn download" style="text-decoration:none">Download</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(!$isSubmitted)
                    <!-- Submit Section -->
                    <div class="submit-section">
                        <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('pelaksana.penugasan') }}'">Kembali</button>
                        <button type="button" class="btn-submit" id="submitTaskBtn" onclick="confirmSubmitTask()"><i class="fi fi-rr-check"></i> Submit Tugas</button>
                    </div>
                    @else
                    <div class="submit-section">
                        <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('pelaksana.penugasan') }}'">Kembali ke Daftar Tugas</button>
                    </div>
                    @endif
                </div>
            </form>
        </div>

        <!-- Navigation Buttons -->
        <div style="display: flex; justify-content: start; margin-top: 20px;">
            <a href="{{ route('pelaksana.penugasan') }}" style="text-decoration:none; padding: 12px 24px; border: 2px solid var(--primary); background: white; color: var(--primary); border-radius: 8px; cursor: pointer; font-weight: 600;">
                <i class="fi fi-rr-arrow-left"></i> Kembali
            </a>
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
        function updateFileName(input) {
            if (input.files && input.files[0]) {
                document.getElementById('uploadText').innerHTML = 'File terpilih: <strong style="color:var(--primary)">' + input.files[0].name + '</strong>';
            }
        }

        function confirmSubmitTask() {
            var fileInput = document.getElementById('fileInput');
            let confirmMessage = '';

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
                submitBtn.innerHTML = '<i class="fi fi-rr-hourglass-end"></i> Mengunggah...';
                
                document.getElementById('submissionForm').submit();
            }
        }

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
            if (e.key === 'Escape') {
                closePdfModal();
            }
        });

        // Auto scroll to bottom of chat
        const chatContainer = document.getElementById('pelaksanaCommentFeed');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    </script>
</x-pelaksana-layout>


