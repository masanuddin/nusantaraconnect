<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Middleware untuk menangani redirect setelah login
Route::get('/redirect', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'customer') {
        return redirect()->route('customer.dashboard');
    } elseif ($user->role === 'vendor') {
        return redirect()->route('vendor.dashboard');
    } else {
        return redirect()->route('dashboard');
    }
})->name('redirect');

// Halaman khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Halaman khusus customer
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
});

// Halaman khusus customer
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
});

// Dashboard umum
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
