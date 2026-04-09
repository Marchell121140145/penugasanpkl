<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PelaksanaController;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard jika sudah login
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Admin Routes (Protected)
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        if (auth()->user()->role_id == 3) {
            return redirect()->route('pelaksana.dashboard');
        }
        return view('dashboard.dashboard');
    })->name('dashboard');

    Route::get('/penugasan/create', [TaskController::class, 'create'])->name('penugasan.create');
    Route::post('/penugasan', [TaskController::class, 'store'])->name('penugasan.store');

    Route::get('/penugasan/edit/{id}', function ($id) {
        if (auth()->user()->role_id == 3) {
            return redirect()->route('pelaksana.penugasan');
        }
        return app(TaskController::class)->edit($id);
    })->name('penugasan.edit');

    Route::put('/penugasan/{id}', [TaskController::class, 'update'])->name('penugasan.update');
    Route::delete('/penugasan/{id}', [TaskController::class, 'destroy'])->name('penugasan.destroy');

    Route::get('/penugasan/detail/{id}', function ($id) {
        if (auth()->user()->role_id == 3) {
             return redirect()->route('pelaksana.penugasan.show', $id);
        }
        return app(TaskController::class)->show($id);
    })->name('penugasan.show');

    Route::get('/penugasan', function () {
        if (auth()->user()->role_id == 3) {
            return redirect()->route('pelaksana.penugasan');
        }
        return app(TaskController::class)->index(request());
    })->name('penugasan');

    Route::get('/absensi', function () {
        if (auth()->user()->role_id == 3) {
            return redirect()->route('pelaksana.absensi');
        }
        return view('monitoring.absensi');
    })->name('absensi');

    Route::get('/absensi/history/{nim}', function ($nim) {
        // In production, fetch student data from database
        return view('monitoring.absensi-history', ['nim' => $nim]);
    })->name('absensi.history');

    Route::get('/pelaksana-list', [PelaksanaController::class, 'index'])->name('pelaksana.list');

    Route::get('/pembimbing-list', function () {
        return view('monitoring.pembimbing');
    })->name('pembimbing.list');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Student Routes
// Pelaksana Routes
Route::prefix('pelaksana')->middleware(['auth', 'verified'])->name('pelaksana.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pelaksana.dashboard');
    })->name('dashboard');

    Route::get('/absensi', function () {
        return view('pelaksana.absensi');
    })->name('absensi');

    Route::get('/absensi/create', function () {
        return view('pelaksana.upload-absensi');
    })->name('absensi.create');

    Route::get('/penugasan/detail/{id}', function ($id) {
        return view('pelaksana.detail');
    })->name('penugasan.show');

    Route::get('/penugasan', function () {
        return view('pelaksana.penugasan');
    })->name('penugasan');

    Route::post('/penugasan/submit/{id}', function ($id) {
        // TODO: Add actual task submission logic here
        // - Validate that files have been uploaded
        // - Update task status in database to 'submitted'
        // - Record submission timestamp
        // - Send notification to pembimbing
        
        return redirect()->route('pelaksana.penugasan.show', $id)
            ->with('success', 'Tugas berhasil disubmit! File Anda telah dikirim untuk direview.');
    })->name('penugasan.submit');
});

require __DIR__.'/auth.php';