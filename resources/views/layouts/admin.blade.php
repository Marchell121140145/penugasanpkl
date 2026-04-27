<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dashboard Admin') }}</title>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarOpen: true }" class="bg-slate-100 flex min-h-screen font-sans">
    
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-y-auto">
        {{ $slot }}
    </div>

</body>
</html>


