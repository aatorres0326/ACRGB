<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // Route::get('/table', [App\Http\Controllers\AuthController::class, 'table'])->name('table');
    Route::get('table', [APIController::class, 'displayData']);
    Route::get('/profile', [App\Http\Controllers\PageController::class, 'profile'])->name('profile');
    Route::get('/users', [App\Http\Controllers\PageController::class, 'users'])->name('users');
    Route::get('/assets', [App\Http\Controllers\PageController::class, 'assets'])->name('assets');
    Route::get('/xmlupload', [App\Http\Controllers\PageController::class, 'xmlupload'])->name('xmlupload');
    Route::get('facilities', [APIController::class, 'apiData']);
    // Route::get('budgetmanagement', [App\Http\Controllers\PageController::class, 'budgetmanagement'])->name('budgetmanagement');
    Route::get('budgetmanagement', [APIController::class, 'displayBudget']);
});
Route::middleware('Admin')->group(function () {
    Route::get('/users', [App\Http\Controllers\PageController::class, 'users'])->name('users');
});

