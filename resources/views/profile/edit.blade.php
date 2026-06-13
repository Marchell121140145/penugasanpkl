@php
    $layout = auth()->user()->role_id == 3 ? 'pelaksana-layout' : 'admin-layout';
@endphp

<x-dynamic-component :component="$layout">
    <div class="mb-6 md:mb-8">
        <h1 class="text-slate-800 text-2xl md:text-3xl font-bold mb-1">Edit Profil</h1>
        <p class="text-slate-600 text-sm md:text-base">Kelola informasi profil dan keamanan akun Anda</p>
    </div>

    <div class="space-y-4 md:space-y-6">
        <div class="p-4 md:p-6 bg-white rounded-2xl shadow-sm border border-slate-200/60 transition-all hover:shadow-md">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 md:p-6 bg-white rounded-2xl shadow-sm border border-slate-200/60 transition-all hover:shadow-md">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 md:p-6 bg-white rounded-2xl shadow-sm border border-slate-200/60 transition-all hover:shadow-md">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-dynamic-component>



