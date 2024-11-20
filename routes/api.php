<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AnouncementVillageController;
use App\Http\Controllers\MasterRoleController;
use App\Http\Controllers\MasterMessageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ImageReportsController;
use App\Http\Controllers\MasterTypeMessageController;
use App\Http\Controllers\MasterResidentController;
use App\Http\Controllers\LetterSubmissionController;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'  
], function ($router) {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/user-list', [UserController::class, 'getUserList']);
    Route::get('/user-verified/{id}', [UserController::class, 'updateUserVerified']);
    Route::post('/check-nik', [MasterResidentController::class, 'checkNikResident']);

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'master'  
], function ($router) {
    Route::post('/create-role', [MasterRoleController::class, 'createMasterRole']);
    Route::get('/get-role', [MasterRoleController::class, 'getMasterRole']);
    Route::delete('/delete-role/{id}', [MasterRoleController::class, 'deleteMasterRole']);


    Route::post('/create-message', [MasterMessageController::class, 'createMasterMessage']);
    Route::get('/get-message', [MasterMessageController::class, 'getMasterMessages']);
    Route::delete('/delete-message/{id}', [MasterMessageController::class, 'deleteMasterMessage']);

    Route::post('/create-type-message', [MasterTypeMessageController::class, 'createMasterTypeMessage']);
    Route::get('/get-type-message', [MasterTypeMessageController::class, 'getMasterTypeMessages']);
    Route::delete('/delete-type-message/{id}', [MasterTypeMessageController::class, 'deleteMasterTypeMessage']);



});

Route::prefix('content')->group(function ($router) {
    Route::post('news', [NewsController::class, 'createNews']);
    Route::post('news/{id}', [NewsController::class, 'updateNews']);
    Route::get('news', [NewsController::class, 'getNews']);
    Route::delete('news/{id}', [NewsController::class, 'deleteNews']);

    Route::post('anouncement', [AnouncementVillageController::class, 'createAnouncement']);
    Route::post('anouncement/{id}', [AnouncementVillageController::class, 'updateAnouncement']);
    Route::get('anouncement', [AnouncementVillageController::class, 'getAnouncements']);
    Route::delete('anouncement/{id}', [AnouncementVillageController::class, 'deleteAnouncement']);

    Route::post('report', [ReportController::class, 'createReport']);
    Route::get('report', [ReportController::class, 'manageReport']);
    Route::delete('report', [ReportController::class, 'manageReport']);
    Route::post('update-report', [ReportController::class, 'manageReport']);

    Route::post('image-report', [ImageReportsController::class, 'createImageReport']);
    Route::delete('delete-report/{id}', [ImageReportsController::class, 'deleteImageReport']);
    Route::post('update-report/{id}', [ImageReportsController::class, 'updateImageReport']);

});

Route::prefix('letter')->group(function ($router) {
    Route::get('relations-family', [MasterResidentController::class, 'getRelationsFamily']);
    Route::get('download-pdf', [MasterResidentController::class, 'cetak_pdf']);
    Route::post('create-letter-incapacity', [LetterSubmissionController::class, 'createLetter']);
    Route::get('get-letter-incapacity', [LetterSubmissionController::class, 'getAllSubmissionsLetter']);
    Route::get('get-detail-letter-incapacity/{id}', [LetterSubmissionController::class, 'getSubmissionById']);
    Route::post('update-letter-incapacity/{id}', [LetterSubmissionController::class, 'updateLetter']);
    Route::post('update-status-letter-incapacity/{id}', [LetterSubmissionController::class, 'updateLetterStatus']);
    Route::delete('delete-letter-incapacity/{id}', [LetterSubmissionController::class, 'deleteSubmission']);

});

