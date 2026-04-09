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

    <!-- Action Bar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
        <div class="flex gap-4 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
            <button class="bg-blue-500 text-white px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap">
                <span>📝</span> Buat Absensi
            </button>
            <button class="bg-emerald-500 text-white px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap">
                <span>📥</span> Download
            </button>
            <button class="bg-white text-slate-800 border-2 border-slate-200 px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 hover:-translate-y-0.5 shadow-sm transition-all text-sm whitespace-nowrap hover:border-blue-300">
                <span>🔄</span> Refresh
            </button>
        </div>
        <div class="flex gap-4 items-center w-full md:w-auto">
            <select id="statusFilter" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="Hadir">Hadir</option>
                <option value="Terlambat">Terlambat</option>
                <option value="Alpha">Alpha</option>
                <option value="Izin">Izin</option>
            </select>
            <select id="divisionFilter" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-blue-500">
                <option value="">Semua Divisi</option>
                <option value="IT Development">IT Development</option>
                <option value="Data Analytics">Data Analytics</option>
                <option value="UI/UX Design">UI/UX Design</option>
                <option value="Quality Assurance">Quality Assurance</option>
            </select>
            <input type="text" id="searchInput" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-[250px] text-sm focus:outline-none focus:border-blue-500" placeholder="Cari nama atau NIM...">
        </div>
    </div>

    <!-- Date Navigation -->
    <div class="flex items-center gap-4 mb-6 bg-white p-4 rounded-xl shadow-sm">
        <button class="date-nav-btn text-blue-500 p-2 rounded-lg hover:bg-slate-100 transition-colors text-lg">◀</button>
        <div class="date-display font-semibold text-slate-800 text-lg">Senin, 9 Desember 2024</div>
        <button class="date-nav-btn text-blue-500 p-2 rounded-lg hover:bg-slate-100 transition-colors text-lg">▶</button>
        <button class="today-btn ml-auto bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition-colors">Hari Ini</button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-slate-400">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Mahasiswa</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">50</div>
            <div class="text-xs text-slate-500">Terdaftar aktif</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-blue-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Hadir Hari Ini</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">42</div>
            <div class="text-xs text-emerald-500">84% kehadiran</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-amber-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Terlambat</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">5</div>
            <div class="text-xs text-amber-500">10% mahasiswa</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tidak Hadir</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">3</div>
            <div class="text-xs text-red-500">2 alpha, 1 izin</div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-xl p-8 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-slate-800 text-xl font-semibold">Tabel Absensi</h2>
            <div class="text-slate-500 text-sm">
                Terakhir update: 10:30 WIB
            </div>
        </div>
        
        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">NIM</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Nama Mahasiswa</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Divisi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Waktu Check-in</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Status</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Lokasi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Keterangan</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors attendance-row" data-nim="TI2024001" data-name="Andi Wijaya" data-division="IT Development" data-status="Hadir">
                        <td class="p-4 text-sm text-slate-800">TI2024001</td>
                        <td class="p-4 text-sm text-slate-800">Andi Wijaya</td>
                        <td class="p-4 text-sm text-slate-600"><span class="px-2 py-1 rounded-md bg-purple-50 text-purple-600 text-xs font-medium">IT Development</span></td>
                        <td class="p-4 text-sm text-slate-800">07:45 WIB</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-600 block w-fit text-center">Hadir</span></td>
                        <td class="p-4 text-sm text-slate-800">Gedung A, Lantai 2</td>
                        <td class="p-4 text-sm text-slate-800">-</td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button onclick="viewAttendanceHistory('TI2024001')" class="px-3 py-1.5 rounded-md bg-emerald-100 text-emerald-600 text-xs font-medium hover:bg-emerald-200 transition-colors hover:-translate-y-px"> View</button>
                                <button class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors hover:-translate-y-px">Edit</button>
                                <button class="px-3 py-1.5 rounded-md bg-red-100 text-red-600 text-xs font-medium hover:bg-red-200 transition-colors hover:-translate-y-px">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors attendance-row" data-nim="TI2024002" data-name="Budi Santoso" data-division="Data Analytics" data-status="Terlambat">
                        <td class="p-4 text-sm text-slate-800">TI2024002</td>
                        <td class="p-4 text-sm text-slate-800">Budi Santoso</td>
                        <td class="p-4 text-sm text-slate-600"><span class="px-2 py-1 rounded-md bg-blue-50 text-blue-600 text-xs font-medium">Data Analytics</span></td>
                        <td class="p-4 text-sm text-slate-800">08:15 WIB</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1.5 rounded-full text-xs font-medium bg-amber-100 text-amber-600 block w-fit text-center">Terlambat</span></td>
                        <td class="p-4 text-sm text-slate-800">Gedung B, Lantai 1</td>
                        <td class="p-4 text-sm text-slate-800">Macet di jalan</td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button onclick="viewAttendanceHistory('TI2024002')" class="px-3 py-1.5 rounded-md bg-emerald-100 text-emerald-600 text-xs font-medium hover:bg-emerald-200 transition-colors hover:-translate-y-px">View</button>
                                <button class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors hover:-translate-y-px">Edit</button>
                                <button class="px-3 py-1.5 rounded-md bg-red-100 text-red-600 text-xs font-medium hover:bg-red-200 transition-colors hover:-translate-y-px">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors attendance-row" data-nim="TI2024003" data-name="Siti Rahayu" data-division="UI/UX Design" data-status="Hadir">
                        <td class="p-4 text-sm text-slate-800">TI2024003</td>
                        <td class="p-4 text-sm text-slate-800">Siti Rahayu</td>
                        <td class="p-4 text-sm text-slate-600"><span class="px-2 py-1 rounded-md bg-pink-50 text-pink-600 text-xs font-medium">UI/UX Design</span></td>
                        <td class="p-4 text-sm text-slate-800">07:50 WIB</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-600 block w-fit text-center">Hadir</span></td>
                        <td class="p-4 text-sm text-slate-800">Gedung A, Lantai 3</td>
                        <td class="p-4 text-sm text-slate-800">-</td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button onclick="viewAttendanceHistory('TI2024003')" class="px-3 py-1.5 rounded-md bg-emerald-100 text-emerald-600 text-xs font-medium hover:bg-emerald-200 transition-colors hover:-translate-y-px">View</button>
                                <button class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors hover:-translate-y-px">Edit</button>
                                <button class="px-3 py-1.5 rounded-md bg-red-100 text-red-600 text-xs font-medium hover:bg-red-200 transition-colors hover:-translate-y-px">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors attendance-row" data-nim="TI2024004" data-name="Dewi Lestari" data-division="Quality Assurance" data-status="Alpha">
                        <td class="p-4 text-sm text-slate-800">TI2024004</td>
                        <td class="p-4 text-sm text-slate-800">Dewi Lestari</td>
                        <td class="p-4 text-sm text-slate-600"><span class="px-2 py-1 rounded-md bg-green-50 text-green-600 text-xs font-medium">Quality Assurance</span></td>
                        <td class="p-4 text-sm text-slate-800">-</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-600 block w-fit text-center">Alpha</span></td>
                        <td class="p-4 text-sm text-slate-800">-</td>
                        <td class="p-4 text-sm text-slate-800">Belum ada kabar</td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button onclick="viewAttendanceHistory('TI2024004')" class="px-3 py-1.5 rounded-md bg-emerald-100 text-emerald-600 text-xs font-medium hover:bg-emerald-200 transition-colors hover:-translate-y-px">View</button>
                                <button class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors hover:-translate-y-px">Edit</button>
                                <button class="px-3 py-1.5 rounded-md bg-red-100 text-red-600 text-xs font-medium hover:bg-red-200 transition-colors hover:-translate-y-px">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors attendance-row" data-nim="TI2024005" data-name="Rizki Pratama" data-division="IT Development" data-status="Izin">
                        <td class="p-4 text-sm text-slate-800">TI2024005</td>
                        <td class="p-4 text-sm text-slate-800">Rizki Pratama</td>
                        <td class="p-4 text-sm text-slate-600"><span class="px-2 py-1 rounded-md bg-purple-50 text-purple-600 text-xs font-medium">IT Development</span></td>
                        <td class="p-4 text-sm text-slate-800">-</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-600 block w-fit text-center">Izin</span></td>
                        <td class="p-4 text-sm text-slate-800">-</td>
                        <td class="p-4 text-sm text-slate-800">Sakit</td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button onclick="viewAttendanceHistory('TI2024005')" class="px-3 py-1.5 rounded-md bg-emerald-100 text-emerald-600 text-xs font-medium hover:bg-emerald-200 transition-colors hover:-translate-y-px">View</button>
                                <button class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors hover:-translate-y-px">Edit</button>
                                <button class="px-3 py-1.5 rounded-md bg-red-100 text-red-600 text-xs font-medium hover:bg-red-200 transition-colors hover:-translate-y-px">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors attendance-row" data-nim="TI2024006" data-name="Maya Sari" data-division="Data Analytics" data-status="Terlambat">
                        <td class="p-4 text-sm text-slate-800">TI2024006</td>
                        <td class="p-4 text-sm text-slate-800">Maya Sari</td>
                        <td class="p-4 text-sm text-slate-600"><span class="px-2 py-1 rounded-md bg-blue-50 text-blue-600 text-xs font-medium">Data Analytics</span></td>
                        <td class="p-4 text-sm text-slate-800">08:05 WIB</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1.5 rounded-full text-xs font-medium bg-amber-100 text-amber-600 block w-fit text-center">Terlambat</span></td>
                        <td class="p-4 text-sm text-slate-800">Gedung C, Lantai 2</td>
                        <td class="p-4 text-sm text-slate-800">Kendaraan bermasalah</td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button onclick="viewAttendanceHistory('TI2024006')" class="px-3 py-1.5 rounded-md bg-emerald-100 text-emerald-600 text-xs font-medium hover:bg-emerald-200 transition-colors hover:-translate-y-px">View</button>
                                <button class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors hover:-translate-y-px">Edit</button>
                                <button class="px-3 py-1.5 rounded-md bg-red-100 text-red-600 text-xs font-medium hover:bg-red-200 transition-colors hover:-translate-y-px">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b-0 hover:bg-slate-50 transition-colors attendance-row" data-nim="TI2024007" data-name="Fajar Nugroho" data-division="UI/UX Design" data-status="Hadir">
                        <td class="p-4 text-sm text-slate-800">TI2024007</td>
                        <td class="p-4 text-sm text-slate-800">Fajar Nugroho</td>
                        <td class="p-4 text-sm text-slate-600"><span class="px-2 py-1 rounded-md bg-pink-50 text-pink-600 text-xs font-medium">UI/UX Design</span></td>
                        <td class="p-4 text-sm text-slate-800">07:55 WIB</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-600 block w-fit text-center">Hadir</span></td>
                        <td class="p-4 text-sm text-slate-800">Gedung B, Lantai 3</td>
                        <td class="p-4 text-sm text-slate-800">-</td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button onclick="viewAttendanceHistory('TI2024007')" class="px-3 py-1.5 rounded-md bg-emerald-100 text-emerald-600 text-xs font-medium hover:bg-emerald-200 transition-colors hover:-translate-y-px">View</button>
                                <button class="px-3 py-1.5 rounded-md bg-blue-100 text-blue-600 text-xs font-medium hover:bg-blue-200 transition-colors hover:-translate-y-px">Edit</button>
                                <button class="px-3 py-1.5 rounded-md bg-red-100 text-red-600 text-xs font-medium hover:bg-red-200 transition-colors hover:-translate-y-px">Hapus</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-6 pt-5 border-t border-slate-200">
            <div class="text-slate-500 text-sm">
                Menampilkan 1-7 dari 50 mahasiswa
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

    <script>
        // Simple date navigation functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dateDisplay = document.querySelector('.date-display');
            // Update selectors to match Tailwind classes/structure if needed, 
            // but relying on classes .date-display, .date-nav-btn, .today-btn which are preserved in the HTML
            const prevBtn = document.querySelectorAll('.date-nav-btn')[0];
            const nextBtn = document.querySelectorAll('.date-nav-btn')[1]; 
            const todayBtn = document.querySelector('.today-btn');
            
            let currentDate = new Date();
            
            function updateDateDisplay() {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                // Enforce Indonesian locale
                dateDisplay.textContent = currentDate.toLocaleDateString('id-ID', options);
            }
            
            prevBtn.addEventListener('click', function() {
                currentDate.setDate(currentDate.getDate() - 1);
                updateDateDisplay();
            });
            
            nextBtn.addEventListener('click', function() {
                currentDate.setDate(currentDate.getDate() + 1);
                updateDateDisplay();
            });
            
            todayBtn.addEventListener('click', function() {
                currentDate = new Date();
                updateDateDisplay();
            });
            
            updateDateDisplay();
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
