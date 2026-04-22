<x-admin-layout>
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('absensi') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:-translate-x-1 hover:shadow-md transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-slate-800 text-3xl font-bold mb-1">Buat Sesi Absensi</h1>
            <p class="text-slate-600">Buat absensi dan tugaskan kepada divisi atau pelaksana</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl list-none bg-red-50 border-l-4 border-red-500 text-red-700 shadow-sm">
            <div class="font-bold mb-2">Terjadi kesalahan:</div>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf

            <!-- Informasi Utama -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="text-blue-500">1</span> Informasi Absensi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Judul Absensi <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all shadow-sm bg-slate-50 p-2.5" placeholder="Contoh: Absen Pagi - 25 April" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="deadline" class="block text-sm font-semibold text-slate-700 mb-2">Batas Waktu (Deadline) <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="deadline" id="deadline" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all shadow-sm bg-slate-50 p-2.5" value="{{ old('deadline') }}" required>
                    </div>

                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Keterangan</label>
                        <textarea name="description" id="description" rows="3" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all shadow-sm bg-slate-50 p-2.5" placeholder="Instruksi tambahan absensi...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Penugasan -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="text-blue-500">2</span> Penugasan Absensi
                </h3>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Tugaskan kepada <span class="text-red-500">*</span></label>
                    <div class="flex gap-6">
                        <label class="relative flex items-center p-3 rounded-xl border-2 border-slate-200 cursor-pointer hover:bg-slate-50 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/50">
                            <input type="radio" name="assign_type" value="divisi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" {{ old('assign_type') == 'divisi' ? 'checked' : '' }} onchange="toggleAssignType('divisi')">
                            <span class="ml-3 font-medium text-slate-700 group-has-[:checked]:text-blue-700">Divisi (Semua Anggota)</span>
                        </label>
                        <label class="relative flex items-center p-3 rounded-xl border-2 border-slate-200 cursor-pointer hover:bg-slate-50 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/50">
                            <input type="radio" name="assign_type" value="pelaksana" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" {{ old('assign_type', 'pelaksana') == 'pelaksana' ? 'checked' : '' }} onchange="toggleAssignType('pelaksana')">
                            <span class="ml-3 font-medium text-slate-700 group-has-[:checked]:text-blue-700">Pelaksana Tertentu</span>
                        </label>
                    </div>
                </div>

                <!-- Divisi Selection -->
                <div id="divisi-selection" class="mb-6 hidden">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Divisi <span class="text-red-500">*</span></label>
                    <p class="text-xs text-slate-500 mb-3">Pilih satu atau lebih divisi. Semua akun ber-role Pelaksana dari divisi terpilih akan ditugaskan.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-[300px] overflow-y-auto p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        @foreach($divisis as $divisi)
                            <label class="flex items-center p-3 rounded-lg border border-slate-200 bg-white cursor-pointer hover:bg-blue-50 transition-colors">
                                <input type="checkbox" name="divisi_ids[]" value="{{ $divisi->id }}" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 mr-3" {{ (is_array(old('divisi_ids')) && in_array($divisi->id, old('divisi_ids'))) ? 'checked' : '' }}>
                                <span class="font-medium text-slate-700">{{ $divisi->nama }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Pelaksana Selection -->
                <div id="pelaksana-selection" class="mb-6 hidden">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Pelaksana <span class="text-red-500">*</span></label>
                    <p class="text-xs text-slate-500 mb-3">Pilih satu atau lebih mahasiswa/pelaksana.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-[400px] overflow-y-auto p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        @foreach($pelaksanas as $pelaksana)
                            <label class="flex items-center p-3 rounded-lg border border-slate-200 bg-white cursor-pointer hover:bg-blue-50 transition-colors">
                                <input type="checkbox" name="pelaksana_ids[]" value="{{ $pelaksana->id }}" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 mr-3" {{ (is_array(old('pelaksana_ids')) && in_array($pelaksana->id, old('pelaksana_ids'))) ? 'checked' : '' }}>
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold overflow-hidden flex-shrink-0">
                                        @if($pelaksana->avatar)
                                            <img src="{{ asset('storage/' . $pelaksana->avatar) }}" alt="{{ $pelaksana->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($pelaksana->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="font-medium text-slate-800 text-sm truncate">{{ $pelaksana->name }}</div>
                                        <div class="text-xs text-slate-500 truncate">{{ $pelaksana->divisi?->nama ?? 'Tanpa Divisi' }}</div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('absensi') }}" class="px-6 py-2.5 border-2 border-slate-200 text-slate-700 font-medium rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-sm hover:shadow transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Absensi
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleAssignType(type) {
            const divisiSection = document.getElementById('divisi-selection');
            const pelaksanaSection = document.getElementById('pelaksana-selection');

            if (type === 'divisi') {
                divisiSection.classList.remove('hidden');
                pelaksanaSection.classList.add('hidden');
            } else {
                divisiSection.classList.add('hidden');
                pelaksanaSection.classList.remove('hidden');
            }
        }

        // Initialize display based on current selection
        document.addEventListener('DOMContentLoaded', function() {
            const checkedRadio = document.querySelector('input[name="assign_type"]:checked');
            if (checkedRadio) {
                toggleAssignType(checkedRadio.value);
            } else {
                toggleAssignType('pelaksana'); // Default
            }
        });
    </script>
</x-admin-layout>
