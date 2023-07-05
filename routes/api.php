<?php

use App\Http\Controllers\BreakdownController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\BreakdownRequestController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\AutobulanceController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix' => 'client'], function () {
    //everyone (done)
    Route::POST('/register', [ClientController::class, 'register']);
    Route::POST('/login', [ClientController::class, 'login']);
    //auth admin only (not done)
    Route::get('/showall', [ClientController::class, 'showAll']);
    Route::get('/search/{url}', [ClientController::class, 'search']);
    //only logged in clients (done)
    Route::group(['middleware' => ['auth:client']], function () {
        Route::POST('/logout', [ClientController::class, 'logout']);
        Route::get('/{url}', [ClientController::class, 'show']);  // ynajem yra ken ro7ou 
    });
});



Route::group(['prefix' => 'request'], function () {
    //only logged in clients (not done)
    Route::post('/save', [RequestController::class, 'store']);

    //only logged in clients and admins (not done)
    Route::put('/{request_id}', [RequestController::class, 'edit']);
    Route::delete('/{request_id}', [RequestController::class, 'destroy']);

    //auth admin only (not done)
    Route::get('/showall', [RequestController::class, 'index']);  // najmou nrodouha /showall/{request_type}
    Route::get('/{request_id}', [RequestController::class, 'show']);
});



Route::group(['prefix' => 'breakdown'], function () {
    //only logged in clients and admins (not done)
    Route::post('/save', [BreakdownController::class, 'store']);

    //auth admin only (not done)
    Route::get('/showall', [BreakdownController::class, 'index']);
    Route::put('/{breakdown_id}', [BreakdownController::class, 'edit']);
    Route::delete('/{breakdown_id}', [BreakdownController::class, 'destroy']);
    Route::get('/{breakdown_id}', [BreakdownController::class, 'show']);
});



Route::group(['prefix' => 'breakdownRequest'], function () {
    //only logged in clients and admins (not done)
    Route::post('/save', [BreakdownRequestController::class, 'store']);
    Route::delete('/{request_id}/{breakdown_id}', [BreakdownRequestController::class, 'destroy']);

    //auth admin only (not done)
    Route::get('/showall', [BreakdownRequestController::class, 'index']);
    Route::get('/{request_id}/{breakdown_id}', [BreakdownRequestController::class, 'show']);
});


Route::group(['prefix' => 'role'], function () {
    //auth admin only (not done)
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::get('/showall', [RoleController::class, 'index']);
        Route::post('/save', [RoleController::class, 'store']);
        Route::delete('/{role_name}', [RoleController::class, 'destroy']);
    });
});



Route::group(['prefix' => 'staff'], function () {
    //everyone (done)
    Route::post('/login', [StaffController::class, 'login']);

    //auth staff only (done)
    Route::group(['middleware' => ['auth:staff']], function () {
        //auth adminstaff only (done)
        Route::group(['middleware' => ['check.identity:admin']], function () {
            Route::POST('/register', [StaffController::class, 'register']);
        });
        Route::POST('/logout', [StaffController::class, 'logout']);
    });
});


Route::group(['prefix' => 'state'], function () {
    Route::post('/', [StateController::class, 'store']);
    Route::get('/', [StateController::class, 'index']);
    Route::put('/{id}', [StateController::class, 'edit']);
    Route::delete('/{state_id}', [StateController::class, 'destroy']);
    Route::get('/{state_id}', [StateController::class, 'show']);
});



Route::group(['prefix' => 'auto'], function () {
    Route::post('/', [AutobulanceController::class, 'store']);
    Route::get('/', [AutobulanceController::class, 'index']);
    Route::put('/{autobulance_id}', [AutobulanceController::class, 'edit']);
    Route::delete('/{autobulance_id}', [AutobulanceController::class, 'destroy']);
    Route::get('/{autobulance_id}', [AutobulanceController::class, 'show']);
    Route::get('/findbystatus/{status_id}', [AutobulanceController::class, 'findByStatus']);
    Route::post('/updatestatus/{autobulance_id}/{status_id}', [AutobulanceController::class, 'updateStatus']);
});



Route::group(['prefix' => 'equipment'], function () {
    Route::post('/', [EquipmentController::class, 'store']);
    Route::get('/{equipment_id}', [EquipmentController::class, 'show']);
    Route::get('/', [EquipmentController::class, 'index']);
    Route::put('/{equipment_id}', [EquipmentController::class, 'edit']);
    Route::delete('/{equipment_id}', [EquipmentController::class, 'destroy']);
});



Route::group(['prefix' => 'service'], function () {
    Route::post('/', [ServiceController::class, 'store']);
    Route::get('/{service_id}', [ServiceController::class, 'show']);
    Route::get('/', [ServiceController::class, 'index']);
    Route::put('/{service_id}', [ServiceController::class, 'edit']);
    Route::delete('/{service_id}', [ServiceController::class, 'destroy']);
});


Route::get('/sendmail', [MailController::class, 'index']);
