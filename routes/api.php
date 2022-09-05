<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\LookupController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\EmpDetailController;
use App\Http\Controllers\API\EmpContController;
use App\Http\Controllers\API\EmpBankController;
use App\Http\Controllers\API\EmpCardController;
use App\Http\Controllers\API\EmpAnnualController;
use App\Http\Controllers\API\EmpFileController;
use App\Http\Controllers\API\EmpTransController;
use App\Http\Controllers\API\FuelConsController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\LookupSettController;
use App\Http\Controllers\API\EmpRosterController;
use App\Http\Controllers\API\TestController;

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

Route::post('signUp', [UserController::class, 'signUp']);
Route::post('signIn', [UserController::class, 'signIn']);
Route::post('signOut', [UserController::class, 'signOut']);
Route::get('profile', [UserController::class, 'profile']);
Route::get('permiss', [UserController::class, 'permiss']);
Route::get('username', [UserController::class, 'username']);
Route::post('permissUpdate', [UserController::class, 'permissUpdate']);
Route::post('permissEdit', [UserController::class, 'permissEdit']);


Route::group(['prefix' => 'employee', 'middlewar' => 'auth:santum'], function(){
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/add', [EmployeeController::class, 'add']);
    Route::post('/update', [EmployeeController::class, 'update']);
    Route::post('/edit/{id}', [EmployeeController::class, 'edit']);
    Route::post('/delete/{id}', [EmployeeController::class, 'delete']);
    Route::post('/preview/{id}', [EmployeeController::class, 'preview']);
});

Route::group(['prefix' => 'detail', 'middlewar' => 'auth:santum'], function(){
    Route::post('/data/{id}', [EmpDetailController::class, 'data']);
    Route::post('/add', [EmpDetailController::class, 'add']);
    Route::post('/edit/{id}', [EmpDetailController::class, 'edit']);
    Route::post('/update', [EmpDetailController::class, 'update']);
    Route::post('/delete/{id}', [EmpDetailController::class, 'delete']);
});

Route::group(['prefix' => 'contact', 'middlewar' => 'auth:santum'], function(){
    Route::post('/data/{id}', [EmpContController::class, 'data']);
    Route::post('/add', [EmpContController::class, 'add']);
    Route::post('/edit/{id}', [EmpContController::class, 'edit']);
    Route::post('/update', [EmpContController::class, 'update']);
    Route::post('/delete/{id}', [EmpContController::class, 'delete']);
});

Route::group(['prefix' => 'bank', 'middlewar' => 'auth:santum'], function(){
    Route::post('/data/{id}', [EmpBankController::class, 'data']);
    Route::post('/add', [EmpBankController::class, 'add']);
    Route::post('/edit/{id}', [EmpBankController::class, 'edit']);
    Route::post('/update', [EmpBankController::class, 'update']);
    Route::post('/delete/{id}', [EmpBankController::class, 'delete']);
});

Route::group(['prefix' => 'card', 'middlewar' => 'auth:santum'], function(){
    Route::post('/data/{id}', [EmpCardController::class, 'data']);
    Route::post('/add', [EmpCardController::class, 'add']);
    Route::post('/edit/{id}', [EmpCardController::class, 'edit']);
    Route::post('/update', [EmpCardController::class, 'update']);
    Route::post('/delete/{id}', [EmpCardController::class, 'delete']);
});

Route::group(['prefix' => 'annual', 'middlewar' => 'auth:santum'], function(){
    Route::post('/data/{id}', [EmpAnnualController::class, 'data']);
    Route::post('/add', [EmpAnnualController::class, 'add']);
    Route::post('/edit/{id}', [EmpAnnualController::class, 'edit']);
    Route::post('/update', [EmpAnnualController::class, 'update']);
    Route::post('/delete/{id}', [EmpAnnualController::class, 'delete']);
    Route::post('/info', [EmpAnnualController::class, 'info']);
});

Route::group(['prefix' => 'file', 'middlewar' => 'auth:santum'], function(){
    Route::post('/data/{id}', [EmpFileController::class, 'data']);
    Route::post('/add', [EmpFileController::class, 'add']);
    Route::get('/download/{file}', [EmpFileController::class, 'download']);
    Route::post('/delete/{file}', [EmpFileController::class, 'delete']);
});

Route::group(['prefix' => 'transport', 'middlewar' => 'auth:santum'], function(){
    Route::post('/out', [EmpTransController::class, 'out']);
    Route::post('/in', [EmpTransController::class, 'in']);
    Route::post('/pickup', [EmpTransController::class, 'pickup']);
    Route::post('/dropoff', [EmpTransController::class, 'dropoff']);
});

Route::group(['prefix' => 'fuel', 'middlewar' => 'auth:santum'], function(){
    Route::post('/date', [FuelConsController::class, 'date']);
    Route::post('/header', [FuelConsController::class, 'header']);
    Route::post('/detail', [FuelConsController::class, 'detail']);
    Route::post('/headerAdd', [FuelConsController::class, 'headerAdd']);
    Route::post('/headerEdit/{id}', [FuelConsController::class, 'headerEdit']);
    Route::post('/headerUpd', [FuelConsController::class, 'headerUpd']);
    Route::post('/headerDel/{id}', [FuelConsController::class, 'headerDel']);
    Route::post('/detailAdd', [FuelConsController::class, 'detailAdd']);
    Route::post('/detailDel/{id}', [FuelConsController::class, 'detailDel']);
    Route::post('/detailEdit/{id}', [FuelConsController::class, 'detailEdit']);
    Route::post('/detailUpd', [FuelConsController::class, 'detailUpd']);
    Route::post('/addNewReserveNo', [FuelConsController::class, 'addNewReserveNo']);
});

Route::group(['prefix' => 'home', 'middlewar' => 'auth:santum'], function(){
    Route::get('/countcountry', [HomeController::class, 'countcountry']);
    Route::get('/countdept', [HomeController::class, 'countdept']);
    Route::get('/allemp', [HomeController::class, 'allemp']);
});

Route::group(['prefix' => 'lookupSett', 'middlewar' => 'auth:santum'], function(){
    Route::get('/genCategory', [LookupSettController::class, 'genCategory']);
    Route::post('/genLookup', [LookupSettController::class, 'genLookup']);
    Route::post('/genCodeAdd', [LookupSettController::class, 'genCodeAdd']);
    Route::post('/genCodeEdit/{id}', [LookupSettController::class, 'genCodeEdit']);
    Route::post('/genCodeUpd', [LookupSettController::class, 'genCodeUpd']);
    Route::post('/genCodeDel/{id}', [LookupSettController::class, 'genCodeDel']);
    Route::get('/fuelCategory', [LookupSettController::class, 'fuelCategory']);
    Route::post('/fuelLookup', [LookupSettController::class, 'fuelLookup']);
    Route::post('/fuelCodeAdd', [LookupSettController::class, 'fuelCodeAdd']);
    Route::post('/fuelCodeEdit/{id}', [LookupSettController::class, 'fuelCodeEdit']);
    Route::post('/fuelCodeUpd', [LookupSettController::class, 'fuelCodeUpd']);
    Route::post('/fuelCodeDel/{id}', [LookupSettController::class, 'fuelCodeDel']);
    Route::get('/equipment', [LookupSettController::class, 'equipment']);
    Route::post('/workOrder', [LookupSettController::class, 'workOrder']);
    Route::post('/equipAdd', [LookupSettController::class, 'equipAdd']);
    Route::post('/equipEdit/{id}', [LookupSettController::class, 'equipEdit']);
    Route::post('/equipUpd', [LookupSettController::class, 'equipUpd']);
    Route::post('/equipDel/{id}', [LookupSettController::class, 'equipDel']);
    Route::post('/workOrderAdd', [LookupSettController::class, 'workOrderAdd']);
    Route::post('/workOrderEdit/{id}', [LookupSettController::class, 'workOrderEdit']);
    Route::post('/workOrderUpd', [LookupSettController::class, 'workOrderUpd']);
    Route::post('/workOrderDel/{id}', [LookupSettController::class, 'workOrderDel']);
});

Route::group(['prefix' => 'roster', 'middlewar' => 'auth:santum'], function(){
    Route::get('/roscode', [EmpRosterController::class, 'rosCode']);
    Route::post('/rosCodeEdit/{id}', [EmpRosterController::class, 'rosCodeEdit']);
});

Route::group(['prefix' => 'lookup', 'middlewar' => 'auth:santum'], function(){
    Route::get('/country', [LookupController::class, 'country']);
    Route::get('/position', [LookupController::class, 'position']);
    Route::get('/status', [LookupController::class, 'status']);
    Route::get('/contract', [LookupController::class, 'contract']);
    Route::get('/levels', [LookupController::class, 'levels']);
    Route::get('/roster', [LookupController::class, 'roster']);
    Route::get('/scantimes', [LookupController::class, 'scantimes']);
    Route::get('/site', [LookupController::class, 'site']);
    Route::get('/dept', [LookupController::class, 'dept']);
    Route::get('/depts', [LookupController::class, 'depts']);
    Route::get('/section', [LookupController::class, 'section']);
    Route::get('/crew', [LookupController::class, 'crew']);
    Route::get('/name', [LookupController::class, 'name']);
    Route::get('/relate', [LookupController::class, 'relate']);
    Route::get('/bank', [LookupController::class, 'bank']);
    Route::get('/card', [LookupController::class, 'card']);
    Route::get('/year', [LookupController::class, 'year']);
    Route::get('/month', [LookupController::class, 'month']);
    Route::get('/fueldept', [LookupController::class, 'fueldept']);
    Route::get('/costtype', [LookupController::class, 'costtype']);
    Route::post('/costno', [LookupController::class, 'costno']);
    Route::post('/wbs', [LookupController::class, 'wbs']);
    Route::post('/approve', [LookupController::class, 'approve']);
    Route::get('/equipno', [LookupController::class, 'equipno']);
    Route::get('/material', [LookupController::class, 'material']);
    Route::post('/equipdescr', [LookupController::class, 'equipdescr']);
    Route::post('/workorder', [LookupController::class, 'workorder']);
    Route::post('/driver', [LookupController::class, 'driver']);
    Route::post('/addNewDriver', [LookupController::class, 'addNewDriver']);
});


// Route::group(['prefix' => 'test', 'middlewar' => 'auth:santum'], function(){


// });


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
