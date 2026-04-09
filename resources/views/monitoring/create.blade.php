<x-admin-layout>
    <style>
        /* Scoped styles based on user's design */
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

        /* Nav back style */
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

        /* Error styling */
        .input-error {
            border-color: #ef4444 !important;
        }
        .error-text {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        /* Alert messages */
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

        /* File list item */
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

        /* Link section */
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

        /* Student counter */
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
        <a href="{{ route('penugasan') }}" class="nav-back">
            <span>←</span> Kembali ke Daftar Tugas
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
                <h1>📝 Buat Tugas Baru</h1>
                <p>Buat penugasan untuk peserta PKL</p>
            </div>

            <div class="form-section">
                <form id="createTaskForm" action="{{ route('penugasan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" id="taskStatus" value="active">

                    <!-- Informasi Dasar Tugas -->
                    <div class="form-group">
                        <label for="taskTitle">Judul Tugas *</label>
                        <input type="text" id="taskTitle" name="judul" class="form-control-custom @error('judul') input-error @enderror" placeholder="Contoh: Analisis Requirement System" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="taskDescription">Deskripsi Tugas *</label>
                        <textarea id="taskDescription" name="deskripsi" class="form-control-custom @error('deskripsi') input-error @enderror" placeholder="Jelaskan detail tugas yang harus dikerjakan..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row-custom">
                        <div class="form-group">
                            <label for="taskType">Jenis Tugas</label>
                            <select id="taskType" name="jenis_tugas" class="form-control-custom">
                                <option value="individu" {{ old('jenis_tugas') == 'individu' ? 'selected' : '' }}>Tugas Individu</option>
                                <option value="kelompok" {{ old('jenis_tugas') == 'kelompok' ? 'selected' : '' }}>Tugas Kelompok</option>
                                <option value="proyek" {{ old('jenis_tugas') == 'proyek' ? 'selected' : '' }}>Proyek</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="taskPriority">Prioritas</label>
                            <select id="taskPriority" name="prioritas" class="form-control-custom">
                                <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="sedang" {{ old('prioritas', 'sedang') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <!-- Divisi (Dynamic from DB) -->
                    <div class="form-group">
                        <label for="taskDivisi">Divisi *</label>
                        <select id="taskDivisi" name="divisi_id" class="form-control-custom @error('divisi_id') input-error @enderror" required>
                            <option value="" disabled {{ old('divisi_id') ? '' : 'selected' }}>-- Pilih Divisi --</option>
                            @foreach($divisis as $divisi)
                                <option value="{{ $divisi->id }}" {{ old('divisi_id') == $divisi->id ? 'selected' : '' }}>
                                    {{ $divisi->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('divisi_id')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deadline -->
                    <div class="form-row-custom">
                        <div class="form-group">
                            <label for="taskDeadline">Deadline *</label>
                            <input type="date" id="taskDeadline" name="deadline_date" class="form-control-custom @error('deadline_date') input-error @enderror" value="{{ old('deadline_date') }}" required>
                            @error('deadline_date')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="taskTime">Waktu Deadline</label>
                            <input type="time" id="taskTime" name="deadline_time" class="form-control-custom" value="{{ old('deadline_time', '23:59') }}">
                        </div>
                    </div>

                    <!-- Pilih Mahasiswa (Dynamic from DB) -->
                    <div class="form-group">
                        <label>Pilih Mahasiswa *</label>
                        @error('assignees')
                            <div class="error-text" style="margin-bottom: 8px;">{{ $message }}</div>
                        @enderror
                        <div class="student-list">
                            @forelse($mahasiswas as $mhs)
                                <div class="student-item">
                                    <input type="checkbox" 
                                           class="student-checkbox" 
                                           name="assignees[]" 
                                           value="{{ $mhs->id }}" 
                                           id="student{{ $mhs->id }}"
                                           {{ is_array(old('assignees')) && in_array($mhs->id, old('assignees')) ? 'checked' : '' }}>
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

                    <!-- File Pendukung (Multiple) -->
                    <div class="form-group">
                        <label>File Pendukung (Opsional)</label>
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
                            <!-- Link entries will be added here -->
                        </div>
                        <button type="button" class="add-link-btn" onclick="addLinkEntry()">
                            🔗 Tambah Link
                        </button>
                    </div>

                    <!-- Catatan Tambahan -->
                    <div class="form-group">
                        <label for="taskNotes">Catatan Tambahan</label>
                        <textarea id="taskNotes" name="catatan" class="form-control-custom" placeholder="Tambahkan catatan atau instruksi khusus...">{{ old('catatan') }}</textarea>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                        <button type="button" class="btn-custom btn-outline-custom" onclick="saveDraft()">Simpan Draft</button>
                        <button type="submit" class="btn-custom btn-primary-custom">Buat Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        const deadlineInput = document.getElementById('taskDeadline');
        deadlineInput.min = today;

        // Auto-set deadline ke 7 hari dari sekarang (hanya jika belum ada old value)
        if (!deadlineInput.value) {
            const nextWeek = new Date();
            nextWeek.setDate(nextWeek.getDate() + 7);
            deadlineInput.value = nextWeek.toISOString().split('T')[0];
        }

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

        // Listen for checkbox changes
        document.querySelectorAll('.student-checkbox').forEach(cb => {
            cb.addEventListener('change', updateStudentCount);
        });
        updateStudentCount(); // Initial count

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

        // Drag and drop
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

        function addLinkEntry() {
            const container = document.getElementById('linkContainer');
            const div = document.createElement('div');
            div.className = 'link-entry';
            div.id = `linkEntry${linkCount}`;
            div.innerHTML = `
                <input type="text" name="links[${linkCount}][judul]" class="form-control-custom" placeholder="Judul link (opsional)" style="flex: 0.4;">
                <input type="url" name="links[${linkCount}][url]" class="form-control-custom" placeholder="https://contoh.com/dokumen" style="flex: 0.6;">
                <button type="button" class="remove-link" onclick="removeLinkEntry(${linkCount})" title="Hapus link">✕</button>
            `;
            container.appendChild(div);
            linkCount++;
        }

        function removeLinkEntry(id) {
            const entry = document.getElementById(`linkEntry${id}`);
            if (entry) entry.remove();
        }

        // --- Draft save ---
        function saveDraft() {
            document.getElementById('taskStatus').value = 'draft';
            document.getElementById('createTaskForm').submit();
        }

        // Restore old link data (if validation fails)
        @if(old('links'))
            @foreach(old('links') as $index => $link)
                @if(!empty($link['url']))
                    (function() {
                        const container = document.getElementById('linkContainer');
                        const div = document.createElement('div');
                        div.className = 'link-entry';
                        div.id = `linkEntry${linkCount}`;
                        div.innerHTML = `
                            <input type="text" name="links[${linkCount}][judul]" class="form-control-custom" placeholder="Judul link (opsional)" style="flex: 0.4;" value="{{ addslashes($link['judul'] ?? '') }}">
                            <input type="url" name="links[${linkCount}][url]" class="form-control-custom" placeholder="https://contoh.com/dokumen" style="flex: 0.6;" value="{{ addslashes($link['url'] ?? '') }}">
                            <button type="button" class="remove-link" onclick="removeLinkEntry(${linkCount})" title="Hapus link">✕</button>
                        `;
                        container.appendChild(div);
                        linkCount++;
                    })();
                @endif
            @endforeach
        @endif
    </script>
</x-admin-layout>
