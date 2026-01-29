<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Customer\LamaranController;
use App\Http\Controllers\Vendor\VendorPekerjaanController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (GLOBAL)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    | Redirect setelah login (SATU PINTU)
    */
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return match ($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'customer' => redirect()->route('customer.dashboard'),
            'vendor'   => redirect()->route('vendor.dashboard'),
            default    => abort(403),
        };
    })->middleware('auth')->name('dashboard');

    /*
    | Chat
    */
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.message.send');
    Route::post('/chat/redirect', [ChatController::class, 'redirectToChat'])->name('chat.redirect');

    /*
    | Profile
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {

    Route::get('/customer/dashboard', [CustomerController::class, 'index'])
        ->name('customer.dashboard');

    Route::get('/customer/pekerjaan', [CustomerController::class, 'listPekerjaan'])
        ->name('customer.pekerjaan');

    Route::get('/customer/chatbot', [CustomerController::class, 'chatbot'])
        ->name('customer.chatbot');

    Route::post('/customer/chatbot/ask', [CustomerController::class, 'askChatbot'])
        ->name('customer.chatbot.ask');

    Route::get('/customer/lamaran', [CustomerController::class, 'listLamaranSaya'])
        ->name('customer.lamaran.index');

    // Lamaran flow
    Route::get('/customer/lamaran/{pekerjaan}/step1', [LamaranController::class, 'step1'])
        ->name('customer.lamaran.step1');

    Route::post('/customer/lamaran/{pekerjaan}/step1', [LamaranController::class, 'step1Post'])
        ->name('customer.lamaran.step1.post');

    Route::get('/customer/lamaran/{pekerjaan}/step2', [LamaranController::class, 'step2'])
        ->name('customer.lamaran.step2');

    Route::post('/customer/lamaran/{pekerjaan}/step2', [LamaranController::class, 'step2Post'])
        ->name('customer.lamaran.step2.post');

    Route::get('/customer/lamaran/{pekerjaan}/konfirmasi', [LamaranController::class, 'konfirmasi'])
        ->name('customer.lamaran.konfirmasi');

    Route::post('/customer/lamaran/{pekerjaan}/submit', [LamaranController::class, 'submit'])
        ->name('customer.lamaran.submit');

    Route::get('/customer/lamaran/selesai', [LamaranController::class, 'selesai'])
        ->name('customer.lamaran.selesai');

    Route::post('/customer/lamaran/{lamaran}/cancel', [LamaranController::class, 'cancel'])
        ->name('customer.lamaran.cancel');
});

/*
|--------------------------------------------------------------------------
| VENDOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:vendor'])->group(function () {

    Route::get('/vendor/dashboard', [VendorController::class, 'index'])
        ->name('vendor.dashboard');

    Route::resource('/vendor/pekerjaan', VendorPekerjaanController::class)
        ->names('vendor.pekerjaan');

    Route::get('/vendor/pekerjaan/{pekerjaan}/lamaran', [VendorPekerjaanController::class, 'lamaran'])
        ->name('vendor.pekerjaan.lamaran');

    Route::match(['post', 'patch'], '/vendor/lamaran/{lamaran}/status',
        [VendorPekerjaanController::class, 'updateStatus']
    )->name('vendor.lamaran.updateStatus');

    Route::post('/vendor/lamaran/{lamaran}/approve-cancel',
        [VendorPekerjaanController::class, 'approveCancel']
    )->name('vendor.lamaran.approveCancel');
});

/*
|--------------------------------------------------------------------------
| Auth routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';