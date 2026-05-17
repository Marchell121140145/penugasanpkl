<x-admin-layout>
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('penugasan') }}" class="w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:-translate-x-1 hover:shadow-md transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-slate-800 dark:text-gray-100 text-3xl font-bold mb-1">Buat Tugas Baru</h1>
                <p class="text-slate-600 dark:text-gray-400">Buat penugasan untuk peserta PKL</p>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 p-3.5 rounded-lg mb-5 w-full text-sm flex items-center">
                <i class="fi fi-rr-check-circle mr-2 text-lg"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 p-3.5 rounded-lg mb-5 w-full text-sm flex items-center">
                <i class="fi fi-rr-cross-circle mr-2 text-lg"></i> {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-slate-100 dark:border-gray-700 p-8 mb-12">
            <form id="createTaskForm" action="{{ route('penugasan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" id="taskStatus" value="active">

                    <!-- BAGIAN 1: INFORMASI TUGAS -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-gray-200 mb-4 pb-2 border-b border-slate-100 dark:border-gray-700 flex items-center gap-2">
                            <span class="text-blue-600 dark:text-blue-400 mr-1">1</span> Informasi Tugas
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="taskTitle" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-gray-300">Judul Tugas *</label>
                                <input type="text" id="taskTitle" name="judul" class="w-full px-4 py-2.5 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm transition-colors focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('judul') !border-red-500 @enderror" placeholder="Contoh: Analisis Requirement System" value="{{ old('judul') }}" required>
                                @error('judul')
                                    <div class="text-red-500 text-xs mt-1.5">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="taskDescription" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-gray-300">Deskripsi Tugas *</label>
                                <textarea id="taskDescription" name="deskripsi" rows="3" class="w-full px-4 py-2.5 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm transition-colors focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white resize-y @error('deskripsi') !border-red-500 @enderror" placeholder="Jelaskan detail tugas yang harus dikerjakan..." required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="text-red-500 text-xs mt-1.5">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="taskType" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-gray-300">Jenis Tugas</label>
                                <select id="taskType" name="jenis_tugas" class="w-full px-4 py-2.5 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm transition-colors focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="individu" {{ old('jenis_tugas') == 'individu' ? 'selected' : '' }}>Tugas Individu</option>
                                    <option value="kelompok" {{ old('jenis_tugas') == 'kelompok' ? 'selected' : '' }}>Tugas Kelompok</option>
                                    <option value="proyek" {{ old('jenis_tugas') == 'proyek' ? 'selected' : '' }}>Proyek</option>
                                </select>
                            </div>
                            <div>
                                <label for="taskPriority" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-gray-300">Prioritas</label>
                                <select id="taskPriority" name="prioritas" class="w-full px-4 py-2.5 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm transition-colors focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ old('prioritas', 'sedang') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                </select>
                            </div>

                            <div>
                                <label for="taskDivisi" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-gray-300">Divisi *</label>
                                <select id="taskDivisi" name="divisi_id" class="w-full px-4 py-2.5 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm transition-colors focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('divisi_id') !border-red-500 @enderror" required {{ auth()->user()->role_id == 2 ? 'readonly style=pointer-events:none;background-color:#f8fafc;' : '' }}>
                                    <option value="" disabled {{ old('divisi_id') || auth()->user()->role_id == 2 ? '' : 'selected' }}>-- Pilih Divisi --</option>
                                    @foreach($divisis as $divisi)
                                        <option value="{{ $divisi->id }}" {{ old('divisi_id', auth()->user()->role_id == 2 ? auth()->user()->divisi_id : '') == $divisi->id ? 'selected' : '' }}>
                                            {{ $divisi->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('divisi_id')
                                    <div class="text-red-500 text-xs mt-1.5">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="taskDeadline" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-gray-300">Deadline *</label>
                                    <input type="date" id="taskDeadline" name="deadline_date" class="w-full px-4 py-2.5 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm transition-colors focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('deadline_date') !border-red-500 @enderror" value="{{ old('deadline_date') }}" required>
                                    @error('deadline_date')
                                        <div class="text-red-500 text-xs mt-1.5">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="taskTime" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-gray-300">Waktu Deadline</label>
                                    <input type="time" id="taskTime" name="deadline_time" class="w-full px-4 py-2.5 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm transition-colors focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white" value="{{ old('deadline_time', '23:59') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BAGIAN 2: PILIH MAHASISWA -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-gray-200 mb-4 pb-2 border-b border-slate-100 dark:border-gray-700 flex items-center gap-2">
                            <span class="text-blue-600 dark:text-blue-400 mr-1">2</span> Pilih Penerima Tugas <span class="text-red-500">*</span>
                        </h3>

                        @error('assignees')
                            <div class="text-red-500 text-sm mb-4">{{ $message }}</div>
                        @enderror

                        <div class="mb-4">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <i class="fi fi-rr-search"></i>
                                </span>
                                <input type="text" id="searchPelaksana" class="w-full pl-10 pr-3 py-2.5 border-2 border-slate-200 dark:border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm" placeholder="Cari nama pelaksana...">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-[300px] overflow-y-auto p-4 bg-slate-50 dark:bg-gray-700/50 border border-slate-200 dark:border-gray-600 rounded-xl" id="pelaksanaContainer">
                            @forelse($mahasiswas as $mhs)
                                <label class="student-item flex items-center p-3 rounded-lg border border-slate-200 dark:border-gray-600 bg-white dark:bg-gray-800 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700 transition-all select-none" data-divisi="{{ $mhs->divisi_id }}">
                                    <input type="checkbox" 
                                           class="student-checkbox mr-3 w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" 
                                           name="assignees[]" 
                                           value="{{ $mhs->id }}" 
                                           id="student{{ $mhs->id }}"
                                           {{ is_array(old('assignees')) && in_array($mhs->id, old('assignees')) ? 'checked' : '' }}>
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold overflow-hidden flex-shrink-0 dark:bg-blue-900/50 dark:text-blue-300">
                                            @if($mhs->avatar)
                                                <img src="{{ route('file.avatar', $mhs->id) }}" alt="{{ $mhs->name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($mhs->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div class="overflow-hidden">
                                            <div class="font-medium text-slate-800 dark:text-gray-200 text-sm truncate student-name">{{ $mhs->name }}</div>
                                            <div class="text-xs text-slate-500 dark:text-gray-400 truncate student-email">{{ $mhs->email }}</div>
                                        </div>
                                    </div>
                                </label>
                            @empty
                                <div class="col-span-full text-slate-400 dark:text-gray-500 text-center py-6">
                                    Belum ada data mahasiswa pelaksana.
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-3 flex gap-3 items-center flex-wrap">
                            <button type="button" class="px-3 py-1.5 text-xs rounded-lg font-medium bg-white dark:bg-gray-700 border-2 border-slate-200 dark:border-gray-600 text-slate-600 dark:text-gray-300 hover:border-slate-400 dark:hover:border-gray-400 transition-colors" onclick="selectAllStudents()">Pilih Semua</button>
                            <button type="button" class="px-3 py-1.5 text-xs rounded-lg font-medium bg-white dark:bg-gray-700 border-2 border-slate-200 dark:border-gray-600 text-slate-600 dark:text-gray-300 hover:border-slate-400 dark:hover:border-gray-400 transition-colors" onclick="deselectAllStudents()">Hapus Semua</button>
                            <span class="text-xs text-slate-500 dark:text-gray-400">Dipilih: <strong id="selectedCount" class="text-blue-600 dark:text-blue-400 font-bold">0</strong> dari <span id="totalVisibleCount">{{ count($mahasiswas) }}</span></span>
                        </div>
                    </div>

                    <!-- BAGIAN 3: LAMPIRAN & CATATAN -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-gray-200 mb-4 pb-2 border-b border-slate-100 dark:border-gray-700 flex items-center gap-2">
                            <span class="text-blue-600 dark:text-blue-400 mr-1">3</span> Lampiran & Catatan Tambahan (Opsional)
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-gray-300">File Pendukung</label>
                                <div id="dropZone" class="border-2 border-dashed border-slate-300 dark:border-gray-600 rounded-lg p-6 text-center cursor-pointer transition-colors hover:border-blue-500 hover:bg-slate-50 dark:hover:bg-gray-700 dark:bg-gray-800" onclick="document.getElementById('fileInput').click()">
                                    <div class="text-3xl text-slate-400 dark:text-gray-500 mb-2"><i class="fi fi-rr-clip"></i></div>
                                    <div class="font-medium text-slate-700 dark:text-gray-200 text-sm mb-1">Klik atau seret file kesini</div>
                                    <div class="text-slate-500 dark:text-gray-400 text-xs">
                                        Maks. 10MB per file
                                    </div>
                                </div>
                                <input type="file" id="fileInput" name="files[]" class="hidden" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.zip,.rar">
                                @error('files.*')
                                    <div class="text-red-500 text-xs mt-1.5">{{ $message }}</div>
                                @enderror
                                <div id="fileList" class="mt-3 flex flex-col gap-2"></div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-gray-300">Link Pendukung</label>
                                <div id="linkContainer" class="flex flex-col gap-2">
                                    <!-- Link entries will be added here -->
                                </div>
                                <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 mt-2 border-2 border-slate-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium text-xs transition-colors hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-gray-600" onclick="addLinkEntry()">
                                    <i class="fi fi-rr-link"></i> Tambah Link
                                </button>
                            </div>

                            <div>
                                <label for="taskNotes" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-gray-300">Catatan Tambahan</label>
                                <textarea id="taskNotes" name="catatan" class="w-full px-4 py-2.5 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm transition-colors focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white min-h-[80px] resize-y" placeholder="Tambahkan catatan atau instruksi khusus...">{{ old('catatan') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4 justify-end mt-10 pt-6 border-t border-slate-200 dark:border-gray-700">
                        <button type="button" class="px-6 py-2.5 text-sm rounded-lg font-semibold bg-white dark:bg-gray-700 border-2 border-slate-200 dark:border-gray-600 text-slate-600 dark:text-gray-300 hover:border-slate-400 dark:hover:border-gray-400 transition-colors" onclick="saveDraft()">Simpan Draft</button>
                        <button type="submit" class="px-6 py-2.5 text-sm rounded-lg font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-colors">Buat Tugas</button>
                    </div>
                </form>
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

        // --- Student selection & Filtering ---
        const taskDivisiSelect = document.getElementById('taskDivisi');
        const searchPelaksanaInput = document.getElementById('searchPelaksana');
        const studentItems = document.querySelectorAll('.student-item');
        const totalVisibleCountSpan = document.getElementById('totalVisibleCount');

        function filterStudents() {
            const selectedDivisi = taskDivisiSelect.value;
            const searchText = searchPelaksanaInput.value.toLowerCase().trim();
            let visibleCount = 0;
            
            studentItems.forEach(item => {
                const cb = item.querySelector('.student-checkbox');
                const name = item.querySelector('.student-name').textContent.toLowerCase();
                const email = item.querySelector('.student-email').textContent.toLowerCase();
                const matchesDivisi = !selectedDivisi || item.dataset.divisi === selectedDivisi;
                const matchesSearch = !searchText || name.includes(searchText) || email.includes(searchText);

                if (matchesDivisi && matchesSearch) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                    // if it doesn't match division, we uncheck it so it doesn't submit
                    if (!matchesDivisi) {
                        cb.checked = false;
                    }
                }
            });
            
            totalVisibleCountSpan.textContent = visibleCount;
            updateStudentCount();
        }

        taskDivisiSelect.addEventListener('change', filterStudents);
        searchPelaksanaInput.addEventListener('input', filterStudents);
        
        // Initial run
        filterStudents();

        function updateStudentCount() {
            const checked = document.querySelectorAll('.student-checkbox:checked').length;
            document.getElementById('selectedCount').textContent = checked;
        }

        function selectAllStudents() {
            document.querySelectorAll('.student-item').forEach(item => {
                if(item.style.display !== 'none') {
                    item.querySelector('.student-checkbox').checked = true;
                }
            });
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
            this.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-gray-700');
        });
        dropZone.addEventListener('dragleave', function() {
            this.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-gray-700');
        });
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-gray-700');
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
                div.className = 'flex items-center justify-between p-3 bg-slate-50 dark:bg-gray-700 border border-slate-200 dark:border-gray-600 rounded-lg text-sm';
                div.innerHTML = `
                    <div class="flex items-center gap-2 text-slate-700 dark:text-gray-200 overflow-hidden">
                        <span class="text-slate-500 dark:text-gray-400 text-lg">${icon}</span>
                        <span class="truncate max-w-[150px] sm:max-w-xs">${file.name}</span>
                        <span class="text-slate-400 dark:text-gray-400 text-xs ml-1 whitespace-nowrap">(${size})</span>
                    </div>
                    <button type="button" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-lg px-2" onclick="removeFile(${i})" title="Hapus file"><i class="fi fi-rr-cross-small"></i></button>
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
                'pdf': '<i class="fi fi-rr-document"></i>', 'doc': '<i class="fi fi-rr-document"></i>', 'docx': '<i class="fi fi-rr-document"></i>',
                'xls': '<i class="fi fi-rr-chart-histogram"></i>', 'xlsx': '<i class="fi fi-rr-chart-histogram"></i>',
                'ppt': '<i class="fi fi-rr-presentation"></i>', 'pptx': '<i class="fi fi-rr-presentation"></i>',
                'jpg': '<i class="fi fi-rr-picture"></i>', 'jpeg': '<i class="fi fi-rr-picture"></i>', 'png': '<i class="fi fi-rr-picture"></i>', 'gif': '<i class="fi fi-rr-picture"></i>',
                'zip': '<i class="fi fi-rr-box"></i>', 'rar': '<i class="fi fi-rr-box"></i>',
            };
            return icons[ext] || '<i class="fi fi-rr-clip"></i>';
        }

        // --- Link handling ---
        let linkCount = 0;

        function addLinkEntry() {
            const container = document.getElementById('linkContainer');
            const div = document.createElement('div');
            div.className = 'flex gap-3 items-start';
            div.id = `linkEntry${linkCount}`;
            div.innerHTML = `
                <input type="text" name="links[${linkCount}][judul]" class="w-2/5 px-4 py-3 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Judul (opsional)">
                <input type="url" name="links[${linkCount}][url]" class="w-3/5 px-4 py-3 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="https://contoh.com/dokumen">
                <button type="button" class="text-red-500 border-2 border-red-200 dark:border-red-900 rounded-lg px-4 py-3 text-sm md:text-base transition-colors hover:bg-red-50 dark:hover:bg-red-900/30 hover:border-red-500" onclick="removeLinkEntry(${linkCount})" title="Hapus link"><i class="fi fi-rr-trash"></i></button>
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
                        div.className = 'flex gap-3 items-start';
                        div.id = `linkEntry${linkCount}`;
                        div.innerHTML = `
                            <input type="text" name="links[${linkCount}][judul]" class="w-2/5 px-4 py-3 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Judul (opsional)" value="{{ addslashes($link['judul'] ?? '') }}">
                            <input type="url" name="links[${linkCount}][url]" class="w-3/5 px-4 py-3 border-2 border-slate-200 dark:border-gray-600 rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="https://contoh.com/dokumen" value="{{ addslashes($link['url'] ?? '') }}">
                            <button type="button" class="text-red-500 border-2 border-red-200 dark:border-red-900 rounded-lg px-4 py-3 text-sm md:text-base transition-colors hover:bg-red-50 dark:hover:bg-red-900/30 hover:border-red-500" onclick="removeLinkEntry(${linkCount})" title="Hapus link"><i class="fi fi-rr-trash"></i></button>
                        `;
                        container.appendChild(div);
                        linkCount++;
                    })();
                @endif
            @endforeach
        @endif
    </script>
</x-admin-layout>
