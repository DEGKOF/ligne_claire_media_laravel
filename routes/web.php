<?php

use App\Models\Publication;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\Admin\NewsletterAdminController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WitnessController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CommunityController;

use App\Http\Controllers\AdTrackingController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\InvestigationController;


use App\Http\Controllers\Admin\RubriqueController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\AdminWitnessController;
use App\Http\Controllers\Admin\AdminCommunityController;
use App\Http\Controllers\Admin\AdminCandidatureController;
use App\Http\Controllers\Admin\AdminInvestigationController;
use App\Http\Controllers\Admin\AdvertiserManagementController;
use App\Http\Controllers\Admin\AdvertisementManagementController;
use App\Http\Controllers\Admin\PublicationController as AdminPublicationController;


use App\Http\Controllers\Admin\EditoController as AdminEditoController;

use App\Http\Controllers\EditoController as FrontendEditoController;

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
// Ajoutez cette nouvelle route
// Route::post('/admin/publications/upload-video', [AdminPublicationController::class, 'uploadVideo'])
//     ->name('admin.publications.upload-video')
//     ->middleware(['auth']);

Route::post('/admin/publications/upload-image', [AdminPublicationController::class, 'uploadImage'])
    ->name('admin.publications.upload-image')
    ->middleware(['auth']);

// routes/web.php - Ajouter cette route
Route::get('/coming-soon', function () {
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();
    return view('coming-soon', compact('breakingNews'));
})->name('coming-soon');

// routes/web.php - Ajouter ces routes
Route::get('/devenir-membre', [MembershipController::class, 'index'])->name('membership.index');
Route::post('/devenir-membre', [MembershipController::class, 'store'])->name('membership.store');

// Routes pour le recrutement (accessibles sans authentification)
Route::get('/nous-rejoindre', [RecruitmentController::class, 'index'])->name('recruitment.index');
Route::post('/nous-rejoindre', [RecruitmentController::class, 'store'])->name('recruitment.store');

Route::get('/soutenir-le-media', function () {
        // Récupérer les breaking news pour la sidebar
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();

    return view('soutient', compact('breakingNews'));
})->name('soutient');


Route::get('/annonceurs', function () {
        // Récupérer les breaking news pour la sidebar
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();

    return view('frontend.annonceurs', compact('breakingNews'));
})->name('annonceurs');

// Route::post('/donation/process', [DonationController::class, 'process'])->name('donation.process');
// Route::post('/subscription/process', [SubscriptionController::class, 'process'])->name('subscription.process');
Route::get('/subscription-process', function () {
        // Récupérer les breaking news pour la sidebar
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();

    // return back();
    return view('welcome_success');
})->name('subscription.process');

Route::get('payment-success/{id}', function () {
    return view('welcome_success');
})->name('shop.payment');


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



Route::post('/donation', [DonationController::class, 'process'])->name('donation.process');
// Route::get('/publicite/contact', [AdvertisementController::class, 'contact'])->name('advertising.contact');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Newsletter
    Route::get('/newsletter', [NewsletterAdminController::class, 'index'])->name('newsletter.index');
    Route::delete('/newsletter/{subscription}', [NewsletterAdminController::class, 'destroy'])->name('newsletter.destroy');
    Route::post('/newsletter/export', [NewsletterAdminController::class, 'export'])->name('newsletter.export');
    Route::get('/newsletter/send', [NewsletterAdminController::class, 'sendForm'])->name('newsletter.send.form');
    Route::post('/newsletter/send', [NewsletterAdminController::class, 'sendNewsletter'])->name('newsletter.send');
    Route::post('/newsletter/{subscription}/toggle', [NewsletterAdminController::class, 'toggleStatus'])->name('newsletter.toggle');
});

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
    Route::middleware([CheckRole::class . ':admin,master_admin,journaliste,redacteur'])
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
Route::prefix('investigation')->name('investigation.')->group(function () {

    // Page principale
    Route::get('/', [InvestigationController::class, 'index'])->name('index');

    // Détails d'une proposition
    Route::get('/{proposal}', [InvestigationController::class, 'show'])->name('show');

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

/*
|--------------------------------------------------------------------------
| Routes Advertiser (Annonceurs)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'advertiser'])->prefix('advertiser')->name('advertiser.')->group(function () {
    Route::get('/dashboard', [AdvertiserController::class, 'dashboard'])->name('dashboard');

    // Profil
    Route::get('/profile/complete', [AdvertiserController::class, 'completeProfile'])->name('profile.complete');
    Route::post('/profile/store', [AdvertiserController::class, 'storeProfile'])->name('profile.store');

    // Campagnes
    Route::get('/campaigns', [AdvertiserController::class, 'campaigns'])->name('campaigns.index');
    Route::get('/campaigns/create', [AdvertiserController::class, 'createCampaign'])->name('campaigns.create');
    Route::post('/campaigns', [AdvertiserController::class, 'storeCampaign'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}', [AdvertiserController::class, 'showCampaign'])->name('campaigns.show');
    Route::get('/campaigns/{campaign}/edit', [AdvertiserController::class, 'editCampaign'])->name('campaigns.edit');
    Route::put('/campaigns/{campaign}', [AdvertiserController::class, 'updateCampaign'])->name('campaigns.update');
    Route::delete('/campaigns/{campaign}', [AdvertiserController::class, 'destroyCampaign'])->name('campaigns.destroy');

    // Actions campagnes
    Route::post('/campaigns/{campaign}/submit', [AdvertiserController::class, 'submitCampaign'])->name('campaigns.submit');
    Route::post('/campaigns/{campaign}/pause', [AdvertiserController::class, 'pauseCampaign'])->name('campaigns.pause');
    Route::post('/campaigns/{campaign}/resume', [AdvertiserController::class, 'resumeCampaign'])->name('campaigns.resume');
});

/*
|--------------------------------------------------------------------------
| Routes Admin - Gestion Publicités
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', CheckRole::class . ':admin,master_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Gestion annonceurs
    Route::prefix('advertisers')->name('advertisers.')->group(function () {
        Route::get('/', [AdvertiserManagementController::class, 'index'])->name('index');
        Route::get('/{profile}', [AdvertiserManagementController::class, 'show'])->name('show');
        Route::post('/{profile}/approve', [AdvertiserManagementController::class, 'approve'])->name('approve');
        Route::post('/{profile}/reject', [AdvertiserManagementController::class, 'reject'])->name('reject');
        Route::post('/{profile}/suspend', [AdvertiserManagementController::class, 'suspend'])->name('suspend');
        Route::post('/{profile}/reactivate', [AdvertiserManagementController::class, 'reactivate'])->name('reactivate');
    });

    // Gestion campagnes publicitaires
    Route::prefix('advertisements')->name('advertisements.')->group(function () {
        Route::get('/', [AdvertisementManagementController::class, 'index'])->name('index');
        Route::get('/{campaign}', [AdvertisementManagementController::class, 'show'])->name('show');
        Route::post('/{campaign}/approve', [AdvertisementManagementController::class, 'approve'])->name('approve');
        Route::post('/{campaign}/reject', [AdvertisementManagementController::class, 'reject'])->name('reject');
        Route::post('/{campaign}/activate', [AdvertisementManagementController::class, 'activate'])->name('activate');
        Route::post('/{campaign}/pause', [AdvertisementManagementController::class, 'pause'])->name('pause');

        // Emplacements
        Route::prefix('placements')->name('placements.')->group(function () {
            Route::get('/', [AdvertisementManagementController::class, 'placementsIndex'])->name('index');
            Route::get('/create', [AdvertisementManagementController::class, 'placementsCreate'])->name('create');
            Route::post('/', [AdvertisementManagementController::class, 'placementsStore'])->name('store');
        });
    });
});

// Route publique pour tracker les clics
Route::get('/ad/click/{advertisement}', [AdTrackingController::class, 'trackClick'])->name('ad.track.click');

// Route::get('/api/ad/next/{position}', [AdTrackingController::class, 'getNextAd'])->name('ad.next');
Route::get('/api/ad/next/{position}', [App\Http\Controllers\AdController::class, 'getNextAd'])->name('ad.next');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // ============================================
    // COMMUNITY SUBMISSIONS (Soumissions Communauté)
    // ============================================
    Route::prefix('community')->name('admin.community.')->group(function () {
        // Liste et détails
        Route::get('/', [AdminCommunityController::class, 'index'])->name('index');
        Route::get('/{submission}', [AdminCommunityController::class, 'show'])->name('show');

        // Mise à jour du contenu
        Route::put('/{submission}', [AdminCommunityController::class, 'update'])->name('update');

        // Gestion des statuts
        Route::post('/{submission}/validate', [AdminCommunityController::class, 'validateCommunity'])->name('validate');
        Route::post('/{submission}/reject', [AdminCommunityController::class, 'rejectvalidateCommunity'])->name('reject');
        Route::post('/{submission}/publish', [AdminCommunityController::class, 'publish'])->name('publish');
        Route::post('/{submission}/unpublish', [AdminCommunityController::class, 'unpublish'])->name('unpublish');
        Route::put('/{submission}/status', [AdminCommunityController::class, 'updateStatus'])->name('update-status');

        // Suppression et restauration
        Route::delete('/{submission}', [AdminCommunityController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [AdminCommunityController::class, 'restore'])->name('restore');

        // Actions en masse
        Route::post('/bulk-action', [AdminCommunityController::class, 'bulkAction'])->name('bulk-action');
    });

    // ============================================
    // INVESTIGATION PROPOSALS (Propositions d'Investigation)
    // ============================================


    Route::prefix('investigations')->name('admin.investigations.')->group(function () {
        // Liste et détails
        Route::get('/', [AdminInvestigationController::class, 'index'])->name('index');
        Route::get('/{proposal}', [AdminInvestigationController::class, 'show'])->name('show');

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
    Route::prefix('investigations')->name('apiadmin.investigations.')->group(function () {
        // Liste et détails
        Route::get('/{proposal}', [AdminInvestigationController::class, 'show'])->name('show');
    });

    // ============================================
    // WITNESS TESTIMONIES (Témoignages)
    // ============================================
    Route::prefix('testimonies')->name('admin.testimonies.')->group(function () {
        // Liste et détails
        Route::get('/index-testimonies', [AdminWitnessController::class, 'indexTestimonies'])->name('index.page');
        Route::get('/', [AdminWitnessController::class, 'index'])->name('index');
        Route::get('/{testimony}', [AdminWitnessController::class, 'show'])->name('show');

        // Mise à jour du contenu
        Route::put('/{testimony}', [AdminWitnessController::class, 'update'])->name('update');

        // Gestion des statuts
        Route::post('/{testimony}/validate', [AdminWitnessController::class, 'validateWitness'])->name('validate');
        Route::post('/{testimony}/reject', [AdminWitnessController::class, 'rejectWitness'])->name('reject');
        Route::post('/{testimony}/publish', [AdminWitnessController::class, 'publish'])->name('publish');
        Route::post('/{testimony}/unpublish', [AdminWitnessController::class, 'unpublish'])->name('unpublish');
        Route::put('/{testimony}/status', [AdminWitnessController::class, 'updateStatus'])->name('update-status');

        // Téléchargement de médias
        Route::get('/{testimony}/download-media', [AdminWitnessController::class, 'downloadMedia'])->name('download-media');
        Route::get('/{testimony}/download-all-media', [AdminWitnessController::class, 'downloadAllMedia'])->name('download-all-media');

        // Gestion des médias
        Route::delete('/{testimony}/media', [AdminWitnessController::class, 'deleteMedia'])->name('delete-media');

        // Suppression et restauration
        Route::delete('/{testimony}', [AdminWitnessController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [AdminWitnessController::class, 'restore'])->name('restore');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Candidatures
    Route::prefix('candidatures')->name('candidatures.')->group(function () {
        Route::get('/', [AdminCandidatureController::class, 'index'])->name('index');
        Route::get('/export', [AdminCandidatureController::class, 'export'])->name('export');
        Route::get('/{candidature}', [AdminCandidatureController::class, 'show'])->name('show');
        Route::patch('/{candidature}/status', [AdminCandidatureController::class, 'updateStatus'])->name('update-status');
        Route::patch('/{candidature}/notes', [AdminCandidatureController::class, 'updateNotes'])->name('update-notes');
        Route::get('/{candidature}/cv', [AdminCandidatureController::class, 'downloadCv'])->name('download-cv');
        Route::get('/{candidature}/lettre', [AdminCandidatureController::class, 'downloadLettre'])->name('download-lettre');
        Route::delete('/{candidature}', [AdminCandidatureController::class, 'destroy'])->name('destroy');
    });

});


// Routes Admin pour la gestion des journaux
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Routes CRUD pour les journaux
    Route::resource('issues', IssueController::class);

    // Routes supplémentaires
    Route::post('issues/{id}/restore', [IssueController::class, 'restore'])
        ->name('issues.restore');

    Route::delete('issues/{id}/force-delete', [IssueController::class, 'forceDelete'])
        ->name('issues.force-delete');

    Route::patch('issues/{issue}/status', [IssueController::class, 'updateStatus'])
        ->name('issues.update-status');
});


// ========================================
// ROUTES ADMIN - Gestion des éditos
// ========================================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Routes CRUD pour les éditos
    Route::resource('editos', AdminEditoController::class);

    // Routes supplémentaires
    Route::post('editos/{id}/restore', [AdminEditoController::class, 'restore'])
        ->name('editos.restore');

    Route::delete('editos/{id}/force-delete', [AdminEditoController::class, 'forceDelete'])
        ->name('editos.force-delete');

    Route::patch('editos/{edito}/status', [AdminEditoController::class, 'updateStatus'])
        ->name('editos.update-status');
});

// ========================================
// ROUTES FRONTEND - Page éditos publics
// ========================================
Route::get('/editos', [FrontendEditoController::class, 'index'])->name('editos.index');
Route::get('/edito/{edito:slug}', [FrontendEditoController::class, 'show'])->name('editos.show');


// routes/web.php - Ajouter ces routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

Route::get('/test-404', function () {
    abort(404);
});

Route::get('/test-403', function () {
    abort(403);
});

// use App\Http\Controllers\TeamController;
// use App\Http\Controllers\Admin\TeamMemberController;

// Frontend
Route::get('/notre-equipe', [TeamController::class, 'index'])->name('team.index');

// Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('team', TeamMemberController::class)->parameters(['team' => 'teamMember']);
    Route::post('team/{teamMember}/toggle', [TeamMemberController::class, 'toggleVisibility'])->name('team.toggle');
    Route::delete('team/{teamMember}/photo', [TeamMemberController::class, 'deletePhoto'])->name('team.delete-photo');
});

// use App\Http\Controllers\ContactController;
// use App\Http\Controllers\Admin\ContactAdminController;

// Frontend
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/contacts', [ContactAdminController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactAdminController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{contact}/status', [ContactAdminController::class, 'updateStatus'])->name('contacts.status');
    Route::delete('/contacts/{contact}', [ContactAdminController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/bulk-delete', [ContactAdminController::class, 'bulkDelete'])->name('contacts.bulk-delete');
});

require __DIR__.'/auth.php';
