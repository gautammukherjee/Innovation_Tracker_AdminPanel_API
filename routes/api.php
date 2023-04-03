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
// Route::put('/updateNewsletter/{id}',[NewsletterController::class, 'updateNewsletter']);
// Route::put('/trashNewsletter/{id}',[NewsletterController::class, 'trashNewsletter']);
Route::delete('/deleteNewsletter/{id}',[NewsletterController::class, 'deleteNewsletter']);
Route::post('/approveNewsletter',[NewsletterController::class, 'approveNewsletter']);
Route::post('/disapproveNewsletter',[NewsletterController::class, 'disapproveNewsletter']);
Route::post('/getCommentsNewsletter/{id}',[NewsletterController::class, 'getCommentsNewsletter']);
Route::post('/pendingNewsletter/{id}',[NewsletterController::class, 'pendingNewsletter']);

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
Route::post('/getTasListsNotExistRl/{id}',[TaController::class, 'getTasListsNotExistRl'])->middleware('jwt.auth');
Route::post('/getTasListsExistRl/{id}',[TaController::class, 'getTasListsExistRl'])->middleware('jwt.auth');

//For frontend
Route::post('/getNewsletterFrontLists',[NewsletterController::class, 'getNewsletterFrontLists'])->middleware('jwt.auth');
Route::post('/getNewsletterFrontDetails',[NewsletterController::class, 'getNewsletterFrontDetails'])->middleware('jwt.auth');


// Route::post('/getNewsletterDisease',[NewsletterController::class, 'getNewsletterDisease'])->middleware('jwt.auth');
Route::post('/getNewsletterUserName',[NewsletterController::class, 'getNewsletterUserName'])->middleware('jwt.auth');

//Approved Newsletter lists
Route::get('/getApproveNewsletterLists',[NewsletterController::class, 'getApproveNewsletterLists'])->middleware('jwt.auth');

//Pending Newsletter lists
Route::get('/getPendingNewsletterLists',[NewsletterController::class, 'getPendingNewsletterLists'])->middleware('jwt.auth');

//Save Newsletter Relation for all the master lists
Route::post('/saveNewsTaRl/{id}',[NewsletterController::class, 'saveNewsTaRl']);

//Disease Lists saved relation with Newsletter
Route::post('/getDiseaseListsNotExistRl/{id}',[DiseaseController::class, 'getDiseaseListsNotExistRl'])->middleware('jwt.auth');
Route::post('/getDiseaseListsExistRl/{id}',[DiseaseController::class, 'getDiseaseListsExistRl'])->middleware('jwt.auth');
Route::post('/saveNewsDiseaseRl/{id}',[NewsletterController::class, 'saveNewsDiseaseRl']);

//Drug Lists saved relation with Newsletter
Route::post('/getDrugListsNotExistRl/{id}',[DrugController::class, 'getDrugListsNotExistRl'])->middleware('jwt.auth');
Route::post('/getDrugListsExistRl/{id}',[DrugController::class, 'getDrugListsExistRl'])->middleware('jwt.auth');
Route::post('/saveNewsDrugRl/{id}',[NewsletterController::class, 'saveNewsDrugRl']);

//Company Lists saved relation with Newsletter
Route::post('/getCompanyListsNotExistRl/{id}',[CompanyController::class, 'getCompanyListsNotExistRl'])->middleware('jwt.auth');
Route::post('/getCompanyListsExistRl/{id}',[CompanyController::class, 'getCompanyListsExistRl'])->middleware('jwt.auth');
Route::post('/saveNewsCompanyRl/{id}',[NewsletterController::class, 'saveNewsCompanyRl']);

//Gene Lists saved relation with Newsletter
Route::post('/getGeneListsNotExistRl/{id}',[GeneController::class, 'getGeneListsNotExistRl'])->middleware('jwt.auth');
Route::post('/getGeneListsExistRl/{id}',[GeneController::class, 'getGeneListsExistRl'])->middleware('jwt.auth');
Route::post('/saveNewsGeneRl/{id}',[NewsletterController::class, 'saveNewsGeneRl']);

//MOA Lists saved relation with Newsletter
Route::post('/getMoaListsNotExistRl/{id}',[MoasController::class, 'getMoaListsNotExistRl'])->middleware('jwt.auth');
Route::post('/getMoaListsExistRl/{id}',[MoasController::class, 'getMoaListsExistRl'])->middleware('jwt.auth');
Route::post('/saveNewsMoaRl/{id}',[NewsletterController::class, 'saveNewsMoaRl']);

//Backend master lists
Route::get('/getBackendGenesLists',[GeneController::class, 'getBackendGenesLists'])->middleware('jwt.auth');
Route::get('/getBackendMoasLists',[MoasController::class, 'getBackendMoasLists'])->middleware('jwt.auth');
Route::get('/getBackendDrugsLists',[DrugController::class, 'getBackendDrugsLists'])->middleware('jwt.auth');
Route::get('/getBackendCompaniesLists',[CompanyController::class, 'getBackendCompaniesLists'])->middleware('jwt.auth');
Route::get('/getBackendDiseasesLists',[DiseaseController::class, 'getBackendDiseasesLists'])->middleware('jwt.auth');
Route::get('/getBackendTasLists',[TaController::class, 'getTasLists'])->middleware('jwt.auth');