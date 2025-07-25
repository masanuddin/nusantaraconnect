<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.message.send');
    Route::post('/chat/redirect', [ChatController::class, 'redirectToChat'])->name('chat.redirect');
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
    Route::get('/customer/pekerjaan', [CustomerController::class, 'listPekerjaan'])->name('customer.pekerjaan');
    Route::get('/customer/chatbot', [CustomerController::class, 'chatbot'])->name('customer.chatbot');
    Route::post('/customer/chatbot/ask', [CustomerController::class, 'askChatbot'])->name('customer.chatbot.ask');
    Route::get('/customer/lamaran', [CustomerController::class, 'listLamaranSaya'])->name('customer.lamaran.index');
    
    Route::get('/customer/lamaran/{pekerjaan}/step1', [\App\Http\Controllers\Customer\LamaranController::class, 'step1'])->name('customer.lamaran.step1');
    Route::post('/customer/lamaran/{pekerjaan}/step1', [\App\Http\Controllers\Customer\LamaranController::class, 'step1Post'])->name('customer.lamaran.step1.post');
    Route::get('/customer/lamaran/{pekerjaan}/step2', [\App\Http\Controllers\Customer\LamaranController::class, 'step2'])->name('customer.lamaran.step2');
    Route::post('/customer/lamaran/{pekerjaan}/step2', [\App\Http\Controllers\Customer\LamaranController::class, 'step2Post'])->name('customer.lamaran.step2.post');
    Route::get('/customer/lamaran/{pekerjaan}/konfirmasi', [\App\Http\Controllers\Customer\LamaranController::class, 'konfirmasi'])->name('customer.lamaran.konfirmasi');
    Route::post('/customer/lamaran/{pekerjaan}/submit', [\App\Http\Controllers\Customer\LamaranController::class, 'submit'])->name('customer.lamaran.submit');
    Route::get('/customer/lamaran/selesai', [\App\Http\Controllers\Customer\LamaranController::class, 'selesai'])->name('customer.lamaran.selesai');
    Route::get('/customer/lamaran', [\App\Http\Controllers\Customer\LamaranController::class, 'index'])->name('customer.lamaran.index');
    Route::post('/customer/lamaran/{lamaran}/cancel', [\App\Http\Controllers\Customer\LamaranController::class, 'cancel'])
    ->name('customer.lamaran.cancel');

    
});

// Halaman khusus customer
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
    Route::resource('/vendor/pekerjaan', \App\Http\Controllers\Vendor\VendorPekerjaanController::class)->names('vendor.pekerjaan');
    Route::get('/vendor/pekerjaan/{pekerjaan}/lamaran', [\App\Http\Controllers\Vendor\VendorPekerjaanController::class, 'lamaran'])->name('vendor.pekerjaan.lamaran');
    Route::post('/vendor/lamaran/{lamaran}/status', [\App\Http\Controllers\Vendor\VendorPekerjaanController::class, 'updateStatus'])->name('vendor.lamaran.updateStatus');
    Route::patch('/vendor/lamaran/{lamaran}/status', [\App\Http\Controllers\Vendor\VendorPekerjaanController::class, 'updateStatus'])
    ->name('vendor.lamaran.updateStatus');
    Route::post('/vendor/lamaran/{lamaran}/approve-cancel', [\App\Http\Controllers\Vendor\VendorPekerjaanController::class, 'approveCancel'])
    ->name('vendor.lamaran.approveCancel');

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
