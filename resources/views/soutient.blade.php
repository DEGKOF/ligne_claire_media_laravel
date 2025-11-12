{{-- views/soutient.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Soutenez LCM Plus- La clarté de l\'information')

@section('meta_description', 'Soutenez LIGNE CLAIRE MÉDIA+ et contribuez à une presse libre et indépendante au Bénin et
    en Afrique.')

@section('meta_keywords', 'don, abonnement, soutien, presse libre, LCM Plus, média indépendant, Bénin')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/soutient.css') }}">
    <div class="support-page">
        <!-- Banner -->
        <div class="support-banner">
            La clarté de l'information - Un média indépendant, par vous, pour vous
        </div>

        <!-- Hero Section -->
        <section class="support-hero">
            <h1>Soutenez LCM Plus, la clarté de l'information !</h1>
            <p>Financez un média libre, indépendant et 100 % numérique, accessible à tous.</p>
        </section>

        <!-- Main Content -->
        <div class="support-container">
            <!-- Carte Don -->
            <div class="support-card">
                <div class="card-header" onclick="scrollToCard('don')">
                    <h2>Je fais un don</h2>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        Je soutiens la liberté d'informer au Bénin et en Afrique.
                    </div>

                    <div class="card-content">
                        <h3>Votre don permet à LCM Plus de :</h3>
                        <ul>
                            <li>Financer ses enquêtes et reportages indépendants</li>
                            <li>Protéger ses journalistes et ses sources</li>
                            <li>Garder une information libre, sans publicité politique ni subvention d'État</li>
                            <li>Développer de nouveaux formats éditoriaux</li>
                            <li>Former de jeunes journalistes béninois</li>
                        </ul>

                        <h3>Montants disponibles :</h3>
                        <div class="amounts">
                            <button class="amount-btn" data-amount="1000">1 000 FCFA</button>
                            {{-- <button class="amount-btn" data-amount="2000">2 000 FCFA</button> --}}
                            <button class="amount-btn" data-amount="5000">5 000 FCFA</button>
                            {{-- <button class="amount-btn" data-amount="10000">10 000 FCFA</button> --}}
                            {{-- <button class="amount-btn" data-amount="25000">25 000 FCFA</button> --}}
                            <button class="amount-btn" data-amount="custom">Montant libre</button>
                        </div>

                        <h3>Fréquence de don :</h3>
                        <div class="frequency">
                            <button class="frequency-btn active" data-frequency="ponctuel">Ponctuel</button>
                            <button class="frequency-btn" data-frequency="mensuel">Mensuel</button>
                            <button class="frequency-btn" data-frequency="trimestriel">Trimestriel</button>
                            <button class="frequency-btn" data-frequency="semestriel">Semestriel</button>
                            <button class="frequency-btn" data-frequency="annuel">Annuel</button>
                        </div>

                        <div class="transparency">
                            <p>Vous recevez automatiquement un reçu de confirmation par email</p>
                            <p>Tous les dons sont utilisés exclusivement pour la production de contenus</p>
                            {{-- <p>Vous pouvez suivre l'utilisation des fonds dans nos rapports semestriels</p> --}}
                            <p>Aucun frais administratif excessif : 95% des fonds vont directement à l'information</p>
                        </div>

                        <div class="quote">
                            "Votre don, c'est votre voix pour une presse libre et indépendante."
                        </div>

                        <button class="submit-btn" onclick="showPaymentForm('don')">
                            Je fais mon don maintenant
                        </button>
                    </div>
                </div>
            </div>

            <!-- Carte Abonnement -->
            <div class="support-card">
                <div class="card-header" onclick="scrollToCard('abonnement')">
                    <h2>Je m'abonne</h2>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        Je garantis l'indépendance de LCM Plus.
                    </div>

                    <div class="card-content">
                        <h3>En tant qu'abonné, vous avez accès à :</h3>
                        <ul>
                            <li>La Newsletter quotidienne exclusive</li>
                            <li>Le fil Telegram des Coulisses de LCM Plus</li>
                            <li>Le forum privé des abonnés</li>
                            {{-- <li>Les FAQ en direct avec l'équipe</li> --}}
                            {{-- <li>Des masterclass mensuelles sur le journalisme</li> --}}
                            <li>Des invitations aux émissions spéciales et événements</li>
                            {{-- <li>Accès anticipé aux contenus premium</li> --}}
                            <li>Pas de publicité sur le site</li>
                        </ul>

                        <h3>Notre engagement</h3>
                        <p>LCM+ ne dépend d'aucune puissance publique, entreprise ni parti politique.</p>
                        <p>Notre seule force, c'est vous, lectrices et lecteurs qui croient en une presse libre et
                            responsable.</p>
                        <p>Votre abonnement garantit notre indépendance éditoriale totale.</p>

                        <h3>Formules d'abonnement :</h3>
                        <div class="transparency">
                            <p><strong>Mensuel :</strong> 2 000 FCFA/mois - Engagement sans durée</p>
                            <p><strong>Trimestriel :</strong> 5 000 FCFA/3 mois - Économisez 1 000 FCFA</p>
                            <p><strong>Annuel :</strong> 12 000 FCFA/an - Économisez 9 000 FCFA (37.5%)</p>
                        </div>

                        <div class="quote">
                            "Informer, c'est un acte citoyen. Soutenir, c'est un acte de liberté."
                        </div>

                        <button class="submit-btn" onclick="showPaymentForm('abonnement')">
                            Je m'abonne maintenant
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section supplémentaire : Pourquoi nous soutenir -->
        <div class="container mx-auto px-4 py-12 max-w-4xl">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 border-2 border-blue-200">
                <h2 class="text-3xl font-black text-blue-900 mb-6 text-center">
                    Pourquoi soutenir LCM Plus ?
                </h2>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-xl shadow">
                        <h3 class="text-xl font-bold text-blue-800 mb-3">Indépendance éditoriale</h3>
                        <p class="text-gray-700">Aucune influence politique ou économique sur nos contenus</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow">
                        <h3 class="text-xl font-bold text-blue-800 mb-3">Fact-checking rigoureux</h3>
                        <p class="text-gray-700">Vérification systématique de toutes nos informations</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow">
                        <h3 class="text-xl font-bold text-blue-800 mb-3">Couverture locale & internationale</h3>
                        <p class="text-gray-700">De Cotonou à Paris, nous suivons l'actualité qui compte</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow">
                        <h3 class="text-xl font-bold text-blue-800 mb-3">100% numérique</h3>
                        <p class="text-gray-700">Accessible partout, à tout moment, sur tous vos appareils</p>
                    </div>
                </div>

                <div class="text-center bg-blue-900 text-white p-6 rounded-xl">
                    <p class="text-xl font-bold mb-2">Merci de croire en une presse libre !</p>
                    <p class="text-blue-200">Ensemble, construisons l'information de demain</p>
                </div>
            </div>
        </div>
    </div>


    <!-- MODALS -->
<!-- Modal Don -->
<div class="modal-overlay" id="modal-overlay-don">
    <div class="payment-form" id="payment-form-don">
        <button class="modal-close" onclick="closePaymentForm('don')" type="button">×</button>
        <h3 style="margin-bottom: 1.5rem; color: #0D47A1;">Informations de paiement</h3>
        <form action="{{ route('donation.process') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nom complet *</label>
                <input type="text" name="name" placeholder="Votre nom complet" required>
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" placeholder="votre@email.com" required>
            </div>
            <div class="form-group">
                <label>Téléphone *</label>
                <input type="tel" name="phone" placeholder="+229 XX XX XX XX" required>
            </div>
            {{-- <div class="form-group">
                <label>Montant (FCFA) *</label>
                <input type="number" id="amount-input-don" name="amount" placeholder="Montant en FCFA" min="500"
                    required>
            </div> --}}

            <div class="form-group">
                <label>Montant (FCFA) *</label>
                <input type="number" id="amount-input-don" name="amount" placeholder="Montant en FCFA" min="500"
                    value="{{ $prefilledAmount ?? '' }}" required>
            </div>
            <div class="form-group">
                <label>Fréquence *</label>
                <select id="frequency-select-don" name="frequency" required>
                    <option value="ponctuel">Ponctuel</option>
                    <option value="mensuel">Mensuel</option>
                    <option value="trimestriel">Trimestriel</option>
                    <option value="semestriel">Semestriel</option>
                    <option value="annuel">Annuel</option>
                </select>
            </div>
            <div class="form-group">
                <label>Moyen de paiement *</label>
                <select name="payment_method" required>
                    <option value="">-- Choisir un moyen de paiement --</option>
                    <option value="mobile_money">Mobile Money (MTN/Moov)</option>
                    <option value="card">Carte bancaire</option>
                    <option value="bank_transfer">Virement bancaire</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">
                Valider le paiement
            </button>
        </form>
    </div>
</div>

<!-- Modal Abonnement -->
<div class="modal-overlay" id="modal-overlay-abonnement">
    <div class="payment-form" id="payment-form-abonnement">
        <button class="modal-close" onclick="closePaymentForm('abonnement')" type="button">×</button>
        <h3 style="margin-bottom: 1.5rem; color: #0D47A1;">Informations d'abonnement</h3>
        <form action="{{ route('subscription.process') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nom complet *</label>
                <input type="text" name="name" placeholder="Votre nom complet" required>
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" placeholder="votre@email.com" required>
            </div>
            <div class="form-group">
                <labelTéléphone *</label>
                    <input type="tel" name="phone" placeholder="+229 XX XX XX XX" required>
            </div>
            <div class="form-group">
                <label>Type d'abonnement *</label>
                <select name="subscription_type" required>
                    <option value="">-- Choisir une formule --</option>
                    <option value="monthly">Mensuel - 2 000 FCFA/mois</option>
                    <option value="quarterly">Trimestriel - 5 000 FCFA/3 mois </option>
                    <option value="yearly">Annuel - 15 000 FCFA/an </option>
                </select>
            </div>
            <div class="form-group">
                <label>Moyen de paiement *</label>
                <select name="payment_method" required>
                    <option value="">-- Choisir un moyen de paiement --</option>
                    <option value="mobile_money">Mobile Money (MTN/Moov)</option>
                    <option value="card">Carte bancaire</option>
                    <option value="bank_transfer">Virement bancaire</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="terms" required>
                    <span>J'accepte les <a href="#" class="text-blue-600 hover:underline">conditions
                            générales</a></span>
                </label>
            </div>
            <button type="submit" class="submit-btn">
                Valider l'abonnement
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/soutient.js') }}"></script>

    @if(isset($prefilledAmount))
        <script>
            // Appeler la fonction pour gérer le montant pré-rempli
            document.addEventListener('DOMContentLoaded', function() {
                handlePrefilledAmount();
            });
        </script>
    @endif
@endpush
