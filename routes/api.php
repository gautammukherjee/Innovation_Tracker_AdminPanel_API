<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\GeneController;
use App\Http\Controllers\api\DiseaseController;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\DrugController;
use App\Http\Controllers\api\MoasController;
use App\Http\Controllers\api\NewsletterController;
use App\Http\Controllers\api\TaController;

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
    return $request->user->user_id();
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

//Genes lists, add, update and delete
Route::get('/getGenesLists',[GeneController::class, 'getGenesLists'])->middleware('jwt.auth');
Route::post('/addGenes',[GeneController::class, 'addGenes']);
Route::put('/updateGenes/{id}',[GeneController::class, 'updateGenes']);
Route::put('/deleteGenes/{id}',[GeneController::class, 'deleteGenes']);

//Gene Synonm Lists
Route::get('/getGeneSynLists',[GeneController::class, 'getGeneSynLists'])->middleware('jwt.auth');
Route::post('/addGeneSyn',[GeneController::class, 'addGeneSyn']);
Route::put('/updateGeneSyn/{id}',[GeneController::class, 'updateGeneSyn']);
Route::put('/deleteGeneSyn/{id}',[GeneController::class, 'deleteGeneSyn']);

//Companies lists, add, update and delete
Route::get('/getCompaniesTypes',[CompanyController::class, 'getCompaniesTypes'])->middleware('jwt.auth');
Route::get('/getCompaniesLists',[CompanyController::class, 'getCompaniesLists'])->middleware('jwt.auth');
Route::post('/addCompanies',[CompanyController::class, 'addCompanies']);
Route::put('/updateCompanies/{id}',[CompanyController::class, 'updateCompanies']);
Route::put('/deleteCompanies/{id}',[CompanyController::class, 'deleteCompanies']);

//Diseases lists, add, update and delete
Route::get('/getDiseasesLists',[DiseaseController::class, 'getDiseasesLists'])->middleware('jwt.auth');
Route::post('/addDiseases',[DiseaseController::class, 'addDiseases']);
Route::put('/updateDiseases/{id}',[DiseaseController::class, 'updateDiseases']);
Route::put('/deleteDiseases/{id}',[DiseaseController::class, 'deleteDiseases']);

//Disease Synonm Lists
Route::get('/getDiseaseSynLists',[DiseaseController::class, 'getDiseaseSynLists'])->middleware('jwt.auth');
Route::post('/addDiseaseSyn',[DiseaseController::class, 'addDiseaseSyn']);
Route::put('/updateDiseaseSyn/{id}',[DiseaseController::class, 'updateDiseaseSyn']);
Route::put('/deleteDiseaseSyn/{id}',[DiseaseController::class, 'deleteDiseaseSyn']);

//Newsletter lists, add, update and delete
Route::get('/getNewsletterLists',[NewsletterController::class, 'getNewsletterLists'])->middleware('jwt.auth');
Route::post('/addNewsletter',[NewsletterController::class, 'addNewsletter']);
Route::put('/updateNewsletter/{id}',[NewsletterController::class, 'updateNewsletter']);
Route::put('/deleteNewsletter/{id}',[NewsletterController::class, 'deleteNewsletter']);

Route::get('/getMoasLists',[MoasController::class, 'getMoasLists'])->middleware('jwt.auth');
Route::post('/addMoas',[MoasController::class, 'addMoas']);
Route::put('/updateMoas/{id}',[MoasController::class, 'updateMoas']);
Route::put('/deleteMoas/{id}',[MoasController::class, 'deleteMoas']);

//Drugs lists, add, update and delete
Route::get('/getDrugsLists',[DrugController::class, 'getDrugsLists'])->middleware('jwt.auth');
Route::post('/addDrugs',[DrugController::class, 'addDrugs']);
Route::put('/updateDrugs/{id}',[DrugController::class, 'updateDrugs']);
Route::put('/deleteDrugs/{id}',[DrugController::class, 'deleteDrugs']);

//Drug Synonm Lists
Route::get('/getDrugSynLists',[DrugController::class, 'getDrugSynLists'])->middleware('jwt.auth');
Route::post('/addDrugSyn',[DrugController::class, 'addDrugSyn']);
Route::put('/updateDrugSyn/{id}',[DrugController::class, 'updateDrugSyn']);
Route::put('/deleteDrugSyn/{id}',[DrugController::class, 'deleteDrugSyn']);

//TA lists
Route::get('/getTasLists',[TaController::class, 'getTasLists'])->middleware('jwt.auth');

//for frontend
Route::post('/getNewsletterFrontLists',[NewsletterController::class, 'getNewsletterFrontLists'])->middleware('jwt.auth');