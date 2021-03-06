<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\LookupController;
use App\Http\Controllers\API\EmployeeController;
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
Route::post('profile', [UserController::class, 'profile']);

Route::post('updatePermiss', [TestController::class, 'updatePermiss']);


Route::group(['prefix' => 'employee', 'middlewar' => 'auth:santum'], function(){
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/add', [EmployeeController::class, 'add']);
    Route::post('/update', [EmployeeController::class, 'update']);
    Route::post('/edit/{id}', [EmployeeController::class, 'edit']);
    Route::post('/delete/{id}', [EmployeeController::class, 'delete']);
    Route::post('/preview/{id}', [EmployeeController::class, 'preview']);
    Route::post('/detail/{id}', [EmployeeController::class, 'detail']);
    Route::post('/detailEdit/{id}', [EmployeeController::class, 'detailEdit']);
    Route::post('/detailDel/{id}', [EmployeeController::class, 'detailDel']);
    Route::post('/detailAdd', [EmployeeController::class, 'detailAdd']);
    Route::post('/detailUpdate', [EmployeeController::class, 'detailUpdate']);
});



Route::group(['prefix' => 'test', 'middlewar' => 'auth:santum'], function(){
    Route::post('/addfile', [TestController::class, 'addfile']);
    Route::get('/file', [TestController::class, 'file']);
    Route::post('/images', [TestController::class, 'images']);
    Route::get('/download/{file}', [TestController::class, 'download']);
    Route::post('/deleteFile/{file}', [TestController::class, 'deleteFile']);
    Route::get('/getVal', [TestController::class, 'getVal']);

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
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
