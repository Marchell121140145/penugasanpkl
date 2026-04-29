<div 
    class="bg-slate-800 text-white py-5 flex flex-col transition-all duration-300 ease-in-out shrink-0 overflow-x-hidden min-h-screen"
    :class="sidebarOpen ? 'w-[250px]' : 'w-[80px]'"
>
    <div class="px-5 pb-5 border-b border-slate-700 mb-5 transition-all duration-300" :class="{ 'px-[5px]': !sidebarOpen }">
        <div class="flex items-center justify-between">
            <h2 class="text-white text-2xl font-bold whitespace-nowrap" x-show="sidebarOpen">🎓 SISPKL</h2>
            <button @click="sidebarOpen = !sidebarOpen" class="text-white p-1 hover:bg-slate-700 rounded transition focus:outline-none">
                <span x-show="sidebarOpen">◀</span>
                <span x-show="!sidebarOpen" class="block mx-auto">▶</span>
            </button>
        </div>
        <small class="text-slate-400 block mt-1 whitespace-nowrap" x-show="sidebarOpen">Pelaksana Portal</small>
    </div>
    
    <ul class="list-none px-4 flex-1 transition-all duration-300" :class="{ 'px-[10px]': !sidebarOpen }">
        <li class="mb-1">
            <a href="{{ route('pelaksana.dashboard') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('pelaksana.dashboard') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }">🏠</span> 
                <span x-show="sidebarOpen">Dashboard</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{ route('pelaksana.penugasan') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('pelaksana.penugasan') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }">📋</span> 
                <span x-show="sidebarOpen">Tugas Saya</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{ route('pelaksana.absensi') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('pelaksana.absensi') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }">📅</span> 
                <span x-show="sidebarOpen">Absensi</span>
            </a>
        <li class="mb-1">
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white' : '' }}"
               :class="{ 'justify-center px-0': !sidebarOpen }"
            >
                <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }">👤</span> 
                <span x-show="sidebarOpen">Profile</span>
            </a>
        </li>
        
        <li class="mt-auto mb-1 pt-5 border-t border-slate-700">
             <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 text-slate-300 hover:bg-slate-700 hover:text-white whitespace-nowrap"
                   :class="{ 'justify-center px-0': !sidebarOpen }"
                >
                    <span class="text-xl w-6 text-center flex items-center justify-center mr-3" :class="{ 'mr-0': !sidebarOpen }">🚪</span> 
                    <span x-show="sidebarOpen">Logout</span>
                </a>
            </form>
        </li>
    </ul>
</div>
