<x-admin-layout>
    <div x-data="{ activeTab: 'umum' }">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-slate-800 text-3xl font-bold mb-1">Pengaturan Sistem</h1>
                <p class="text-slate-600">Administrator Control Panel</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-100 border-l-4 border-rose-500 text-rose-700 p-4 mb-6 rounded-r-xl shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            <!-- Settings Navigation -->
            <div class="md:col-span-3 space-y-2">
                <button @click="activeTab = 'umum'" :class="activeTab === 'umum' ? 'bg-blue-600 text-white shadow-blue-100' : 'bg-white text-slate-600 hover:bg-slate-50 border-slate-200'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all shadow-md border">
                    <span class="text-xl">🛠️</span>
                    <span>Umum</span>
                </button>
                <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'bg-blue-600 text-white shadow-blue-100' : 'bg-white text-slate-600 hover:bg-slate-50 border-slate-200'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all shadow-md border">
                    <span class="text-xl">👥</span>
                    <span>Manajemen User</span>
                </button>
                <button @click="activeTab = 'database'" :class="activeTab === 'database' ? 'bg-blue-600 text-white shadow-blue-100' : 'bg-white text-slate-600 hover:bg-slate-50 border-slate-200'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all shadow-md border">
                    <span class="text-xl">💾</span>
                    <span>Database</span>
                </button>
                <div class="pt-4 border-t border-slate-200">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 bg-white text-slate-600 hover:bg-slate-50 rounded-xl font-semibold transition-all border border-slate-200/60">
                        <span class="text-xl">👤</span>
                        <span>Profil Saya</span>
                    </a>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="md:col-span-9">
                <!-- Tab: Umum -->
                <div x-show="activeTab === 'umum'" x-cloak class="space-y-6">
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200/60" x-data="{ 
                        theme: localStorage.theme || 'system',
                        setTheme(val) {
                            this.theme = val;
                            if (val === 'dark') {
                                localStorage.theme = 'dark';
                                document.documentElement.classList.add('dark');
                            } else if (val === 'light') {
                                localStorage.theme = 'light';
                                document.documentElement.classList.remove('dark');
                            } else {
                                localStorage.removeItem('theme');
                                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                                    document.documentElement.classList.add('dark');
                                } else {
                                    document.documentElement.classList.remove('dark');
                                }
                            }
                            // Opsional: Reload chart jika ada
                            if(typeof Chart !== 'undefined') window.dispatchEvent(new Event('resize'));
                        }
                    }">
                        <h3 class="text-xl font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                            <span>🎨</span> Tampilan Aplikasi
                        </h3>
                        
                        <div class="max-w-xl">
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Tema Tampilan</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <!-- Light Mode -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="theme" value="light" class="peer sr-only" x-model="theme" @change="setTheme('light')">
                                    <div class="rounded-xl border-2 border-slate-200 p-4 hover:bg-slate-50 transition-all peer-checked:border-red-500 peer-checked:bg-red-50">
                                        <div class="text-2xl mb-2 text-center">☀️</div>
                                        <div class="text-sm font-bold text-slate-700 text-center">Terang (Light)</div>
                                    </div>
                                </label>
                                
                                <!-- Dark Mode -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="theme" value="dark" class="peer sr-only" x-model="theme" @change="setTheme('dark')">
                                    <div class="rounded-xl border-2 border-slate-200 p-4 hover:bg-slate-50 transition-all peer-checked:border-red-500 peer-checked:bg-red-50">
                                        <div class="text-2xl mb-2 text-center">🌙</div>
                                        <div class="text-sm font-bold text-slate-700 text-center">Gelap (Dark)</div>
                                    </div>
                                </label>
                                
                                <!-- System Mode -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="theme" value="system" class="peer sr-only" x-model="theme" @change="setTheme('system')">
                                    <div class="rounded-xl border-2 border-slate-200 p-4 hover:bg-slate-50 transition-all peer-checked:border-red-500 peer-checked:bg-red-50">
                                        <div class="text-2xl mb-2 text-center">💻</div>
                                        <div class="text-sm font-bold text-slate-700 text-center">Ikuti Sistem</div>
                                    </div>
                                </label>
                            </div>
                            <p class="text-xs text-slate-500 mt-3">Tema akan tersimpan di perangkat Anda saat ini.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab: Manajemen User -->
                <div x-show="activeTab === 'users'" x-cloak class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                                <span class="p-2 bg-blue-50 text-blue-600 rounded-lg text-sm">👥</span>
                                Semua Pengguna Sistem
                            </h2>
                            <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold">{{ $users->total() }} User</span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50 text-slate-500 text-sm uppercase font-bold tracking-wider">
                                    <tr>
                                        <th class="px-6 py-5">User</th>
                                        <th class="px-6 py-5">Role</th>
                                        <th class="px-6 py-5">Divisi</th>
                                        <th class="px-6 py-5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($users as $user)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="font-bold text-slate-800 text-lg">{{ $user->name }}</div>
                                            <div class="text-sm text-slate-500">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="px-3 py-1 rounded-md text-xs font-bold uppercase
                                                {{ $user->role_id == 1 ? 'bg-rose-100 text-rose-600' : ($user->role_id == 2 ? 'bg-blue-100 text-blue-600' : 'bg-emerald-100 text-emerald-600') }}">
                                                {{ $user->role->role ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-base text-slate-600">
                                            {{ $user->divisi->nama ?? '-' }}
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            @if($user->id !== auth()->id())
                                            <form action="{{ route('settings.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini secara permanen? Kamu tidak bisa membatalkan aksi ini.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-xs uppercase underline">Hapus</button>
                                            </form>
                                            @else
                                            <span class="text-slate-400 text-xs italic">Akun Anda</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 bg-slate-50">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>

                <!-- Tab: Database -->
                <div x-show="activeTab === 'database'" x-cloak class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/60">
                            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-4">Storage Info</h3>
                            <div class="flex items-end gap-2 mb-1">
                                <div class="text-4xl font-black text-slate-800">{{ number_format($dbSize / 1024 / 1024, 2) }}</div>
                                <div class="text-slate-500 font-bold mb-1">MB</div>
                            </div>
                            <div class="text-sm text-slate-400">Total Ukuran Database</div>
                        </div>
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/60">
                            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-4">Table Count</h3>
                            <div class="flex items-end gap-2 mb-1">
                                <div class="text-4xl font-black text-slate-800">{{ count($tables) }}</div>
                                <div class="text-slate-500 font-bold mb-1">Tables</div>
                            </div>
                            <div class="text-sm text-slate-400">Terdaftar aktif</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                                <span class="p-2 bg-amber-50 text-amber-600 rounded-lg text-sm">💾</span>
                                Statistik Tabel
                            </h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50 text-slate-500 text-sm uppercase font-bold tracking-wider">
                                    <tr>
                                        <th class="px-6 py-5">Nama Tabel</th>
                                        <th class="px-6 py-5">Records</th>
                                        <th class="px-6 py-5">Size</th>
                                        <th class="px-6 py-5">Engine</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($tables as $table)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-5 font-mono text-base text-blue-600">{{ $table->Name }}</td>
                                        <td class="px-6 py-5 text-slate-700 font-bold text-lg">{{ number_format($table->Rows) }}</td>
                                        <td class="px-6 py-5 text-sm text-slate-500">{{ number_format($table->Data_length / 1024, 1) }} KB</td>
                                        <td class="px-6 py-5"><span class="bg-slate-100 px-3 py-1 rounded text-xs text-slate-500">{{ $table->Engine }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
