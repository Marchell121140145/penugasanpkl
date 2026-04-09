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
    </style>

    <div class="task-detail-content">
        <!-- Header (Adapted to fit inside layout) -->
        <div class="header-section">
            <div class="welcome">
                <h1>Welcome Back Jack</h1>
                <p>Here overview of your course</p>
            </div>
            <div class="user-info">
                <div class="notification">
                    <span>🔔</span>
                    <div class="notification-badge">3</div>
                </div>
            </div>
        </div>

        <!-- Task Detail Card -->
        <div class="task-detail-card">
            <div class="task-header">
                <div class="task-title-section">
                    <h1>Analisis Requirement System</h1>
                    <div class="task-meta">
                        <div class="meta-item">
                            <span class="meta-label">Pembimbing</span>
                            <span class="meta-value">Dr. Ahmad Budiman</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Tanggal Diberikan</span>
                            <span class="meta-value">1 Desember 2024</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Jenis Tugas</span>
                            <span class="meta-value">Tugas Individu</span>
                        </div>
                    </div>
                </div>
                <div class="task-status status-active">Dalam Progres</div>
            </div>

            <!-- Deskripsi Tugas Section -->
            <div class="task-section">
                <h2>Deskripsi Tugas</h2>
                <div class="description-box">
                    <p>
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    </p>
                    <p style="margin-top: 15px;">
                        Tugas ini meliputi analisis mendalam terhadap kebutuhan sistem, identifikasi stakeholder, 
                        dan penyusunan dokumen requirement specification yang komprehensif.
                    </p>
                </div>
            </div>

            <!-- File Pendukung Section -->
            <div class="task-section">
                <h2>File Pendukung</h2>
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span style="font-size: 1.5rem;">📎</span>
                        <div>
                            <div style="font-weight: 600; color: var(--dark);">Panduan_Analisis_Sistem.pdf</div>
                            <div style="font-size: 0.8rem; color: var(--secondary);">PDF • 1.2 MB</div>
                        </div>
                    </div>
                    <button class="action-btn download" style="display: flex; align-items: center; gap: 5px;">
                        <span>⬇️</span> Download
                    </button>
                </div>
            </div>

            <!-- Catatan Tambahan Section -->
            <div class="task-section">
                <h2>Catatan Tambahan</h2>
                <div class="description-box" style="border-left-color: var(--warning);">
                    <p>
                        Pastikan dokumen requirement mengikuti template IEEE 830. Sertakan diagram use case dan activity diagram sebagai lampiran.
                    </p>
                </div>
            </div>

            <!-- Deadline Section -->
            <div class="deadline-section">
                <div class="deadline-header">
                    <h2>Deadline</h2>
                    <div class="deadline-warning">⚠️ 3 hari lagi</div>
                </div>
                <div class="deadline-date">📅 15 Desember 2024 - 23:59 WIB</div>
                <p style="color: var(--secondary); font-size: 0.9rem; margin-top: 10px;">
                    Pastikan untuk mengumpulkan tugas sebelum deadline berakhir. Pengumpulan terlambat akan dikenakan penalti.
                </p>
            </div>

            <!-- Upload Section -->
            <div class="upload-section">
                <div class="upload-header">
                    <h2>Upload Tugas</h2>
                    <div style="color: var(--secondary); font-size: 0.9rem;">
                        Format: PDF, DOC, DOCX (Maks. 10MB)
                    </div>
                </div>
                
                <div class="upload-area">
                    <div class="upload-icon">📁</div>
                    <div class="upload-text">
                        <strong>Drag & drop file di sini atau klik untuk upload</strong>
                    </div>
                    <div style="color: var(--secondary); font-size: 0.8rem; margin-bottom: 15px;">
                        Format yang didukung: .pdf, .doc, .docx, .zip
                    </div>
                    <button class="upload-btn">Pilih File</button>
                </div>

                <!-- Submitted Files -->
                <div class="submitted-files">
                    <h3 style="color: var(--dark); margin-bottom: 15px; font-size: 1.1rem;">File Terupload</h3>
                    
                    <div class="file-item">
                        <div class="file-info">
                            <span class="file-icon">📄</span>
                            <div>
                                <div class="file-name">draft_analysis_requirement.pdf</div>
                                <div class="file-size">2.4 MB - Diupload: 12 Des 2024 14:30</div>
                            </div>
                        </div>
                        <div class="file-actions">
                            <button class="action-btn download">Download</button>
                            <button class="action-btn delete">Hapus</button>
                        </div>
                    </div>

                    <div class="file-item">
                        <div class="file-info">
                            <span class="file-icon">📊</span>
                            <div>
                                <div class="file-name">data_support.xlsx</div>
                                <div class="file-size">1.1 MB - Diupload: 12 Des 2024 14:32</div>
                            </div>
                        </div>
                        <div class="file-actions">
                            <button class="action-btn download">Download</button>
                            <button class="action-btn delete">Hapus</button>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="submit-section">
                    <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('pelaksana.penugasan') }}'">Kembali ke Daftar Tugas</button>
                    <button type="button" class="btn-submit" id="submitTaskBtn" onclick="confirmSubmitTask()">
                        ✅ Submit Tugas
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <div class="success-message" id="successMessage">
            <span style="font-size: 1.5rem;">✅</span>
            <span>Tugas berhasil disubmit! File Anda telah dikirim untuk direview.</span>
        </div>

        <!-- Navigation Buttons -->
        <div style="display: flex; justify-content: space-between; margin-top: 20px;">
            <button style="padding: 12px 24px; border: 2px solid var(--primary); background: white; color: var(--primary); border-radius: 8px; cursor: pointer; font-weight: 600;">
                ← Tugas Sebelumnya
            </button>
            <button style="padding: 12px 24px; border: 2px solid var(--primary); background: white; color: var(--primary); border-radius: 8px; cursor: pointer; font-weight: 600;">
                Tugas Selanjutnya →
            </button>
        </div>
    </div>

    <script>
        // Simple file upload interaction
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.querySelector('.upload-area');
            const uploadBtn = document.querySelector('.upload-btn');
            
            if(uploadArea) {
                uploadArea.addEventListener('click', function() {
                    // Trigger file input click
                    let fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.accept = '.pdf,.doc,.docx,.zip';
                    fileInput.click();
                });
            }
            
            if(uploadBtn) {
                uploadBtn.addEventListener('click', function(e) {
                    e.stopPropagation(); // prevent double trigger if btn is inside area
                    let fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.accept = '.pdf,.doc,.docx,.zip';
                    fileInput.click();
                });
            }

            // Submit Task Function
            window.confirmSubmitTask = function() {
                const confirmed = confirm(
                    'Apakah Anda yakin ingin submit tugas ini?\n\n' +
                    'Setelah disubmit:\n' +
                    '• File tidak dapat diedit atau dihapus\n' +
                    '• Tugas akan dikirim untuk direview pembimbing\n' +
                    '• Status tugas akan berubah menjadi "Submitted"\n\n' +
                    'Pastikan semua file sudah lengkap sebelum submit.'
                );

                if (confirmed) {
                    submitTask();
                }
            };

            function submitTask() {
                const submitBtn = document.getElementById('submitTaskBtn');
                const successMessage = document.getElementById('successMessage');
                const statusBadge = document.querySelector('.task-status');
                const deleteButtons = document.querySelectorAll('.action-btn.delete');
                const uploadArea = document.querySelector('.upload-area');
                const uploadBtn = document.querySelector('.upload-btn');

                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.textContent = '⏳ Mengirim...';

                // Simulate server request
                setTimeout(() => {
                    // Show success message
                    successMessage.classList.add('show');
                    
                    // Update submit button
                    submitBtn.textContent = '✅ Sudah Disubmit';
                    
                    // Update status badge
                    if (statusBadge) {
                        statusBadge.className = 'task-status status-completed';
                        statusBadge.textContent = 'Submitted';
                    }

                    // Disable delete buttons
                    deleteButtons.forEach(btn => {
                        btn.disabled = true;
                        btn.style.opacity = '0.5';
                        btn.style.cursor = 'not-allowed';
                    });

                    // Disable upload area
                    if (uploadArea) {
                        uploadArea.style.opacity = '0.5';
                        uploadArea.style.cursor = 'not-allowed';
                        uploadArea.style.pointerEvents = 'none';
                    }
                    if (uploadBtn) {
                        uploadBtn.disabled = true;
                    }

                    // Scroll to success message
                    successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });

                    // In production, you would send actual POST request here:
                    // fetch('/pelaksana/penugasan/submit/1', {
                    //     method: 'POST',
                    //     headers: {
                    //         'Content-Type': 'application/json',
                    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    //     }
                    // }).then(response => response.json())
                    //   .then(data => { /* handle success */ })
                    //   .catch(error => { /* handle error */ });
                }, 1500);
            }
        });
    </script>
</x-pelaksana-layout>
