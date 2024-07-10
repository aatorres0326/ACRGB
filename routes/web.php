<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersManageController;
use App\Http\Controllers\UtilitiesController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return Redirect::route('login');
});

Route::get('/download-template', function () {
    $filePath = public_path('templates\ACRGBTemplate.xlsx');
    return Response::download($filePath);
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::get('ForgotPassword', 'ForgotPassword')->name('ForgotPassword');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
    Route::post('ResetPassword', [AuthController::class, 'ResetPassword'])->name('ResetPassword');

});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\BudgetController::class, 'dashboard'])->name('message');
});


Route::middleware('Admin')->group(function () {

    Route::put('/update-profile-login', [ProfileController::class, 'UpdateProfileLogin'])->name('UpdateProfileLogin');
    Route::post('INSERTROLEINDEX', [UsersManageController::class, 'INSERTROLEINDEX'])->name('INSERTROLEINDEX');
    Route::get('ActivityLogs', [UtilitiesController::class, 'ActivityLogs'])->name('ActivityLogs');
    Route::post('UPLOADUSERSJSON', [UsersManageController::class, 'UPLOADUSERSJSON'])->name('UPLOADUSERSJSON');



});
Route::middleware('PHIC')->group(function () {
    Route::get('proaccess', [AreaController::class, 'GetProAccess'])->name('proaccess');
    Route::get('pro', [AreaController::class, 'GetRegionalOffice']);
    Route::get('budgetutilization/probudget', [BudgetController::class, 'GETPROFUND']);
    Route::post('INSERTROLEINDEXPRO', [AreaController::class, 'INSERTROLEINDEXPRO'])->name('INSERTROLEINDEXPRO');
    Route::post('AddPROBudget', [BudgetController::class, 'AddPROBudget'])->name('AddPROBudget');
    Route::get('GetPROBudget', [BudgetController::class, 'GetPROBudget'])->name('GetPROBudget');
    Route::get('ContractHistory', [BudgetController::class, 'ContractHistory'])->name('ContractHistory');



});

Route::middleware('Pro')->group(function () {
    Route::get('managingboard', [AreaController::class, 'GetManagingBoard'])->name('managingboard');
    Route::get('mbaccess', [AreaController::class, 'GetMbAccess'])->name('mbaccess');
    Route::put('UpdateHCPN', [AreaController::class, 'UpdateHCPN'])->name('UpdateHCPN');
    Route::post('INSERTROLEINDEXMB', [AreaController::class, 'INSERTROLEINDEXMB'])->name('INSERTROLEINDEXMB');
    Route::get('hcpncontract', [BudgetController::class, 'GetHCPNContract'])->name('hcpncontract');
    Route::post('/add-managingboard', [AreaController::class, 'INSERTManagingBoard'])->name('INSERTManagingBoard');
    Route::put('EditHCPNContract', [BudgetController::class, 'EditHCPNContract'])->name('EditHCPNContract');
    Route::get('hcpnassets', [BudgetController::class, 'GetHCPNAssets'])->name('hcpnassets');
    Route::put('REMOVEROLEINDEXPRO', [AreaController::class, 'REMOVEROLEINDEXPRO'])->name('REMOVEROLEINDEXPRO');
    Route::put('REMOVEROLEINDEXHCPN', [AreaController::class, 'REMOVEROLEINDEXHCPN'])->name('REMOVEROLEINDEXHCPN');
    Route::get('CONTRACTPERIOD', [UtilitiesController::class, 'CONTRACTPERIOD']);
    Route::post('INSERTCONTRACTPERIOD', [UtilitiesController::class, 'INSERTCONTRACTPERIOD'])->name('INSERTCONTRACTPERIOD');
    Route::post('ENDCONTRACTPERIOD', [UtilitiesController::class, 'ENDCONTRACTPERIOD'])->name('ENDCONTRACTPERIOD');
    Route::put('EditHCFTagging', [FacilityController::class, 'EditHCFTagging'])->name('EditHCFTagging');
    Route::post('BookData', [ReportsController::class, 'BookData'])->name('BookData');
    Route::get('Contracts/NewAPEXContract', [BudgetController::class, 'NewAPEXContract'])->name('Contracts/NewAPEXContract');
    Route::get('ApexAffiliates', [FacilityController::class, 'ApexAffiliates'])->name('ApexAffiliates');
    Route::post('AddAPEXContract', [BudgetController::class, 'AddAPEXContract'])->name('AddAPEXContract');
    Route::get('apexcontract', [BudgetController::class, 'GetAPEXContract'])->name('apexcontract');
    Route::get('apexassets', [BudgetController::class, 'GetAPEXAssets'])->name('apexassets');
    Route::get('apexfacilities', [FacilityController::class, 'GetAPEXFacilities']);
    Route::get('userinfo', [UsersManageController::class, 'GetUsersInfo'])->name('userinfo');
    Route::post('/add-user-info', [UsersManageController::class, 'addUserInfo'])->name('addUserInfo');
    Route::get('UploadUsers', [UsersManageController::class, 'UploadUsers'])->name('UploadUsers');
    Route::get('userlogins', [UsersManageController::class, 'GetUsers'])->name('userlogins');
    Route::get('useraccess', [UsersManageController::class, 'GetAccess'])->name('userAccess');
    Route::post('/add-user-login', [UsersManageController::class, 'addUserLogin'])->name('addUserLogin');
    Route::put('/edit-user-login', [UsersManageController::class, 'editUserLogin'])->name('editUserLogin');
    Route::put('UPDATEUSERINFO', [UsersManageController::class, 'UPDATEUSERINFO'])->name('UPDATEUSERINFO');


});

Route::middleware('MB')->group(function () {
    Route::get('facilities', [FacilityController::class, 'GetFacilities']);
    Route::get('GetHealthFacilityBudget', [BudgetController::class, 'GetHealthFacilityBudget'])->name('GetHealthFacilityBudget');
    Route::get('Reports/GeneralLedger', [ReportsController::class, 'GeneralLedger'])->name('Reports/GeneralLedger');
    Route::get('/VIEWBUDGET', [ReportsController::class, 'VIEWBUDGET'])->name('VIEWBUDGET');
    Route::get('accountsettings', [UsersManageController::class, 'GetProfileInfo'])->name('accountsettings');
    Route::get('back', [PageController::class, 'Back'])->name('back');
    Route::get('facilitycontracts', [BudgetController::class, 'GetFacilityContracts'])->name('facilitycontracts');
    Route::post('AddContract', [BudgetController::class, 'AddContract'])->name('AddContract');
    Route::get('facilityassets', [BudgetController::class, 'GetFacilityAssets'])->name('facilityassets');
    Route::get('Reports/Booking', [ReportsController::class, 'Booking'])->name('Reports/Booking');
    Route::get('Reports/SubsidiaryLedger', [ReportsController::class, 'SubsidiaryLedger'])->name('SubsidiaryLedger');
    Route::put('EditContractStatus', [BudgetController::class, 'EditContractStatus'])->name('EditContractStatus');
    Route::post('INSERTASSETS', [BudgetController::class, 'INSERTASSETS'])->name('INSERTASSETS');
    Route::get('Contracts/NewContract', [BudgetController::class, 'NewContract']);
});