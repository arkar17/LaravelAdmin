<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Referee\TwodController;
use App\Http\Controllers\CashInCashOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Referee\ThreedController;
use App\Http\Controllers\Referee\LonePyineController;
use App\Http\Controllers\PusherNotificationController;
use App\Http\Controllers\Referee\AgentRController;
use App\Http\Controllers\Referee\ThreeDManageController;
use App\Http\Controllers\Referee\RefreeManagementController;
use App\Http\Controllers\WinningResultController;

// /Systen Admin///
use App\Http\Controllers\SystemAdmin\AgentController;
use App\Http\Controllers\SystemAdmin\HomeController;
use App\Http\Controllers\SystemAdmin\OperationStaffController;
use App\Http\Controllers\SystemAdmin\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemAdmin\PermissionController;
use App\Http\Controllers\SystemAdmin\RefereeController;
use App\Http\Controllers\SystemAdmin\TwodsController;
use App\Http\Controllers\SystemAdmin\RequestlistController;
use App\Http\Controllers\SystemAdmin\DataController;
use App\Http\Controllers\SystemAdmin\ExportController;
use App\Http\Controllers\SystemAdmin\ProfileController;
use Maatwebsite\Excel\Row;
use App\Http\Controllers\RefereeLoginController;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/r',function(){
//     return view('referee.index');
// });

Auth::routes();

Route::redirect('/', '/login', 301);

Route::fallback(function() {
    return view('auth.login');
});

Route::get('/send',[PusherNotificationController::class, 'notification']);

Route::get('/welcome', fn() => view('welcome'));
Route::get('/refereelogin',fn() => view('auth/refereelogin'))->name('refereelogin');
Route::post('/refereelogin', [RefereeLoginController::class, 'authentication']);

Route::group(['middleware' => 'role:referee'], function(){
// Route::group(['middleware' => 'auth'], function () {
    Route::get('/refe-dashboard', [DashboardController::class, 'refedashboard'])->name('refe-dashboard');

    Route::resource('role', RoleController::class);
    Route::get('/role/delete/{id}',[RoleController::class,'destroy'])->name('role.destroy');

    Route::resource('permission', PermissionController::class);
    Route::get('/permission/delete/{id}',[PermissionController::class,'destroy'])->name('permission.destroy');

    Route::resource('user', UserController::class);
    Route::resource('agent', AgentController::class);


    // Referee Management

    Route::get('/agentRequestListForRefree',[RefreeManagementController::class,'agentList'])->name('agentRequestListForRefree');
    Route::get('/2DManage',[RefreeManagementController::class,'twoDmanage'])->name('2DManage');
    Route::post('/2DManage',[RefreeManagementController::class,'twoDManageCreate'])->name('2DManage');
    Route::get('/3DManage',[ThreeDManageController::class,'ThreeDmanage'])->name('3DManage');
    Route::get('/3D',[ThreeDManageController::class,'ThreeDManageCreate'])->name('3D');
    Route::post('/3DManage',[ThreeDManageController::class,'LonePyaingManageCreate'])->name('3DManage');

     Route::get('/dailysalebook',[RefreeManagementController::class,'dailysalebook'])->name('dailysalebook');
    // Route::post('/dailysalebook',[RefreeManagementController::class,'dailysalebookOne'])->name('dailysalebook');
    Route::get('/acceptTwod',[RefreeManagementController::class,'update'])->name('acceptTwod');

     //Accept
    Route::get('/acceptTwod',[RefreeManagementController::class,'update'])->name('acceptTwod');
    Route::get('/acceptlp',[RefreeManagementController::class,'lpupdate'])->name('acceptlp');
    Route::get('/acceptThreed',[RefreeManagementController::class,'threedupdate'])->name('acceptThreed');

    Route::get('/acceptThreed',[RefreeManagementController::class,'threedupdate'])->name('acceptThreed');

    //decline
    Route::get('/declineTwod',[RefreeManagementController::class,'declineTwod'])->name('declineTwod');
    Route::get('/declinelp',[RefreeManagementController::class,'declinelp'])->name('declinelp');
    Route::get('/declineThreed',[RefreeManagementController::class,'declineThreed'])->name('declineThreed');


    //Accept & decline
    // Route::get('/twodAccept/{id}',[RefreeManagementController::class,'twodAccept'])->name('twodAccept');
    // Route::get('/twodDecline/{id}',[RefreeManagementController::class,'twodDecline'])->name('twodDecline');
    // Route::get('/lonepyineAccept/{id}',[RefreeManagementController::class,'lonepyineAccept'])->name('lonepyineAccept');
    // Route::get('/lonepyinedecline/{id}',[RefreeManagementController::class,'lonepyinedecline'])->name('lonepyinedecline');
    // Route::get('/threedAccept/{id}',[RefreeManagementController::class,'threedAccept'])->name('threedAccept');
    // Route::get('/threedDecline/{id}',[RefreeManagementController::class,'threeddecline'])->name('threeddecline');

    //Route::post('/dailySales',[RefreeManagementController::class,'DailySales'])->name('dailySales');
    // Route::get('/tDList', [RefreeManagementController::class, 'getTwoDs']);

    Route::get('/agentDataForRefree',[AgentRController::class,'agentData'])->name('agentDataForRefree');
    Route::get('/agentAccept/{id}',[RefreeManagementController::class,'agentAccept'])->name('agentAccept');
    Route::get('/agentDecline/{id}',[RefreeManagementController::class,'agentDecline'])->name('agentDecline');

     Route::get('/agentprofiledetail/{id}',[AgentRController::class,'agentprofile'])->name('agentprofiledetail');
    Route::post('/agentcommsionupdate/{id}',[AgentRController::class,'agentcommsionupdate'])->name('agentcommsionupdate');

    Route::get('/2DManageCreate',[RefreeManagementController::class,'twoDManageCreate'])->name('2DManageCreate');

    Route::get('/send3dlist',[ThreeDManageController::class,'threeDManage2'])->name('send3dlist');


    Route::get('/notification', function () {
        return view('RefereeManagement/test');
    });

    //send data to js file 2d manage and 3 manage
    Route::get('send',[RefreeManagementController::class, 'tDListToAgentsAndReferee']);
    Route::get('send2',[ThreeDManageController::class, 'ThreeDmanage']);
    Route::get('sendlonepyineData',[ThreeDManageController::class, 'TnLmanage']);
    Route::get('dailySales',[RefreeManagementController::class, 'dailySales']);
    Route::get('twodlist',[RefreeManagementController::class, 'twodlist']);
    Route::get('lonepyinelist',[RefreeManagementController::class, 'lonepyinelist']);


    Route::get('/2DSaleList',[TwodController::class,'twoDSaleList'])->name('twoDSaleList');
    Route::post('/searchtwodagent',[TwodController::class,'searchthwodagent'])->name('searchthwodagent');
    Route::get('/3DSaleList',[ThreedController::class, 'threeDSaleList'])->name('threeDSaleList');
    Route::post('searchthreedagent',[ThreedController::class,'searchthreeddagent'])->name('searchthreeddagent');
    Route::get('/lonepyineSaleList',[LonePyineController::class,'lonepyineSaleList'])->name('lonepyineSaleList');
    Route::post('/searchlonepyineagent',[LonePyineController::class,'searchlonepyineagent'])->name('searchlonepyineagent');


    Route::get('twod', [TwodController::class, 'twoD'])->name('2d');


    // Cashin Cash out
    Route::get('/cashin-cashout', [CashInCashOutController::class , 'cashInView'] )->name('cashin');
    Route::post('main-cash.store', [CashInCashOutController::class, 'maincashStore'])->name('maincash.store');
    Route::post('/cashin-store', [CashInCashOutController::class, 'cashInStore'])->name('cashin.store');
    Route::post('/cashout-store', [CashInCashOutController::class, 'cashOutStore'])->name('cashout.store');

    //excel export
    Route::get('/export-2dList',[AgentRController::class,'export2DList'])->name('export-2dList');
    Route::get('/export3DList',[AgentRController::class,'export3DList'])->name('export3DList');
    Route::get('/exportlonePyaingList',[AgentRController::class,'exportlonePyaingList'])->name('exportlonePyaingList');

    Route::get('/cashout', [CashInCashOutController::class, 'cashOutView'])->name('cashout');


    Route::get('winning-result', [WinningResultController::class, 'winningresult'])->name('winningresult');
    Route::post('store-winning-result',[WinningResultController::class, 'storeWinningresult'])->name('store.winning');

    Route::get('/announcement',[RefreeManagementController::class,'announcement'])->name('announcement');

    });
    // System Admin//
    Route::group(['middleware' => 'role:system_admin'], function(){
    // Route::get('/', [DashboardController::class, 'sysdashboard'])->name('sys-dashboard');

    Route::get('/sys-dashboard', [DashboardController::class, 'sysdashboard'])->name('sys-dashboard');
    //Route::get('/systemadmin', [HomeController::class, 'index'])->name('systemadmin');

    Route::resource('role', RoleController::class);
    Route::get('/role/delete/{id}',[RoleController::class,'destroy'])->name('role.destroy');

    Route::resource('permission', PermissionController::class);
    Route::get('/permission/delete/{id}',[PermissionController::class,'destroy'])->name('permission.destroy');

    Route::resource('user', UserController::class);
    Route::resource('agent', AgentController::class);

    Route::resource('operation-staff', OperationStaffController::class);
    Route::get('/operation-staff/delete/{id}',[OperationStaffController::class,'destroy'])->name('operation-staff.destroy');
    Route::get('/promoteos/{id}',[OperationStaffController::class,'promoteos'])->name('promoteos');

    Route::resource('referee', RefereeController::class);
    Route::get('/referee/delete/{id}',[RefereeController::class,'destroy'])->name('referee.destroy');
    Route::get('/promoterf/{id}',[RefereeController::class,'promoterf'])->name('promoterf');

    Route::get('/guest/delete/{id}',[HomeController::class,'destroy'])->name('guest.destroy');

    Route::get('/refereerequests',[RequestlistController::class,'refereerequests'])->name('refereerequests');

    Route::post('/referee_accept',[RefereeController::class,'referee_accept'])->name('referee_accept');
    Route::get('/referee_declilne/{id}',[RefereeController::class,'referee_decline'])->name('referee_decline');

    Route::get('/refereecreate/{id}',[RefereeController::class,'refereecreate'])->name('refereecreate');
    Route::post('/refereecreatestore',[RefereeController::class,'refereecreatestore'])->name('refereecreate.store');

    Route::get('/refereeaccept/{id}',[RequestlistController::class,'refereeaccept'])->name('refereeaccept');
    Route::get('/refereedecline/{id}',[RequestlistController::class,'refereedecline'])->name('refereedecline');

    Route::get('/operationstaffrequests',[RequestlistController::class,'operationstaffrequests'])->name('operationstaffrequests');
    Route::get('/operationaccept/{id}',[OperationStaffController::class,'operationaccept'])->name('operationaccept');
    Route::get('/operationdecline/{id}',[OperationStaffController::class,'operationdecline'])->name('operationdecline');

    Route::get('/refereedata',[DataController::class,'refereedata'])->name('refereedata');
    Route::get('/agentdata',[DataController::class,'agentdata'])->name('agentdata');

    Route::get('/refreeprofile/{id}',[ProfileController::class,'refreeprofile'])->name('refreeprofile');
    Route::get('/operationstaffprofile/{id}',[ProfileController::class,'operationstaffprofile'])->name('operationstaffprofile');
    Route::get('/guestprofile/{id}',[ProfileController::class,'guestprofile'])->name('guestprofile');

    Route::get('/agentprofile/{id}',[App\Http\Controllers\SystemAdmin\ProfileController::class,'agentprofile'])->name('agentprofile');

    Route::get('twod', [TwodController::class, 'twoD'])->name('2d');

    Route::get('excel/export', [RefereeController::class, 'export'])->name('export_excel');
    Route::get('pdf/export', [RefereeController::class, 'createPDF'])->name('export_pdf');

    Route::get('excel/customerdata_export/{id}', [ExportController::class, 'customer_export'])->name('customer.export_excel');
    Route::get('pdf/customerdata_export/{id}', [ExportController::class, 'customer_createPDF'])->name('customer.export_pdf');

    Route::get(' create_user', [UserController::class, 'create_user']);
    Route::get('winningstatus',[HomeController::class, 'viewWinning'])->name('winningstatus');
    Route::post('add_winningstatus',[HomeController::class, 'winningstatus'])->name('add_winningstatus');



    // Route::get('winningstatus',[HomeController::class, 'viewWinning'])->name('winningstatus');
    // Route::post('winningstatus',[HomeController::class, 'winningstatus']);

});

