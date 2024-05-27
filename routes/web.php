<?php


use App\Http\Controllers\AreaController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersManageController;
use App\Http\Controllers\UtilitiesController;
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
    Route::post('/add-user-info', [UsersManageController::class, 'addUserInfo'])->name('addUserInfo');
    Route::post('/add-user-login', [UsersManageController::class, 'addUserLogin'])->name('addUserLogin');
    Route::put('/edit-user-login', [UsersManageController::class, 'editUserLogin'])->name('editUserLogin');
    Route::put('UPDATEUSERINFO', [UsersManageController::class, 'UPDATEUSERINFO'])->name('UPDATEUSERINFO');
    Route::put('/update-profile-login', [ProfileController::class, 'UpdateProfileLogin'])->name('UpdateProfileLogin');
    Route::post('/add-user-level', [UsersManageController::class, 'addUserLevel'])->name('addUserLevel');
    Route::get('useraccess', [UsersManageController::class, 'GetAccess'])->name('userAccess');
    Route::post('INSERTROLEINDEX', [UsersManageController::class, 'INSERTROLEINDEX'])->name('INSERTROLEINDEX');


});
Route::middleware('PHIC')->group(function () {
    Route::get('proaccess', [AreaController::class, 'GetProAccess'])->name('proaccess');
    Route::get('pro', [AreaController::class, 'GetRegionalOffice']);
    Route::get('budgetutilization/probudget', [BudgetController::class, 'GETPROFUND']);
    Route::post('INSERTROLEINDEXPRO', [AreaController::class, 'INSERTROLEINDEXPRO'])->name('INSERTROLEINDEXPRO');
    Route::put('EditHCFTagging', [FacilityController::class, 'EditHCFTagging'])->name('EditHCFTagging');
    Route::get('DATESETTINGS', [UtilitiesController::class, 'DATESETTINGS']);


});

Route::middleware('Pro')->group(function () {
    Route::get('managingboard', [AreaController::class, 'GetManagingBoard'])->name('managingboard');
    Route::get('mbaccess', [AreaController::class, 'GetMbAccess'])->name('mbaccess');
    Route::post('INSERTASSETS', [BudgetController::class, 'INSERTASSETS'])->name('INSERTASSETS');
    Route::post('INSERTROLEINDEXMB', [AreaController::class, 'INSERTROLEINDEXMB'])->name('INSERTROLEINDEXMB');
    Route::get('hcpncontract', [BudgetController::class, 'GetHCPNContract'])->name('hcpncontract');
    Route::get('facilitycontracts', [BudgetController::class, 'GetFacilityContracts'])->name('facilitycontracts');
    Route::post('AddContract', [BudgetController::class, 'AddContract'])->name('AddContract');
    Route::get('apexcontract', [BudgetController::class, 'GetAPEXContract'])->name('apexcontract');
    Route::get('apexassets', [BudgetController::class, 'GetAPEXAssets'])->name('apexassets');
    Route::get('facilityassets', [BudgetController::class, 'GetFacilityAssets'])->name('facilityassets');
    Route::post('/add-managingboard', [AreaController::class, 'INSERTManagingBoard'])->name('INSERTManagingBoard');
    Route::post('/add-facility', [FacilityController::class, 'addFacility'])->name('addFacility');
    Route::put('EditHCPNContract', [BudgetController::class, 'EditHCPNContract'])->name('EditHCPNContract');
    Route::put('EditContractStatus', [BudgetController::class, 'EditContractStatus'])->name('EditContractStatus');
    Route::get('apexreports', [BudgetController::class, 'GetAPEXReports'])->name('apexreports');
    Route::get('apexreports/ledger', [BudgetController::class, 'GetAPEXLedger'])->name('apexreports/ledger');
    Route::get('ledger', [BudgetController::class, 'Ledger'])->name('ledger');
    Route::get('ledger/hcpn', [BudgetController::class, 'GetHCPNLedger'])->name('ledger/hcpn');
    Route::get('hcpnassets', [BudgetController::class, 'GetHCPNAssets'])->name('hcpnassets');
    Route::put('REMOVEROLEINDEXPRO', [AreaController::class, 'REMOVEROLEINDEXPRO'])->name('REMOVEROLEINDEXPRO');
    Route::get('CONTRACTPERIOD', [UtilitiesController::class, 'CONTRACTPERIOD']);
    Route::post('INSERTCONTRACTPERIOD', [UtilitiesController::class, 'INSERTCONTRACTPERIOD'])->name('INSERTCONTRACTPERIOD');

});

Route::middleware('MB')->group(function () {
    Route::get('facilities', [FacilityController::class, 'GetFacilities']);
    Route::get('apexfacilities', [FacilityController::class, 'GetApexFacilities']);
    Route::get('GetHealthFacilityBudget', [BudgetController::class, 'GetHealthFacilityBudget'])->name('GetHealthFacilityBudget');
    Route::get('/VIEWBUDGET', [BudgetController::class, 'VIEWBUDGET'])->name('VIEWBUDGET');
    Route::get('accountsettings', [UsersManageController::class, 'GetProfileInfo'])->name('accountsettings');
});


