<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Rute ini berfungsi sebagai "Pengarah lalu lintas" setelah login
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================================
// GRUP RUTE KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    
    Route::get('/admin/dashboard', function () {
        // Mengambil semua data magang dari database beserta data mahasiswanya
        $internships = \App\Models\Internship::with('user')->latest()->get();
        return view('admin.dashboard', compact('internships'));
    })->name('admin.dashboard');

    // Rute untuk mengubah status (Setujui / Tolak)
    Route::patch('/admin/internship/{id}/status', [App\Http\Controllers\InternshipController::class, 'updateStatus'])->name('admin.internship.updateStatus');

});

// ==========================================
// GRUP RUTE KHUSUS USER (MAHASISWA)
// ==========================================
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

});

// Rute bawaan untuk Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';