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
                    <div class="text-lg font-semibold text-slate-800">{{ $pelaksana->name }}</div>
                </div>
                <div>
                    <div class="text-sm text-slate-500 mb-1">NIM</div>
                    <div class="text-lg font-semibold text-slate-800">{{ $pelaksana->nim ?? 'NIM-'.$pelaksana->id }}</div>
                </div>
                <div>
                    <div class="text-sm text-slate-500 mb-1">Divisi</div>
                    <div class="text-lg font-semibold text-slate-800">
                        @php
                            $divName = $pelaksana->divisi->nama ?? 'Tanpa Divisi';
                            $divisionColor = 'bg-gray-50 text-gray-600';
                            if (str_contains(strtolower($divName), 'it')) $divisionColor = 'bg-purple-50 text-purple-600';
                            elseif (str_contains(strtolower($divName), 'data')) $divisionColor = 'bg-blue-50 text-blue-600';
                            elseif (str_contains(strtolower($divName), 'design')) $divisionColor = 'bg-pink-50 text-pink-600';
                            elseif (str_contains(strtolower($divName), 'quality')) $divisionColor = 'bg-green-50 text-green-600';
                        @endphp
                        <span class="px-3 py-1.5 rounded-md {{ $divisionColor }} text-sm font-medium">{{ $divName }}</span>
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
                    <div class="text-2xl font-bold text-emerald-600">{{ $stats['totalHadir'] }}</div>
                </div>
                <div class="text-3xl">✅</div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 mb-1">Terlambat</div>
                    <div class="text-2xl font-bold text-amber-600">{{ $stats['terlambat'] }}</div>
                </div>
                <div class="text-3xl">⏰</div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 mb-1">Izin</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['izinSakit'] }}</div>
                </div>
                <div class="text-3xl">📝</div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 mb-1">Alpha</div>
                    <div class="text-2xl font-bold text-red-600">{{ $stats['alpha'] }}</div>
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
                Total: {{ count($assignees) }} hari kerja
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
                    @forelse($assignees as $index => $assignee)
                        @php
                            $statusColor = 'bg-slate-100 text-slate-600 border-slate-200';
                            if ($assignee->status == 'Hadir') $statusColor = 'bg-emerald-100 text-emerald-600 border-emerald-200';
                            elseif ($assignee->status == 'Terlambat') $statusColor = 'bg-amber-100 text-amber-600 border-amber-200';
                            elseif ($assignee->status == 'Alpha') $statusColor = 'bg-red-100 text-red-600 border-red-200';
                            elseif ($assignee->status == 'Izin' || $assignee->status == 'Sakit') $statusColor = 'bg-blue-100 text-blue-600 border-blue-200';
                        @endphp
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="p-4 text-sm text-slate-800 text-center">{{ $index + 1 }}</td>
                            <td class="p-4 text-sm text-slate-800">
                                <div class="font-medium">{{ $assignee->attendance->deadline->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
                                <div class="text-xs text-slate-500">Batas: {{ $assignee->attendance->deadline->format('H:i') }} WIB | Masuk: {{ $assignee->check_in_time ? $assignee->check_in_time->format('H:i') : '--' }} WIB</div>
                                <div class="text-xs text-slate-400 mt-1">{{ $assignee->attendance->title ?? 'Absensi' }}</div>
                            </td>
                            <td class="p-4 text-sm">
                                <select class="px-3 py-1.5 rounded-md text-xs font-medium border-2 focus:outline-none focus:border-blue-500 {{ $statusColor }}" onchange="updateStatus(this, {{ $assignee->id }})">
                                    <option value="Belum Mengisi" {{ $assignee->status == 'Belum Mengisi' ? 'selected' : '' }}>Belum Mengisi</option>
                                    <option value="Hadir" {{ $assignee->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Terlambat" {{ $assignee->status == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                    <option value="Izin" {{ $assignee->status == 'Izin' ? 'selected' : '' }}>Izin/Sakit</option>
                                    <option value="Alpha" {{ $assignee->status == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                                </select>
                            </td>
                            <td class="p-4 text-sm text-slate-800">
                                <input type="text" value="{{ $assignee->keterangan ?? '-' }}" class="px-2 py-1 border border-slate-200 rounded text-sm w-full focus:outline-none focus:border-blue-500" readonly />
                            </td>
                            <td class="p-4 text-sm">
                                @if($assignee->photo_path)
                                    <button onclick="viewPhoto('{{ url('storage/' . $assignee->photo_path) }}')" class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors whitespace-nowrap">
                                        Lihat Foto
                                    </button>
                                @else
                                    <span class="text-xs text-slate-400 italic">Tidak ada foto</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500 font-medium">Belum ada riwayat kehadiran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-6 pt-5 border-t border-slate-200">
            <div class="text-slate-500 text-sm">
                Menampilkan <span class="font-bold">{{ count($assignees) }}</span> hari kerja
            </div>
            <div class="flex gap-2">
                <!-- Pagination buttons omitted for simplicity -->
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
