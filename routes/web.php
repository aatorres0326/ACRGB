<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersManageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return Redirect::route('login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\PageController::class, 'dashboard'])->name('message');
    Route::get('/changelogin', [App\Http\Controllers\PageController::class, 'changelogin'])->name('changelogin');

});


Route::middleware('Admin')->group(function () {
    Route::get('userlogins', [UsersManageController::class, 'GetUsers'])->name('userlogins');
    Route::get('useraccess', [UsersManageController::class, 'GetAccess'])->name('userAccess');
    Route::get('userinfo', [UsersManageController::class, 'GetUsersInfo'])->name('userinfo');
    Route::get('profile', [ProfileController::class, 'GetProfileInfo'])->name('profile');
    Route::get('userlevel', [UsersManageController::class, 'GetUserLevel'])->name('userlevel');
    Route::get('assets', [AssetsController::class, 'GetAssets']);
    Route::get('budgetmanagement', [BudgetController::class, 'GetFacilityBudget'])->name('budgetmanagement');
    Route::get('/viewhcfbudget', [BudgetController::class, 'viewFacilityBudget'])->name('viewhcfbudget');
    Route::post('/add-user-info', [UsersManageController::class, 'addUserInfo'])->name('addUserInfo');
    Route::post('/add-user-login', [UsersManageController::class, 'addUserLogin'])->name('addUserLogin');
    Route::put('/edit-user-login', [UsersManageController::class, 'editUserLogin'])->name('editUserLogin');
    Route::put('/update-profile-login', [ProfileController::class, 'UpdateProfileLogin'])->name('UpdateProfileLogin');
    Route::post('/add-user-level', [UsersManageController::class, 'addUserLevel'])->name('addUserLevel');
    Route::post('/add-area-type', [AreaController::class, 'addAreaType'])->name('addAreaType');
    Route::post('/add-area', [AreaController::class, 'addArea'])->name('addArea');
    Route::get('area', [AreaController::class, 'GetArea']);
    Route::get('pro', [AreaController::class, 'GetRegionalOffice']);
    Route::get('managingboard', [AreaController::class, 'GetManagingBoard'])->name('managingboard');
    Route::post('/add-managingboard', [AreaController::class, 'INSERTManagingBoard'])->name('INSERTManagingBoard');
    Route::post('addPro', [AreaController::class, 'addPro'])->name('addPro');
    Route::get('facilities', [FacilityController::class, 'GetFacilities']);
    Route::post('/add-facility', [FacilityController::class, 'addFacility'])->name('addFacility');
    Route::post('INSERTROLEINDEX', [UsersManageController::class, 'INSERTROLEINDEX'])->name('INSERTROLEINDEX');
    Route::get('useraccess', [UsersManageController::class, 'GetAccess'])->name('userAccess');
});

Route::middleware('Pro')->group(function () {
    Route::get('managingboard', [AreaController::class, 'GetManagingBoard'])->name('managingboard');
    Route::post('/add-managingboard', [AreaController::class, 'INSERTManagingBoard'])->name('INSERTManagingBoard');
    Route::get('facilities', [FacilityController::class, 'GetAccess']);
    Route::post('/add-facility', [FacilityController::class, 'addFacility'])->name('addFacility');
});