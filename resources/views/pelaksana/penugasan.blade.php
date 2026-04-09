<x-pelaksana-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Daftar Tugas</h1>
            <p class="text-slate-600">Pantau dan kerjakan tugas PKL kamu</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm gap-4">
        <div class="flex gap-4 w-full md:w-auto">
             <!-- Read Only view doesn't need 'Create Task' -->
             <div class="text-sm font-medium text-slate-500 pt-2">Filter Tugas:</div>
        </div>
        <div class="flex flex-col md:flex-row gap-4 items-center w-full md:w-auto">
            <select class="p-2.5 border-2 border-slate-200 rounded-lg bg-white cursor-pointer text-sm min-w-[150px] focus:outline-none focus:border-blue-500">
                <option>Semua Status</option>
                <option>Belum Dikerjakan</option>
                <option>Dalam Proses</option>
                <option>Selesai</option>
            </select>
            <input type="text" class="p-2.5 border-2 border-slate-200 rounded-lg w-full md:w-[250px] text-sm focus:outline-none focus:border-blue-500" placeholder="Cari tugas...">
        </div>
    </div>

    <!-- Tasks Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Task Card 1 -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-100 hover:shadow-md transition-shadow group">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">High Priority</span>
                    <span class="text-slate-400 text-xs">Due: 2 Hari Lagi</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Laporan Mingguan #4</h3>
                <p class="text-slate-500 text-sm mb-4 line-clamp-2">Membuat laporan kegiatan mingguan periode 9-13 Desember 2024 beserta dokumentasi foto.</p>
                
                <div class="mb-4">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-slate-600">Progress</span>
                        <span class="text-slate-800 font-medium">20%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-amber-500 h-2 rounded-full" style="width: 20%"></div>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                    <div class="flex -space-x-2">
                        <!-- Teacher/Supervisor Avatar -->
                        <div class="w-8 h-8 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-xs" title="Pembimbing">👨‍🏫</div>
                    </div>
                    <a href="{{ route('pelaksana.penugasan.show', 1) }}" class="px-4 py-2 bg-slate-50 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-100 transition-colors">Detail</a>
                </div>
            </div>
        </div>

        <!-- Task Card 2 -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-100 hover:shadow-md transition-shadow group">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Medium Priority</span>
                    <span class="text-slate-400 text-xs">Due: 20 Des 2024</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Desain Mockup Dashboard</h3>
                <p class="text-slate-500 text-sm mb-4 line-clamp-2">Merancang tampilan dashboard user dengan style modern menggunakan Figma.</p>
                
                <div class="mb-4">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-slate-600">Progress</span>
                        <span class="text-slate-800 font-medium">0%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-slate-300 h-2 rounded-full" style="width: 0%"></div>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                     <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-xs" title="Pembimbing">👨‍🏫</div>
                    </div>
                    <a href="{{ route('pelaksana.penugasan.show', 2) }}" class="px-4 py-2 bg-slate-50 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-100 transition-colors">Detail</a>
                </div>
            </div>
        </div>

        <!-- Task Card 3 (Completed) -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-100 hover:shadow-md transition-shadow group opacity-75 hover:opacity-100">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">Selesai</span>
                    <span class="text-slate-400 text-xs">Submitted: 10 Des</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Analisis Database</h3>
                <p class="text-slate-500 text-sm mb-4 line-clamp-2">Melakukan normalisasi database untuk sistem perpustakaan.</p>
                
                <div class="mb-4">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-slate-600">Progress</span>
                        <span class="text-emerald-600 font-medium">100%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                     <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-xs" title="Pembimbing">👨‍🏫</div>
                    </div>
                    <a href="{{ route('pelaksana.penugasan.show', 3) }}" class="px-4 py-2 bg-emerald-50 text-emerald-700 text-sm font-medium rounded-lg hover:bg-emerald-100 transition-colors">Nilai: A</a>
                </div>
            </div>
        </div>
    </div>
</x-pelaksana-layout>
