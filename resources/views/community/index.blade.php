@extends('layouts.frontend')

@section('title', 'LCM Communauté — la voix des contributeurs')

@section('content')
<style>
/* Styles isolés pour la communauté */
.lcm-community-wrapper {
    --comm-blue: #0C2D57;
    --comm-blue-2: #184178;
    --comm-accent: #FFD54F;
    --comm-bg: #f6f8fb;
    --comm-text: #1f2630;
    --comm-muted: #6c7a8a;
    --comm-ok: #2fa66a;
    --comm-warn: #ff9f40;
    --comm-danger: #e05263;
    --comm-border: #e7edf5;
    padding: 40px 0;
    background: var(--comm-bg);
}

.lcm-community-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Hero */
.lcm-community-hero {
    background: linear-gradient(180deg, #fff, #f8fbff);
    padding: 50px 20px 30px;
    border-radius: 16px;
    margin-bottom: 40px;
    border: 1px solid var(--comm-border);
}

.lcm-community-hero h1 {
    font-size: 36px;
    color: var(--comm-blue);
    margin: 0 0 15px;
}

.lcm-community-hero p {
    font-size: 18px;
    color: #425060;
    max-width: 800px;
    line-height: 1.6;
}

.lcm-comm-submit-btn {
    display: inline-block;
    background: var(--comm-blue);
    color: white !important;
    padding: 14px 24px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 16px;
    border: none;
    cursor: pointer;
    margin-top: 20px;
    transition: all 0.2s;
    text-decoration: none;
}

.lcm-comm-submit-btn:hover {
    background: var(--comm-blue-2);
    transform: translateY(-2px);
    color: white !important;
}

/* Grille des soumissions */
.lcm-submissions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    margin: 40px 0;
}

.lcm-submission-card {
    background: white;
    border: 1px solid var(--comm-border);
    border-radius: 14px;
    overflow: hidden;
    transition: all 0.3s;
}

.lcm-submission-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(12, 45, 87, 0.1);
}

.lcm-submission-thumb {
    height: 180px;
    background: #dfe8f5;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #5e738f;
    font-weight: 700;
    overflow: hidden;
}

.lcm-submission-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.lcm-submission-body {
    padding: 18px;
}

.lcm-submission-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    gap: 10px;
    flex-wrap: wrap;
}

.lcm-submission-section {
    background: var(--comm-bg);
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    color: #4a596d;
}

.lcm-submission-access {
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
}

.lcm-submission-access.free {
    color: var(--comm-ok);
    background: #e8f5f0;
}

.lcm-submission-access.premium {
    color: #b25b00;
    background: #fff4e6;
}

.lcm-submission-status {
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
}

.lcm-submission-status.pending {
    color: var(--comm-warn);
    background: #fff3e0;
}

.lcm-submission-status.validated {
    color: var(--comm-ok);
    background: #e8f5f0;
}

.lcm-submission-status.rejected {
    color: var(--comm-danger);
    background: #fee;
}

.lcm-submission-card h3 {
    font-size: 17px;
    margin: 0 0 10px;
    color: var(--comm-text);
    line-height: 1.4;
}

.lcm-submission-author {
    font-size: 13px;
    color: var(--comm-muted);
}

/* Modal central */
.lcm-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 999999;
    padding: 20px;
    overflow-y: auto;
}

.lcm-modal-overlay.active {
    display: flex !important;
}

.lcm-modal {
    background: white;
    border-radius: 16px;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: lcmModalSlideIn 0.3s ease;
}

@keyframes lcmModalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.lcm-modal-header {
    padding: 24px;
    border-bottom: 1px solid var(--comm-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--comm-blue);
    color: white;
    border-radius: 16px 16px 0 0;
    flex-shrink: 0;
}

.lcm-modal-header h2 {
    margin: 0;
    font-size: 20px;
}

.lcm-modal-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.lcm-modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

.lcm-modal-body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
}

.lcm-modal-footer {
    padding: 20px 24px;
    border-top: 1px solid var(--comm-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
    background: #fafcff;
}

/* Formulaire */
.lcm-form-group {
    margin-bottom: 18px;
}

.lcm-form-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #425060;
    margin-bottom: 6px;
}

.lcm-form-input,
.lcm-form-select,
.lcm-form-textarea {
    width: 100%;
    padding: 12px;
    border: 1.6px solid #d7e1ee;
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    transition: border-color 0.2s;
}

.lcm-form-input:focus,
.lcm-form-select:focus,
.lcm-form-textarea:focus {
    outline: none;
    border-color: var(--comm-blue);
}

.lcm-form-textarea {
    min-height: 120px;
    resize: vertical;
}

.lcm-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.lcm-form-hint {
    font-size: 12px;
    color: #7787a1;
    margin-top: 4px;
}

.lcm-form-chips {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.lcm-form-chip {
    padding: 8px 16px;
    border-radius: 999px;
    background: #eef3f9;
    border: 2px solid #e0e9f6;
    color: #3d4b5f;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}

.lcm-form-chip:hover {
    background: #dfe8f5;
}

.lcm-form-chip.active {
    border-color: var(--comm-blue);
    background: #e0ecff;
    color: var(--comm-blue);
    font-weight: 600;
}

.lcm-btn {
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
}

.lcm-btn-primary {
    background: var(--comm-blue) !important;
    /* color: white; */
    border: 1px solid var(--comm-blue) !important;
}

.lcm-btn-primary:hover {
    background: var(--comm-blue-2);
}

.lcm-btn-secondary {
    background: transparent;
    border: 2px solid #d7e1ee;
    color: var(--comm-text);
}

.lcm-btn-secondary:hover {
    background: #f5f7fa;
}

/* Toast */
.lcm-toast {
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    background: #111827;
    color: white;
    padding: 14px 20px;
    border-radius: 999px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    z-index: 9999999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s;
}

.lcm-toast.show {
    opacity: 1;
}

/* Panel mes soumissions */
.lcm-my-submissions {
    background: white;
    border: 1px solid var(--comm-border);
    border-radius: 14px;
    padding: 24px;
    margin: 40px 0;
}

.lcm-my-submissions h3 {
    color: var(--comm-blue);
    margin: 0 0 20px;
    font-size: 18px;
}

.lcm-my-submission-item {
    padding: 16px;
    background: #fafcff;
    border: 1px solid var(--comm-border);
    border-radius: 10px;
    margin-bottom: 12px;
}

.lcm-my-submission-item:last-child {
    margin-bottom: 0;
}

/* Loader */
.lcm-loader {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid white;
    border-radius: 50%;
    animation: lcmSpin 0.8s linear infinite;
}

@keyframes lcmSpin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .lcm-community-hero h1 {
        font-size: 28px;
    }

    .lcm-community-hero p {
        font-size: 16px;
    }

    .lcm-submissions-grid {
        grid-template-columns: 1fr;
    }

    .lcm-form-row {
        grid-template-columns: 1fr;
    }

    .lcm-modal {
        max-width: 100%;
        max-height: 100vh;
        border-radius: 0;
    }

    .lcm-modal-header {
        border-radius: 0;
    }
}
</style>

<div class="lcm-community-wrapper">
    <div class="lcm-community-container">
        <!-- Hero -->
        <div class="lcm-community-hero">
            <center>
                <h1>Publiez vos tribunes, enquêtes et analyses</h1>
                <p>Journalistes, intellectuels, citoyens : proposez vos contenus à la rédaction. Chaque article est relu, vérifié et publié sous votre signature. Les meilleurs contenus peuvent être <strong>Premium</strong> (rémunérés au partage de revenus).</p>
                <button class="lcm-comm-submit-btn" id="lcmOpenModal">+ Soumettre un article</button>
            </center>
        </div>

        <!-- Grille des soumissions -->
        <div class="lcm-submissions-grid">
            @forelse($submissions as $submission)
            <article class="lcm-submission-card">
<a href="{{ route('community.show', $submission) }}" class="lcm-submission-card" style="text-decoration: none; color: inherit; display: block;">
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

        <!-- Mes soumissions (si connecté) -->
        @if(Auth::check())
        <div class="lcm-my-submissions">
            <h3>🗂️ Mes soumissions</h3>
            <div id="lcmMySubmissionsList">
                <p style="color: var(--comm-muted); font-size: 14px;">Chargement...</p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="lcm-modal-overlay" id="lcmModalOverlay">
    <div class="lcm-modal">
        <!-- Header -->
        <div class="lcm-modal-header">
            <h2>✍️ Soumettre un article</h2>
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
                    <label class="lcm-form-label">Contenu / Résumé *</label>
                    <textarea name="summary" class="lcm-form-textarea" placeholder="Collez ici votre texte ou décrivez votre sujet..." required></textarea>
                    <div class="lcm-form-hint">💡 Les sources et chiffres renforcent vos chances d'être publiés</div>
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
    const closeBtn = document.getElementById('lcmCloseModal');
    const form = document.getElementById('lcmSubmitForm');
    const submitBtn = document.getElementById('lcmSubmitBtn');
    const toast = document.getElementById('lcmToast');

    // Ouvrir/fermer modal
    openBtn.addEventListener('click', () => {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

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

                @if(Auth::check())
                    loadMySubmissions();
                @endif

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

    // Charger mes soumissions
    @if(Auth::check())
    async function loadMySubmissions() {
        try {
            const response = await fetch('{{ route("community.my-submissions") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ email: '{{ Auth::user()->email }}' })
            });

            const data = await response.json();
            const container = document.getElementById('lcmMySubmissionsList');

            if (data.success && data.submissions.length > 0) {
                container.innerHTML = data.submissions.map(item => `
                    <div class="lcm-my-submission-item">
                        <strong style="color: var(--comm-blue);">${item.section}</strong> — "${item.title}"
                        <span class="lcm-submission-status ${item.status}">${item.status_label}</span>
                        <div style="font-size: 13px; color: var(--comm-muted); margin-top: 8px;">
                            ${item.created_at} • ${item.access_type === 'premium' ? 'Premium' : 'Gratuit'}
                            ${item.rejection_reason ? '<br>Raison: ' + item.rejection_reason : ''}
                        </div>
                    </div>
                `).join('');
            } else {
                container.innerHTML = '<p style="color: var(--comm-muted); font-size: 14px;">Aucune soumission pour le moment.</p>';
            }
        } catch (error) {
            console.error(error);
        }
    }

    loadMySubmissions();
    @endif
})();
</script>
@endsection
