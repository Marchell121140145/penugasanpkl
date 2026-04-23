<x-admin-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Pengaturan Sistem</h1>
            <p class="text-slate-600">Kelola konfigurasi dan preferensi aplikasi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Settings Navigation (Sidebar inside page) -->
        <div class="md:col-span-1 space-y-2">
            <a href="#" class="flex items-center gap-3 px-4 py-3 bg-blue-600 text-white rounded-xl shadow-md shadow-blue-100 font-bold transition-all">
                <span class="text-xl">🛠️</span>
                <span>Umum</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 bg-white text-slate-600 hover:bg-slate-50 rounded-xl font-semibold transition-all border border-slate-200/60">
                <span class="text-xl">👤</span>
                <span>Profil Saya</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 bg-white text-slate-600 hover:bg-slate-50 rounded-xl font-semibold transition-all border border-slate-200/60">
                <span class="text-xl">🔔</span>
                <span>Notifikasi</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 bg-white text-slate-600 hover:bg-slate-50 rounded-xl font-semibold transition-all border border-slate-200/60">
                <span class="text-xl">🔒</span>
                <span>Keamanan</span>
            </a>
        </div>

        <!-- Main Settings Content -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200/60">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <span class="p-2 bg-blue-50 text-blue-600 rounded-lg text-sm">⚙️</span>
                    Konfigurasi Umum
                </h2>
                
                <div class="space-y-6 text-center py-10">
                    <div class="text-6xl mb-4">🏗️</div>
                    <h3 class="text-lg font-bold text-slate-800">Halaman Sedang Dikembangkan</h3>
                    <p class="text-slate-500 max-w-sm mx-auto">
                        Fitur pengaturan sistem sedang dalam tahap pengerjaan. Segera hadir untuk memudahkan Anda mengelola preferensi aplikasi secara terpusat.
                    </p>
                    <div class="mt-8 pt-8 border-t border-slate-100 flex justify-center gap-4">
                        <div class="bg-slate-50 px-6 py-4 rounded-2xl w-full">
                            <div class="text-slate-400 text-xs uppercase font-bold tracking-wider mb-1">Status</div>
                            <div class="text-blue-600 font-bold">Planned</div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 rounded-2xl w-full">
                            <div class="text-slate-400 text-xs uppercase font-bold tracking-wider mb-1">Versi</div>
                            <div class="text-slate-800 font-bold">v1.1.0-alpha</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Placeholder Section -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200/60 opacity-60">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="p-2 bg-slate-100 text-slate-500 rounded-lg text-sm">🌐</span>
                    Pengaturan Wilayah
                </h2>
                <div class="space-y-4">
                    <div class="h-10 bg-slate-100 rounded-xl w-full animate-pulse"></div>
                    <div class="h-10 bg-slate-100 rounded-xl w-3/4 animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
