<x-pelaksana-layout>
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div class="welcome">
            <h1 class="text-slate-800 text-3xl font-bold mb-1 flex items-center gap-3">Halo, {{ Auth::user()->name ?? 'Mahasiswa' }}! <i class="fi fi-rr-hand-wave text-amber-400"></i></h1>
            <p class="text-slate-600">Selamat datang di portal Pelaksana PKL</p>
        </div>
        <div class="flex items-center gap-4">

            <div class="flex items-center gap-2.5 cursor-pointer relative" x-data="{ open: false }" @click.away="open = false" @click="open = !open">
                @if(Auth::user()->avatar)
                    <img src="{{ route('file.avatar', Auth::user()->id) }}" class="w-10 h-10 rounded-full object-cover">
                @else
                    <div class="w-10 h-10 rounded-full bg-red-500 text-white flex items-center justify-center font-bold">{{ substr(Auth::user()->name ?? 'P', 0, 1) }}</div>
                @endif
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

    <!-- User Info Banner -->
    <div class="flex flex-col md:flex-row gap-4 mb-8 bg-white p-4 rounded-xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-lg flex-1">
            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                <i class="fi fi-rr-building"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 uppercase font-semibold tracking-wider">Divisi</p>
                <p class="font-bold text-slate-800">{{ Auth::user()->divisi->nama ?? 'Belum Ditentukan' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-lg flex-1">
            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fi fi-rr-chalkboard-user"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 uppercase font-semibold tracking-wider">Pembimbing</p>
                <p class="font-bold text-slate-800">{{ Auth::user()->pembimbing->name ?? 'Belum Ditentukan' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3 px-4 py-2 bg-red-50 border border-red-100 rounded-lg flex-1">
            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xl shrink-0">
                <i class="fi fi-rr-hourglass-end"></i>
            </div>
            <div>
                <p class="text-xs text-red-500 uppercase font-semibold tracking-wider">Sisa Masa PKL</p>
                <p class="font-bold text-red-700">
                    @if(round($daysLeft) > 0)
                        {{ round($daysLeft) }} Hari Lagi
                    @else
                        Berakhir Hari Ini / Selesai
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-red-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Tugas Saya</h3>
            <div class="flex items-end justify-between">
                <div class="text-3xl font-bold text-slate-800">{{ $totalTasks }}</div>
                <span class="text-xs px-2 py-1 bg-red-100 text-red-600 rounded-lg">{{ $pendingTasks }} Pending</span>
            </div>
            <div class="text-xs text-slate-500 mt-2">{{ $nearingDeadlineCount }} tugas mendekati deadline</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-l-emerald-500">
            <h3 class="text-slate-500 text-sm mb-2 uppercase tracking-wide">Kehadiran</h3>
            <div class="flex items-end justify-between">
                <div class="text-3xl font-bold text-slate-800">{{ $attendanceRate }}%</div>
                @php
                    $statusColor = $attendanceRate >= 90 ? 'bg-emerald-100 text-emerald-600' : ($attendanceRate >= 75 ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600');
                    $statusText = $attendanceRate >= 90 ? 'Sangat Baik' : ($attendanceRate >= 75 ? 'Baik' : 'Cukup');
                @endphp
                <span class="text-xs px-2 py-1 {{ $statusColor }} rounded-lg">{{ $statusText }}</span>
            </div>
            <div class="text-xs text-slate-500 mt-2">Hadir {{ $presentCount }} dari {{ $totalAttendanceSessions }} hari</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Tasks -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-slate-800">Tugas Terbaru</h2>
                <a href="{{ route('pelaksana.penugasan') }}" class="text-red-500 text-sm hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($recentTasks as $task)
                @php
                    $userSubmission = $task->submissions->first();
                    $isCompleted = $userSubmission && in_array($userSubmission->status, ['submitted', 'graded']);
                    $statusColor = !$isCompleted ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600';
                    $icon = !$isCompleted ? '<i class="fi fi-rr-triangle-warning"></i>' : '<i class="fi fi-rr-check"></i>';
                @endphp
                <a href="{{ route('pelaksana.penugasan.show', $task->id) }}" class="flex items-start p-4 bg-slate-50 rounded-lg border border-slate-100 block hover:bg-slate-100 transition-colors">
                    <div class="{{ $statusColor }} p-3 rounded-lg mr-4">
                        <span class="text-xl">{!! $icon !!}</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-slate-800 mb-1">{{ $task->judul }}</h4>
                        <p class="text-sm text-slate-600 mb-2">Deadline: {{ \Carbon\Carbon::parse($task->deadline_date)->translatedFormat('d M Y') }}</p>
                        <div class="w-full bg-slate-200 rounded-full h-1.5 mb-2">
                            <div class="{{ !$isCompleted ? 'bg-amber-500' : 'bg-emerald-500' }} h-1.5 rounded-full" style="width: {{ $isCompleted ? '100%' : '0%' }}"></div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="text-center py-8 text-slate-500">
                    <p>Belum ada tugas yang diberikan.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Task Detail Widget (New) -->
        <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-slate-800">Detail Tugas</h2>
                <span class="px-2 py-1 bg-amber-100 text-amber-600 rounded text-xs font-semibold">Prioritas</span>
            </div>
            
            <div class="flex-1 flex flex-col justify-center items-center text-center p-4 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                @if($priorityTask)
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4 text-3xl text-slate-700">
                        <i class="fi fi-rr-chart-histogram"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $priorityTask->judul }}</h3>
                    <p class="text-slate-500 text-sm max-w-xs mb-6">
                        {{ Str::limit($priorityTask->deskripsi, 100) }}
                    </p>
                    
                    <div class="grid grid-cols-2 gap-4 w-full max-w-xs mb-6">
                        <div class="bg-white p-3 rounded-lg border border-slate-100">
                            <div class="text-xs text-slate-400 uppercase">Deadline</div>
                            <div class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($priorityTask->deadline_date)->diffForHumans() }}</div>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-slate-100">
                            <div class="text-xs text-slate-400 uppercase">Prioritas</div>
                            <div class="font-semibold text-amber-500">{{ $priorityTask->prioritas ?? 'Normal' }}</div>
                        </div>
                    </div>

                    <a href="{{ route('pelaksana.penugasan.show', $priorityTask->id) }}" class="w-full max-w-xs bg-red-600 text-white py-2.5 rounded-lg hover:bg-red-700 transition font-medium">
                        Lihat Detail Tugas
                    </a>
                @else
                    <div class="text-slate-400">
                        <p>Tidak ada tugas pending saat ini.</p>
                        <p class="text-xs mt-2">Kerja bagus! <i class="fi fi-rr-party-horn text-lg"></i></p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Attendance History (Moved to Full Width Bottom) -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-slate-800">Riwayat Absensi</h2>
            <a href="{{ route('pelaksana.absensi') }}" class="text-red-500 text-sm hover:underline">Lihat Semua</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($recentAttendances as $attendance)
            @php
                $statusColor = 'bg-slate-50 border-slate-100';
                $iconColor = 'bg-slate-400';
                $textClass = 'text-slate-700';
                $subTextClass = 'text-slate-500';
                $icon = '<i class="fi fi-rr-check"></i>';

                if (in_array($attendance->status, ['Hadir', 'Hadir - Selesai'])) {
                    $statusColor = 'bg-emerald-50 border-emerald-100';
                    $iconColor = 'bg-emerald-500';
                    $textClass = 'text-emerald-800';
                    $subTextClass = 'text-emerald-600';
                } elseif (in_array($attendance->status, ['Terlambat', 'Terlambat - Selesai'])) {
                    $statusColor = 'bg-amber-50 border-amber-100';
                    $iconColor = 'bg-amber-500';
                    $textClass = 'text-amber-800';
                    $subTextClass = 'text-amber-600';
                    $icon = '<i class="fi fi-rr-info"></i>';
                }
            @endphp
            <div class="relative pl-4 md:pl-0">
                <div class="flex items-center gap-4 {{ $statusColor }} p-4 rounded-xl border">
                    <div class="{{ $iconColor }} h-10 w-10 rounded-full flex items-center justify-center text-white shadow-sm shrink-0">
                        {!! $icon !!}
                    </div>
                    <div>
                        <h4 class="font-semibold {{ $textClass }} text-sm">{{ $attendance->status }}</h4>
                        <p class="text-xs {{ $subTextClass }}">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->translatedFormat('d M Y, H:i') : 'Belum Absen' }} WIB</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-8 text-slate-500">
                <p>Belum ada riwayat absensi.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-pelaksana-layout>


