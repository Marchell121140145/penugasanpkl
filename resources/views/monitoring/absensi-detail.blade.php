<x-admin-layout>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('absensi') }}" class="text-red-500 hover:text-red-700 transition-colors">
                <span class="text-2xl"><i class="fi fi-rr-arrow-left"></i></span>
            </a>
            <h1 class="text-slate-800 text-3xl font-bold">Detail Sesi Absensi</h1>
        </div>
        <p class="text-slate-600">Riwayat kehadiran pelaksana untuk sesi ini</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-200 flex items-start gap-3">
            <span class="text-xl"><i class="fi fi-rr-check-circle"></i></span>
            <div>
                <h4 class="font-bold text-sm">Berhasil!</h4>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Session Info Card -->
    <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <div class="text-sm text-slate-500 mb-1">Judul Sesi</div>
                <div class="text-lg font-semibold text-slate-800">{{ $attendance->title ?? 'Absensi Rutin' }}</div>
            </div>
            <div>
                <div class="text-sm text-slate-500 mb-1">Batas Check-In</div>
                <div class="text-lg font-semibold {{ $attendance->deadline < now() ? 'text-red-500' : 'text-emerald-600' }}">
                    {{ $attendance->deadline->format('d M Y, H:i') }} WIB
                </div>
            </div>
            <div>
                <div class="text-sm text-slate-500 mb-1">Mulai Check-Out</div>
                <div class="text-lg font-semibold text-slate-800">
                    @if($attendance->checkout_start)
                        {{ $attendance->checkout_start->format('d M Y, H:i') }} WIB
                    @else
                        <span class="text-slate-400 font-normal">Bebas</span>
                    @endif
                </div>
            </div>
            <div>
                <div class="text-sm text-slate-500 mb-1">Pembuat</div>
                <div class="text-lg font-semibold text-slate-800">{{ $attendance->creator->name ?? 'Admin' }}</div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-slate-400">
            <h3 class="text-slate-500 text-xs mb-1 uppercase tracking-wide">Total Peserta</h3>
            <div class="text-2xl font-bold text-slate-800">{{ count($assignees) }}</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-xs mb-1 uppercase tracking-wide">Hadir</h3>
            <div class="text-2xl font-bold text-emerald-600">{{ $stats['hadir'] }}</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-amber-500">
            <h3 class="text-slate-500 text-xs mb-1 uppercase tracking-wide">Terlambat</h3>
            <div class="text-2xl font-bold text-amber-600">{{ $stats['terlambat'] }}</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-blue-500">
            <h3 class="text-slate-500 text-xs mb-1 uppercase tracking-wide">Check-Out</h3>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['selesai'] }}</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-xs mb-1 uppercase tracking-wide">Tidak Hadir</h3>
            <div class="text-2xl font-bold text-red-600">{{ $stats['tidakHadir'] }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-6 bg-white p-5 rounded-xl shadow-sm">
        <select id="statusFilter" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-red-500">
            <option value="">Semua Status</option>
            <option value="Hadir">Hadir</option>
            <option value="Terlambat">Terlambat</option>
            <option value="Hadir - Selesai">Hadir - Selesai</option>
            <option value="Terlambat - Selesai">Terlambat - Selesai</option>
            <option value="Alpha">Alpha</option>
            <option value="Izin">Izin</option>
            <option value="Belum Mengisi">Belum Mengisi</option>
        </select>
        <select id="divisionFilter" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-red-500">
            <option value="">Semua Divisi</option>
            @foreach($divisis as $divisi)
                <option value="{{ $divisi->nama }}">{{ $divisi->nama }}</option>
            @endforeach
        </select>
        <input type="text" id="searchInput" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-64 text-sm focus:outline-none focus:border-red-500" placeholder="Cari nama pelaksana...">
    </div>

    <!-- Assignees Table -->
    <div class="bg-white rounded-xl p-8 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-slate-800 text-xl font-semibold">Daftar Kehadiran Pelaksana</h2>
            <div class="text-slate-500 text-sm">
                Total: <span class="font-medium text-slate-800">{{ count($assignees) }}</span> peserta
            </div>
        </div>

        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm w-12">No</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Nama Mahasiswa</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Divisi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Check-In</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Check-Out</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Status</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Keterangan</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Bukti</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignees as $index => $assignee)
                        @php
                            $user = $assignee->user;

                            $statusColor = 'bg-slate-100 text-slate-600';
                            if (in_array($assignee->status, ['Hadir', 'Hadir - Selesai'])) $statusColor = 'bg-emerald-100 text-emerald-600';
                            elseif (in_array($assignee->status, ['Terlambat', 'Terlambat - Selesai'])) $statusColor = 'bg-amber-100 text-amber-600';
                            elseif ($assignee->status == 'Alpha') $statusColor = 'bg-red-100 text-red-600';
                            elseif (in_array($assignee->status, ['Izin', 'Sakit'])) $statusColor = 'bg-red-100 text-red-600';

                            $divisionColor = 'bg-gray-50 text-gray-600';
                            $divName = $user->divisi->nama ?? 'Tanpa Divisi';
                            if (str_contains(strtolower($divName), 'it')) $divisionColor = 'bg-purple-50 text-purple-600';
                            elseif (str_contains(strtolower($divName), 'data')) $divisionColor = 'bg-red-50 text-red-600';
                            elseif (str_contains(strtolower($divName), 'design')) $divisionColor = 'bg-pink-50 text-pink-600';
                            elseif (str_contains(strtolower($divName), 'quality')) $divisionColor = 'bg-green-50 text-green-600';
                        @endphp
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors attendance-row"
                            data-name="{{ strtolower($user->name) }}"
                            data-division="{{ $divName }}"
                            data-status="{{ $assignee->status }}">

                            <td class="p-4 text-sm text-slate-800 text-center">{{ $index + 1 }}</td>
                            <td class="p-4 text-sm text-slate-800 font-medium">{{ $user->name }}</td>
                            <td class="p-4 text-sm text-slate-600"><span class="px-2 py-1 rounded-md {{ $divisionColor }} text-xs font-medium">{{ $divName }}</span></td>
                            <td class="p-4 text-sm text-slate-800">
                                @if($assignee->check_in_time)
                                    <span class="font-mono text-emerald-600 font-medium">{{ $assignee->check_in_time->format('H:i') }}</span>
                                    <span class="text-xs text-slate-400">WIB</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-slate-800">
                                @if($assignee->check_out_time)
                                    <span class="font-mono text-blue-600 font-medium">{{ $assignee->check_out_time->format('H:i') }}</span>
                                    <span class="text-xs text-slate-400">WIB</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm"><span class="px-3 py-1.5 rounded-full text-xs font-medium {{ $statusColor }} block w-fit text-center whitespace-nowrap">{{ $assignee->status }}</span></td>
                            <td class="p-4 text-sm text-slate-800">{{ $assignee->keterangan ?? '-' }}</td>
                            <td class="p-4 text-sm">
                                <div class="flex gap-1 flex-col">
                                    @if($assignee->photo_path)
                                        <button onclick="viewPhoto('{{ route('file.attendance', [$assignee->id, 'checkin']) }}')" class="px-3 py-1.5 rounded-md bg-emerald-100 text-emerald-600 text-xs font-medium hover:bg-emerald-200 transition-colors whitespace-nowrap">
                                            <i class="fi fi-rr-camera"></i> Check-In
                                        </button>
                                    @endif
                                    @if($assignee->checkout_photo_path)
                                        <button onclick="viewPhoto('{{ route('file.attendance', [$assignee->id, 'checkout']) }}')" class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors whitespace-nowrap">
                                            <i class="fi fi-rr-camera"></i> Check-Out
                                        </button>
                                    @endif
                                    @if(!$assignee->photo_path && !$assignee->checkout_photo_path)
                                        <span class="text-xs text-slate-400 italic">Tidak ada foto</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-sm">
                                <a href="{{ route('absensi.history', $user->id) }}" class="px-3 py-1.5 rounded-md bg-emerald-100 text-emerald-600 text-xs font-medium hover:bg-emerald-200 transition-colors hover:-translate-y-px inline-block whitespace-nowrap">
                                    Riwayat User
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-slate-500 font-medium">Belum ada peserta dalam sesi ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Info -->
        <div class="flex justify-between items-center mt-6 pt-5 border-t border-slate-200">
            <div class="text-slate-500 text-sm">
                Menampilkan <span class="font-medium text-slate-800">{{ count($assignees) }}</span> data mahasiswa
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
        // Search and Filter Functionality
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const divisionFilter = document.getElementById('divisionFilter');
        const attendanceRows = document.querySelectorAll('.attendance-row');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            const divisionValue = divisionFilter.value;

            attendanceRows.forEach(row => {
                const name = row.getAttribute('data-name');
                const division = row.getAttribute('data-division');
                const status = row.getAttribute('data-status');

                const matchesSearch = name.includes(searchTerm);
                const matchesStatus = statusValue === '' || status === statusValue;
                const matchesDivision = divisionValue === '' || division === divisionValue;

                row.style.display = (matchesSearch && matchesStatus && matchesDivision) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
        divisionFilter.addEventListener('change', filterTable);

        // View photo in modal
        function viewPhoto(photoUrl) {
            const modal = document.getElementById('photoModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = photoUrl;
            modal.classList.remove('hidden');
        }

        function closePhotoModal() {
            document.getElementById('photoModal').classList.add('hidden');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closePhotoModal();
        });
    </script>
</x-admin-layout>
