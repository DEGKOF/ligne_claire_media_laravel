<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MarketDataController;
use App\Http\Controllers\Admin\AdminInvestigationController;

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


// ==========================================
// ROUTES API POUR LES PUBLICITÉS (Frontend)
// ==========================================


Route::get('/market-data', [MarketDataController::class, 'index']);

    Route::prefix('admin/investigations')->name('admin.investigations.')->group(function () {
        // Liste et détails
        Route::get('/', [AdminInvestigationController::class, 'indexApi'])->name('index');
        Route::get('/{proposal}', [AdminInvestigationController::class, 'investigations'])->name('show');

        // Mise à jour du contenu
        Route::put('/{proposal}', [AdminInvestigationController::class, 'update'])->name('update');

        // Gestion des statuts
        Route::post('/{proposal}/validate', [AdminInvestigationController::class, 'validateInvestigation'])->name('validate');
        Route::post('/{proposal}/reject', [AdminInvestigationController::class, 'rejectInvestigation'])->name('reject');
        Route::post('/{proposal}/start', [AdminInvestigationController::class, 'startInvestigation'])->name('start');
        Route::post('/{proposal}/complete', [AdminInvestigationController::class, 'complete'])->name('complete');
        Route::put('/{proposal}/status', [AdminInvestigationController::class, 'updateStatus'])->name('update-status');

        // Gestion des fichiers
        Route::delete('/{proposal}/files', [AdminInvestigationController::class, 'deleteFile'])->name('delete-file');

        // Suppression et restauration
        Route::delete('/{proposal}', [AdminInvestigationController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [AdminInvestigationController::class, 'restore'])->name('restore');

        // Actions en masse
        Route::post('/bulk-action', [AdminInvestigationController::class, 'bulkAction'])->name('bulk-action');
    });
