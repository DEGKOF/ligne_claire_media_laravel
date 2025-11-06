@extends('layouts.frontend')

@section('title', 'Soutenez LCM - La clarté de l\'information')

@section('meta_description', 'Soutenez LIGNE CLAIRE MÉDIA+ et contribuez à une presse libre et indépendante au Bénin et en Afrique.')

@section('meta_keywords', 'don, abonnement, soutien, presse libre, LCM, média indépendant, Bénin')

@push('styles')
<style>
    .support-page {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .support-banner {
        background: #1565C0;
        color: white;
        padding: 1rem 2rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .support-hero {
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        padding: 4rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .support-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: drift 20s linear infinite;
    }

    @keyframes drift {
        0% { transform: translate(0, 0); }
        100% { transform: translate(50px, 50px); }
    }

    .support-hero h1 {
        font-size: 2.5rem;
        font-weight: 900;
        color: #0D47A1;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .support-hero p {
        font-size: 1.2rem;
        color: #1565C0;
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .support-container {
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .support-card {
        background: white;
        border: 2px solid #E3F2FD;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .support-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #1565C0 0%, #0D47A1 100%);
        color: white;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .card-header:hover {
        background: linear-gradient(135deg, #0D47A1 0%, #1565C0 100%);
    }

    .card-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin: 0;
    }

    .card-body {
        padding: 2rem;
    }

    .info-box {
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        color: #0D47A1;
        font-weight: 600;
        border-left: 4px solid #1565C0;
    }

    .card-content h3 {
        color: #0D47A1;
        margin: 1.5rem 0 1rem 0;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .card-content p {
        margin-bottom: 1rem;
        color: #555;
        line-height: 1.7;
    }

    .card-content ul {
        list-style: none;
        margin: 1rem 0;
        padding: 0;
    }

    .card-content ul li {
        padding: 0.75rem 0;
        padding-left: 2rem;
        position: relative;
        color: #555;
        line-height: 1.6;
    }

    .card-content ul li:before {
        content: "✓";
        color: #1565C0;
        font-weight: bold;
        position: absolute;
        left: 0;
        font-size: 1.2rem;
        top: 0.6rem;
    }

    .amounts {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin: 1.5rem 0;
    }

    .amount-btn {
        background: white;
        border: 2px solid #1565C0;
        color: #1565C0;
        padding: 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .amount-btn:hover {
        background: #E3F2FD;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(21, 101, 192, 0.2);
    }

    .amount-btn.active {
        background: #1565C0;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 101, 192, 0.4);
    }

    .frequency {
        display: flex;
        gap: 0.5rem;
        margin: 1.5rem 0;
        flex-wrap: wrap;
    }

    .frequency-btn {
        background: white;
        border: 2px solid #1565C0;
        color: #1565C0;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .frequency-btn:hover {
        background: #E3F2FD;
        transform: translateY(-1px);
    }

    .frequency-btn.active {
        background: #1565C0;
        color: white;
        box-shadow: 0 2px 8px rgba(21, 101, 192, 0.3);
    }

    .submit-btn {
        background: linear-gradient(135deg, #1565C0 0%, #0D47A1 100%);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        width: 100%;
        margin-top: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(21, 101, 192, 0.3);
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #0D47A1 0%, #1565C0 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(21, 101, 192, 0.4);
    }

    .payment-form {
        display: none;
        margin-top: 2rem;
        padding: 2rem;
        background: #F8F9FA;
        border-radius: 8px;
        border: 2px solid #E3F2FD;
        animation: slideDown 0.4s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .payment-form.active {
        display: block;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #0D47A1;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #BBDEFB;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #1565C0;
        box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.1);
    }

    .quote {
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        padding: 2rem;
        border-left: 4px solid #1565C0;
        margin: 2rem 0;
        font-style: italic;
        color: #0D47A1;
        text-align: center;
        font-size: 1.1rem;
        border-radius: 8px;
        font-weight: 600;
    }

    .transparency {
        background: #F8F9FA;
        padding: 2rem;
        border-radius: 8px;
        margin: 2rem 0;
        border: 2px solid #E3F2FD;
    }

    .transparency h3 {
        color: #0D47A1;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .transparency p {
        color: #555;
        margin-bottom: 0.75rem;
        line-height: 1.7;
        padding-left: 1.5rem;
        position: relative;
    }

    .transparency p:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #1565C0;
        font-weight: bold;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .support-card {
        animation: fadeIn 0.6s ease;
    }

    .support-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .support-container {
            grid-template-columns: 1fr;
            padding: 0 1rem;
            margin: 2rem auto;
        }

        .support-hero h1 {
            font-size: 1.8rem;
        }

        .support-hero p {
            font-size: 1rem;
        }

        .support-hero {
            padding: 3rem 1rem;
        }

        .amounts {
            grid-template-columns: repeat(2, 1fr);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-header h2 {
            font-size: 1.3rem;
        }

        .payment-form {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .amounts {
            grid-template-columns: 1fr;
        }

        .frequency {
            flex-direction: column;
        }

        .frequency-btn {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="support-page">
    <!-- Banner -->
    <div class="support-banner">
        La clarté de l'information - Un média indépendant, par vous, pour vous
    </div>

    <!-- Hero Section -->
    <section class="support-hero">
        <h1>Soutenez LCM, la clarté de l'information !</h1>
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
                    <h3>Votre don permet à LCM Press de :</h3>
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
                        <button class="amount-btn" data-amount="2000">2 000 FCFA</button>
                        <button class="amount-btn" data-amount="5000">5 000 FCFA</button>
                        <button class="amount-btn" data-amount="10000">10 000 FCFA</button>
                        <button class="amount-btn" data-amount="25000">25 000 FCFA</button>
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
                        <h3>🔍 Transparence totale :</h3>
                        <p>Vous recevez automatiquement un reçu de confirmation par email</p>
                        <p>Tous les dons sont utilisés exclusivement pour la production de contenus</p>
                        <p>Vous pouvez suivre l'utilisation des fonds dans nos rapports semestriels</p>
                        <p>Aucun frais administratif excessif : 95% des fonds vont directement à l'information</p>
                    </div>

                    <div class="quote">
                        "Votre don, c'est votre voix pour une presse libre et indépendante."
                    </div>

                    <button class="submit-btn" onclick="showPaymentForm('don')">
                        Je fais mon don maintenant
                    </button>
                </div>

                <!-- Formulaire de paiement Don -->
                <div class="payment-form" id="payment-form-don">
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
                        <div class="form-group">
                            <label>Montant (FCFA) *</label>
                            <input type="number" id="amount-input-don" name="amount" placeholder="Montant en FCFA" min="500" required>
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
        </div>

        <!-- Carte Abonnement -->
        <div class="support-card">
            <div class="card-header" onclick="scrollToCard('abonnement')">
                <h2>Je m'abonne</h2>
            </div>
            <div class="card-body">
                <div class="info-box">
                    Je garantis l'indépendance de LCM Press, la clarté de l'information.
                </div>

                <div class="card-content">
                    <h3>En tant qu'abonné, vous avez accès à :</h3>
                    <ul>
                        <li>La Newsletter quotidienne exclusive</li>
                        <li>Le fil Telegram des Coulisses de LCM</li>
                        <li>Le forum privé des abonnés</li>
                        <li>Les FAQ en direct avec l'équipe</li>
                        <li>Des masterclass mensuelles sur le journalisme</li>
                        <li>Des invitations aux émissions spéciales et événements</li>
                        <li>Accès anticipé aux contenus premium</li>
                        <li>Pas de publicité sur le site</li>
                    </ul>

                    <h3>Notre engagement</h3>
                    <p>LCM+ ne dépend d'aucune puissance publique, entreprise ni parti politique.</p>
                    <p>Notre seule force, c'est vous, lectrices et lecteurs qui croient en une presse libre et responsable.</p>
                    <p>Votre abonnement garantit notre indépendance éditoriale totale.</p>

                    <h3>Formules d'abonnement :</h3>
                    <div class="transparency">
                        <p><strong>Mensuel :</strong> 2 000 FCFA/mois - Engagement sans durée</p>
                        <p><strong>Trimestriel :</strong> 5 000 FCFA/3 mois - Économisez 1 000 FCFA</p>
                        <p><strong>Annuel :</strong> 15 000 FCFA/an - Économisez 9 000 FCFA (37.5%)</p>
                    </div>

                    <div class="quote">
                        "Informer, c'est un acte citoyen. Soutenir, c'est un acte de liberté."
                    </div>

                    <button class="submit-btn" onclick="showPaymentForm('abonnement')">
                        Je m'abonne maintenant
                    </button>
                </div>

                <!-- Formulaire d'abonnement -->
                <div class="payment-form" id="payment-form-abonnement">
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
                                <span>J'accepte les <a href="#" class="text-blue-600 hover:underline">conditions générales</a></span>
                            </label>
                        </div>
                        <button type="submit" class="submit-btn">
                            Valider l'abonnement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Section supplémentaire : Pourquoi nous soutenir -->
    <div class="container mx-auto px-4 py-12 max-w-4xl">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 border-2 border-blue-200">
            <h2 class="text-3xl font-black text-blue-900 mb-6 text-center">
                Pourquoi soutenir LCM Press ?
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
@endsection

@push('scripts')
<script>
    // Gestion des montants de don
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));

            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');

            const amount = this.dataset.amount;
            const amountInput = document.getElementById('amount-input-don');

            if (amount !== 'custom') {
                amountInput.value = amount;
            } else {
                amountInput.value = '';
                amountInput.focus();
                amountInput.placeholder = 'Entrez votre montant...';
            }
        });
    });

    // Gestion des fréquences de don
    document.querySelectorAll('.frequency-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            document.querySelectorAll('.frequency-btn').forEach(b => b.classList.remove('active'));

            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');

            const frequency = this.dataset.frequency;
            const frequencySelect = document.getElementById('frequency-select-don');

            if (frequencySelect) {
                frequencySelect.value = frequency;
            }
        });
    });

    // Affichage/masquage des formulaires de paiement
    function showPaymentForm(type) {
        const form = document.getElementById(`payment-form-${type}`);

        if (form) {
            // Si le formulaire est déjà visible, on le masque
            if (form.classList.contains('active')) {
                form.classList.remove('active');
            } else {
                // Sinon, on le rend visible
                form.classList.add('active');

                // Scroll smooth vers le formulaire
                setTimeout(() => {
                    form.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }, 100);
            }
        }
    }

    // Fonction pour scroll vers une carte spécifique (optionnel)
    function scrollToCard(type) {
        const card = document.getElementById(`payment-form-${type}`);
        if (card) {
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // Validation personnalisée des formulaires
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            // Validation du montant pour le formulaire de don
            if (this.querySelector('#amount-input-don')) {
                const amount = parseInt(this.querySelector('#amount-input-don').value);

                if (isNaN(amount) || amount < 500) {
                    e.preventDefault();
                    alert('⚠️ Le montant minimum est de 500 FCFA');
                    return false;
                }
            }

            // Afficher un message de confirmation
            const submitBtn = this.querySelector('.submit-btn');
            if (submitBtn) {
                submitBtn.textContent = '⏳ Traitement en cours...';
                submitBtn.disabled = true;
            }
        });
    });

    // Animation au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    // Observer les cartes de support
    document.querySelectorAll('.support-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

    // Message de bienvenue (optionnel)
    console.log('💝 Merci de visiter notre page de soutien !');
    console.log('🌟 Ensemble, construisons une presse libre et indépendante.');
</script>
@endpush
