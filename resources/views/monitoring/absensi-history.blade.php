<x-admin-layout>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('absensi') }}" class="text-blue-500 hover:text-blue-700 transition-colors">
                <span class="text-2xl">←</span>
            </a>
            <h1 class="text-slate-800 text-3xl font-bold">Riwayat Absensi Mahasiswa</h1>
        </div>
        <p class="text-slate-600">Detail kehadiran dan riwayat absensi</p>
    </div>

    <!-- Student Info Card -->
    <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-3xl">
                👤
            </div>
            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <div class="text-sm text-slate-500 mb-1">Nama Mahasiswa</div>
                    <div class="text-lg font-semibold text-slate-800">Andi Wijaya</div>
                </div>
                <div>
                    <div class="text-sm text-slate-500 mb-1">NIM</div>
                    <div class="text-lg font-semibold text-slate-800">TI2024001</div>
                </div>
                <div>
                    <div class="text-sm text-slate-500 mb-1">Divisi</div>
                    <div class="text-lg font-semibold text-slate-800">
                        <span class="px-3 py-1.5 rounded-md bg-purple-50 text-purple-600 text-sm font-medium">IT Development</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 mb-1">Total Hadir</div>
                    <div class="text-2xl font-bold text-emerald-600">42</div>
                </div>
                <div class="text-3xl">✅</div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 mb-1">Terlambat</div>
                    <div class="text-2xl font-bold text-amber-600">5</div>
                </div>
                <div class="text-3xl">⏰</div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 mb-1">Izin</div>
                    <div class="text-2xl font-bold text-blue-600">2</div>
                </div>
                <div class="text-3xl">📝</div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 mb-1">Alpha</div>
                    <div class="text-2xl font-bold text-red-600">1</div>
                </div>
                <div class="text-3xl">❌</div>
            </div>
        </div>
    </div>

    <!-- Attendance History Table -->
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-slate-800 text-xl font-semibold">Riwayat Kehadiran</h2>
            <div class="text-slate-500 text-sm">
                Total: 50 hari kerja
            </div>
        </div>

        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm w-16">No</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Hari dan Tanggal</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Status</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Keterangan</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                        <td class="p-4 text-sm text-slate-800 text-center">1</td>
                        <td class="p-4 text-sm text-slate-800">
                            <div class="font-medium">Senin, 16 Desember 2024</div>
                            <div class="text-xs text-slate-500">07:45 WIB</div>
                        </td>
                        <td class="p-4 text-sm">
                            <select class="px-3 py-1.5 rounded-md text-xs font-medium border-2 focus:outline-none focus:border-blue-500 bg-emerald-100 text-emerald-600 border-emerald-200" onchange="updateStatus(this, 1)">
                                <option value="Hadir" selected>Hadir</option>
                                <option value="Terlambat">Terlambat</option>
                                <option value="Izin">Izin</option>
                                <option value="Alpha">Alpha</option>
                            </select>
                        </td>
                        <td class="p-4 text-sm text-slate-800">
                            <input type="text" value="-" class="px-2 py-1 border border-slate-200 rounded text-sm w-full focus:outline-none focus:border-blue-500" />
                        </td>
                        <td class="p-4 text-sm">
                            <button onclick="viewPhoto('https://via.placeholder.com/400x300/4ade80/ffffff?text=Bukti+Absensi+1')" class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors">
                                Lihat Foto
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                        <td class="p-4 text-sm text-slate-800 text-center">2</td>
                        <td class="p-4 text-sm text-slate-800">
                            <div class="font-medium">Selasa, 15 Desember 2024</div>
                            <div class="text-xs text-slate-500">08:10 WIB</div>
                        </td>
                        <td class="p-4 text-sm">
                            <select class="px-3 py-1.5 rounded-md text-xs font-medium border-2 focus:outline-none focus:border-blue-500 bg-amber-100 text-amber-600 border-amber-200" onchange="updateStatus(this, 2)">
                                <option value="Hadir">Hadir</option>
                                <option value="Terlambat" selected>Terlambat</option>
                                <option value="Izin">Izin</option>
                                <option value="Alpha">Alpha</option>
                            </select>
                        </td>
                        <td class="p-4 text-sm text-slate-800">
                            <input type="text" value="Macet di jalan" class="px-2 py-1 border border-slate-200 rounded text-sm w-full focus:outline-none focus:border-blue-500" />
                        </td>
                        <td class="p-4 text-sm">
                            <button onclick="viewPhoto('https://via.placeholder.com/400x300/fb923c/ffffff?text=Bukti+Absensi+2')" class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors">
                                Lihat Foto
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                        <td class="p-4 text-sm text-slate-800 text-center">3</td>
                        <td class="p-4 text-sm text-slate-800">
                            <div class="font-medium">Senin, 14 Desember 2024</div>
                            <div class="text-xs text-slate-500">07:50 WIB</div>
                        </td>
                        <td class="p-4 text-sm">
                            <select class="px-3 py-1.5 rounded-md text-xs font-medium border-2 focus:outline-none focus:border-blue-500 bg-emerald-100 text-emerald-600 border-emerald-200" onchange="updateStatus(this, 3)">
                                <option value="Hadir" selected>Hadir</option>
                                <option value="Terlambat">Terlambat</option>
                                <option value="Izin">Izin</option>
                                <option value="Alpha">Alpha</option>
                            </select>
                        </td>
                        <td class="p-4 text-sm text-slate-800">
                            <input type="text" value="-" class="px-2 py-1 border border-slate-200 rounded text-sm w-full focus:outline-none focus:border-blue-500" />
                        </td>
                        <td class="p-4 text-sm">
                            <button onclick="viewPhoto('https://via.placeholder.com/400x300/4ade80/ffffff?text=Bukti+Absensi+3')" class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors">
                                Lihat Foto
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                        <td class="p-4 text-sm text-slate-800 text-center">4</td>
                        <td class="p-4 text-sm text-slate-800">
                            <div class="font-medium">Jumat, 13 Desember 2024</div>
                            <div class="text-xs text-slate-500">-</div>
                        </td>
                        <td class="p-4 text-sm">
                            <select class="px-3 py-1.5 rounded-md text-xs font-medium border-2 focus:outline-none focus:border-blue-500 bg-blue-100 text-blue-600 border-blue-200" onchange="updateStatus(this, 4)">
                                <option value="Hadir">Hadir</option>
                                <option value="Terlambat">Terlambat</option>
                                <option value="Izin" selected>Izin</option>
                                <option value="Alpha">Alpha</option>
                            </select>
                        </td>
                        <td class="p-4 text-sm text-slate-800">
                            <input type="text" value="Sakit demam" class="px-2 py-1 border border-slate-200 rounded text-sm w-full focus:outline-none focus:border-blue-500" />
                        </td>
                        <td class="p-4 text-sm">
                            <button onclick="viewPhoto('https://via.placeholder.com/400x300/60a5fa/ffffff?text=Surat+Izin')" class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors">
                                Lihat Foto
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 text-sm text-slate-800 text-center">5</td>
                        <td class="p-4 text-sm text-slate-800">
                            <div class="font-medium">Kamis, 12 Desember 2024</div>
                            <div class="text-xs text-slate-500">07:55 WIB</div>
                        </td>
                        <td class="p-4 text-sm">
                            <select class="px-3 py-1.5 rounded-md text-xs font-medium border-2 focus:outline-none focus:border-blue-500 bg-emerald-100 text-emerald-600 border-emerald-200" onchange="updateStatus(this, 5)">
                                <option value="Hadir" selected>Hadir</option>
                                <option value="Terlambat">Terlambat</option>
                                <option value="Izin">Izin</option>
                                <option value="Alpha">Alpha</option>
                            </select>
                        </td>
                        <td class="p-4 text-sm text-slate-800">
                            <input type="text" value="-" class="px-2 py-1 border border-slate-200 rounded text-sm w-full focus:outline-none focus:border-blue-500" />
                        </td>
                        <td class="p-4 text-sm">
                            <button onclick="viewPhoto('https://via.placeholder.com/400x300/4ade80/ffffff?text=Bukti+Absensi+5')" class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors">
                                Lihat Foto
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-6 pt-5 border-t border-slate-200">
            <div class="text-slate-500 text-sm">
                Menampilkan 1-5 dari 50 hari kerja
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-700 hover:shadow-md transition-all">Sebelumnya</button>
                <button class="px-3 py-2 bg-blue-500 rounded-lg text-sm text-white hover:shadow-md transition-all">1</button>
                <button class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-700 hover:shadow-md transition-all">2</button>
                <button class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-700 hover:shadow-md transition-all">3</button>
                <button class="px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white text-slate-700 hover:shadow-md transition-all">Selanjutnya</button>
            </div>
        </div>
    </div>

    <!-- Photo Modal -->
    <div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closePhotoModal()">
        <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
            <button onclick="closePhotoModal()" class="absolute -top-10 right-0 text-white text-2xl hover:text-gray-300">
                ✕
            </button>
            <img id="modalImage" src="" alt="Bukti Absensi" class="w-full h-auto rounded-lg shadow-2xl">
        </div>
    </div>

    <script>
        // Update status styling when changed
        function updateStatus(selectElement, id) {
            const status = selectElement.value;
            
            // Remove all status classes
            selectElement.className = 'px-3 py-1.5 rounded-md text-xs font-medium border-2 focus:outline-none focus:border-blue-500';
            
            // Add appropriate class based on status
            switch(status) {
                case 'Hadir':
                    selectElement.classList.add('bg-emerald-100', 'text-emerald-600', 'border-emerald-200');
                    break;
                case 'Terlambat':
                    selectElement.classList.add('bg-amber-100', 'text-amber-600', 'border-amber-200');
                    break;
                case 'Izin':
                    selectElement.classList.add('bg-blue-100', 'text-blue-600', 'border-blue-200');
                    break;
                case 'Alpha':
                    selectElement.classList.add('bg-red-100', 'text-red-600', 'border-red-200');
                    break;
            }
            
            // In production, save to database via AJAX
            console.log(`Status for record ${id} changed to: ${status}`);
            
            // Show success notification
            showNotification(`Status berhasil diubah menjadi: ${status}`);
        }

        // View photo in modal
        function viewPhoto(photoUrl) {
            const modal = document.getElementById('photoModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = photoUrl;
            modal.classList.remove('hidden');
        }

        // Close photo modal
        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.add('hidden');
        }

        // Show notification
        function showNotification(message) {
            // Simple alert for now, can be replaced with toast notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePhotoModal();
            }
        });
    </script>
</x-admin-layout>
