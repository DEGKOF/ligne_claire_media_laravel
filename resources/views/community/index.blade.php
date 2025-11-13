@extends('layouts.frontend')

@section('title', 'LCM Communauté — la voix des contributeurs')
    <link rel="stylesheet" href="{{ asset('css/community.css') }}">

@section('content')

<div class="lcm-community-wrapper">
    <div class="lcm-community-container">
        <!-- Hero -->
        <div class="lcm-community-hero">
            <center>
                <h1><strong>LCM Communauté — La voix des contributeurs</strong></h1>
                <h2>Renforcer un journalisme indépendant</h2>
                <p style="max-width: 900px; margin: 0 auto 20px;"><strong>LCM Communauté</strong> est une initiative au service du journalisme libre, de l'engagement citoyen et du pluralisme médiatique.</p>
                <p style="max-width: 900px; margin: 0 auto 25px;">À l'intersection des médias, du numérique et de la société civile, nous soutenons toutes celles et ceux qui s'engagent à produire une information rigoureuse, inclusive et indépendante.</p>

                <div class="info-box">
                    <h3>Donner la parole à ceux qui pensent, agissent et observent</h3>
                    <p style="margin: 0; line-height: 1.7;">LCM Communauté est l'espace participatif de LCM Media, ouvert aux journalistes indépendants, auteurs, universitaires, experts et citoyens engagés désireux de partager leurs analyses, opinions et tribunes.</p>
                    <p style="margin: 12px 0 0; line-height: 1.7;">Nous croyons qu'une information plurielle, libre et éclairée se construit ensemble, au-delà des structures éditoriales traditionnelles. Chaque voix compte, chaque regard enrichit le débat public.</p>
                </div>

                <button class="lcm-comm-submit-btn2" id="lcmOpenModal">+ Soumettre un article</button>
            </center>
        </div>

        <!-- Section Notre Ambition -->
        <div class="lcm-ambition-section" style="margin-bottom: 40px;">
            <div class="panel">
                <h2 style="color: var(--comm-blue); margin: 0 0 20px; font-size: 24px; font-weight: 700;">Notre ambition</h2>
                <p style="margin-bottom: 15px; line-height: 1.7;">Nous œuvrons pour une presse véritablement <strong>indépendante et durable</strong>, en accompagnant les acteurs médiatiques sur :</p>
                <ul style="margin: 0 0 20px 20px; padding-left: 0; line-height: 1.9;">
                    <li style="margin-bottom: 10px;">le <strong>plan éditorial</strong>, pour garantir la qualité et la vérification des contenus ;</li>
                    <li style="margin-bottom: 10px;">le <strong>plan économique</strong>, pour bâtir des modèles viables et transparents ;</li>
                    <li style="margin-bottom: 10px;">le <strong>plan managérial</strong>, pour structurer les rédactions ;</li>
                    <li style="margin-bottom: 10px;">et le <strong>plan technique</strong>, en intégrant les outils numériques et les nouvelles technologies du journalisme.</li>
                </ul>
                <p style="margin: 20px 0 0; line-height: 1.7; font-size: 16px;">Notre objectif : <strong>donner les moyens de durer à ceux qui informent librement.</strong></p>

                <div style="background: linear-gradient(135deg, #f8fbff, #e8f1ff); border-radius: 12px; padding: 20px; margin-top: 25px; text-align: center;">
                    <p style="margin: 0; font-style: italic; color: var(--comm-blue-2); font-size: 17px; font-weight: 600;">"Informer, c'est exercer un acte de liberté.<br>LCM Communauté existe pour la protéger."</p>
                    <p style="margin: 8px 0 0; color: var(--comm-muted); font-size: 14px;">— LCM Média</p>
                </div>
            </div>
        </div>

        <!-- Section Ce que nous offrons -->
        <div class="lcm-offers-section" style="margin-bottom: 40px;">
            <div class="panel">
                <h2 style="color: var(--comm-blue); margin: 0 0 20px; font-size: 24px; font-weight: 700;">Ce que nous offrons</h2>
                <p style="margin-bottom: 20px; line-height: 1.7;">Un espace numérique moderne, simple et transparent où :</p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px;">
                    <div class="offer-card">
                        <h3>Publication</h3>
                        <p>Chaque contributeur peut <strong>publier</strong> des articles ou analyses (après validation éditoriale)</p>
                    </div>
                    <div class="offer-card">
                        <h3>Rémunération</h3>
                        <p>Certains contenus sont <strong>gratuits</strong>, d'autres <strong>premium</strong>, rémunérant directement l'auteur</p>
                    </div>
                    <div class="offer-card">
                        <h3>Soutien</h3>
                        <p>Les lecteurs peuvent <strong>soutenir les journalistes indépendants</strong> via un système de dons ou d'abonnement</p>
                    </div>
                    <div class="offer-card">
                        <h3>Transparence</h3>
                        <p>LCM Plus assure la <strong>modération, la mise en forme et la visibilité</strong> sur le site et les réseaux</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Comment ça marche -->
        <div class="lcm-howto-section" style="margin-bottom: 40px;">
            <div class="panel">
                <h2 style="color: var(--comm-blue); margin: 0 0 20px; font-size: 24px; font-weight: 700;">Comment ça marche ?</h2>
                <div style="display: grid; gap: 15px;">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div>
                            <h3>Inscription & validation</h3>
                            <p>du profil contributeur</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div>
                            <h3>Soumission d'un article</h3>
                            <p>(texte, images, sources, etc.)</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div>
                            <h3>Relecture éditoriale</h3>
                            <p>par l'équipe de LCM</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div>
                            <h3>Publication</h3>
                            <p>sur la plateforme</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">5</div>
                        <div>
                            <h3>Rémunération</h3>
                            <p>selon le modèle (gratuit / premium)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section CTA final -->
        <div class="cta-final">
            <h2><strong>LCM Communauté — La voix des contributeurs</strong></h2>
            <p style="margin: 0 0 10px; font-size: 16px; opacity: 0.95; position: relative; z-index: 1;">Publiez vos articles, analyses et tribunes sur la première plateforme béninoise d'expression journalistique indépendante.</p>
            <div style="margin-top: 25px; position: relative; z-index: 1;">
                <p style="margin: 0; font-size: 15px;">✓ Participez au débat.</p>
                <p style="margin: 5px 0 0; font-size: 15px;">✓ Faites entendre votre point de vue.</p>
                <p style="margin: 5px 0 20px; font-size: 15px;">✓ Recevez une part des revenus de vos publications.</p>
            </div>
            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; position: relative; z-index: 1;">
                <button class="lcm-comm-submit-btn" id="lcmOpenModal2" style="background: white; color: var(--comm-blue); margin-top: 0;">Rejoindre LCM Communauté</button>
                <a href="#published-articles" class="lcm-comm-submit-btn2" style="background: rgba(255,255,255,0.2); border: 2px solid white; margin-top: 0;">Découvrir les articles publiés</a>
            </div>
        </div>

        <!-- Grille des soumissions -->
        <h2 id="published-articles" style="color: var(--comm-blue); margin: 0 0 25px; font-size: 28px; font-weight: 700; text-align: center;">Articles publiés par la communauté</h2>
        <div class="lcm-submissions-grid">
            @forelse($submissions as $submission)
            <article class="lcm-submission-card">
                <a href="{{ route('community.show', $submission) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="lcm-submission-thumb">
                        @if($submission->image_path)
                            <img src="{{ Storage::url($submission->image_path) }}" alt="{{ $submission->title }}">
                        @else
                            Visuel
                        @endif
                    </div>
                    <div class="lcm-submission-body">
                        <div class="lcm-submission-meta">
                            <span class="lcm-submission-section">{{ $submission->section }}</span>
                            <span class="lcm-submission-access {{ $submission->access_type }}">
                                {{ $submission->access_type === 'premium' ? 'Premium' : 'Gratuit' }}
                            </span>
                        </div>
                        <h3>{{ $submission->title }}</h3>
                        <p class="lcm-submission-author">
                            par <strong>{{ $submission->user->prenom }} {{ $submission->user->nom }}</strong>
                            @if($submission->user->city)
                                • {{ $submission->user->city }}
                            @endif
                        </p>
                        <p class="lcm-submission-author my-2">
                            <span class="lcm-submission-status {{ $submission->status }}">
                                {{ $submission->status_label }}
                            </span>
                            • {{ $submission->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                </a>
            </article>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                <p style="color: var(--comm-muted);">Aucune soumission pour le moment. Soyez le premier à contribuer !</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($submissions->hasPages())
        <div style="display: flex; justify-content: center; margin: 40px 0;">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="lcm-modal-overlay" id="lcmModalOverlay">
    <div class="lcm-modal">
        <!-- Header -->
        <div class="lcm-modal-header">
            <h2 style="color: #0C2D57">Soumettre un article</h2>
            <button class="lcm-modal-close" id="lcmCloseModal" type="button">×</button>
        </div>

        <!-- Body -->
        <div class="lcm-modal-body">
            <form id="lcmSubmitForm">
                @csrf

                <div class="lcm-form-row">
                    <div class="lcm-form-group">
                        <label class="lcm-form-label">Nom & Prénom *</label>
                        <input type="text" name="name" class="lcm-form-input" placeholder="Ex. Awa Dossa"
                               value="{{ Auth::check() ? Auth::user()->prenom . ' ' . Auth::user()->nom : '' }}" required>
                    </div>
                    <div class="lcm-form-group">
                        <label class="lcm-form-label">Email *</label>
                        <input type="email" name="email" class="lcm-form-input" placeholder="Ex. awa@email.com"
                               value="{{ Auth::check() ? Auth::user()->email : '' }}"
                               {{ Auth::check() ? 'readonly' : '' }} required>
                    </div>
                </div>

                <div class="lcm-form-row">
                    <div class="lcm-form-group">
                        <label class="lcm-form-label">Téléphone (WhatsApp)</label>
                        <input type="tel" name="phone" class="lcm-form-input" placeholder="+229 ..."
                               value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                    </div>
                    <div class="lcm-form-group">
                        <label class="lcm-form-label">Ville / Commune</label>
                        <input type="text" name="city" class="lcm-form-input" placeholder="Ex. Cotonou"
                               value="{{ Auth::check() ? Auth::user()->city : '' }}">
                    </div>
                </div>

                <div class="lcm-form-group">
                    <label class="lcm-form-label">Titre de l'article *</label>
                    <input type="text" name="title" class="lcm-form-input" placeholder="Un titre clair et descriptif" required>
                </div>

                <div class="lcm-form-row">
                    <div class="lcm-form-group">
                        <label class="lcm-form-label">Rubrique *</label>
                        <select name="section" class="lcm-form-select" required>
                            <option value="Société">Société</option>
                            <option value="Économie">Économie</option>
                            <option value="Politique">Politique</option>
                            <option value="Tech & IA">Tech & IA</option>
                            <option value="Culture">Culture</option>
                            <option value="Environnement">Environnement</option>
                            <option value="Investigation">Investigation</option>
                        </select>
                    </div>
                    <div class="lcm-form-group">
                        <label class="lcm-form-label">Type d'accès *</label>
                        <div class="lcm-form-chips">
                            <span class="lcm-form-chip active" data-value="free">Gratuit</span>
                            <span class="lcm-form-chip" data-value="premium">Premium</span>
                        </div>
                        <input type="hidden" name="access_type" value="free" id="lcmAccessType">
                    </div>
                </div>

                <div class="lcm-form-group">
                    <label class="lcm-form-label">Résumé *</label>
                    <textarea name="summary" class="lcm-form-textarea" rows="5"  placeholder="Collez ici votre texte ou décrivez votre sujet..." required></textarea>
                    <div class="lcm-form-hint">Les sources et chiffres renforcent vos chances d'être publiés</div>
                </div>

                <div class="lcm-form-group">
                    <label class="lcm-form-label">Contenu *</label>
                    <textarea name="content" class="lcm-form-textarea" rows="15" placeholder="Collez ici votre texte ou décrivez votre sujet..." required></textarea>
                    <div class="lcm-form-hint">Les sources et chiffres renforcent vos chances d'être publiés</div>
                </div>

                <div class="lcm-form-group">
                    <label class="lcm-form-label">Image (optionnel)</label>
                    <input type="file" name="image" class="lcm-form-input" accept="image/*">
                    <div class="lcm-form-hint">JPG, PNG, WebP - Max 5 Mo</div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="lcm-modal-footer">
            <small style="color: var(--comm-muted); font-size: 12px;">En envoyant, vous acceptez la charte LCM Communauté</small>
            <button class="lcm-btn lcm-btn-primary btn primary" id="lcmSubmitBtn">Envoyer</button>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="lcm-toast" id="lcmToast"></div>

<script>
(function() {
    'use strict';

    const modal = document.getElementById('lcmModalOverlay');
    const openBtn = document.getElementById('lcmOpenModal');
    const openBtn2 = document.getElementById('lcmOpenModal2');
    const closeBtn = document.getElementById('lcmCloseModal');
    const form = document.getElementById('lcmSubmitForm');
    const submitBtn = document.getElementById('lcmSubmitBtn');
    const toast = document.getElementById('lcmToast');

    // Ouvrir/fermer modal
    openBtn.addEventListener('click', () => {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    // Deuxième bouton d'ouverture
    if (openBtn2) {
        openBtn2.addEventListener('click', () => {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    const closeModal = () => {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    };

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Chips access_type
    document.querySelectorAll('.lcm-form-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            document.querySelectorAll('.lcm-form-chip').forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            document.getElementById('lcmAccessType').value = chip.dataset.value;
        });
    });

    // Toast
    function showToast(message, duration = 3000) {
        toast.textContent = message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), duration);
    }

    // Soumission
    submitBtn.addEventListener('click', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const originalText = submitBtn.textContent;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="lcm-loader"></span> Envoi...';

        try {
            const response = await fetch('{{ route("community.submit") }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const data = await response.json();

            if (data.success) {
                showToast('✅ ' + data.message, 4000);
                form.reset();
                document.getElementById('lcmAccessType').value = 'free';
                document.querySelectorAll('.lcm-form-chip').forEach(c => c.classList.remove('active'));
                document.querySelector('.lcm-form-chip[data-value="free"]').classList.add('active');
                closeModal();

                setTimeout(() => location.reload(), 2000);
            } else {
                const errors = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
                showToast('❌ ' + errors, 5000);
            }
        } catch (error) {
            console.error(error);
            showToast('❌ Une erreur est survenue', 4000);
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });

})();
</script>
@endsection
