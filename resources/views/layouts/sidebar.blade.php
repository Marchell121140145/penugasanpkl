<div 
    class="bg-slate-800 text-white py-5 flex flex-col transition-all duration-300 ease-in-out shrink-0 overflow-x-hidden min-h-screen print:hidden"
    :class="sidebarOpen ? 'w-[250px]' : 'w-[80px]'"
>
    <div class="px-5 pb-5 border-b border-slate-700 mb-5 transition-all duration-300" :class="{ 'px-[5px]': !sidebarOpen }">
        <div class="flex items-center justify-between">
            <h2 class="text-white text-2xl font-bold whitespace-nowrap" x-show="sidebarOpen"><i class="fi fi-rr-wrench-simple text-xl mr-1"></i> SISPKL</h2>
            <button @click="sidebarOpen = !sidebarOpen" class="text-white p-1 hover:bg-slate-700 rounded transition focus:outline-none">
                <span x-show="sidebarOpen"><i class="fi fi-rr-angle-left"></i></span>
                <span x-show="!sidebarOpen" class="block mx-auto"><i class="fi fi-rr-angle-right"></i></span>
            </button>
        </div>
        <small class="text-slate-400 block mt-1 whitespace-nowrap" x-show="sidebarOpen">Penugasan & Absensi</small>
    </div>
    
    <ul class="list-none px-4 flex-1 transition-all duration-300" :class="{ 'px-[10px]': !sidebarOpen }">
        <li class="mb-1">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }"><i class="fi fi-rr-home"></i></span> 
                <span x-show="sidebarOpen">Dashboard</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{ route('pelaksana.list') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('pelaksana.list') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <div class="relative flex items-center justify-center mr-3 w-6" :class="{ 'mr-0': !sidebarOpen }">
                    <span class="text-xl text-center"><i class="fi fi-rr-users"></i></span>
                    @if(Auth::check() && Auth::user()->role_id == 1 && isset($badgePendingRegistrations) && $badgePendingRegistrations > 0)
                        <span x-show="!sidebarOpen" class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $badgePendingRegistrations }}</span>
                    @endif
                </div>
                <span x-show="sidebarOpen" class="flex-1 flex justify-between items-center">
                    Pelaksana
                    @if(Auth::check() && Auth::user()->role_id == 1 && isset($badgePendingRegistrations) && $badgePendingRegistrations > 0)
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $badgePendingRegistrations }}</span>
                    @endif
                </span>
            </a>
        </li>
        @if(Auth::check() && Auth::user()->role_id == 1)
        <li class="mb-1">
            <a href="{{ route('pembimbing.list') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('pembimbing.list') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }"><i class="fi fi-rr-chalkboard-user"></i></span> 
                <span x-show="sidebarOpen">Pembimbing</span>
            </a>
        </li>
        @endif
        <li class="mb-1">
            <a href="{{ route('penugasan') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('penugasan') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <div class="relative flex items-center justify-center mr-3 w-6" :class="{ 'mr-0': !sidebarOpen }">
                    <span class="text-xl text-center"><i class="fi fi-rr-clipboard-list"></i></span>
                    @if(isset($badgeNeedGrading) && $badgeNeedGrading > 0)
                        <span x-show="!sidebarOpen" class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $badgeNeedGrading }}</span>
                    @endif
                </div>
                <span x-show="sidebarOpen" class="flex-1 flex justify-between items-center">
                    Penugasan
                    @if(isset($badgeNeedGrading) && $badgeNeedGrading > 0)
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full" title="Perlu Dinilai">{{ $badgeNeedGrading }}</span>
                    @endif
                </span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{ route('absensi') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('absensi') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }"><i class="fi fi-rr-chart-histogram"></i></span> 
                <span x-show="sidebarOpen">Absensi</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{ route('laporan.index') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('laporan.index') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }"><i class="fi fi-rr-chart-line-up"></i></span> 
                <span x-show="sidebarOpen">Laporan</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{ route('settings.index') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('settings.index') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }"><i class="fi fi-rr-settings"></i></span> 
                <span x-show="sidebarOpen">Settings</span>
            </a>
        </li>
        <li class="mb-1">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap"
                   :class="{ 'justify-center px-0': !sidebarOpen }"
                >
                    <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }"><i class="fi fi-rr-exit"></i></span> 
                    <span x-show="sidebarOpen">Logout</span>
                </a>
            </form>
        </li>
    </ul>
</div>
