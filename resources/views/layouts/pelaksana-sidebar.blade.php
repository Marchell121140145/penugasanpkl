<div 
    class="bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 text-slate-800 dark:text-white py-5 flex flex-col transition-all duration-300 ease-in-out shrink-0 overflow-x-hidden print:hidden
           fixed inset-y-0 left-0 z-50 lg:relative lg:z-auto
           w-[270px] lg:w-auto"
    :class="{
        'lg:w-[250px]': sidebarOpen,
        'lg:w-[80px]': !sidebarOpen,
        'translate-x-0': mobileMenuOpen,
        '-translate-x-full lg:translate-x-0': !mobileMenuOpen
    }"
>
    <div class="px-5 pb-5 border-b border-slate-200 dark:border-slate-800 mb-5 transition-all duration-300" :class="{ 'lg:px-[5px]': !sidebarOpen }">
        <div class="flex items-center justify-between">
            <h2 class="text-slate-800 dark:text-white text-2xl font-bold whitespace-nowrap flex items-center gap-2" x-show="sidebarOpen || mobileMenuOpen" x-cloak>
                <img src="{{ asset('img/logo telkom.png') }}" alt="Telkom Logo" class="h-7 w-auto dark:hidden">
                <img src="{{ asset('img/logo telkom reverse.png') }}" alt="Telkom Logo" class="h-7 w-auto hidden dark:block">
                <span>SISPKL</span>
            </h2>
            <!-- Desktop collapse toggle (hidden on mobile) -->
            <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:flex text-slate-500 dark:text-white p-1 hover:bg-slate-200/60 dark:hover:bg-slate-800 rounded transition focus:outline-none items-center justify-center">
                <span x-show="sidebarOpen"><i class="fi fi-rr-angle-left"></i></span>
                <span x-show="!sidebarOpen" class="block mx-auto"><i class="fi fi-rr-angle-right"></i></span>
            </button>
            <!-- Mobile close button -->
            <button @click="mobileMenuOpen = false" class="lg:hidden text-slate-500 dark:text-white p-1 hover:bg-slate-200/60 dark:hover:bg-slate-800 rounded transition focus:outline-none">
                <i class="fi fi-rr-cross"></i>
            </button>
        </div>
        <small class="text-slate-400 dark:text-slate-500 block mt-1 whitespace-nowrap" x-show="sidebarOpen || mobileMenuOpen" x-cloak>Pelaksana Portal</small>
    </div>
    
    <ul class="list-none px-4 flex-1 transition-all duration-300" :class="{ 'lg:px-[10px]': !sidebarOpen }">
        <li class="mb-1">
            <a href="{{ route('pelaksana.dashboard') }}" 
               @click="mobileMenuOpen = false"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 whitespace-nowrap {{ request()->routeIs('pelaksana.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}"
               :class="{ 'lg:justify-center lg:px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'lg:mr-0': !sidebarOpen }"><i class="fi fi-rr-home"></i></span> 
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak>Dashboard</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{ route('pelaksana.penugasan') }}" 
               @click="mobileMenuOpen = false"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 whitespace-nowrap {{ request()->routeIs('pelaksana.penugasan') ? 'bg-blue-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}"
               :class="{ 'lg:justify-center lg:px-0': !sidebarOpen }"
            >
                <div class="relative flex items-center justify-center mr-3 w-6" :class="{ 'lg:mr-0': !sidebarOpen }">
                    <span class="text-xl text-center"><i class="fi fi-rr-clipboard-list"></i></span>
                    @if(isset($badgePendingTasks) && $badgePendingTasks > 0)
                        <span x-show="!sidebarOpen && !mobileMenuOpen" class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $badgePendingTasks }}</span>
                    @endif
                </div>
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak class="flex-1 flex justify-between items-center">
                    Tugas Saya
                    @if(isset($badgePendingTasks) && $badgePendingTasks > 0)
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $badgePendingTasks }}</span>
                    @endif
                </span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{ route('pelaksana.absensi') }}" 
               @click="mobileMenuOpen = false"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 whitespace-nowrap {{ request()->routeIs('pelaksana.absensi') ? 'bg-blue-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}"
               :class="{ 'lg:justify-center lg:px-0': !sidebarOpen }"
            >
                <div class="relative flex items-center justify-center mr-3 w-6" :class="{ 'lg:mr-0': !sidebarOpen }">
                    <span class="text-xl text-center"><i class="fi fi-rr-calendar"></i></span>
                    @if(isset($badgeUnfilledAttendances) && $badgeUnfilledAttendances > 0)
                        <span x-show="!sidebarOpen && !mobileMenuOpen" class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $badgeUnfilledAttendances }}</span>
                    @endif
                </div>
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak class="flex-1 flex justify-between items-center">
                    Absensi
                    @if(isset($badgeUnfilledAttendances) && $badgeUnfilledAttendances > 0)
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $badgeUnfilledAttendances }}</span>
                    @endif
                </span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{ route('profile.edit') }}" 
               @click="mobileMenuOpen = false"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 whitespace-nowrap {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}"
               :class="{ 'lg:justify-center lg:px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'lg:mr-0': !sidebarOpen }"><i class="fi fi-rr-user"></i></span> 
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak>Profile</span>
            </a>
        </li>
        
        <li class="mb-1">
            <button @click="isDark = !isDark; if (isDark) { localStorage.theme = 'dark'; document.documentElement.classList.add('dark'); } else { localStorage.theme = 'light'; document.documentElement.classList.remove('dark'); }" 
               class="w-full flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white whitespace-nowrap"
               :class="{ 'lg:justify-center lg:px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'lg:mr-0': !sidebarOpen }">
                    <span x-show="!isDark"><i class="fi fi-rr-moon"></i></span>
                    <span x-show="isDark"><i class="fi fi-rr-sun"></i></span>
                </span> 
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak>
                    <span x-show="!isDark">Dark Mode</span>
                    <span x-show="isDark">Light Mode</span>
                </span>
            </button>
        </li>

        <li class="mt-auto mb-1 pt-5 border-t border-slate-200 dark:border-slate-800">
             <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white whitespace-nowrap"
                   :class="{ 'lg:justify-center lg:px-0': !sidebarOpen }"
                >
                    <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'lg:mr-0': !sidebarOpen }"><i class="fi fi-rr-exit"></i></span> 
                    <span x-show="sidebarOpen || mobileMenuOpen" x-cloak>Logout</span>
                </a>
            </form>
        </li>
    </ul>
</div>
