<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('pelaksana.list') }}" class="text-red-500 hover:text-red-700 hover:underline flex items-center gap-2 text-sm font-medium transition-colors w-max">
            <i class="fi fi-rr-arrow-left"></i> Kembali ke Data Pelaksana
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative flex items-center" role="alert">
            <strong class="font-bold mr-2">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <strong class="font-bold">Ada kesalahan!</strong>
            <ul class="list-disc pl-5 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header & Profile -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center gap-6">
            @php
                $initials = collect(explode(' ', $pelaksana->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                $colors = ['indigo', 'blue', 'pink', 'green', 'amber', 'cyan', 'rose', 'purple'];
                $color = $colors[$pelaksana->id % count($colors)];
            @endphp
            <div class="w-20 h-20 rounded-full bg-{{ $color }}-100 flex items-center justify-center text-{{ $color }}-600 text-2xl font-bold shadow-inner">
                {{ $initials }}
            </div>
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-1">{{ $pelaksana->name }}</h1>
                <div class="flex items-center gap-3 text-sm text-slate-500 flex-wrap mt-2">
                    <span><i class="fi fi-rr-envelope"></i> {{ $pelaksana->email }}</span>
                    <span>•</span>
                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium">
                        {{ $pelaksana->divisi->nama ?? 'Belum ada Divisi' }}
                    </span>
                    <span>•</span>
                    <span class="px-2 py-0.5 rounded bg-red-50 text-red-700 font-medium">
                        <i class="fi fi-rr-chalkboard-user"></i> Pembimbing: <strong class="ml-1">{{ $pelaksana->pembimbing->name ?? 'Belum ditugaskan' }}</strong>
                    </span>
                </div>
            </div>
        </div>
        <div>
            <button onclick="document.getElementById('editModal').classList.remove('hidden')" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl shadow-md transition-all hover:-translate-y-0.5 mt-4 md:mt-0 flex items-center gap-2">
                <i class="fi fi-rr-edit"></i> Edit Profil
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-red-50 to-white p-6 rounded-2xl shadow-sm border border-red-100 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-red-600/80 text-sm font-bold uppercase tracking-wider mb-1">Total Tugas</p>
                <p class="text-4xl font-extrabold text-indigo-900">{{ $pelaksana->assigned_tasks_count }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 text-8xl opacity-10"><i class="fi fi-rr-clipboard-list"></i></div>
        </div>
        <div class="bg-gradient-to-br from-emerald-50 to-white p-6 rounded-2xl shadow-sm border border-emerald-100 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-emerald-600/80 text-sm font-bold uppercase tracking-wider mb-1">Tugas Selesai</p>
                <p class="text-4xl font-extrabold text-emerald-900">{{ $pelaksana->tugas_selesai_count }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 text-8xl opacity-10"><i class="fi fi-rr-check-circle"></i></div>
        </div>
        <div class="bg-gradient-to-br from-amber-50 to-white p-6 rounded-2xl shadow-sm border border-amber-100 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-amber-600/80 text-sm font-bold uppercase tracking-wider mb-1">Tugas Aktif</p>
                <p class="text-4xl font-extrabold text-amber-900">{{ $pelaksana->tugas_aktif_count }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 text-8xl opacity-10"><i class="fi fi-rr-hourglass"></i></div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-lg font-bold text-slate-800">Daftar Tugas</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-widest">
                        <th class="px-6 py-4 font-medium">Judul Tugas</th>
                        <th class="px-6 py-4 font-medium">Status Tugas</th>
                        <th class="px-6 py-4 font-medium">Deadline</th>
                        <th class="px-6 py-4 font-medium" width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pelaksana->assignedTasks as $task)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $task->judul }}</td>
                        <td class="px-6 py-4">
                            @php
                                $submission = $pelaksana->submissions->where('task_id', $task->id)->first();
                                $status = $submission ? $submission->status : 'pending';
                            @endphp
                            @if($status === 'submitted' || $status === 'graded')
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold border border-emerald-200">Selesai</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold border border-amber-200">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ \Carbon\Carbon::parse($task->deadline_date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('penugasan.show', $task->id) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-800 transition-colors tooltip" title="Lihat Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-4xl mb-3"><i class="fi fi-rr-box-open"></i></span>
                                <p class="text-sm">Belum ada tugas yang ditugaskan ke pelaksana ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="document.getElementById('editModal').classList.add('hidden')">
                <div class="absolute inset-0 bg-slate-900 opacity-40 backdrop-blur-sm"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-slate-100">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-800">Edit Data Pelaksana</h3>
                    <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 bg-white hover:bg-slate-100 rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
                
                <form action="{{ route('pelaksana.update', $pelaksana->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $pelaksana->name) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:border-red-500 shadow-sm transition-all text-sm outline-none" required maxlength="60" pattern="^[a-zA-Z\s]+$" title="Nama hanya boleh berisi huruf dan spasi.">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $pelaksana->email) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:border-red-500 shadow-sm transition-all text-sm outline-none" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Divisi</label>
                            <select name="divisi_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:border-red-500 shadow-sm transition-all text-sm cursor-pointer outline-none">
                                <option value="">-- Pilih Divisi --</option>
                                @foreach($divisis as $div)
                                    <option value="{{ $div->id }}" {{ old('divisi_id', $pelaksana->divisi_id) == $div->id ? 'selected' : '' }}>
                                        {{ $div->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pembimbing Khusus</label>
                            <select name="pembimbing_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500 focus:border-red-500 shadow-sm transition-all text-sm cursor-pointer outline-none">
                                <option value="">-- Kosong / Belum ada --</option>
                                @foreach($pembimbings as $pb)
                                    <option value="{{ $pb->id }}" {{ old('pembimbing_id', $pelaksana->pembimbing_id) == $pb->id ? 'selected' : '' }}>
                                        {{ $pb->name }} {{ $pb->divisi ? '('.$pb->divisi->nama.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl font-medium text-white bg-red-600 hover:bg-red-700 shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>


