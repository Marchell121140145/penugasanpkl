<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PendingRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:60', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', 'unique:pending_registrations,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'pkl_start' => ['required', 'date'],
            'pkl_end' => ['required', 'date', 'after_or_equal:pkl_start'],
        ], [
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'name.max' => 'Nama tidak boleh lebih dari 60 karakter.',
            'email.unique' => 'Email ini sudah terdaftar atau sedang menunggu persetujuan.',
            'pkl_start.required' => 'Tanggal mulai PKL wajib diisi.',
            'pkl_end.required' => 'Tanggal selesai PKL wajib diisi.',
            'pkl_end.after_or_equal' => 'Tanggal selesai PKL harus setelah atau sama dengan tanggal mulai.',
        ]);

        PendingRegistration::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pkl_start' => $request->pkl_start,
            'pkl_end' => $request->pkl_end,
        ]);

        return redirect()->route('login')->with('status', 'Pendaftaran berhasil dikirim! Akun Anda sedang menunggu persetujuan admin. Anda akan dapat login setelah admin menyetujui pendaftaran Anda.');
    }
}
