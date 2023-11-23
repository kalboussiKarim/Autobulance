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
use App\Http\Controllers\ServiceEquipmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LocalisationController;
use App\Http\Controllers\TransactionReparateurController;
use App\Models\ServiceEquipment;
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
    //logged in admins only (done)
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::get('/', [ClientController::class, 'index']);


        Route::get('/{client_id}', [ClientController::class, 'show']);
        Route::delete('/{client_id}', [ClientController::class, 'destroy']);
        Route::get('/search/{url}', [ClientController::class, 'search']);
        Route::put('/{client_id}', [ClientController::class, 'edit']);
    });
    //logged in clients only (done)
    Route::group(['middleware' => ['auth:client']], function () {
        Route::POST('/logout', [ClientController::class, 'logout']);
        Route::get('/profile/{client_id}', [ClientController::class, 'showProfile']);
        Route::put('/', [ClientController::class, 'edit']);
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'role'], function () {
    //auth admin only (done)
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/{role_id}', [RoleController::class, 'show']);
        Route::get('/', [RoleController::class, 'index']);
        Route::put('/{role_id}', [RoleController::class, 'edit']);
        Route::delete('/{role_name}', [RoleController::class, 'destroy']);
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'staff'], function () {
    //everyone (done)
    Route::post('/login', [StaffController::class, 'login']);
    Route::POST('/admin/register', [StaffController::class, 'adminRegister']);
    //auth staff only (done)
    Route::group(['middleware' => ['auth:staff']], function () {
        Route::POST('/logout', [StaffController::class, 'logout']);
        Route::get('/profile/{client_id}', [StaffController::class, 'showProfile']);
        //auth admins staff only (done)
        Route::group(['middleware' => ['check.identity:admin']], function () {
            Route::POST('/register', [StaffController::class, 'register']);
            Route::put('/{staff_id}', [StaffController::class, 'edit']);
            Route::get('/{staff_id}', [StaffController::class, 'show']);
            Route::get('/autobulances', [StaffController::class, 'getAutobulance']); /*this route is not tested */

        });
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'breakdown'], function () {
    //auth admins staff only (done)
    Route::get('/', [BreakdownController::class, 'index']);
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::post('/', [BreakdownController::class, 'store']);
        
        Route::put('/{breakdown_id}', [BreakdownController::class, 'edit']);
        Route::get('/search/{url}', [BreakdownController::class, 'search']);
        Route::delete('/{breakdown_id}', [BreakdownController::class, 'destroy']);
        Route::get('/avg', [BreakdownController::class, 'avg']);
        Route::get('/{breakdown_id}', [BreakdownController::class, 'show']);
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'state'], function () {
    //auth admins staff only (done)
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::post('/', [StateController::class, 'store']);
        Route::get('/', [StateController::class, 'index']);
        Route::put('/{state_id}', [StateController::class, 'edit']);
        Route::delete('/{state_id}', [StateController::class, 'destroy']);
        Route::get('/{state_id}', [StateController::class, 'show']);
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'equipment'], function () {
    //auth admins staff only (done)
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::post('/', [EquipmentController::class, 'store']);
        Route::get('/', [EquipmentController::class, 'index']);
        Route::put('/{equipment_id}', [EquipmentController::class, 'edit']);
        Route::delete('/{equipment_id}', [EquipmentController::class, 'destroy']);
        Route::get('/{equipment_id}', [EquipmentController::class, 'show']);
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'service'], function () {
    //auth admins staff only (done)
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::post('/', [ServiceController::class, 'store']);
        Route::get('/{service_id}', [ServiceController::class, 'show']);
        Route::get('/', [ServiceController::class, 'index']);
        Route::put('/{service_id}', [ServiceController::class, 'edit']);
        Route::delete('/{service_id}', [ServiceController::class, 'destroy']);
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'request'], function () {
    //logged in clients only (done)
    Route::group(['prefix' => 'client'], function () {
       Route::group(['middleware' => ['auth:client']], function () {
            Route::post('/', [RequestController::class, 'store']);
            Route::get('/', [RequestController::class, 'index']);
            Route::get('/{request_id}', [RequestController::class, 'show']);
            Route::put('/{request_id}', [RequestController::class, 'edit']);
            Route::delete('/{request_id}', [RequestController::class, 'destroy']);
         });
    });
    //auth admins staff only (done)
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::post('/', [RequestController::class, 'adminStore']);
        Route::get('/', [RequestController::class, 'adminIndex']);
        Route::get('/{request_id}', [RequestController::class, 'adminShow']);
        Route::put('/{request_id}', [RequestController::class, 'adminEdit']);
        Route::delete('/{request_id}', [RequestController::class, 'adminDestroy']);
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'breakdownRequest'], function () {
    //logged in clients only (done)
    Route::group(['middleware' => ['auth:client']], function () {
        Route::group(['prefix' => 'client'], function () {
            Route::post('/', [BreakdownRequestController::class, 'store']);
            Route::delete('/request/{request_id}/breakdown/{breakdown_id}', [BreakdownRequestController::class, 'destroy']);
            Route::get('/request/{request_id}/breakdown/{breakdown_id}', [BreakdownRequestController::class, 'show']);
            Route::get('/request/{request_id}', [BreakdownRequestController::class, 'showBreakdowns']);
        });
    });
    //auth admins staff only (done)
    Route::group(['middleware' => ['auth:staff']], function () {
        Route::group(['middleware' => ['check.identity:admin']], function () {
            Route::get('/', [BreakdownRequestController::class, 'adminIndex']);
            Route::post('/', [BreakdownRequestController::class, 'adminStore']);
            Route::get('/request/{request_id}', [BreakdownRequestController::class, 'adminShowBreakdowns']);
            Route::get('/request/{request_id}/breakdown/{breakdown_id}', [BreakdownRequestController::class, 'adminShow']);
            Route::delete('/request/{request_id}/breakdown/{breakdown_id}', [BreakdownRequestController::class, 'adminDestroy']);
        });
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'autobulance'], function () {
    //auth admins staff only (done)
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::get('/', [AutobulanceController::class, 'adminAutobulances']); /* admin ma yra ken les autoblances teb3inou tnajem tsameha index*/
        Route::post('/', [AutobulanceController::class, 'store']);
        Route::put('/{autobulance_id}', [AutobulanceController::class, 'edit']);
        Route::delete('/{autobulance_id}', [AutobulanceController::class, 'destroy']);
        Route::get('/{autobulance_id}', [AutobulanceController::class, 'show']);
        Route::get('/findbystatus/{status_id}', [AutobulanceController::class, 'findByStatus']); /* to test */
    });
    //auth admins and mangers only (done)
    Route::group(['middleware' => ['check.identity:admin,manager']], function () {
        Route::post('/{autobulance_id}/status/{status_id}', [AutobulanceController::class, 'updateStatus']);
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'transactions'], function () {
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::post('/affectadmin/{autobulance_id}', [TransactionReparateurController::class, 'adminAffect']);
        Route::post('/detachadmin/{autobulance_id}', [TransactionReparateurController::class, 'adminDetach']);
        Route::post('/affecmanager/{staff_id}/auto/{autobulance_id}', [TransactionReparateurController::class, 'managerAffect']);
        Route::post('/detachmanager/{staff_id}/auto/{autobulance_id}', [TransactionReparateurController::class, 'managerDetach']);
        Route::post('/affecttechnician/{staff_id}/auto/{autobulance_id}', [TransactionReparateurController::class, 'technicianAffect']);
        Route::post('/detachtechnician/{staff_id}/auto/{autobulance_id}', [TransactionReparateurController::class, 'technicianDetach']);
    });
});











/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'serviceEquipment'], function () {
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::post('/', [ServiceEquipmentController::class, 'store']);
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/
Route::group(['prefix' => 'tasks'], function () {
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::post('/', [TaskController::class, 'store']);
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/price/{id}', [TaskController::class, 'totalPrice']);
    });
});
/*****************************************************************************************************/
/*****************************************************************************************************/

Route::group(['prefix' => 'localisations'], function () {
    Route::get('/loc', [ClientController::class, 'localisation']);

    Route::group(['middleware' => ['check.identity:manager']], function () {
        Route::post('/', [LocalisationController::class, 'store']);
    });
    Route::group(['middleware' => ['check.identity:admin']], function () {
        Route::get('/{id}', [LocalisationController::class, 'show']);
        Route::get('/', [LocalisationController::class, 'index']);});
        
    });





























/*****************************************************************************************************/
/*****************************************************************************************************/




/*****************************************************************************************************/
/*****************************************************************************************************/


/*****************************************************************************************************/
/*****************************************************************************************************/

/*****************************************************************************************************/
/*****************************************************************************************************/
