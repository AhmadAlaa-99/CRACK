<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CoinGateController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NowPaymentsController;
use App\Http\Controllers\BTCPayController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// routes/web.php


Route::post('/ipn/now/{token}', [NowPaymentsController::class, 'ipn'])->name('now.ipn');   // POST callback


// Payment route
Route::middleware('auth')->group(function () {
    Route::get('/now',  [NowPaymentsController::class, 'createPayment'])->name('now');
    Route::get('/now/success',     [NowPaymentsController::class, 'success'])->name('now.success');
    Route::get('/now/cancel',      [NowPaymentsController::class, 'cancel'])->name('now.cancel');
});


Route::middleware('auth')->group(function () {
    Route::get('/pay/{plan_id?}',         [BTCPayController::class,'createPayment'])->name('btcpay.pay');
    Route::get('/btcpay/processing/{id}', [BTCPayController::class,'processing'])->name('btcpay.processing');
    Route::get('/btcpay/success/{id}',    [BTCPayController::class,'success'])  ->name('btcpay.success');
});

Route::get ('/btcpay/status/{id}',  [BTCPayController::class,'status']) ->name('btcpay.status');
Route::post('/btcpay/webhook',      [BTCPayController::class,'webhook'])->name('btcpay.webhook');



// Payment routes


// CoinGate callback routes
Route::post('/coin-gate/callback/{token}', [CoinGateController::class, 'callback'])
    ->name('coingate.callback');

Route::get('/coin-gate/cancel', [CoinGateController::class, 'cancel'])
    ->name('coingate.cancel')
    ->middleware(['auth']);

Route::get('/coin-gate/success', [CoinGateController::class, 'success'])
    ->name('coingate.success')
    ->middleware(['auth']);



    // Download route after successful payment

    Route::get('/download/plan/{p}', [CoinGateController::class, 'downloadPlan'])
    ->name('download.plan')
    ->middleware(['auth']);
    


    Route::get('/', function () {
    $users = User::count();
    $visitors = DB::table('visitors')->count();
    return view('index', compact('users', 'visitors'));
})->name('index');

Route::get('/change-language/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en', 'ch'])) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('change-language');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/price', function () {
    return view('price');
})->name('price');



Route::middleware(['auth'])->group(function () {
    Route::get('/pay', [PayController::class, 'index'])->name('pay');
});
Route::get('/team', function () {
    return view('team');
})->name('team');

Route::get('/open', function () {
    return view('open');
})->name('open');

Route::get('/testimonial', function () {
    return view('testimonial');
})->name('testimonial');

Route::get('/404', function () {
    return view('404');
})->name('404');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/register', [AuthController::class, 'registerStep1'])->name('register');
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('verify.otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::get('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');


Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/plan_purchases/{plan}', [DashboardController::class,'purchases'])
          ->name('plans.purchases');
     Route::patch('/purchases/{purchase}/allow',  [DashboardController::class, 'allow'])
               ->name('purchases.allow');
          Route::patch('/purchases/{purchase}/revoke', [DashboardController::class, 'revoke'])
               ->name('purchases.revoke');
});
Route::prefix('files')->name('files.')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('index');
    Route::post('/', [FileController::class, 'store'])->name('store');
    Route::get('/{file}/get', [FileController::class, 'getFile'])->name('get');
    Route::put('/{file}', [FileController::class, 'update'])->name('update');
    Route::delete('/{file}', [FileController::class, 'destroy'])->name('destroy');
    Route::get('/{file}/download', [FileController::class, 'download'])->name('download');
});
