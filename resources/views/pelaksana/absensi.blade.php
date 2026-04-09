<x-pelaksana-layout>
     <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Riwayat Absensi</h1>
            <p class="text-slate-600">Laporan kehadiran magang kamu</p>
        </div>
        <div>
            <!-- Self Check-in button idea, disabling for now unless requested -->
            <!-- <button class="bg-blue-500 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 hover:-translate-y-0.5 transition-all shadow-blue-200 shadow-lg">
                <span>📍</span> Check-In Sekarang
            </button> -->
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-emerald-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Hadir Tepat Waktu</div>
            <div class="text-2xl font-bold text-slate-800">18</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-amber-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Terlambat</div>
            <div class="text-2xl font-bold text-slate-800">2</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-blue-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Izin / Sakit</div>
            <div class="text-2xl font-bold text-slate-800">1</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm text-center border-b-4 border-red-500">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Alpha</div>
            <div class="text-2xl font-bold text-slate-800">0</div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl p-8 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-slate-800 text-xl font-semibold">Bulan Desember 2024</h2>
            <div class="flex gap-2">
                 <select class="p-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                    <option>Desember 2024</option>
                    <option>November 2024</option>
                </select>
            </div>
        </div>
        
        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Tanggal</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Waktu Check-in</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Status</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Lokasi</th>
                        <th class="p-4 font-semibold text-slate-800 border-b-2 border-slate-200 text-sm">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Active Attendance Row -->
                    <tr class="border-b border-slate-200 bg-blue-50/50 hover:bg-blue-50 transition-colors">
                        <td class="p-4 text-sm text-slate-800 font-medium">
                            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMM Y') }}
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                Hari Ini
                            </span>
                        </td>
                        <td class="p-4 text-sm text-slate-800 font-mono">--:-- WIB</td>
                        <td class="p-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 inline-block w-24 text-center border border-slate-200">Belum Absen</span>
                        </td>
                        <td class="p-4 text-sm text-slate-600">-</td>
                        <td class="p-4 text-sm">
                            <a href="{{ route('pelaksana.absensi.create') }}" class="inline-flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-camera"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                                Absen Sekarang
                            </a>
                        </td>
                    </tr>
                    
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                        <td class="p-4 text-sm text-slate-800">Jumat, 13 Des 2024</td>
                        <td class="p-4 text-sm text-slate-800 font-mono">07:45 WIB</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-600 inline-block w-24 text-center">Hadir</span></td>
                        <td class="p-4 text-sm text-slate-600">Gedung A</td>
                        <td class="p-4 text-sm text-slate-600">-</td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                        <td class="p-4 text-sm text-slate-800">Kamis, 12 Des 2024</td>
                        <td class="p-4 text-sm text-slate-800 font-mono">07:50 WIB</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-600 inline-block w-24 text-center">Hadir</span></td>
                        <td class="p-4 text-sm text-slate-600">Gedung A</td>
                        <td class="p-4 text-sm text-slate-600">-</td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                        <td class="p-4 text-sm text-slate-800">Rabu, 11 Des 2024</td>
                        <td class="p-4 text-sm text-slate-800 font-mono">08:15 WIB</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-600 inline-block w-24 text-center">Terlambat</span></td>
                        <td class="p-4 text-sm text-slate-600">Gedung B</td>
                        <td class="p-4 text-sm text-slate-600">Macet</td>
                    </tr>
                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                        <td class="p-4 text-sm text-slate-800">Selasa, 10 Des 2024</td>
                        <td class="p-4 text-sm text-slate-800 font-mono">-</td>
                        <td class="p-4 text-sm"><span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-600 inline-block w-24 text-center">Izin</span></td>
                        <td class="p-4 text-sm text-slate-600">-</td>
                        <td class="p-4 text-sm text-slate-600">Sakit demam</td>
                    </tr>
                    <!-- More rows... -->
                </tbody>
            </table>
        </div>
    </div>
</x-pelaksana-layout>
