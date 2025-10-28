<?php

use App\Http\Middleware\CheckRole;
use App\Http\Controllers\WitnessController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\RubriqueController;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PublicationController as AdminPublicationController;


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
Route::get('/direct', [FrontendController::class, 'direct'])->name('direct');
Route::get('/replay', [FrontendController::class, 'replay'])->name('replay');
Route::get('/buy-news-paper', [FrontendController::class, 'buyNewsPaper'])->name('buy-news-paper');

// Route::view('/direct', 'frontend.direct')->name('direct');
// Route::view('/replay', 'frontend.replay')->name('replay');
// Route::view('/buy-news-paper', 'frontend.buy-news-paper')->name('buy-news-paper');


Route::post('/donation', [DonationController::class, 'process'])->name('donation.process');
// Route::get('/publicite/contact', [AdvertisementController::class, 'contact'])->name('advertising.contact');
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


// ==========================================
// ROUTES ANNONCEURS (ADVERTISERS)-v1
// ==========================================
// Route::middleware(['auth:advertiser', 'advertiser.active'])->group(function () {

//     Route::prefix('advertiser')->name('advertiser.')->group(function () {

//         // Routes d'authentification (accessibles sans authentification)
//         Route::middleware('guest:advertiser')->group(function () {
//             Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//             Route::post('/register', [RegisterController::class, 'register']);

//             Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
//             Route::post('/login', [LoginController::class, 'login']);
//         });

//         // Routes protégées (nécessitent l'authentification)
//         Route::middleware('auth:advertiser')->group(function () {

//             // Déconnexion
//             Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//             // Dashboard
//             Route::get('/dashboard', [App\Http\Controllers\Advertiser\DashboardController::class, 'index'])->name('dashboard');

//             // Gestion des publicités
//             Route::resource('advertisements', AdvertisementController::class)->except(['show']);
//             Route::get('/advertisements/{advertisement}', [AdvertisementController::class, 'show'])
//                 ->name('advertisements.show');
//             Route::post('/advertisements/{advertisement}/pause', [AdvertisementController::class, 'pause'])
//                 ->name('advertisements.pause');
//             Route::post('/advertisements/{advertisement}/resume', [AdvertisementController::class, 'resume'])
//                 ->name('advertisements.resume');

//             // Gestion du solde
//             Route::prefix('balance')->name('balance.')->group(function () {
//                 Route::get('/', [BalanceController::class, 'index'])->name('index');
//                 Route::get('/recharge', [BalanceController::class, 'showRechargeForm'])->name('recharge');
//                 Route::post('/recharge', [BalanceController::class, 'processRecharge'])->name('process-recharge');
//                 Route::post('/payments/{payment}/confirm', [BalanceController::class, 'confirmPayment'])
//                     ->name('confirm-payment');
//             });

//             // Statistiques
//             Route::prefix('statistics')->name('statistics.')->group(function () {
//                 Route::get('/', [StatisticsController::class, 'index'])->name('index');
//                 Route::get('/export', [StatisticsController::class, 'export'])->name('export');
//             });

//             // Profil
//             Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//             Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
//             Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
//         });
//     });

// });

Route::get('/test-market', function () {
    $service = new \App\Services\YahooFinanceService();
    $data = $service->getMarketData();
    return response()->json($data);
});

// Routes pour les commentaires
Route::prefix('api')->group(function () {
    Route::get('/publications/{publication}/comments', [CommentController::class, 'index'])
        ->name('api.comments.index');

    Route::post('/publications/{publication}/comments', [CommentController::class, 'store'])
        ->name('api.comments.store');

    Route::get('/user/info', [CommentController::class, 'getUserInfo'])
        ->name('api.user.info');
});

// Routes pour la boutique
Route::prefix('boutique')->name('shop.')->group(function () {
    // Page principale de la boutique
    Route::get('/', [ShopController::class, 'index'])->name('index');

    // Recherche de numéros
    Route::get('/recherche', [ShopController::class, 'search'])->name('search');

    // Détails d'un numéro
    Route::get('/numero/{id}', [ShopController::class, 'show'])->name('show');

    // Page d'achat/commande
    Route::get('/acheter/{id}', [ShopController::class, 'purchase'])->name('purchase');

    // Traitement de la commande
    Route::post('/commander', [ShopController::class, 'processOrder'])->name('process-order');

    // Page de paiement
    // Route::get('/paiement/{orderId}', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment');
    // Route::get('/paiement/{orderId}', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment');

    // Confirmation de paiement
    Route::get('/confirmation/{orderId}', [ShopController::class, 'confirmation'])->name('confirmation');
});


/*
|--------------------------------------------------------------------------
| Routes pour les Pôles LCM (Communauté, Investigation, Témoins)
|--------------------------------------------------------------------------
*/

// ==================== PÔLE COMMUNAUTÉ ====================
Route::prefix('community')->name('community.')->group(function () {
    // Page principale
    Route::get('/', [CommunityController::class, 'index'])->name('index');

    // Soumission d'article (API)
    Route::post('/submit', [CommunityController::class, 'submit'])->name('submit');

    // Récupérer mes soumissions (API)
    Route::post('/my-submissions', [CommunityController::class, 'mySubmissions'])->name('my-submissions');

    // Dans votre fichier de routes, ajoutez cette ligne dans le groupe community :
    Route::get('/{submission}', [CommunityController::class, 'show'])->name('show');
});

// ==================== PÔLE INVESTIGATION ====================
// Route::prefix('investigation')->name('investigation.')->group(function () {
//     // Page principale
//     Route::get('/', [InvestigationController::class, 'index'])->name('index');

//     // Soumission de proposition d'enquête (API)
//     Route::post('/submit', [InvestigationController::class, 'submit'])->name('submit');

//     // Récupérer mes propositions (API)
//     Route::post('/my-proposals', [InvestigationController::class, 'myProposals'])->name('my-proposals');
// });

// Routes publiques pour le pôle investigation
Route::prefix('investigation')->name('investigation.')->group(function () {

    // Page principale
    Route::get('/', [InvestigationController::class, 'index'])->name('index');

    // Soumettre une proposition
    Route::post('/submit', [InvestigationController::class, 'submit'])->name('submit');

    // Récupérer les propositions d'un utilisateur (AJAX)
    Route::post('/my-proposals', [InvestigationController::class, 'myProposals'])->name('myProposals');

});
// ==================== PÔLE TÉMOINS ====================
Route::prefix('witness')->name('witness.')->group(function () {
    // Page principale
    Route::get('/', [WitnessController::class, 'index'])->name('index');

    // Soumission de témoignage (API)
    Route::post('/submit', [WitnessController::class, 'submit'])->name('submit');

    // Récupérer mes témoignages (API)
    Route::post('/my-testimonies', [WitnessController::class, 'myTestimonies'])->name('my-testimonies');

    // Nouvelle route pour la page de détails
    Route::get('/temoins/{testimony}', [WitnessController::class, 'show'])->name('show');

});




require __DIR__.'/auth.php';
