<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// 未ログイン状態で表示する画面のルーティング
Route::get('/transactions/login', [AuthController::class, 'showLoginForm'])->name('transaction.login');
Route::redirect('/transactions', '/transactions/login');
Route::redirect('/transactions/index', '/transactions/login');
Route::post('/transactions/login', [AuthController::class, 'login']);
Route::get('/transactions/logout', [AuthController::class, 'logout']);
Route::get('/transactions/register', [AuthController::class, 'showRegisterForm']);
Route::post('/transactions/register', [AuthController::class, 'createUser']);

// middleware：未ログイン時のアクセスをログイン画面にリダイレクト
Route::middleware(['custom-redirect'])->group(function () {   
    Route::resource('transactions', TransactionController::class)
        ->except(['show'])
        ->parameters([
            'transactions' => 'id', 
    ]);
});

// 想定外のURLはログイン画面にリダイレクト
Route::any('transactions/{any}', function () {
    return redirect()->route('transaction.login');
})->where('any', '.*');


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {        
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
