<x-admin-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Data Pembimbing</h1>
            <p class="text-slate-600">Daftar seluruh pembimbing PKL</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative cursor-pointer">
                <span class="text-xl">🔔</span>
                <div class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-[18px] h-[18px] text-[0.7rem] flex items-center justify-center">2</div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-blue-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Pembimbing</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">5</div>
            <div class="text-xs text-slate-500">Terdaftar aktif</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Total Pelaksana Dibimbing</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">25</div>
            <div class="text-xs text-emerald-500">Rata-rata 5 per pembimbing</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-amber-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Dibuat</h3>
            <div class="text-3xl font-bold text-slate-800 mb-1">24</div>
            <div class="text-xs text-amber-500">Total penugasan aktif</div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
        <div class="flex gap-4 w-full md:w-auto">
            <div class="text-sm font-medium text-slate-500 pt-2">Filter Pembimbing:</div>
        </div>
        <div class="flex flex-col md:flex-row gap-4 items-center w-full md:w-auto">
            <select id="divisiFilter" class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-blue-500">
                <option value="">Semua Divisi</option>
                <option value="IT Development">IT Development</option>
                <option value="Data Analytics">Data Analytics</option>
                <option value="UI/UX Design">UI/UX Design</option>
                <option value="Quality Assurance">Quality Assurance</option>
            </select>
            <input type="text" id="searchInput" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-[250px] text-sm focus:outline-none focus:border-blue-500" placeholder="Cari nama pembimbing...">
        </div>
    </div>

    <!-- Pembimbing Table -->
    <div class="bg-white rounded-xl p-8 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-slate-800 text-xl font-semibold">Tabel Pembimbing</h2>
            <div class="text-slate-500 text-sm">
                Menampilkan 5 pembimbing
            </div>
        </div>
        
        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">No</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Nama Pembimbing</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Divisi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">NIP</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Jumlah Pelaksana</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Tugas Dibuat</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors pembimbing-row" data-divisi="IT Development" data-name="Dr. Ahmad Budiman">
                        <td class="p-4 text-sm text-slate-800 text-center">1</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold">AB</div>
                                <div>
                                    <div class="font-semibold text-slate-800">Dr. Ahmad Budiman</div>
                                    <div class="text-xs text-slate-500">ahmad.budiman@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm"><span class="px-2 py-1 rounded-md bg-purple-50 text-purple-600 text-xs font-medium">IT Development</span></td>
                        <td class="p-4 text-sm text-slate-800">198501012010</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-slate-800">7</span>
                                <span class="text-xs text-slate-500">pelaksana</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex flex-col gap-1">
                                <span class="text-emerald-600 font-medium text-xs">✅ Selesai: 8</span>
                                <span class="text-blue-500 font-medium text-xs">🔄 Aktif: 3</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button class="px-3 py-1.5 rounded-md bg-slate-100 text-slate-800 text-xs font-medium hover:bg-slate-200 transition-colors hover:-translate-y-px">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors pembimbing-row" data-divisi="Data Analytics" data-name="Ir. Siti Nurhaliza">
                        <td class="p-4 text-sm text-slate-800 text-center">2</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 text-xs font-bold">SN</div>
                                <div>
                                    <div class="font-semibold text-slate-800">Ir. Siti Nurhaliza</div>
                                    <div class="text-xs text-slate-500">siti.nurhaliza@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm"><span class="px-2 py-1 rounded-md bg-blue-50 text-blue-600 text-xs font-medium">Data Analytics</span></td>
                        <td class="p-4 text-sm text-slate-800">198703152012</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-slate-800">5</span>
                                <span class="text-xs text-slate-500">pelaksana</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex flex-col gap-1">
                                <span class="text-emerald-600 font-medium text-xs">✅ Selesai: 6</span>
                                <span class="text-blue-500 font-medium text-xs">🔄 Aktif: 2</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button class="px-3 py-1.5 rounded-md bg-slate-100 text-slate-800 text-xs font-medium hover:bg-slate-200 transition-colors hover:-translate-y-px">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors pembimbing-row" data-divisi="UI/UX Design" data-name="M. Rizky Fauzan, M.Kom">
                        <td class="p-4 text-sm text-slate-800 text-center">3</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-xs font-bold">RF</div>
                                <div>
                                    <div class="font-semibold text-slate-800">M. Rizky Fauzan, M.Kom</div>
                                    <div class="text-xs text-slate-500">rizky.fauzan@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm"><span class="px-2 py-1 rounded-md bg-pink-50 text-pink-600 text-xs font-medium">UI/UX Design</span></td>
                        <td class="p-4 text-sm text-slate-800">199005202015</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-slate-800">6</span>
                                <span class="text-xs text-slate-500">pelaksana</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex flex-col gap-1">
                                <span class="text-emerald-600 font-medium text-xs">✅ Selesai: 5</span>
                                <span class="text-blue-500 font-medium text-xs">🔄 Aktif: 4</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button class="px-3 py-1.5 rounded-md bg-slate-100 text-slate-800 text-xs font-medium hover:bg-slate-200 transition-colors hover:-translate-y-px">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors pembimbing-row" data-divisi="Quality Assurance" data-name="Dra. Lina Marlina">
                        <td class="p-4 text-sm text-slate-800 text-center">4</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 text-xs font-bold">LM</div>
                                <div>
                                    <div class="font-semibold text-slate-800">Dra. Lina Marlina</div>
                                    <div class="text-xs text-slate-500">lina.marlina@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm"><span class="px-2 py-1 rounded-md bg-green-50 text-green-600 text-xs font-medium">Quality Assurance</span></td>
                        <td class="p-4 text-sm text-slate-800">198209102008</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-slate-800">4</span>
                                <span class="text-xs text-slate-500">pelaksana</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex flex-col gap-1">
                                <span class="text-emerald-600 font-medium text-xs">✅ Selesai: 3</span>
                                <span class="text-blue-500 font-medium text-xs">🔄 Aktif: 1</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button class="px-3 py-1.5 rounded-md bg-slate-100 text-slate-800 text-xs font-medium hover:bg-slate-200 transition-colors hover:-translate-y-px">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors pembimbing-row" data-divisi="IT Development" data-name="Prof. Hendro Wicaksono">
                        <td class="p-4 text-sm text-slate-800 text-center">5</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-violet-100 flex items-center justify-center text-violet-600 text-xs font-bold">HW</div>
                                <div>
                                    <div class="font-semibold text-slate-800">Prof. Hendro Wicaksono</div>
                                    <div class="text-xs text-slate-500">hendro.wicaksono@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm"><span class="px-2 py-1 rounded-md bg-purple-50 text-purple-600 text-xs font-medium">IT Development</span></td>
                        <td class="p-4 text-sm text-slate-800">197812012005</td>
                        <td class="p-4 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-bold text-slate-800">3</span>
                                <span class="text-xs text-slate-500">pelaksana</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex flex-col gap-1">
                                <span class="text-emerald-600 font-medium text-xs">✅ Selesai: 2</span>
                                <span class="text-blue-500 font-medium text-xs">🔄 Aktif: 2</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="flex gap-2">
                                <button class="px-3 py-1.5 rounded-md bg-slate-100 text-slate-800 text-xs font-medium hover:bg-slate-200 transition-colors hover:-translate-y-px">Detail</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-6 pt-5 border-t border-slate-200">
            <div class="text-slate-500 text-sm">
                Menampilkan 1-5 dari 5 pembimbing
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-2 bg-blue-500 rounded-lg text-sm text-white hover:shadow-md transition-all">1</button>
            </div>
        </div>
    </div>

    <script>
        // Search and Filter Functionality
        const searchInput = document.getElementById('searchInput');
        const divisiFilter = document.getElementById('divisiFilter');
        const rows = document.querySelectorAll('.pembimbing-row');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const divisiValue = divisiFilter.value;

            rows.forEach(row => {
                const name = row.getAttribute('data-name').toLowerCase();
                const divisi = row.getAttribute('data-divisi');

                const matchesSearch = name.includes(searchTerm);
                const matchesDivisi = divisiValue === '' || divisi === divisiValue;

                if (matchesSearch && matchesDivisi) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterTable);
        divisiFilter.addEventListener('change', filterTable);
    </script>
</x-admin-layout>
