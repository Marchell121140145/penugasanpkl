<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PelaksanaController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ExcelEditorController;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard jika sudah login
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Admin Routes (Protected)
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

    Route::get('/penugasan/excel-editor', [ExcelEditorController::class, 'edit'])->name('excel.editor');
    Route::post('/penugasan/excel-editor/save', [ExcelEditorController::class, 'save'])->name('excel.editor.save');

    Route::get('/penugasan/detail/{id}', function ($id) {
        if (auth()->user()->role_id == 3) {
             return redirect()->route('pelaksana.penugasan.show', $id);
        }
        return app(TaskController::class)->show($id);
    })->name('penugasan.show');

    Route::post('/penugasan/grade/{id}', [TaskController::class, 'submitGrade'])->name('penugasan.grade');
    Route::post('/penugasan/comment/{id}', [TaskController::class, 'storeComment'])->name('penugasan.comment');

    Route::get('/penugasan', function () {
        if (auth()->user()->role_id == 3) {
            return redirect()->route('pelaksana.penugasan');
        }
        return app(TaskController::class)->index(request());
    })->name('penugasan');

    Route::get('/absensi/create', [AttendanceController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [AttendanceController::class, 'store'])->name('absensi.store');

    Route::get('/absensi', [AttendanceController::class, 'index'])->name('absensi');

    Route::get('/absensi/history/{id}', [AttendanceController::class, 'adminHistory'])->name('absensi.history');
    Route::patch('/absensi/status/{id}', [AttendanceController::class, 'updateStatus'])->name('absensi.updateStatus');

    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [ReportController::class, 'exportCsv'])->name('laporan.export');
    Route::get('/laporan/pelaksana/{id}', [ReportController::class, 'show'])->name('laporan.show');

    Route::get('/pelaksana-list', [PelaksanaController::class, 'index'])->name('pelaksana.list');
    Route::post('/pelaksana-list', [PelaksanaController::class, 'store'])->name('pelaksana.store');
    Route::post('/pelaksana-list/{id}/approve', [PelaksanaController::class, 'approveRegistration'])->name('pelaksana.approve');
    Route::delete('/pelaksana-list/{id}/reject', [PelaksanaController::class, 'rejectRegistration'])->name('pelaksana.reject');
    Route::get('/pelaksana-list/{id}', [PelaksanaController::class, 'show'])->name('pelaksana.show');
    Route::put('/pelaksana-list/{id}', [PelaksanaController::class, 'update'])->name('pelaksana.update');

    Route::get('/pembimbing-list', [PembimbingController::class, 'index'])->name('pembimbing.list');
    Route::post('/pembimbing-list', [PembimbingController::class, 'store'])->name('pembimbing.store');
    Route::get('/pembimbing-list/{id}', [PembimbingController::class, 'show'])->name('pembimbing.show');
    Route::put('/pembimbing-list/{id}', [PembimbingController::class, 'update'])->name('pembimbing.update');

    Route::post('/divisi', [PembimbingController::class, 'storeDivisi'])->name('divisi.store');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::delete('/settings/user/{id}', [SettingsController::class, 'destroyUser'])->name('settings.user.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Pelaksana Routes
Route::prefix('pelaksana')->middleware(['auth', 'verified'])->name('pelaksana.')->group(function () {
    Route::get('/dashboard', [PelaksanaController::class, 'dashboard'])->name('dashboard');

    Route::get('/absensi', [AttendanceController::class, 'pelaksanaIndex'])->name('absensi');

    Route::get('/absensi/upload/{id}', [AttendanceController::class, 'pelaksanaShowUpload'])->name('absensi.create');
    Route::post('/absensi/submit/{id}', [AttendanceController::class, 'pelaksanaSubmit'])->name('absensi.submit');

    Route::get('/absensi/checkout/{id}', [AttendanceController::class, 'pelaksanaShowCheckout'])->name('absensi.checkout');
    Route::post('/absensi/checkout/{id}', [AttendanceController::class, 'pelaksanaSubmitCheckout'])->name('absensi.checkout.submit');

    Route::get('/penugasan/detail/{id}', [TaskController::class, 'pelaksanaShow'])->name('penugasan.show');

    Route::get('/penugasan', [TaskController::class, 'pelaksanaIndex'])->name('penugasan');

    Route::post('/penugasan/submit/{id}', [TaskController::class, 'pelaksanaSubmit'])->name('penugasan.submit');

    Route::post('/penugasan/comment/{id}', [TaskController::class, 'storeComment'])->name('comment');
});

require __DIR__.'/auth.php';