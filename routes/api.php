<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\GeneController;
use App\Http\Controllers\api\DiseaseController;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\DrugController;
use App\Http\Controllers\api\MoasController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'api'], function($router){
    //Login
    Route::post('/login',[UserController::class, 'login']);
    //Register
    Route::post('/register',[UserController::class, 'register']);
    //Profile
    Route::get('/profile',[UserController::class, 'profile']);

    //Get Users Lists
    // Route::get('/getUsersLists',[UserController::class, 'getUsersLists']);    
    //Logout
    // Route::post('/logout',[UserController::class, 'logout']);
});

Route::get('/getUsersLists',[UserController::class, 'getUsersLists'])->middleware('jwt.auth');
Route::get('/getGenesLists',[GeneController::class, 'getGenesLists'])->middleware('jwt.auth');
Route::get('/getDiseasesLists',[DiseaseController::class, 'getDiseasesLists'])->middleware('jwt.auth');
Route::get('/getCompaniesLists',[CompanyController::class, 'getCompaniesLists'])->middleware('jwt.auth');
Route::get('/getDrugsLists',[DrugController::class, 'getDrugsLists'])->middleware('jwt.auth');
Route::get('/getMoasLists',[MoasController::class, 'getMoasLists'])->middleware('jwt.auth');

Route::post('/addGenes',[GeneController::class, 'addGenes']);
Route::post('/updateGenes/{id}',[GeneController::class, 'updateGenes']);
Route::delete('/deleteGenes/{id}',[GeneController::class, 'deleteGenes']);