<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\DebtPaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('category',CategoryController::class);
    Route::resource('product',ProductController::class);
    Route::resource('pengadaan',PurchaseController::class);
    Route::resource('costumer',CostumerController::class);
    Route::resource('transaction',TransactionController::class);
    Route::get('/pos',[TransactionController::class,'pos'])->name('pos');
    Route::post('/post/checkout',[TransactionController::class,'checkout'])->name('pos.checkout');

    Route::get('/setting',[SettingController::class,'index'])->name('setting.index');
    Route::post('/setting',[SettingController::class,'update'])->name('setting.update');
    
    // debts
    Route::resource('debt',DebtController::class);
    Route::get('/print/debt',[DebtController::class,'print'])->name('debt.print');
    Route::get('/detail-debt/{id}',[DebtController::class,'detail'])->name('detail.debts');
    Route::resource('bayar-tagihan',DebtPaymentController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/update-avatar',[ProfileController::class,'updateAvatar'])->name('update.avatar');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
