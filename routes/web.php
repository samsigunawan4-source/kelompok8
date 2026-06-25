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
        return view('admin.dashboard');
    })->name('admin.dashboard');

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