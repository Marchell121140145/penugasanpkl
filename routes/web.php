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
use App\Http\Controllers\FileServeController;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard jika sudah login
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// =========================================
// Semua User Terautentikasi (tanpa batasan role)
// =========================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard (controller menangani redirect berdasarkan role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Private file serving routes (controller memiliki access check sendiri)
    Route::get('/file/task/{id}', [FileServeController::class, 'serveTaskFile'])->name('file.task');
    Route::get('/file/submission/{id}', [FileServeController::class, 'serveSubmissionFile'])->name('file.submission');
    Route::get('/file/attendance/{id}/{type}', [FileServeController::class, 'serveAttendancePhoto'])->name('file.attendance');
    Route::get('/file/avatar/{id}', [FileServeController::class, 'serveAvatar'])->name('file.avatar');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================================
// Admin & Pembimbing (role:1,2)
// =========================================
Route::middleware(['auth', 'verified', 'role:1,2'])->group(function () {

    // --- Penugasan ---
    Route::get('/penugasan', [TaskController::class, 'index'])->name('penugasan');
    Route::get('/penugasan/create', [TaskController::class, 'create'])->name('penugasan.create');
    Route::post('/penugasan', [TaskController::class, 'store'])->name('penugasan.store');
    Route::get('/penugasan/detail/{id}', [TaskController::class, 'show'])->name('penugasan.show');
    Route::get('/penugasan/edit/{id}', [TaskController::class, 'edit'])->name('penugasan.edit');
    Route::put('/penugasan/{id}', [TaskController::class, 'update'])->name('penugasan.update');
    Route::delete('/penugasan/{id}', [TaskController::class, 'destroy'])->name('penugasan.destroy');
    Route::post('/penugasan/grade/{id}', [TaskController::class, 'submitGrade'])->name('penugasan.grade');
    Route::post('/penugasan/comment/{id}', [TaskController::class, 'storeComment'])->name('penugasan.comment');

    // --- Excel Editor ---
    Route::get('/penugasan/excel-editor', [ExcelEditorController::class, 'edit'])->name('excel.editor');
    Route::post('/penugasan/excel-editor/save', [ExcelEditorController::class, 'save'])->name('excel.editor.save');

    // --- Absensi ---
    Route::get('/absensi', [AttendanceController::class, 'index'])->name('absensi');
    Route::get('/absensi/create', [AttendanceController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [AttendanceController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/detail/{id}', [AttendanceController::class, 'sessionDetail'])->name('absensi.detail');
    Route::get('/absensi/history/{id}', [AttendanceController::class, 'adminHistory'])->name('absensi.history');
    Route::patch('/absensi/status/{id}', [AttendanceController::class, 'updateStatus'])->name('absensi.updateStatus');

    // --- Laporan ---
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [ReportController::class, 'exportCsv'])->name('laporan.export');
    Route::get('/laporan/pelaksana/{id}', [ReportController::class, 'show'])->name('laporan.show');

    // --- Pelaksana Management (lihat & update) ---
    Route::get('/pelaksana-list', [PelaksanaController::class, 'index'])->name('pelaksana.list');
    Route::get('/pelaksana-list/{id}', [PelaksanaController::class, 'show'])->name('pelaksana.show');
    Route::put('/pelaksana-list/{id}', [PelaksanaController::class, 'update'])->name('pelaksana.update');
});

// =========================================
// Admin Only (role:1)
// =========================================
Route::middleware(['auth', 'verified', 'role:1'])->group(function () {

    // --- Pelaksana: Tambah, Approve, Reject ---
    Route::post('/pelaksana-list', [PelaksanaController::class, 'store'])->name('pelaksana.store');
    Route::post('/pelaksana-list/{id}/approve', [PelaksanaController::class, 'approveRegistration'])->name('pelaksana.approve');
    Route::delete('/pelaksana-list/{id}/reject', [PelaksanaController::class, 'rejectRegistration'])->name('pelaksana.reject');

    // --- Pembimbing Management ---
    Route::get('/pembimbing-list', [PembimbingController::class, 'index'])->name('pembimbing.list');
    Route::post('/pembimbing-list', [PembimbingController::class, 'store'])->name('pembimbing.store');
    Route::get('/pembimbing-list/{id}', [PembimbingController::class, 'show'])->name('pembimbing.show');
    Route::put('/pembimbing-list/{id}', [PembimbingController::class, 'update'])->name('pembimbing.update');

    // --- Divisi Management ---
    Route::post('/divisi', [PembimbingController::class, 'storeDivisi'])->name('divisi.store');

    // --- Settings ---
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::delete('/settings/user/{id}', [SettingsController::class, 'destroyUser'])->name('settings.user.destroy');
    Route::put('/settings/user/{id}', [SettingsController::class, 'updateUser'])->name('settings.user.update');
    Route::post('/settings/purge-pelaksana', [SettingsController::class, 'purgePelaksana'])->name('settings.purge');
});

// =========================================
// Pelaksana Routes (role:3)
// =========================================
Route::prefix('pelaksana')->middleware(['auth', 'verified', 'role:3'])->name('pelaksana.')->group(function () {
    Route::get('/dashboard', [PelaksanaController::class, 'dashboard'])->name('dashboard');

    Route::get('/absensi', [AttendanceController::class, 'pelaksanaIndex'])->name('absensi');
    Route::get('/absensi/upload/{id}', [AttendanceController::class, 'pelaksanaShowUpload'])->name('absensi.create');
    Route::post('/absensi/submit/{id}', [AttendanceController::class, 'pelaksanaSubmit'])->name('absensi.submit');
    Route::get('/absensi/checkout/{id}', [AttendanceController::class, 'pelaksanaShowCheckout'])->name('absensi.checkout');
    Route::post('/absensi/checkout/{id}', [AttendanceController::class, 'pelaksanaSubmitCheckout'])->name('absensi.checkout.submit');

    Route::get('/penugasan', [TaskController::class, 'pelaksanaIndex'])->name('penugasan');
    Route::get('/penugasan/detail/{id}', [TaskController::class, 'pelaksanaShow'])->name('penugasan.show');
    Route::post('/penugasan/submit/{id}', [TaskController::class, 'pelaksanaSubmit'])->name('penugasan.submit');
    Route::post('/penugasan/comment/{id}', [TaskController::class, 'storeComment'])->name('comment');
});

require __DIR__.'/auth.php';