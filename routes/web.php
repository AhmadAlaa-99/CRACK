<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PayController;
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

Route::get('/', function () {
    $users = User::count();
    $visitors = DB::table('visitors')->count();
    return view('index', compact('users','visitors'));
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

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
