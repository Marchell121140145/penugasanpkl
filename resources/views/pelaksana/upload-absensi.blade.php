<x-pelaksana-layout>
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('pelaksana.absensi') }}" class="text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 flex items-center gap-2 text-sm font-medium transition-colors mb-4 inline-flex">
                <i class="fi fi-rr-arrow-left"></i> Kembali ke Riwayat
            </a>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-2 flex items-center gap-3">
                <i class="fi fi-rr-camera text-blue-600 dark:text-blue-500"></i> Upload Bukti Absensi
            </h1>
            <p class="text-slate-600 dark:text-slate-400">Ambil foto sebagai bukti kehadiran untuk check-in absensi.</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-6">
            <!-- Time Display -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 dark:from-slate-800 dark:to-slate-900 text-white p-8 text-center border-b border-blue-900/50">
                <div class="text-4xl md:text-5xl font-black mb-2 tracking-tight" id="currentTime">--:--:--</div>
                <div class="text-blue-100 dark:text-slate-400 font-medium" id="currentDate">-- --- ----</div>
                <div class="mt-4 inline-flex items-center gap-2 bg-white/20 dark:bg-slate-700/50 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-semibold border border-white/10">
                    <i class="fi fi-rr-clock"></i> Check-In Mode
                </div>
            </div>

            <div class="p-6 md:p-8">
                <!-- Attendance Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8 bg-slate-50 dark:bg-slate-900/50 p-6 rounded-xl border border-slate-100 dark:border-slate-800">
                    <div>
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Nama</div>
                        <div class="font-semibold text-slate-800 dark:text-white">{{ Auth::user()->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Tugas Absen</div>
                        <div class="font-semibold text-slate-800 dark:text-white">{{ $assignee->attendance->title ?? 'Absensi Rutin' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Batas Waktu</div>
                        <div class="font-semibold text-blue-600 dark:text-blue-400">{{ $assignee->attendance->deadline->format('d M Y - H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Status</div>
                        <div class="font-semibold text-emerald-600 dark:text-emerald-400">Belum Absen</div>
                    </div>
                </div>

                <!-- Upload Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fi fi-rr-camera text-blue-600 dark:text-blue-500"></i> Bukti Foto Absensi
                    </h3>
                    
                    <div id="uploadArea" class="border-2 border-dashed border-blue-200 dark:border-slate-700 bg-blue-50/50 dark:bg-slate-800/50 rounded-2xl p-8 text-center transition-all hover:bg-blue-50 dark:hover:bg-slate-800">
                        <div class="w-20 h-20 bg-white dark:bg-slate-700 rounded-full flex items-center justify-center text-blue-500 dark:text-blue-400 text-3xl mx-auto mb-4 shadow-sm animate-pulse">
                            <i class="fi fi-rr-camera"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Ambil Foto dengan Kamera</h4>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 max-w-sm mx-auto">
                            Pastikan foto jelas menunjukkan wajah dan lingkungan sekitar tempat kerja Anda
                        </p>
                        <button onclick="openCamera()" id="openCameraBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md shadow-blue-500/30 transition-all flex items-center gap-2 mx-auto">
                            <i class="fi fi-rr-camera"></i> Buka Kamera
                        </button>
                    </div>

                    <!-- Camera Preview (Live Video) -->
                    <div id="cameraPreview" class="hidden w-full max-w-md mx-auto aspect-video bg-black rounded-2xl overflow-hidden mt-4 relative shadow-inner">
                        <video id="video" autoplay playsinline class="w-full h-full object-cover"></video>
                    </div>
                    <div id="cameraControls" class="hidden text-center mt-6 flex-wrap justify-center gap-3">
                        <button onclick="capturePhoto()" class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-xl shadow-md shadow-emerald-500/30 transition-all flex items-center gap-2">
                            <i class="fi fi-rr-camera"></i> Ambil Foto
                        </button>
                        <button onclick="closeCamera()" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-white font-semibold py-3 px-6 rounded-xl transition-all flex items-center gap-2">
                            <i class="fi fi-rr-cross"></i> Batal
                        </button>
                    </div>

                    <!-- Hidden canvas for capturing -->
                    <canvas id="canvas" class="hidden"></canvas>

                    <!-- Preview -->
                    <div id="previewSection" class="hidden mt-6">
                        <div class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Preview Foto:</div>
                        <div id="previewContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Preview images will appear here -->
                        </div>
                    </div>
                </div>

                <form id="attendanceForm" action="{{ route('pelaksana.absensi.submit', $assignee->id) }}" method="POST" class="border-t border-slate-100 dark:border-slate-700 pt-6 mt-2">
                    @csrf
                    <input type="hidden" name="image_data" id="image_data" required>
                    
                    <div class="mb-8">
                        <label for="keterangan" class="block font-semibold text-slate-700 dark:text-slate-300 mb-2">Catatan / Keterangan (Opsional):</label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="w-full border-2 border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800 text-slate-800 dark:text-white p-4 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-500 transition-colors resize-y" placeholder="Tuliskan keterangan jika ada kondisi khusus (telat, hujan, alat rusak, izin sebentar, dsb)"></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('pelaksana.absensi') }}" class="flex-1 py-3.5 px-6 rounded-xl font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-center transition-all">
                            Kembali
                        </a>
                        <button type="submit" id="submitBtn" class="flex-[2] py-3.5 px-6 rounded-xl font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-lg shadow-blue-500/30 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            Submit Absensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID');
            const dateString = now.toLocaleDateString('id-ID', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            
            const timeEl = document.getElementById('currentTime');
            const dateEl = document.getElementById('currentDate');
            if(timeEl) timeEl.textContent = timeString;
            if(dateEl) dateEl.textContent = dateString;
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime();

        // File upload handling - Camera only
        const uploadArea = document.getElementById('uploadArea');
        const cameraPreview = document.getElementById('cameraPreview');
        const cameraControls = document.getElementById('cameraControls');
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const previewSection = document.getElementById('previewSection');
        const previewContainer = document.getElementById('previewContainer');
        const openCameraBtn = document.getElementById('openCameraBtn');

        let stream = null;
        let capturedImageData = null;

        // Open camera function
        async function openCamera() {
            try {
                // Request camera access
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'user', // Use front camera for selfie
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    } 
                });
                
                video.srcObject = stream;
                
                // Show camera preview and controls
                uploadArea.classList.add('hidden');
                cameraPreview.classList.remove('hidden');
                cameraControls.classList.remove('hidden');
                cameraControls.classList.add('flex');
                
            } catch (error) {
                console.error('Error accessing camera:', error);
                alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
            }
        }

        // Capture photo from video stream
        function capturePhoto() {
            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw current video frame to canvas
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Convert canvas to data URL
            capturedImageData = canvas.toDataURL('image/jpeg', 0.9);
            
            // Stop camera stream
            closeCamera();
            
            // Show preview
            showPreview(capturedImageData);
        }

        // Close camera
        function closeCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            
            video.srcObject = null;
            cameraPreview.classList.add('hidden');
            cameraControls.classList.remove('flex');
            cameraControls.classList.add('hidden');
            uploadArea.classList.remove('hidden');
        }

        // Show preview of captured photo
        function showPreview(imageData) {
            const previewItem = document.createElement('div');
            previewItem.className = 'relative border-2 border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden aspect-video shadow-sm group';
            previewItem.innerHTML = `
                <img src="${imageData}" class="w-full h-full object-cover" alt="Preview">
                <button type="button" onclick="removePreview(this)" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg transition-transform hover:scale-110">
                    <i class="fi fi-rr-cross text-xs"></i>
                </button>
                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity">
                    <p class="text-white text-xs font-medium">Foto siap diunggah</p>
                </div>
            `;
            
            previewContainer.innerHTML = '';
            previewContainer.appendChild(previewItem);
            previewSection.classList.remove('hidden');
            
            // Enable submit button
            document.getElementById('submitBtn').disabled = false;
        }

        // Remove preview
        function removePreview(button) {
            button.closest('div.relative').remove();
            if (previewContainer.children.length === 0) {
                previewSection.classList.add('hidden');
                document.getElementById('submitBtn').disabled = true;
                capturedImageData = null;
            }
        }

        // Intercept form submission to add captured image
        document.getElementById('attendanceForm').addEventListener('submit', function(e) {
            const hasPhoto = previewContainer.children.length > 0;
            
            if (!hasPhoto || !capturedImageData) {
                e.preventDefault();
                alert('Harap ambil foto bukti terlebih dahulu!');
                return false;
            }

            // Set hidden input with base64 data
            document.getElementById('image_data').value = capturedImageData;

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fi fi-rr-spinner animate-spin"></i> Mengirim...';
            submitBtn.disabled = true;
        });

        // Initialize
        document.getElementById('submitBtn').disabled = true;
    </script>
</x-pelaksana-layout>


