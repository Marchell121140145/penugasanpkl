<x-admin-layout>
    <div x-data="{ 
        activeTab: localStorage.getItem('settingsActiveTab') || 'umum',
        isEditModalOpen: false,
        editUser: {},
        isPurgeModalOpen: false,
        openEditModal(user) {
            this.editUser = user;
            this.isEditModalOpen = true;
        },
        init() {
            this.$watch('activeTab', value => localStorage.setItem('settingsActiveTab', value));
            if (window.location.search.includes('page=') || window.location.search.includes('search=')) {
                this.activeTab = 'users';
            }
        }
    }">
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
                    <span class="text-xl"><i class="fi fi-rr-settings"></i></span>
                    <span>Umum</span>
                </button>
                @if(auth()->user()->role_id == 1)
                <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'bg-blue-600 text-white shadow-blue-100' : 'bg-white text-slate-600 hover:bg-slate-50 border-slate-200'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all shadow-md border">
                    <span class="text-xl"><i class="fi fi-rr-users"></i></span>
                    <span>Manajemen User</span>
                </button>
                <button @click="activeTab = 'database'" :class="activeTab === 'database' ? 'bg-blue-600 text-white shadow-blue-100' : 'bg-white text-slate-600 hover:bg-slate-50 border-slate-200'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all shadow-md border">
                    <span class="text-xl"><i class="fi fi-rr-disk"></i></span>
                    <span>Database</span>
                </button>
                @endif
                <div class="pt-4 border-t border-slate-200">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 bg-white text-slate-600 hover:bg-slate-50 rounded-xl font-semibold transition-all border border-slate-200/60">
                        <span class="text-xl"><i class="fi fi-rr-user"></i></span>
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
                            <span><i class="fi fi-rr-palette"></i></span> Tampilan Aplikasi
                        </h3>
                        
                        <div class="max-w-xl">
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Tema Tampilan</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <!-- Light Mode -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="theme" value="light" class="peer sr-only" x-model="theme" @change="setTheme('light')">
                                    <div class="rounded-xl border-2 border-slate-200 p-4 hover:bg-slate-50 transition-all peer-checked:border-red-500 peer-checked:bg-red-50">
                                        <div class="text-2xl mb-2 text-center"><i class="fi fi-rr-sun"></i></div>
                                        <div class="text-sm font-bold text-slate-700 text-center">Terang (Light)</div>
                                    </div>
                                </label>
                                
                                <!-- Dark Mode -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="theme" value="dark" class="peer sr-only" x-model="theme" @change="setTheme('dark')">
                                    <div class="rounded-xl border-2 border-slate-200 p-4 hover:bg-slate-50 transition-all peer-checked:border-red-500 peer-checked:bg-red-50">
                                        <div class="text-2xl mb-2 text-center"><i class="fi fi-rr-moon"></i></div>
                                        <div class="text-sm font-bold text-slate-700 text-center">Gelap (Dark)</div>
                                    </div>
                                </label>
                                
                                <!-- System Mode -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="theme" value="system" class="peer sr-only" x-model="theme" @change="setTheme('system')">
                                    <div class="rounded-xl border-2 border-slate-200 p-4 hover:bg-slate-50 transition-all peer-checked:border-red-500 peer-checked:bg-red-50">
                                        <div class="text-2xl mb-2 text-center"><i class="fi fi-rr-computer"></i></div>
                                        <div class="text-sm font-bold text-slate-700 text-center">Ikuti Sistem</div>
                                    </div>
                                </label>
                            </div>
                            <p class="text-xs text-slate-500 mt-3">Tema akan tersimpan di perangkat Anda saat ini.</p>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->role_id == 1)
                <!-- Tab: Manajemen User -->
                <div x-show="activeTab === 'users'" x-cloak class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                                <span class="p-2 bg-blue-50 text-blue-600 rounded-lg text-sm"><i class="fi fi-rr-users"></i></span>
                                Semua Pengguna Sistem
                            </h2>
                            <div class="flex items-center gap-3">
                                <button @click="isPurgeModalOpen = true" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 transition-colors">
                                    <span><i class="fi fi-rr-broom"></i></span> Purge Pelaksana
                                </button>
                                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold">{{ $users->total() }} User</span>
                            </div>
                        </div>
                        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                            <form action="{{ route('settings.index') }}" method="GET" class="flex gap-2">
                                <div class="relative flex-1">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <i class="fi fi-rr-search"></i>
                                    </span>
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                           class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                           placeholder="Cari nama, email, role, atau divisi user...">
                                </div>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-bold transition-colors">
                                    Cari
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('settings.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-600 px-4 py-2 rounded-lg text-sm font-bold transition-colors flex items-center">
                                        Reset
                                    </a>
                                @endif
                            </form>
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
                                            <div class="flex items-center justify-end gap-3">
                                                <button @click="openEditModal({{ json_encode($user) }})" class="text-blue-500 hover:text-blue-700 font-bold text-xs uppercase underline">Edit</button>
                                                <form action="{{ route('settings.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini secara permanen? Kamu tidak bisa membatalkan aksi ini.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-xs uppercase underline">Hapus</button>
                                                </form>
                                            </div>
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
                                <span class="p-2 bg-amber-50 text-amber-600 rounded-lg text-sm"><i class="fi fi-rr-disk"></i></span>
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
        @endif

        <!-- Modals Moved to Bottom to Avoid Clipping -->
        <!-- Edit User Modal -->
        <div x-show="isEditModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="isEditModalOpen" class="fixed inset-0 transition-opacity bg-slate-900/75 backdrop-blur-sm" @click="isEditModalOpen = false"></div>

                <div x-show="isEditModalOpen" class="relative inline-block w-full max-w-2xl px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:p-6"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-xl font-bold leading-6 text-slate-800 flex items-center gap-2">
                            <span><i class="fi fi-rr-edit text-blue-600"></i></span> 
                            <span x-text="`Edit User: ${editUser.name}`"></span>
                        </h3>
                        <button @click="isEditModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <span class="text-2xl">&times;</span>
                        </button>
                    </div>
                    <form :action="`/settings/user/${editUser.id}`" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-5">
                            <!-- Baris 1: Nama & Email -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                                    <input type="text" name="name" x-model="editUser.name" required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Alamat Email</label>
                                    <input type="email" name="email" x-model="editUser.email" required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5">
                                </div>
                            </div>

                            <!-- Baris 2: Role & Divisi -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Role Akun</label>
                                    <select name="role_id" x-model="editUser.role_id" required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Divisi Kerja</label>
                                    <select name="divisi_id" x-model="editUser.divisi_id" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5">
                                        <option value="">-- Pilih Divisi --</option>
                                        @foreach($divisis as $divisi)
                                        <option value="{{ $divisi->id }}">{{ $divisi->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Khusus Pelaksana (Role 3) -->
                            <div x-show="editUser.role_id == 3" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="p-5 bg-slate-50 rounded-xl border border-slate-200 space-y-4">
                                <div class="flex items-center gap-2 text-blue-600 font-bold text-xs uppercase tracking-wider mb-1">
                                    <i class="fi fi-rr-info"></i> Informasi PKL
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Pembimbing Lapangan</label>
                                        <select name="pembimbing_id" x-model="editUser.pembimbing_id" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5 bg-white">
                                            <option value="">-- Pilih Pembimbing --</option>
                                            @foreach($pembimbings as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Tanggal Mulai</label>
                                            <input type="date" name="pkl_start" x-model="editUser.pkl_start" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5 bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Tanggal Selesai</label>
                                            <input type="date" name="pkl_end" x-model="editUser.pkl_end" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5 bg-white">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ganti Password -->
                            <div class="pt-2">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Ganti Password (Kosongkan jika tidak diubah)</label>
                                <input type="password" name="password" placeholder="Masukkan password baru..." class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5">
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-slate-100">
                            <button type="button" @click="isEditModalOpen = false" class="px-6 py-2.5 bg-white text-slate-700 border border-slate-300 rounded-xl shadow-sm hover:bg-slate-50 font-bold text-sm transition-all">Batal</button>
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl shadow-sm hover:bg-blue-700 font-bold text-sm transition-all">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Purge Modal -->
        <div x-show="isPurgeModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="isPurgeModalOpen" class="fixed inset-0 transition-opacity bg-slate-900/75 backdrop-blur-sm" @click="isPurgeModalOpen = false"></div>

                <div x-show="isPurgeModalOpen" class="relative inline-block w-full max-w-lg px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:p-6"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold leading-6 text-rose-600 flex items-center gap-2">
                            <span><i class="fi fi-rr-broom"></i></span> Purge Pelaksana Kadaluarsa
                        </h3>
                        <button @click="isPurgeModalOpen = false" class="text-slate-400 hover:text-slate-500">
                            <span class="text-2xl">&times;</span>
                        </button>
                    </div>
                    <div class="bg-rose-50 border border-rose-200 rounded-lg p-4 mb-5">
                        <p class="text-sm text-rose-700 font-medium">Fitur ini digunakan untuk membersihkan secara massal akun pelaksana yang masa PKL-nya sudah berakhir dalam rentang waktu tertentu.</p>
                    </div>
                    <form action="{{ route('settings.purge') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Masa Berakhir Dari</label>
                                    <input type="date" name="start_date" required class="block w-full rounded-md border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Hingga Tanggal</label>
                                    <input type="date" name="end_date" required class="block w-full rounded-md border-slate-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tipe Penghapusan</label>
                                <div class="space-y-2">
                                    <label class="flex items-start p-3 border border-emerald-200 rounded-lg bg-emerald-50 cursor-pointer">
                                        <input type="radio" name="type" value="soft" checked class="mt-1 h-4 w-4 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-emerald-800">Soft Delete (Aman)</span>
                                            <span class="block text-xs text-emerald-600">Akun tidak bisa login, tapi data riwayat tugas dan absensi tetap tersimpan.</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start p-3 border border-rose-200 rounded-lg bg-white cursor-pointer hover:bg-rose-50">
                                        <input type="radio" name="type" value="hard" class="mt-1 h-4 w-4 text-rose-600 border-slate-300 focus:ring-rose-500">
                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-rose-800">Hard Delete (Permanen)</span>
                                            <span class="block text-xs text-rose-600">Akun terhapus total beserta <b>seluruh data tugas dan absensi</b> miliknya.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="isPurgeModalOpen = false" class="px-4 py-2 bg-white text-slate-700 border border-slate-300 rounded-md shadow-sm hover:bg-slate-50 font-medium text-sm">Batal</button>
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengeksekusi purge ini? Pastikan rentang tanggal sudah benar.')" class="px-4 py-2 bg-rose-600 text-white rounded-md shadow-sm hover:bg-rose-700 font-bold text-sm flex items-center gap-2">
                                Eksekusi Purge
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
