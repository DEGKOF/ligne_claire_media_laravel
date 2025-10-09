<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PublicationController as AdminPublicationController;
use App\Http\Controllers\Admin\RubriqueController;
use App\Http\Controllers\FrontendController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Frontend (Publiques)
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/article/{slug}', [FrontendController::class, 'showPublication'])->name('publication.show');
Route::get('/rubrique/{slug}', [FrontendController::class, 'showRubrique'])->name('rubrique.show');
Route::get('/videos', [FrontendController::class, 'videos'])->name('videos');
Route::get('/recherche', [FrontendController::class, 'search'])->name('search');

// Pages statiques (à adapter selon vos besoins)
Route::view('/direct', 'frontend.direct')->name('direct');
Route::view('/replay', 'frontend.replay')->name('replay');

/*
|--------------------------------------------------------------------------
| Routes Backoffice (Authentification requise)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Gestion des Publications
    | Accessible par: journaliste, redacteur, admin, master_admin
    |--------------------------------------------------------------------------
    */
    Route::middleware([CheckRole::class . ':journaliste,redacteur,admin,master_admin'])
        ->group(function () {
            Route::resource('publications', AdminPublicationController::class);
            Route::post('publications/{publication}/publish', [AdminPublicationController::class, 'quickPublish'])
                ->name('publications.publish');
            Route::post('publications/{publication}/unpublish', [AdminPublicationController::class, 'quickUnpublish'])
                ->name('publications.unpublish');
        });

    /*
    |--------------------------------------------------------------------------
    | Gestion des Rubriques
    | Accessible par: admin, master_admin
    |--------------------------------------------------------------------------
    */
    Route::middleware([CheckRole::class . ':admin,master_admin'])
        ->group(function () {
            Route::resource('rubriques', RubriqueController::class);
            Route::post('rubriques/{rubrique}/toggle', [RubriqueController::class, 'toggleActive'])
                ->name('rubriques.toggle');
            Route::post('rubriques/reorder', [RubriqueController::class, 'reorder'])
                ->name('rubriques.reorder');
        });

    /*
    |--------------------------------------------------------------------------
    | Gestion des Utilisateurs (à implémenter)
    | Accessible par: admin, master_admin
    |--------------------------------------------------------------------------
    */
    // Route::middleware([CheckRole::class . ':admin,master_admin'])
    //     ->resource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------
| Routes d'authentification (Laravel Breeze/Jetstream)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
