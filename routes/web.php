<?php


use App\Http\Controllers\AreaController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\LayoutsController;
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
    Route::post('/add-user-info', [UsersManageController::class, 'addUserInfo'])->name('addUserInfo');
    Route::post('/add-user-login', [UsersManageController::class, 'addUserLogin'])->name('addUserLogin');
    Route::put('/edit-user-login', [UsersManageController::class, 'editUserLogin'])->name('editUserLogin');
    Route::put('/update-profile-login', [ProfileController::class, 'UpdateProfileLogin'])->name('UpdateProfileLogin');
    Route::post('/add-user-level', [UsersManageController::class, 'addUserLevel'])->name('addUserLevel');
    Route::get('useraccess', [UsersManageController::class, 'GetAccess'])->name('userAccess');
    Route::post('INSERTROLEINDEX', [UsersManageController::class, 'INSERTROLEINDEX'])->name('INSERTROLEINDEX');


});

Route::middleware('Pro')->group(function () {
    Route::get('managingboard', [AreaController::class, 'GetManagingBoard'])->name('managingboard');
    Route::get('mbaccess', [AreaController::class, 'GetMbAccess'])->name('mbaccess');
    Route::post('INSERTASSETS', [BudgetController::class, 'INSERTASSETS'])->name('INSERTASSETS');
    Route::post('INSERTROLEINDEXMB', [AreaController::class, 'INSERTROLEINDEXMB'])->name('INSERTROLEINDEXMB');
    Route::get('hcpncontract', [BudgetController::class, 'GetHCPNContract'])->name('hcpncontract');
    Route::post('AddHCPNContract', [BudgetController::class, 'AddHCPNContract'])->name('AddHCPNContract');
    Route::get('apexcontract', [BudgetController::class, 'GetAPEXContract'])->name('apexcontract');
    Route::get('apexassets', [BudgetController::class, 'GetAPEXAssets'])->name('apexassets');
    Route::post('/add-managingboard', [AreaController::class, 'INSERTManagingBoard'])->name('INSERTManagingBoard');
    Route::post('/add-facility', [FacilityController::class, 'addFacility'])->name('addFacility');
    Route::put('EditHCPNContract', [BudgetController::class, 'EditHCPNContract'])->name('EditHCPNContract');

});

Route::middleware('MB')->group(function () {
    Route::get('facilities', [FacilityController::class, 'GetFacilities']);
    Route::get('GetHealthFacilityBudget', [BudgetController::class, 'GetHealthFacilityBudget'])->name('GetHealthFacilityBudget');
    Route::get('/viewhcfbudget', [BudgetController::class, 'viewFacilityBudget'])->name('viewhcfbudget');
});

Route::middleware('PHIC')->group(function () {
    Route::get('proaccess', [AreaController::class, 'GetProAccess'])->name('proaccess');
    Route::get('pro', [AreaController::class, 'GetRegionalOffice']);
    Route::get('assets', [AssetsController::class, 'GetAssets']);
    Route::post('addPro', [AreaController::class, 'addPro'])->name('addPro');
    Route::post('INSERTROLEINDEXPRO', [AreaController::class, 'INSERTROLEINDEXPRO'])->name('INSERTROLEINDEXPRO');

});
