<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PublicationController as AdminPublicationController;
use App\Http\Controllers\Admin\RubriqueController;
use App\Http\Controllers\FrontendController;
use App\Http\Middleware\CheckRole;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


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

Route::post('/donation', [DonationController::class, 'process'])->name('donation.process');
Route::get('/publicite/contact', [AdvertisingController::class, 'contact'])->name('advertising.contact');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

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

require __DIR__.'/auth.php';
