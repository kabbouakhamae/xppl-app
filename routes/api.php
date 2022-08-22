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
    Route::get('/info', [EmpAnnualController::class, 'info']);
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
    Route::post('/headadd', [FuelConsController::class, 'headadd']);
    Route::post('/headedit/{id}', [FuelConsController::class, 'headedit']);
    Route::post('/headupd', [FuelConsController::class, 'headupd']);
    Route::post('/headdel/{id}', [FuelConsController::class, 'headdel']);
    Route::post('/detailadd', [FuelConsController::class, 'detailadd']);
    Route::post('/detaildel/{id}', [FuelConsController::class, 'detaildel']);
    Route::post('/detailedit/{id}', [FuelConsController::class, 'detailedit']);
    Route::post('/detailupd', [FuelConsController::class, 'detailupd']);
});

Route::group(['prefix' => 'home', 'middlewar' => 'auth:santum'], function(){
    Route::get('/countcountry', [HomeController::class, 'countcountry']);
    Route::get('/countdept', [HomeController::class, 'countdept']);
    Route::get('/allemp', [HomeController::class, 'allemp']);
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
});


Route::group(['prefix' => 'test', 'middlewar' => 'auth:santum'], function(){
    Route::post('/addfile', [TestController::class, 'addfile']);
    Route::get('/file', [TestController::class, 'file']);
    Route::post('/images', [TestController::class, 'images']);
    Route::get('/download/{file}', [TestController::class, 'download']);
    Route::post('/deleteFile/{file}', [TestController::class, 'deleteFile']);
    Route::get('/getVal', [TestController::class, 'getVal']);
    Route::get('/tests', [TestController::class, 'tests']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
