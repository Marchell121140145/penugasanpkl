<x-admin-layout>
    <style>
        #create-task-container * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        #create-task-container .container-custom {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 50px;
        }

        #create-task-container .header-custom {
            background: #3b82f6;
            color: white;
            padding: 25px;
        }

        #create-task-container .header-custom h1 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            font-weight: bold;
        }

        #create-task-container .form-section {
            padding: 30px;
        }

        #create-task-container .form-group {
            margin-bottom: 25px;
        }

        #create-task-container .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1e293b;
        }

        #create-task-container .form-control-custom {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        #create-task-container .form-control-custom:focus {
            outline: none;
            border-color: #3b82f6;
        }

        #create-task-container textarea.form-control-custom {
            min-height: 120px;
            resize: vertical;
        }

        #create-task-container .form-row-custom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        #create-task-container .btn-custom {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
        }

        #create-task-container .btn-primary-custom {
            background: #3b82f6;
            color: white;
        }

        #create-task-container .btn-primary-custom:hover {
            background: #2563eb;
        }

        #create-task-container .btn-outline-custom {
            background: white;
            border: 2px solid #e2e8f0;
            color: #64748b;
        }

        #create-task-container .btn-outline-custom:hover {
            border-color: #94a3b8;
            color: #475569;
        }

        #create-task-container .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        #create-task-container .student-list {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            max-height: 200px;
            overflow-y: auto;
        }

        #create-task-container .student-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        #create-task-container .student-item:last-child {
            border-bottom: none;
        }

        #create-task-container .student-checkbox {
            margin-right: 10px;
        }

        #create-task-container .file-upload {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        #create-task-container .file-upload:hover {
            border-color: #3b82f6;
            background: #f8fafc;
        }

        #create-task-container .file-upload.drag-over {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        #create-task-container .upload-icon {
            font-size: 2rem;
            color: #64748b;
            margin-bottom: 10px;
        }

        .nav-back {
            margin-bottom: 15px;
            display: inline-block;
            color: #64748b;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .nav-back:hover {
            color: #3b82f6;
        }

        .input-error {
            border-color: #ef4444 !important;
        }
        .error-text {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            font-size: 0.95rem;
        }
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-top: 8px;
            font-size: 0.9rem;
        }
        .file-item .file-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #334155;
        }
        .file-item .file-size {
            color: #94a3b8;
            font-size: 0.8rem;
        }
        .file-item .remove-file {
            color: #ef4444;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 1.1rem;
            padding: 0 4px;
        }
        .file-item .remove-file:hover {
            color: #dc2626;
        }

        .existing-file {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .existing-file.marked-delete {
            background: #fef2f2;
            border-color: #fecaca;
            opacity: 0.6;
        }

        .link-entry {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            align-items: flex-start;
        }
        .link-entry input {
            flex: 1;
        }
        .link-entry .remove-link {
            color: #ef4444;
            cursor: pointer;
            background: none;
            border: 2px solid #fecaca;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 1rem;
            transition: all 0.3s;
            margin-top: 0;
        }
        .link-entry .remove-link:hover {
            background: #fef2f2;
            border-color: #ef4444;
        }
        .add-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            margin-top: 10px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: #3b82f6;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        .add-link-btn:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .student-counter {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 8px;
        }
        .student-counter strong {
            color: #3b82f6;
        }
    </style>

    <div id="create-task-container">
        <!-- Back Navigation -->
        <a href="{{ route('penugasan.show', $task->id) }}" class="nav-back">
            <span>←</span> Kembali ke Detail Tugas
        </a>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        <div class="container-custom">
            <div class="header-custom">
                <h1>✏️ Edit Tugas</h1>
                <p>Perbarui informasi tugas "{{ $task->judul }}"</p>
            </div>

            <div class="form-section">
                <form id="editTaskForm" action="{{ route('penugasan.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" id="taskStatus" value="{{ old('status', $task->status) }}">

                    <!-- Informasi Dasar Tugas -->
                    <div class="form-group">
                        <label for="taskTitle">Judul Tugas *</label>
                        <input type="text" id="taskTitle" name="judul" class="form-control-custom @error('judul') input-error @enderror" value="{{ old('judul', $task->judul) }}" required>
                        @error('judul')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="taskDescription">Deskripsi Tugas *</label>
                        <textarea id="taskDescription" name="deskripsi" class="form-control-custom @error('deskripsi') input-error @enderror" required>{{ old('deskripsi', $task->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row-custom">
                        <div class="form-group">
                            <label for="taskType">Jenis Tugas</label>
                            <select id="taskType" name="jenis_tugas" class="form-control-custom">
                                <option value="individu" {{ old('jenis_tugas', $task->jenis_tugas) == 'individu' ? 'selected' : '' }}>Tugas Individu</option>
                                <option value="kelompok" {{ old('jenis_tugas', $task->jenis_tugas) == 'kelompok' ? 'selected' : '' }}>Tugas Kelompok</option>
                                <option value="proyek" {{ old('jenis_tugas', $task->jenis_tugas) == 'proyek' ? 'selected' : '' }}>Proyek</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="taskPriority">Prioritas</label>
                            <select id="taskPriority" name="prioritas" class="form-control-custom">
                                <option value="rendah" {{ old('prioritas', $task->prioritas) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="sedang" {{ old('prioritas', $task->prioritas) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="tinggi" {{ old('prioritas', $task->prioritas) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <!-- Divisi -->
                    <div class="form-group">
                        <label for="taskDivisi">Divisi *</label>
                        <select id="taskDivisi" name="divisi_id" class="form-control-custom @error('divisi_id') input-error @enderror" required>
                            <option value="" disabled>-- Pilih Divisi --</option>
                            @foreach($divisis as $divisi)
                                <option value="{{ $divisi->id }}" {{ old('divisi_id', $task->divisi_id) == $divisi->id ? 'selected' : '' }}>
                                    {{ $divisi->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('divisi_id')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="taskStatusSelect">Status</label>
                        <select id="taskStatusSelect" name="status" class="form-control-custom">
                            <option value="draft" {{ old('status', $task->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status', $task->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <!-- Deadline -->
                    <div class="form-row-custom">
                        <div class="form-group">
                            <label for="taskDeadline">Deadline *</label>
                            <input type="date" id="taskDeadline" name="deadline_date" class="form-control-custom @error('deadline_date') input-error @enderror" value="{{ old('deadline_date', $task->deadline_date->format('Y-m-d')) }}" required>
                            @error('deadline_date')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="taskTime">Waktu Deadline</label>
                            <input type="time" id="taskTime" name="deadline_time" class="form-control-custom" value="{{ old('deadline_time', $task->deadline_time) }}">
                        </div>
                    </div>

                    <!-- Pilih Mahasiswa -->
                    <div class="form-group">
                        <label>Pilih Mahasiswa *</label>
                        @error('assignees')
                            <div class="error-text" style="margin-bottom: 8px;">{{ $message }}</div>
                        @enderror
                        @php
                            $currentAssigneeIds = old('assignees', $task->assignees->pluck('id')->toArray());
                        @endphp
                        <div class="student-list">
                            @forelse($mahasiswas as $mhs)
                                <div class="student-item">
                                    <input type="checkbox"
                                           class="student-checkbox"
                                           name="assignees[]"
                                           value="{{ $mhs->id }}"
                                           id="student{{ $mhs->id }}"
                                           {{ in_array($mhs->id, $currentAssigneeIds) ? 'checked' : '' }}>
                                    <label for="student{{ $mhs->id }}">{{ $mhs->name }} ({{ $mhs->email }})</label>
                                </div>
                            @empty
                                <div style="color: #94a3b8; text-align: center; padding: 20px;">
                                    Belum ada data mahasiswa pelaksana.
                                </div>
                            @endforelse
                        </div>
                        <div style="margin-top: 10px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                            <button type="button" class="btn-custom btn-outline-custom" style="padding: 8px 12px; font-size: 0.9rem;" onclick="selectAllStudents()">Pilih Semua</button>
                            <button type="button" class="btn-custom btn-outline-custom" style="padding: 8px 12px; font-size: 0.9rem;" onclick="deselectAllStudents()">Hapus Semua</button>
                            <span class="student-counter">Dipilih: <strong id="selectedCount">0</strong> dari {{ count($mahasiswas) }} mahasiswa</span>
                        </div>
                    </div>

                    <!-- Existing Files -->
                    @php
                        $existingFiles = $task->files->where('jenis', 'file');
                        $existingLinks = $task->files->where('jenis', 'link');
                    @endphp

                    @if($existingFiles->count() > 0)
                    <div class="form-group">
                        <label>File Terlampir Saat Ini</label>
                        <div id="existingFilesList">
                            @foreach($existingFiles as $file)
                            <div class="existing-file" id="existingFile{{ $file->id }}">
                                <div class="file-info" style="display: flex; align-items: center; gap: 8px;">
                                    <span>📎</span>
                                    <span>{{ $file->nama_file }}</span>
                                    <span class="file-size" style="color: #94a3b8; font-size: 0.8rem;">({{ strtoupper($file->tipe) }},
                                        @if($file->ukuran >= 1048576)
                                            {{ number_format($file->ukuran / 1048576, 1) }} MB
                                        @elseif($file->ukuran >= 1024)
                                            {{ number_format($file->ukuran / 1024, 1) }} KB
                                        @else
                                            {{ $file->ukuran }} Bytes
                                        @endif
                                    )</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <label style="display: flex; align-items: center; gap: 4px; cursor: pointer; font-size: 0.85rem; color: #ef4444; margin: 0;">
                                        <input type="checkbox" name="delete_files[]" value="{{ $file->id }}" onchange="toggleFileDelete(this, {{ $file->id }})">
                                        Hapus
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Files -->
                    <div class="form-group">
                        <label>Tambah File Baru (Opsional)</label>
                        <div class="file-upload" id="dropZone" onclick="document.getElementById('fileInput').click()">
                            <div class="upload-icon">📎</div>
                            <div style="font-weight: 500; margin-bottom: 5px;">Klik atau seret file kesini</div>
                            <div style="color: #64748b; font-size: 0.9rem;">
                                Format: PDF, Word, Excel, PowerPoint, Gambar, ZIP (Maks. 10MB per file)
                            </div>
                        </div>
                        <input type="file" id="fileInput" name="files[]" style="display: none;" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.zip,.rar">
                        @error('files.*')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                        <div id="fileList"></div>
                    </div>

                    <!-- Link Pendukung -->
                    <div class="form-group">
                        <label>Link Pendukung (Opsional)</label>
                        <div id="linkContainer">
                            <!-- Existing links will be rendered here by JS -->
                        </div>
                        <button type="button" class="add-link-btn" onclick="addLinkEntry()">
                            🔗 Tambah Link
                        </button>
                    </div>

                    <!-- Catatan Tambahan -->
                    <div class="form-group">
                        <label for="taskNotes">Catatan Tambahan</label>
                        <textarea id="taskNotes" name="catatan" class="form-control-custom" placeholder="Tambahkan catatan atau instruksi khusus...">{{ old('catatan', $task->catatan) }}</textarea>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                        <a href="{{ route('penugasan.show', $task->id) }}" class="btn-custom btn-outline-custom" style="text-decoration: none; text-align: center;">Batal</a>
                        <button type="submit" class="btn-custom btn-primary-custom">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // --- Student selection ---
        function updateStudentCount() {
            const checked = document.querySelectorAll('.student-checkbox:checked').length;
            document.getElementById('selectedCount').textContent = checked;
        }

        function selectAllStudents() {
            document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = true);
            updateStudentCount();
        }

        function deselectAllStudents() {
            document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = false);
            updateStudentCount();
        }

        document.querySelectorAll('.student-checkbox').forEach(cb => {
            cb.addEventListener('change', updateStudentCount);
        });
        updateStudentCount();

        // --- Toggle file delete visual ---
        function toggleFileDelete(checkbox, fileId) {
            const el = document.getElementById('existingFile' + fileId);
            if (checkbox.checked) {
                el.classList.add('marked-delete');
            } else {
                el.classList.remove('marked-delete');
            }
        }

        // --- File upload handling ---
        const fileInput = document.getElementById('fileInput');
        const fileListDiv = document.getElementById('fileList');
        const dropZone = document.getElementById('dropZone');
        let selectedFiles = new DataTransfer();

        fileInput.addEventListener('change', function() {
            for (let i = 0; i < this.files.length; i++) {
                selectedFiles.items.add(this.files[i]);
            }
            fileInput.files = selectedFiles.files;
            renderFileList();
        });

        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });
        dropZone.addEventListener('dragleave', function() {
            this.classList.remove('drag-over');
        });
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            for (let i = 0; i < e.dataTransfer.files.length; i++) {
                selectedFiles.items.add(e.dataTransfer.files[i]);
            }
            fileInput.files = selectedFiles.files;
            renderFileList();
        });

        function renderFileList() {
            fileListDiv.innerHTML = '';
            const files = selectedFiles.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const size = formatFileSize(file.size);
                const icon = getFileIcon(file.name);

                const div = document.createElement('div');
                div.className = 'file-item';
                div.innerHTML = `
                    <div class="file-info">
                        <span>${icon}</span>
                        <span>${file.name}</span>
                        <span class="file-size">(${size})</span>
                    </div>
                    <button type="button" class="remove-file" onclick="removeFile(${i})" title="Hapus file">✕</button>
                `;
                fileListDiv.appendChild(div);
            }
        }

        function removeFile(index) {
            const newDT = new DataTransfer();
            const files = selectedFiles.files;
            for (let i = 0; i < files.length; i++) {
                if (i !== index) newDT.items.add(files[i]);
            }
            selectedFiles = newDT;
            fileInput.files = selectedFiles.files;
            renderFileList();
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
        }

        function getFileIcon(filename) {
            const ext = filename.split('.').pop().toLowerCase();
            const icons = {
                'pdf': '📄', 'doc': '📝', 'docx': '📝',
                'xls': '📊', 'xlsx': '📊',
                'ppt': '📽️', 'pptx': '📽️',
                'jpg': '🖼️', 'jpeg': '🖼️', 'png': '🖼️', 'gif': '🖼️',
                'zip': '📦', 'rar': '📦',
            };
            return icons[ext] || '📎';
        }

        // --- Link handling ---
        let linkCount = 0;

        function addLinkEntry(title = '', url = '') {
            const container = document.getElementById('linkContainer');
            const div = document.createElement('div');
            div.className = 'link-entry';
            div.id = `linkEntry${linkCount}`;
            div.innerHTML = `
                <input type="text" name="links[${linkCount}][judul]" class="form-control-custom" placeholder="Judul link (opsional)" style="flex: 0.4;" value="${escapeHtml(title)}">
                <input type="url" name="links[${linkCount}][url]" class="form-control-custom" placeholder="https://contoh.com/dokumen" style="flex: 0.6;" value="${escapeHtml(url)}">
                <button type="button" class="remove-link" onclick="removeLinkEntry(${linkCount})" title="Hapus link">✕</button>
            `;
            container.appendChild(div);
            linkCount++;
        }

        function removeLinkEntry(id) {
            const entry = document.getElementById(`linkEntry${id}`);
            if (entry) entry.remove();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Pre-populate existing links from database
        @foreach($existingLinks as $link)
            addLinkEntry(@json($link->nama_file), @json($link->url));
        @endforeach

        // Restore old link data if validation fails
        @if(old('links'))
            // Clear existing links first (they were already added above)
            document.getElementById('linkContainer').innerHTML = '';
            linkCount = 0;
            @foreach(old('links') as $index => $link)
                @if(!empty($link['url']))
                    addLinkEntry(@json($link['judul'] ?? ''), @json($link['url'] ?? ''));
                @endif
            @endforeach
        @endif
    </script>
</x-admin-layout>


