<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Absensi - Sistem PKL</title>
    <!-- Flaticon CDN -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8fafc;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: #3b82f6;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .header h1 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .content {
            padding: 30px;
        }

        /* Attendance Info */
        .attendance-info {
            background: #f0f9ff;
            border: 2px solid #bae6fd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 5px;
        }

        .info-value {
            font-weight: 600;
            color: #1e293b;
        }

        /* Upload Section */
        .upload-section {
            margin-bottom: 25px;
        }

        .upload-title {
            font-size: 1.1rem;
            color: #1e293b;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .upload-area {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            transition: all 0.3s;
            background: #f8fafc;
        }

        .camera-icon {
            font-size: 4rem;
            color: #3b82f6;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .camera-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            transition: all 0.3s;
        }

        .camera-btn:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        .camera-btn:active {
            transform: translateY(0);
        }

        /* Camera Preview */
        #cameraPreview {
            display: none;
            width: 100%;
            max-width: 400px;
            height: 300px;
            background: #000;
            border-radius: 12px;
            margin: 20px auto;
            overflow: hidden;
        }

        #cameraPreview video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .capture-btn {
            background: #10b981;
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 10px 5px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transition: all 0.3s;
        }

        .capture-btn:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .cancel-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 10px 5px;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            transition: all 0.3s;
        }

        .cancel-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        /* Preview Section */
        .preview-section {
            margin-top: 20px;
        }

        .preview-title {
            font-size: 1rem;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .preview-item {
            position: relative;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .preview-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        .preview-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Location Section */
        .location-section {
            background: #f0fdf4;
            border: 2px solid #bbf7d0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .location-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .location-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .location-status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-valid {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-invalid {
            background: #fef3c7;
            color: #d97706;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            flex: 1;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-outline {
            background: white;
            border: 2px solid #e2e8f0;
            color: #64748b;
        }

        .btn-outline:hover {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        /* Time Display */
        .time-display {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #1e293b;
            margin: 20px 0;
        }

        .date-display {
            text-align: center;
            color: #64748b;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fi fi-rr-camera"></i> Upload Bukti Absensi</h1>
            <p>Ambil foto sebagai bukti kehadiran</p>
        </div>

        <div class="content">
            <!-- Current Time Display -->
            <div class="time-display" id="currentTime">--:--:--</div>
            <div class="date-display" id="currentDate">-- --- ----</div>

            <!-- Attendance Info -->
            <div class="attendance-info">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nama</span>
                        <span class="info-value">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tugas Absen</span>
                        <span class="info-value">{{ $assignee->attendance->title ?? 'Absensi Rutin' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Batas Waktu</span>
                        <span class="info-value" id="attendanceType">{{ $assignee->attendance->deadline->format('d M Y - H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value" style="color: #059669;">Belum Absen</span>
                    </div>
                </div>
            </div>

            <!-- Location Info -->
            <div class="location-section">
                <div class="location-header">
                    <span><i class="fi fi-rr-marker"></i></span>
                    <strong>Lokasi Saat Ini</strong>
                </div>
                <div class="location-info">
                    <span id="locationText">Mendeteksi lokasi...</span>
                    <span class="location-status status-valid" id="locationStatus">Dalam Area</span>
                </div>
            </div>

            <!-- Upload Section -->
            <div class="upload-section">
                <div class="upload-title">
                    <span><i class="fi fi-rr-camera"></i></span>
                    Bukti Foto Absensi
                </div>
                
                <div class="upload-area" id="uploadArea">
                    <div class="camera-icon"><i class="fi fi-rr-camera"></i></div>
                    <div style="font-weight: 600; font-size: 1.2rem; margin-bottom: 10px; color: #1e293b;">Ambil Foto dengan Kamera</div>
                    <div style="color: #64748b; margin-bottom: 20px;">
                        Pastikan foto jelas menunjukkan wajah dan lingkungan sekitar
                    </div>
                    <button class="camera-btn" onclick="openCamera()" id="openCameraBtn">
                        <i class="fi fi-rr-camera"></i> Buka Kamera
                    </button>
                </div>

                <!-- Camera Preview (Live Video) -->
                <div id="cameraPreview">
                    <video id="video" autoplay playsinline></video>
                </div>
                <div id="cameraControls" style="text-align: center; display: none; margin-top: 15px;">
                    <button class="capture-btn" onclick="capturePhoto()">
                        <i class="fi fi-rr-camera"></i> Ambil Foto
                    </button>
                    <button class="cancel-btn" onclick="closeCamera()">
                        <i class="fi fi-rr-cross"></i> Batal
                    </button>
                </div>

                <!-- Hidden canvas for capturing -->
                <canvas id="canvas" style="display: none;"></canvas>

                <!-- Preview -->
                <div class="preview-section" id="previewSection" style="display: none;">
                    <div class="preview-title">Preview Foto:</div>
                    <div class="preview-container" id="previewContainer">
                        <!-- Preview images will appear here -->
                    </div>
                </div>
            </div>

            <form id="attendanceForm" action="{{ route('pelaksana.absensi.submit', $assignee->id) }}" method="POST">
                @csrf
                <input type="hidden" name="image_data" id="image_data" required>
                <input type="hidden" name="lokasi" id="lokasi" value="Mendeteksi lokasi..." required>
                
                <div class="mb-4" style="margin-top: 25px; margin-bottom: 25px;">
                    <label for="keterangan" style="display: block; font-weight: 600; margin-bottom: 10px; color: #1e293b;">Catatan / Keterangan (Opsional):</label>
                    <textarea name="keterangan" id="keterangan" rows="3" style="width: 100%; border: 2px solid #e2e8f0; border-radius: 8px; padding: 12px; font-size: 1rem; color: #333;" placeholder="Tuliskan keterangan jika ada kondisi khusus (telat, hujan, alat rusak, dsb)"></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('pelaksana.absensi') }}" class="btn btn-outline text-center" style="line-height: inherit; text-decoration: none; align-content: center;">Kembali</a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit Absensi</button>
                </div>
            </form>
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
            
            document.getElementById('currentTime').textContent = timeString;
            document.getElementById('currentDate').textContent = dateString;
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
                uploadArea.style.display = 'none';
                cameraPreview.style.display = 'block';
                cameraControls.style.display = 'block';
                
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
            cameraPreview.style.display = 'none';
            cameraControls.style.display = 'none';
            uploadArea.style.display = 'block';
        }

        // Show preview of captured photo
        function showPreview(imageData) {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            previewItem.innerHTML = `
                <img src="${imageData}" class="preview-image" alt="Preview">
                <button class="preview-remove" onclick="removePreview(this)">×</button>
            `;
            
            previewContainer.innerHTML = '';
            previewContainer.appendChild(previewItem);
            previewSection.style.display = 'block';
            
            // Enable submit button
            document.getElementById('submitBtn').disabled = false;
        }

        // Remove preview
        function removePreview(button) {
            button.parentElement.remove();
            if (previewContainer.children.length === 0) {
                previewSection.style.display = 'none';
                document.getElementById('submitBtn').disabled = true;
                capturedImageData = null;
            }
        }

        // Get location
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const locText = `Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`;
                        document.getElementById('locationText').textContent = locText;
                        document.getElementById('lokasi').value = `${lat}, ${lng}`; // Set hidden input value
                        
                        const statusElement = document.getElementById('locationStatus');
                        statusElement.textContent = 'Dalam Area';
                        statusElement.className = 'location-status status-valid';
                    },
                    (error) => {
                        document.getElementById('locationText').textContent = 'Tidak dapat mengakses lokasi';
                        document.getElementById('locationStatus').textContent = 'Location Off';
                        document.getElementById('locationStatus').className = 'location-status status-invalid';
                        document.getElementById('lokasi').value = 'Location Off / GPS Error';
                    }
                );
            } else {
                document.getElementById('locationText').textContent = 'Geolocation tidak didukung';
                document.getElementById('lokasi').value = 'Geolocation tidak didukung browser';
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
            submitBtn.textContent = 'Mengirim...';
            submitBtn.disabled = true;
        });

        // Initialize
        document.getElementById('submitBtn').disabled = true;
        getLocation();
    </script>
</body>
</html>


