<x-pelaksana-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div class="welcome">
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Halo, {{ Auth::user()->name ?? 'Mahasiswa' }}! 👋</h1>
            <p class="text-slate-600">Selamat datang di portal Pelaksana PKL</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative cursor-pointer">
                <span class="text-xl">🔔</span>
                <div class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-[18px] h-[18px] text-[0.7rem] flex items-center justify-center">2</div>
            </div>
            <div class="flex items-center gap-2.5 cursor-pointer relative" x-data="{ open: false }" @click.away="open = false" @click="open = !open">
                <div class="w-10 h-10 rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold">{{ substr(Auth::user()->name ?? 'P', 0, 1) }}</div>
                <div class="hidden md:block text-right">
                    <span class="block font-medium text-slate-700 text-sm leading-none">{{ Auth::user()->name ?? 'Pelaksana' }}</span>
                    <span class="text-xs text-slate-500">Mahasiswa PKL</span>
                </div>
                
                <!-- Dropdown Menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     class="absolute top-[120%] right-0 w-48 bg-white rounded-lg shadow-lg z-50 py-2 border border-slate-100"
                     style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profile</a>
                    <div class="border-t border-slate-100 my-1"></div>
                     <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Log Out</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-blue-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Saya</h3>
            <div class="flex items-end justify-between">
                <div class="text-3xl font-bold text-slate-800">5</div>
                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-600 rounded-lg">2 Pending</span>
            </div>
            <div class="text-xs text-slate-500 mt-2">1 tugas mendekati deadline</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Kehadiran</h3>
            <div class="flex items-end justify-between">
                <div class="text-3xl font-bold text-slate-800">95%</div>
                <span class="text-xs px-2 py-1 bg-emerald-100 text-emerald-600 rounded-lg">Sangat Baik</span>
            </div>
            <div class="text-xs text-slate-500 mt-2">Hadir 19 dari 20 hari</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-violet-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Sisa Hari PKL</h3>
            <div class="flex items-end justify-between">
                <div class="text-3xl font-bold text-slate-800">45</div>
                <span class="text-xs px-2 py-1 bg-violet-100 text-violet-600 rounded-lg">Hari</span>
            </div>
            <div class="text-xs text-slate-500 mt-2">Berakhir: 28 Feb 2026</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Tasks -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-slate-800">Tugas Terbaru</h2>
                <a href="{{ route('pelaksana.penugasan') }}" class="text-blue-500 text-sm hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                <a href="{{ route('pelaksana.penugasan.show', 1) }}" class="flex items-start p-4 bg-slate-50 rounded-lg border border-slate-100 block hover:bg-slate-100 transition-colors">
                    <div class="bg-amber-100 text-amber-600 p-3 rounded-lg mr-4">
                        <span class="text-xl">⚠️</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-slate-800 mb-1">Laporan Mingguan #4</h4>
                        <p class="text-sm text-slate-600 mb-2">Deadline: Besok, 23:59 WIB</p>
                        <div class="w-full bg-slate-200 rounded-full h-1.5 mb-2">
                            <div class="bg-amber-500 h-1.5 rounded-full" style="width: 20%"></div>
                        </div>
                    </div>
                </a>
                <div class="flex items-start p-4 bg-slate-50 rounded-lg border border-slate-100">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-lg mr-4">
                        <span class="text-xl">📝</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-slate-800 mb-1">Desain Mockup Dashboard</h4>
                        <p class="text-sm text-slate-600 mb-2">Deadline: 20 Des 2025</p>
                        <div class="w-full bg-slate-200 rounded-full h-1.5 mb-2">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task Detail Widget (New) -->
        <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-slate-800">Detail Tugas</h2>
                <span class="px-2 py-1 bg-amber-100 text-amber-600 rounded text-xs font-semibold">Prioritas</span>
            </div>
            
            <div class="flex-1 flex flex-col justify-center items-center text-center p-4 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4 text-3xl">
                    📊
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Laporan Mingguan #4</h3>
                <p class="text-slate-500 text-sm max-w-xs mb-6">
                    Kumpulkan laporan kegiatan harian selama satu minggu ini beserta foto dokumentasi.
                </p>
                
                <div class="grid grid-cols-2 gap-4 w-full max-w-xs mb-6">
                    <div class="bg-white p-3 rounded-lg border border-slate-100">
                        <div class="text-xs text-slate-400 uppercase">Deadline</div>
                        <div class="font-semibold text-slate-700">Besok</div>
                    </div>
                    <div class="bg-white p-3 rounded-lg border border-slate-100">
                        <div class="text-xs text-slate-400 uppercase">Status</div>
                        <div class="font-semibold text-amber-500">Pending</div>
                    </div>
                </div>

                <a href="{{ route('pelaksana.penugasan.show', 1) }}" class="w-full max-w-xs bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 transition font-medium">
                    Lihat Detail Tugas
                </a>
            </div>
        </div>
    </div>

    <!-- Attendance History (Moved to Full Width Bottom) -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-slate-800">Riwayat Absensi</h2>
            <a href="{{ route('pelaksana.absensi') }}" class="text-blue-500 text-sm hover:underline">Lihat Semua</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="relative pl-4 md:pl-0">
                <div class="flex items-center gap-4 bg-emerald-50 p-4 rounded-xl border border-emerald-100">
                    <div class="bg-emerald-500 h-10 w-10 rounded-full flex items-center justify-center text-white shadow-sm shrink-0">
                        ✓
                    </div>
                    <div>
                        <h4 class="font-semibold text-emerald-800 text-sm">Hadir Tepat Waktu</h4>
                        <p class="text-xs text-emerald-600">Hari ini, 07:45 WIB</p>
                    </div>
                </div>
            </div>
            <div class="relative pl-4 md:pl-0">
                 <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div class="bg-slate-400 h-10 w-10 rounded-full flex items-center justify-center text-white shadow-sm shrink-0">
                        ✓
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-700 text-sm">Hadir</h4>
                        <p class="text-xs text-slate-500">Kemarin, 07:50 WIB</p>
                    </div>
                </div>
            </div>
            <div class="relative pl-4 md:pl-0">
                 <div class="flex items-center gap-4 bg-amber-50 p-4 rounded-xl border border-amber-100">
                    <div class="bg-amber-500 h-10 w-10 rounded-full flex items-center justify-center text-white shadow-sm shrink-0">
                        !
                    </div>
                    <div>
                        <h4 class="font-semibold text-amber-800 text-sm">Terlambat</h4>
                        <p class="text-xs text-amber-600">11 Des 2024, 08:15 WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-pelaksana-layout>
