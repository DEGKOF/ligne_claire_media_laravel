@extends('layouts.frontend')

@section('title', 'Soutenez LCM - La clarté de l\'information')

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
    }

    .support-hero {
        background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        padding: 4rem 2rem;
        text-align: center;
    }

    .support-hero h1 {
        font-size: 2.5rem;
        font-weight: 900;
        color: #0D47A1;
        margin-bottom: 1rem;
    }

    .support-hero p {
        font-size: 1.2rem;
        color: #1565C0;
        max-width: 800px;
        margin: 0 auto;
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
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-header {
        background: #1565C0;
        color: white;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: background 0.3s;
    }

    .card-header:hover {
        background: #0D47A1;
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
        background: #E3F2FD;
        padding: 1.5rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        color: #0D47A1;
    }

    .card-content h3 {
        color: #0D47A1;
        margin: 1.5rem 0 1rem 0;
        font-size: 1.2rem;
    }

    .card-content p {
        margin-bottom: 1rem;
        color: #555;
    }

    .card-content ul {
        list-style: none;
        margin: 1rem 0;
        padding: 0;
    }

    .card-content ul li {
        padding: 0.5rem 0;
        padding-left: 1.5rem;
        position: relative;
        color: #555;
    }

    .card-content ul li:before {
        content: "•";
        color: #1565C0;
        font-weight: bold;
        position: absolute;
        left: 0;
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
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 0.95rem;
    }

    .amount-btn:hover, .amount-btn.active {
        background: #1565C0;
        color: white;
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
        transition: all 0.3s;
        font-size: 0.9rem;
    }

    .frequency-btn:hover, .frequency-btn.active {
        background: #1565C0;
        color: white;
    }

    .submit-btn {
        background: #1565C0;
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 6px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        width: 100%;
        margin-top: 1rem;
        transition: background 0.3s;
    }

    .submit-btn:hover {
        background: #0D47A1;
    }

    .payment-form {
        display: none;
        margin-top: 2rem;
        padding: 2rem;
        background: #F5F5F5;
        border-radius: 6px;
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
    }

    .form-group input, .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #BBDEFB;
        border-radius: 6px;
        font-size: 1rem;
    }

    .form-group input:focus, .form-group select:focus {
        outline: none;
        border-color: #1565C0;
    }

    .quote {
        background: #E3F2FD;
        padding: 2rem;
        border-left: 4px solid #1565C0;
        margin: 2rem 0;
        font-style: italic;
        color: #0D47A1;
        text-align: center;
        font-size: 1.1rem;
    }

    .transparency {
        background: #F5F5F5;
        padding: 2rem;
        border-radius: 6px;
        margin: 2rem 0;
    }

    .transparency h3 {
        color: #0D47A1;
        margin-bottom: 1rem;
    }

    .transparency p {
        color: #555;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .support-container {
            grid-template-columns: 1fr;
        }

        .support-hero h1 {
            font-size: 1.8rem;
        }

        .amounts {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="support-page">
    <div class="support-banner">
        La clarté de l'information
    </div>

    <section class="support-hero">
        <h1>Soutenez LCM, la clarté de l'information !</h1>
        <p>Financez un média libre, indépendant et 100 % numérique, accessible à tous.</p>
    </section>

    <div class="support-container">
        <!-- Don Card -->
        <div class="support-card">
            <div class="card-header" onclick="togglePaymentForm('don')">
                <h2>💝 Je fais un don</h2>
            </div>
            <div class="card-body">
                <div class="info-box">
                    Je soutiens la liberté d'informer au Bénin et en Afrique.
                </div>

                <div class="card-content">
                    <h3>Votre don permet à LCM Press de :</h3>
                    <ul>
                        <li>financer ses enquêtes et reportages indépendants,</li>
                        <li>protéger ses journalistes et ses sources,</li>
                        <li>garder une information libre, sans publicité politique ni subvention d'État.</li>
                    </ul>

                    <h3>Montants disponibles :</h3>
                    <div class="amounts">
                        <button class="amount-btn" data-amount="1000">1 000 FCFA</button>
                        <button class="amount-btn" data-amount="2000">2 000 FCFA</button>
                        <button class="amount-btn" data-amount="5000">5 000 FCFA</button>
                        <button class="amount-btn" data-amount="10000">10 000 FCFA</button>
                        <button class="amount-btn" data-amount="custom">💬 montant libre</button>
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
                        <h3>Transparence :</h3>
                        <p>• Vous recevez automatiquement un reçu de confirmation.</p>
                        <p>• Tous les dons sont utilisés exclusivement pour la production de contenus et la protection du média.</p>
                        <p>• Vous pouvez suivre l'utilisation des fonds dans nos rapports semestriels publiés en ligne.</p>
                    </div>

                    <div class="quote">
                        💡 Votre don, c'est votre voix pour une presse libre.
                    </div>

                    <button class="submit-btn" onclick="showPaymentForm('don')">Je fais mon don</button>
                </div>

                <div class="payment-form" id="payment-form-don">
                    <h3 style="margin-bottom: 1.5rem; color: #0D47A1;">Informations de paiement</h3>
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nom complet</label>
                            <input type="text" name="name" placeholder="Votre nom complet" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="votre@email.com" required>
                        </div>
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="tel" name="phone" placeholder="+229 XX XX XX XX" required>
                        </div>
                        <div class="form-group">
                            <label>Montant</label>
                            <input type="number" id="amount-input-don" name="amount" placeholder="Montant en FCFA" required>
                        </div>
                        <div class="form-group">
                            <label>Fréquence</label>
                            <select id="frequency-select-don" name="frequency">
                                <option value="ponctuel">Ponctuel</option>
                                <option value="mensuel">Mensuel</option>
                                <option value="trimestriel">Trimestriel</option>
                                <option value="semestriel">Semestriel</option>
                                <option value="annuel">Annuel</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Moyen de paiement</label>
                            <select name="payment_method">
                                <option>Carte bancaire</option>
                                <option>Mobile Money</option>
                                <option>Virement bancaire</option>
                            </select>
                        </div>
                        <button type="submit" class="submit-btn">Valider le paiement</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Abonnement Card -->
        <div class="support-card">
            <div class="card-header" onclick="togglePaymentForm('abonnement')">
                <h2>📖 Je m'abonne</h2>
            </div>
            <div class="card-body">
                <div class="info-box">
                    Je garantis l'indépendance de LCM Press, la clarté de l'information.
                </div>

                <div class="card-content">
                    <h3>En tant qu'abonné, vous avez accès à :</h3>
                    <ul>
                        <li>la Newsletter</li>
                        <li>le fil Telegram des Coulisses de LCM</li>
                        <li>le forum des abonnés</li>
                        <li>les FAQ avec l'équipe</li>
                        <li>des masterclass</li>
                        <li>des invitations aux émissions spéciales</li>
                    </ul>

                    <h3>Notre engagement</h3>
                    <p>LCM+ ne dépend d'aucune puissance publique, entreprise ni parti politique.</p>
                    <p>Notre seule force, c'est vous, lectrices et lecteurs qui croient en une presse libre et responsable.</p>

                    <div class="quote">
                        "Informer, c'est un acte citoyen. Soutenir, c'est un acte de liberté."
                    </div>

                    <button class="submit-btn" onclick="showPaymentForm('abonnement')">Je m'abonne</button>
                </div>

                <div class="payment-form" id="payment-form-abonnement">
                    <h3 style="margin-bottom: 1.5rem; color: #0D47A1;">Informations d'abonnement</h3>
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nom complet</label>
                            <input type="text" name="name" placeholder="Votre nom complet" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="votre@email.com" required>
                        </div>
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="tel" name="phone" placeholder="+229 XX XX XX XX" required>
                        </div>
                        <div class="form-group">
                            <label>Type d'abonnement</label>
                            <select name="subscription_type">
                                <option value="monthly">Mensuel - 2 000 FCFA/mois</option>
                                <option value="quarterly">Trimestriel - 5 000 FCFA/3 mois</option>
                                <option value="yearly">Annuel - 15 000 FCFA/an</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Moyen de paiement</label>
                            <select name="payment_method">
                                <option>Carte bancaire</option>
                                <option>Mobile Money</option>
                                <option>Virement bancaire</option>
                            </select>
                        </div>
                        <button type="submit" class="submit-btn">Valider l'abonnement</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Gestion des montants
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const amount = this.dataset.amount;
            if (amount !== 'custom') {
                document.getElementById('amount-input-don').value = amount;
            } else {
                document.getElementById('amount-input-don').value = '';
                document.getElementById('amount-input-don').focus();
            }
        });
    });

    // Gestion des fréquences
    document.querySelectorAll('.frequency-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.frequency-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const frequency = this.dataset.frequency;
            document.getElementById('frequency-select-don').value = frequency;
        });
    });

    // Affichage des formulaires
    function showPaymentForm(type) {
        const form = document.getElementById(`payment-form-${type}`);
        form.classList.add('active');
        form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function togglePaymentForm(type) {
        const form = document.getElementById(`payment-form-${type}`);
        form.classList.toggle('active');
    }
</script>
@endpush
