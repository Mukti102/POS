<?php

use App\Http\Controllers\{
    BranchController,
    CategoryController,
    CostumerController,
    DashboardController,
    DebtController,
    DebtPaymentController,
    ProductController,
    ProfileController,
    PurchaseController,
    SettingController,
    StockTransferController,
    TransactionController,
    UserController
};
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // Route khusus admin
    Route::middleware(AdminMiddleware::class)->group(function () {

        // User management
        Route::resource('user', UserController::class);

        // Cabang & Master Data
        Route::resource('cabang', BranchController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('product', ProductController::class);
        Route::resource('pengadaan', PurchaseController::class);

        // Setting
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

        // Debts
        Route::resource('debt', DebtController::class);
        Route::get('/print/debt', [DebtController::class, 'print'])->name('debt.print');
        Route::get('/detail-debt/{id}', [DebtController::class, 'detail'])->name('detail.debts');
        Route::resource('bayar-tagihan', DebtPaymentController::class);

        // mutasi staock
        Route::resource('mutasi-stock', StockTransferController::class);
        // Route untuk AJAX get products
        Route::get('/get-products', [StockTransferController::class, 'getProductsByBranch'])->name('mutasi-stock.get-products');
    });

    // Costumer
    Route::resource('costumer', CostumerController::class);

    // Transaction / POS
    Route::resource('transaction', TransactionController::class);
    Route::get('/pos', [TransactionController::class, 'pos'])->name('pos');
    Route::post('/post/checkout', [TransactionController::class, 'checkout'])->name('pos.checkout');

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::patch('/update-avatar', [ProfileController::class, 'updateAvatar'])->name('update.avatar');
    });

    // 🔹 Opsional: Route untuk storage:link (hapus setelah digunakan)
    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return 'Storage link created successfully!';
    })->name('storage.link');
});

// Auth routes
require __DIR__ . '/auth.php';
