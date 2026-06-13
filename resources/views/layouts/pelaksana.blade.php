<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Student Portal') }}</title>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Flaticon -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body x-data="{ 
        sidebarOpen: window.innerWidth >= 1024, 
        mobileMenuOpen: false,
        isDark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) 
     }" 
     x-init="window.addEventListener('resize', () => { if(window.innerWidth >= 1024) { mobileMenuOpen = false; } })"
     class="dark-auto bg-slate-100 dark:bg-gray-900 flex min-h-screen font-sans">
    
    <!-- Mobile Overlay Backdrop -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false" 
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
         style="display: none;"></div>

    <!-- Pelaksana Sidebar -->
    @include('layouts.pelaksana-sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- Mobile Top Bar -->
        <div class="sticky top-0 z-30 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-4 py-3 flex items-center justify-between lg:hidden print:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                <i class="fi fi-rr-menu-burger text-lg"></i>
            </button>
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo telkom.png') }}" alt="Telkom Logo" class="h-6 w-auto dark:hidden">
                <img src="{{ asset('img/logo telkom reverse.png') }}" alt="Telkom Logo" class="h-6 w-auto hidden dark:block">
                <span class="font-bold text-slate-800 dark:text-white text-lg">SISPKL</span>
            </div>
            <div class="w-10 h-10 flex items-center justify-center">
                <!-- Spacer for centering logo -->
            </div>
        </div>

        <!-- Page Content -->
        <div class="flex-1 p-4 md:p-6 lg:p-8 print:p-0 flex flex-col">
            {{ $slot }}
            
            <footer class="mt-auto pt-8 pb-2 text-center text-xs text-slate-500 dark:text-slate-400 print:hidden">
                <div class="border-t border-slate-200 dark:border-slate-800 pt-4">
                    &copy; {{ date('Y') }} SISPKL Telkom. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

</body>
</html>
