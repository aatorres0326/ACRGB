<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UsersManageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});
Route::get('/dashboard', [App\Http\Controllers\PageController::class, 'dashboard'])->name('message');
Route::get('table', [APIController::class, 'displayData']);
Route::get('userlogins', [UsersManageController::class, 'GetUsers'])->name('userlogins');
Route::get('userinfo', [UsersManageController::class, 'GetUsersInfo'])->name('userinfo');
Route::get('userlevel', [UsersManageController::class, 'GetUserLevel'])->name('userlevel');
Route::get('/profile', [App\Http\Controllers\PageController::class, 'profile'])->name('profile');
Route::get('/assets', [App\Http\Controllers\PageController::class, 'assets'])->name('assets');
Route::get('/xmlupload', [App\Http\Controllers\PageController::class, 'xmlupload'])->name('xmlupload');
Route::get('facilities', [FacilityController::class, 'GetFacilities']);
Route::get('/budgetmanagement', [App\Http\Controllers\PageController::class, 'budgetmanagement'])->name('budgetmanagement');
Route::post('/add-user-info', [UsersManageController::class, 'addUserInfo'])->name('addUserInfo');
Route::post('/add-user-login', [UsersManageController::class, 'addUserLogin'])->name('addUserLogin');
Route::put('/edit-user-login', [UsersManageController::class, 'editUserLogin'])->name('editUserLogin');
Route::post('/add-user-level', [UsersManageController::class, 'addUserLevel'])->name('addUserLevel');
Route::post('/add-facility', [FacilityController::class, 'addFacility'])->name('addFacility');
Route::post('/add-area-type', [AreaController::class, 'addAreaType'])->name('addAreaType');
Route::post('/add-area', [AreaController::class, 'addArea'])->name('addArea');
Route::get('area', [AreaController::class, 'GetArea']);
// Route::middleware(['auth'])->group(function () {
//     // Protected routes go here
//     Route::get('/dashboard', [App\Http\Controllers\PageController::class,'dashboard'])->name('message');
//     Route::get('table', [APIController::class, 'displayData']);
//     Route::get('users', [UsersManageController::class, 'GetUsers'])->name('users');
//     Route::get('/profile', [App\Http\Controllers\PageController::class, 'profile'])->name('profile');
//     Route::get('/assets', [App\Http\Controllers\PageController::class, 'assets'])->name('assets');
//     Route::get('/xmlupload', [App\Http\Controllers\PageController::class, 'xmlupload'])->name('xmlupload');
//     Route::get('facilities', [APIController::class, 'apiData']);
//     Route::get('budgetmanagement', [APIController::class, 'displayBudget']);
//     Route::post('/add-user-account', [UsersManageController::class, 'addUserAccount'])->name('addUserAccount');

//     // ... other protected routes
// });




// Route::middleware('Admin')->group(function () {
//     Route::get('/users', [App\Http\Controllers\PageController::class, 'users'])->name('users');
// });

