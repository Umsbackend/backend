<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\SituationFinanciereController;
use App\Http\Controllers\Api\PaiementController;
use App\Http\Controllers\Api\AideFinanciereController;
use App\Http\Controllers\Api\DetailFraisController;
use App\Http\Controllers\Api\StudentController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

Route::apiResource('enrollments', EnrollmentController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('paiements', PaiementController::class);
Route::apiResource('situations-financieres', SituationFinanciereController::class);

Route::apiResource('details_frais', DetailFraisController::class);
Route::apiResource('aides-financieres', AideFinanciereController::class);



Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::put('/students/{id}', [StudentController::class, 'update']); // important !
Route::delete('/students/{id}', [StudentController::class, 'destroy']);


Route::get('situation_financieres', [SituationFinanciereController::class, 'index']);
Route::post('situation_financieres', [SituationFinanciereController::class, 'store']);
Route::get('situation_financieres/{id}', [SituationFinanciereController::class, 'show']);
Route::put('situation_financieres/{id}', [SituationFinanciereController::class, 'update']);
Route::delete('situation_financieres/{id}', [SituationFinanciereController::class, 'destroy']);


// Liste tous les aides financières
Route::get('aides_financieres', [AideFinanciereController::class, 'index']);

// Crée un nouvel aide financière
Route::post('aides_financieres', [AideFinanciereController::class, 'store']);

// Optionnel : voir un aide spécifique
Route::get('aides_financieres/{id}', [AideFinanciereController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});
