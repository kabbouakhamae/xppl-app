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

Route::group(['prefix' => 'employee', 'middlewar' => 'auth:santum'], function(){
    Route::get('/', [EmployeeController::class, 'index']);
    Route::get('/newUserid', [EmployeeController::class, 'newUserid']);
    Route::post('/empInsert', [EmployeeController::class, 'empInsert']);
    Route::post('/edit/{userid}', [EmployeeController::class, 'edit']);
    Route::post('/empUpdate', [EmployeeController::class, 'empUpdate']);
    Route::post('/preview/{userid}', [EmployeeController::class, 'preview']);
    Route::post('/delete/{userid}', [EmployeeController::class, 'delete']);
    Route::post('/detail/{userid}', [EmployeeController::class, 'detail']);
    Route::post('/editDetail/{id}', [EmployeeController::class, 'editDetail']);
});



Route::group(['prefix' => 'test', 'middlewar' => 'auth:santum'], function(){
    Route::post('/addfile', [TestController::class, 'addfile']);
    Route::get('/file', [TestController::class, 'file']);
    Route::post('/images', [TestController::class, 'images']);
    Route::get('/download/{file}', [TestController::class, 'download']);
    Route::post('/deleteFile/{file}', [TestController::class, 'deleteFile']);

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
