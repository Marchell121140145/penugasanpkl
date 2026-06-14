<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Testing Database</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<table class="min-w-full border border-gray-300 text-sm mt-4">
    <thead class="bg-gray-200">
        <tr>
            <th class="py-2 px-4 border-b text-left">Nama</th>
            <th class="py-2 px-4 border-b text-left">Email</th>
            <th class="py-2 px-4 border-b text-left">Role (Status)</th> <!-- Tambah 1 kolom untuk status -->
        </tr>
    </thead>
    <tbody>
        <!-- Looping datanya -->
        @foreach ($users as $user)
            <tr>
                <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                <td class="py-2 px-4 border-b">
                    
                    <!-- ========== PRAKTEK IF - ELSE DI SINI ========== -->
                    @if ($user->role_id == 1)
                        <!-- Jika Admin, kasih label merah -->
                        <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                            Admin Utama
                        </span>
                        
                    @elseif ($user->role_id == 2)
                        <!-- Jika Pembimbing, kasih label biru -->
                        <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold">
                            Pembimbing
                        </span>
                        
                    @else
                        <!-- Jika selain itu (Pelaksana), kasih label abu-abu -->
                        <span class="bg-gray-500 text-white px-2 py-1 rounded text-xs font-bold">
                            Pelaksana
                        </span>
                    @endif
                    <!-- ================================================= -->

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</html>
