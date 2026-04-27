<x-admin-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Monitoring Absensi</h1>
            <p class="text-slate-600">Kelola dan pantau kehadiran mahasiswa PKL</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative cursor-pointer">
                <span class="text-xl">🔔</span>
                <div class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-[18px] h-[18px] text-[0.7rem] flex items-center justify-center">3</div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-200 flex items-start gap-3">
            <span class="text-xl">✅</span>
            <div>
                <h4 class="font-bold text-sm">Berhasil!</h4>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Action Bar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
        <div class="flex gap-4 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
            <a href="{{ route('absensi.create') }}" class="bg-red-500 text-white px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap">
                <span>📝</span> Buat Absensi
            </a>
            <button class="bg-emerald-500 text-white px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap">
                <span>📥</span> Download
            </button>
            <button class="bg-white text-slate-800 border-2 border-slate-200 px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap hover:border-red-300">
                <span>🔄</span> Refresh
            </button>
        </div>
        <div class="flex gap-4 items-center w-full md:w-auto">
            <select id="statusFilter" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-red-500">
                <option value="">Semua Status</option>
                <option value="Hadir">Hadir</option>
                <option value="Terlambat">Terlambat</option>
                <option value="Hadir - Selesai">Hadir - Selesai</option>
                <option value="Terlambat - Selesai">Terlambat - Selesai</option>
                <option value="Alpha">Alpha</option>
                <option value="Izin">Izin</option>
            </select>
            <select id="divisionFilter" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-red-500">
                <option value="">Semua Divisi</option>
                <option value="IT Development">IT Development</option>
                <option value="Data Analytics">Data Analytics</option>
                <option value="UI/UX Design">UI/UX Design</option>
                <option value="Quality Assurance">Quality Assurance</option>
            </select>
            <input type="text" id="searchInput" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-[250px] text-sm focus:outline-none focus:border-red-500" placeholder="Cari nama atau NIM...">
        </div>
    </div>

    <!-- Date Navigation -->
    <div class="flex items-center gap-4 mb-6 bg-white p-4 rounded-xl shadow-sm">
        <button class="date-nav-btn text-red-500 p-2 rounded-lg hover:bg-slate-100 transition-colors text-lg" id="prevDateBtn">◀</button>
        <div class="date-display font-semibold text-slate-800 text-lg">{{ $selectedDate->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
        <button class="date-nav-btn text-red-500 p-2 rounded-lg hover:bg-slate-100 transition-colors text-lg" id="nextDateBtn">▶</button>
        <button class="today-btn ml-auto bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 transition-colors" id="todayBtn">Hari Ini</button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-slate-400">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Sesi</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ count($attendances) }}</div>
            <div class="text-xs text-slate-500">Sesi terdata</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Sudah Check-In</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $assignees->whereIn('status', ['Hadir', 'Terlambat', 'Hadir - Selesai', 'Terlambat - Selesai'])->count() }}</div>
            <div class="text-xs text-emerald-500">Dari {{ count($assignees) }} daftar hadir</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-blue-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Sudah Check-Out</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $assignees->whereIn('status', ['Hadir - Selesai', 'Terlambat - Selesai'])->count() }}</div>
            <div class="text-xs text-blue-500">Selesai hari ini</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-amber-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Terlambat</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $assignees->whereIn('status', ['Terlambat', 'Terlambat - Selesai'])->count() }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tidak Hadir</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">{{ $assignees->whereIn('status', ['Alpha', 'Izin', 'Sakit'])->count() }}</div>
        </div>
    </div>

    <!-- Active Attendances Table -->
    <div class="bg-white rounded-xl p-8 shadow-sm mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-slate-800 text-xl font-semibold">Daftar Sesi Absensi Aktif / Riwayat</h2>
        </div>
        
        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Judul Sesi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Batas Check-In</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Mulai Check-Out</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Pembuat</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Check-In</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Check-Out</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $att)
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="p-4 text-sm text-slate-800">{{ $att->title ?? 'Absensi Rutin' }}</td>
                            <td class="p-4 text-sm text-slate-800 font-medium {{ $att->deadline < now() ? 'text-red-500' : 'text-emerald-500' }}">
                                {{ $att->deadline->format('d M Y, H:i') }}
                            </td>
                            <td class="p-4 text-sm text-slate-800">
                                @if($att->checkout_start)
                                    <span class="font-medium {{ $att->checkout_start < now() ? 'text-blue-500' : 'text-slate-400' }}">{{ $att->checkout_start->format('d M Y, H:i') }}</span>
                                @else
                                    <span class="text-slate-400 italic text-xs">Bebas</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-slate-600">{{ $att->creator->name ?? 'Admin' }}</td>
                            <td class="p-4 text-sm text-slate-600">
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded text-xs font-medium">{{ $att->hadir_count }} / {{ $att->total_assignees }}</span>
                            </td>
                            <td class="p-4 text-sm text-slate-600">
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-medium">{{ $att->checkout_count }} / {{ $att->total_assignees }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500 font-medium">Belum ada sesi absensi yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-xl p-8 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-slate-800 text-xl font-semibold">Tabel Absensi Pelaksana (Tanggal: {{ $selectedDate->format('d/m/Y') }})</h2>
        </div>
        
        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">NIM</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Nama Mahasiswa</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Divisi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Check-In</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Check-Out</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Status</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Lokasi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Keterangan</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignees as $assignee)
                        @php
                            $user = $assignee->user;
                            
                            $statusColor = 'bg-slate-100 text-slate-600';
                            if (in_array($assignee->status, ['Hadir', 'Hadir - Selesai'])) $statusColor = 'bg-emerald-100 text-emerald-600';
                            elseif (in_array($assignee->status, ['Terlambat', 'Terlambat - Selesai'])) $statusColor = 'bg-amber-100 text-amber-600';
                            elseif ($assignee->status == 'Alpha') $statusColor = 'bg-red-100 text-red-600';
                            elseif ($assignee->status == 'Izin') $statusColor = 'bg-red-100 text-red-600';

                            $divisionColor = 'bg-gray-50 text-gray-600';
                            $divName = $user->divisi->nama ?? 'Tanpa Divisi';
                            if (str_contains(strtolower($divName), 'it')) $divisionColor = 'bg-purple-50 text-purple-600';
                            elseif (str_contains(strtolower($divName), 'data')) $divisionColor = 'bg-red-50 text-red-600';
                            elseif (str_contains(strtolower($divName), 'design')) $divisionColor = 'bg-pink-50 text-pink-600';
                            elseif (str_contains(strtolower($divName), 'quality')) $divisionColor = 'bg-green-50 text-green-600';
                        @endphp
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors attendance-row" 
                            data-nim="{{ $user->nim ?? 'NIM-'.$user->id }}" 
                            data-name="{{ $user->name }}" 
                            data-division="{{ $divName }}" 
                            data-status="{{ $assignee->status }}">
                            
                            <td class="p-4 text-sm text-slate-800">{{ $user->nim ?? 'NIM-'.$user->id }}</td>
                            <td class="p-4 text-sm text-slate-800">{{ $user->name }}</td>
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
                            <td class="p-4 text-sm text-slate-800">{{ $assignee->lokasi ?? '-' }}</td>
                            <td class="p-4 text-sm text-slate-800">{{ $assignee->keterangan ?? '-' }}</td>
                            <td class="p-4 text-sm">
                                <div class="flex gap-2">
                                    <button onclick="viewAttendanceHistory('{{ $user->id }}')" class="px-3 py-1.5 rounded-md bg-emerald-100 text-emerald-600 text-xs font-medium hover:bg-emerald-200 transition-colors hover:-translate-y-px">View Riwayat</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-slate-500 font-medium">Belum ada data absensi untuk saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-6 pt-5 border-t border-slate-200">
            <div class="text-slate-500 text-sm">
                Menampilkan <span class="font-medium text-slate-800">{{ count($assignees) }}</span> data mahasiswa
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentDateStr = "{{ $selectedDate->format('Y-m-d') }}";
            let currentDate = new Date(currentDateStr);
            
            function reloadWithDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                
                window.location.href = `{{ route('absensi') }}?date=${year}-${month}-${day}`;
            }
            
            document.getElementById('prevDateBtn').addEventListener('click', function() {
                currentDate.setDate(currentDate.getDate() - 1);
                reloadWithDate(currentDate);
            });
            
            document.getElementById('nextDateBtn').addEventListener('click', function() {
                currentDate.setDate(currentDate.getDate() + 1);
                reloadWithDate(currentDate);
            });
            
            document.getElementById('todayBtn').addEventListener('click', function() {
                reloadWithDate(new Date());
            });
        });

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
                const nim = row.getAttribute('data-nim').toLowerCase();
                const name = row.getAttribute('data-name').toLowerCase();
                const division = row.getAttribute('data-division');
                const status = row.getAttribute('data-status');

                const matchesSearch = nim.includes(searchTerm) || name.includes(searchTerm);
                const matchesStatus = statusValue === '' || status === statusValue;
                const matchesDivision = divisionValue === '' || division === divisionValue;

                if (matchesSearch && matchesStatus && matchesDivision) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Add event listeners for search and filters
        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
        divisionFilter.addEventListener('change', filterTable);

        // View Attendance History Function
        window.viewAttendanceHistory = function(nim) {
            // Redirect to attendance history page
            window.location.href = `/absensi/history/${nim}`;
        };
    </script>
</x-admin-layout>
