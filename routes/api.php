<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TwodThreeDController;
use App\Http\Controllers\Api\Pusher\TwoDController;
use App\Http\Controllers\Api\ApiTwoDManageController;
use App\Http\Controllers\Api\Pusher\ThreeDController;
use App\Http\Controllers\Api\Noti\NotiCenterController;
use App\Http\Controllers\Api\Opstaff\OpstaffController;
use App\Http\Controllers\Api\Pusher\LonePyaingController;
use App\Http\Controllers\Api\AcceptedTransitionController;
use App\Http\Controllers\Api\PusherNotificationController;
use App\Http\Controllers\Api\TwoD\TwodManagementController;
use App\Http\Controllers\Api\Pusher\TwoDSaleListsController;
use App\Http\Controllers\Api\Noti\NotificationCenterController;
use App\Http\Controllers\Api\SaleDayBook\SaleDayBookController;
use App\Http\Controllers\Api\WinningResult\WinningResultController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('checkPhone', [AuthController::class, 'checkPhone']);
Route::post('hasPhone', [AuthController::class, 'hasPhone']);;
Route::post('forget-password', [AuthController::class, 'passwordChange']);

Route::get('/winning-result', [WinningResultController::class, 'checkResult']);

Route::group(['middleware' => 'jwt.auth'], function () {

    Route::get('agent-profile', [AuthController::class, 'agentProfile']);
    Route::post('profile-update', [AuthController::class, 'profileUpdate']);
    Route::post('request-promotion', [AuthController::class, 'promoteRequest']);

    // Get 2Ds, 3Ds, longpyaings (from referee to agents)
    Route::get('/getTwoDsAM', [TwodThreeDController::class, 'getTwoDsAm']);
    Route::get('/getTwoDsPM', [TwodThreeDController::class, 'getTwoDsPM']);
    Route::get('/3ds', [TwodThreeDController::class, 'getThreeDs']);
    Route::get('/getLonePyaingsAM', [TwodThreeDController::class, 'getLonePyaingsAM']);
    Route::get('/getLonePyaingsPM', [TwodThreeDController::class, 'getLonePyaingsPM']);

    // Store 2d sale lists ,3d sale lists, lonepyaing sale lists (default pending)
    Route::post('2d-sale', [TwodThreeDController::class, 'twoDSale']);
    Route::post('3d-sale', [TwodThreeDController::class, 'threeDSale']);
    Route::post('lonepyaing-sale', [TwodThreeDController::class, 'lonePyaingSale']);

    // Accepted Transitions
    Route::get('/2d-accepted-transition', [AcceptedTransitionController::class, 'twodAcceptedTransitions']);
    Route::post('/2d-accepted-transitionbydate', [AcceptedTransitionController::class, 'twodAcceptedTransitionsByDate']);

    Route::get('/3d-accepted-transition', [AcceptedTransitionController::class, 'threedAcceptedTransitions']);
    Route::post('/3d-accepted-transitionbydate', [AcceptedTransitionController::class, 'threedAcceptedTransitionsByDate']);

    Route::get('/lonepyaing-accepted-transition', [AcceptedTransitionController::class, 'lonepyineAcceptedTransitions']);
    Route::post('/lonepyaing-accepted-transitionbydate', [AcceptedTransitionController::class, 'lonepyineAcceptedTransitionsByDate']);

    Route::get('round', [AcceptedTransitionController::class, 'roundDate']);

    // show pending bet lists from
    Route::get('2d-salelists', [TwodThreeDController::class, 'ShowTwoDPendingSaleLists']);
    Route::get('3d-salelists', [TwodThreeDController::class, 'ShowThreeDPendingSaleLists']);
    Route::get('lonepyaing-salelists', [TwodThreeDController::class, 'ShowLonePyaingPendingSaleLists']);

    // referee profile
    Route::get('referee', [AuthController::class, 'refereeProfile']);

    // Operation staff manage
    Route::get('referee-requests', [OpstaffController::class, 'showRefereeRequests']);
    Route::get('showreferees', [OpstaffController::class, 'showReferees']);
    Route::delete('/referees/{id}', [OpstaffController::class, 'destroyReferee']);
    Route::post('/referees/{id}', [OpstaffController::class, 'editReferee']);
    Route::get('opstaff-profile', [OpstaffController::class, 'opstaffProfile']);
    Route::post('/opstaffProfile-update', [OpstaffController::class, 'opstaffProfileUpdate']);
    Route::post('accept-referee/{id}', [OpstaffController::class, 'acceptReferee']);
    Route::post('decline-referee/{id}', [OpstaffController::class, 'declineReferee']);


    // show 2d sale lists
    Route::get('/2d-noti', [TwoDController::class, 'notification']);
    Route::get('/3d-noti', [ThreeDController::class, 'notification']);
    Route::get('/lonepyaing-noti', [LonePyaingController::class, 'notification']);

    // Route::get('/3d-salelists-noti', [TwoDSaleListsController::class, 'twod']);

    //Winning Result
    Route::get('2d-win', [WinningResultController::class, 'twodWin']);
    Route::post('2d-win-bydate', [WinningResultController::class, 'twodWinByDate']);
    Route::get('3d-win', [WinningResultController::class, 'threedWin']);
    Route::post('3d-win-bydate', [WinningResultController::class, 'threedWinByDate']);
    Route::get('lp-win', [WinningResultController::class, 'lpWin']);
    Route::post('lp-win-bydate', [WinningResultController::class, 'lpWinByDate']);


    // Notifications
    Route::get('all-notis', [NotiCenterController::class, 'getAllNotifications']);
    Route::get('current-noti', [NotiCenterController::class, 'getCurrentNotification']);
    // Route::get('/all-notifications', [NotificationCenterController::class, 'getAllNotifications']); // For Notification center
    // Route::get('/current-notifications', [NotificationCenterController::class, 'getCurrentNotifications']);

    Route::get('/twod-salesday-book', [SaleDayBookController::class, 'twoDSaleDayBook']);
    Route::get('/threed-salesday-book', [SaleDayBookController::class, 'threeDSaleDayBook']);
    Route::get('/lonepyaing-salesday-book', [SaleDayBookController::class, 'lonePyaingSaleDayBook']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('winning-3ds', [WinningResultController::class, 'winningThreeds']);


    Route::get('/tDList', [ApiTwoDManageController::class, 'getTwoDs']);
});
