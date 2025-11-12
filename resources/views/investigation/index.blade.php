@extends('layouts.frontend')

@section('title', 'LCM Investigation — Enquêter, révéler, comprendre')

    <link rel="stylesheet" href="{{ asset('css/investigation.css') }}">
@section('content')
    <section class="hero">
        <center>
        <div class="container">
            <h1><strong>Le pôle d'enquêtes d'intérêt public de LCM +</strong></h1>
            <p>Cellule dédiée à l'investigation numérique en Afrique francophone. Rédaction interne, pigistes et partenaires
                (ONG, collectifs, citoyens) mènent des enquêtes validées par la direction éditoriale et diffusées en
                <strong>article long</strong>, <strong>vidéo</strong>, <strong>podcast</strong> et
                <strong>infographie</strong>.
            </p>
            <center>
                <div class="badges">
                    <span class="pill">Sources vérifiées</span>
                    <span class="pill">Droit de réponse</span>
                    <span class="pill">Protection des lanceurs</span>
                    <span class="pill">Méthode transparente</span>
                </div>
            </center>
        </div>
        </center>
    </section>

    <div class="subnav">
        <center>
            <div class="container">
                <button class="tab active" data-tab="overview">Présentation</button>
                <button class="tab" data-tab="projects">Enquêtes en cours</button>
                <button class="tab" data-tab="submit">Proposer une enquête</button>
            </div>
        </center>
    </div>

    <!-- Présentation -->
    <section id="overview" class="section active">
        <div class="container">
            <div class="panel" style="margin-bottom:20px">
                <header>Notre mission</header>
                <div class="body">
                    <h3 style="margin:0 0 12px;color:var(--blue);font-size:18px;font-weight:700">Révéler ce que d'autres cachent</h3>
                    <p style="margin-bottom:12px;line-height:1.7">Dans un monde saturé par le désastre de la propagande, les fake news, la désinformation et les scandales étouffés, la frontière entre vérité et mensonge n'a jamais été aussi fragile. Dans un pays où une grande partie des médias défend les intérêts d'une minorité, où la surenchère autoritaire du pouvoir semble ne plus avoir de limites, il devient vital de protéger la liberté d'informer et de restaurer la confiance du public dans le journalisme.</p>
                    <p style="margin-bottom:12px;font-style:italic;line-height:1.7">Parce qu'un peuple sans presse libre, c'est un peuple sans regard sur lui-même.</p>
                    <p style="margin-bottom:12px;line-height:1.7">C'est dans cet esprit que nous avons créé <strong>LCM Investigation</strong> — un média numérique indépendant, animé par la conviction que <strong>la vérité ne se négocie pas</strong>.</p>
                    <p style="line-height:1.7">Portée par une <strong>équipe soudée et passionnée</strong>, complétée par des <strong>journalistes reconnus pour leur intégrité et leur courage</strong>, <strong>LCM Investigation</strong> se consacre à <strong>l'enquête d'intérêt public</strong>, à <strong>l'analyse critique</strong> et à <strong>la révélation des faits que d'autres préfèrent taire</strong>.</p>
                </div>
            </div>

            <div class="panel" style="margin-bottom:20px">
                <header>Notre champ d'action</header>
                <div class="body">
                    <p style="margin-bottom:12px;line-height:1.7">Nos enquêtes s'étendent sur les grands enjeux de notre temps :</p>
                    <ul style="margin:0 0 16px;padding-left:20px;line-height:1.9">
                        <li>la <strong>corruption</strong> et les abus de pouvoir,</li>
                        <li>la <strong>gouvernance</strong> et la transparence publique,</li>
                        <li>l'<strong>écologie</strong> et la crise environnementale,</li>
                        <li>l'<strong>économie</strong> et les inégalités,</li>
                        <li>la <strong>justice</strong>, la <strong>santé</strong>, <strong>éducation</strong>, et les <strong>luttes sociales</strong>,</li>
                        <li>mais aussi l'<strong>égalité des chances</strong>, l'<strong>innovation</strong>, la <strong>géopolitique</strong> et la <strong>culture</strong>.</li>
                    </ul>
                    <p style="line-height:1.7">Nous explorons ces thématiques à travers des <strong>reportages de terrain</strong>, des <strong>chroniques</strong>, des <strong>documentaires</strong>, des <strong>lives</strong> et des <strong>entretiens exclusifs</strong> — accessibles à tous sur nos plateformes numériques.</p>
                </div>
            </div>

            <div class="panel" style="margin-bottom:20px">
                <header>Notre ambition</header>
                <div class="body">
                    <p style="margin-bottom:12px;line-height:1.7">Faire de <strong>LCM Investigation</strong> un acteur majeur du <strong>journalisme d'impact</strong> en Afrique francophone. Nos enquêtes sont conçues non seulement pour informer, mais pour <strong>réveiller les consciences</strong>, <strong>stimuler le débat public</strong> et <strong>inciter à l'action collective</strong>.</p>
                    <p style="margin-bottom:8px;font-style:italic;line-height:1.7">Parce qu'informer, c'est d'abord comprendre.</p>
                    <p style="line-height:1.7">Et comprendre, c'est déjà commencer à agir.</p>
                </div>
            </div>

            <div class="panel">
                <header>Comment nous travaillons</header>
                <div class="body">
                    <p style="margin-bottom:16px;line-height:1.7">LCM Investigation repose sur un modèle <strong>collaboratif et numérique</strong>, associant journalistes permanents, pigistes, collectifs indépendants et citoyens enquêteurs.</p>

                    <ol style="margin:0;padding-left:20px;line-height:1.8">
                        <li style="margin-bottom:14px">
                            <strong>Proposition d'enquête</strong><br>
                            <span style="color:var(--muted);font-size:15px">Journalistes internes, pigistes ou partenaires peuvent soumettre un projet d'enquête.</span>
                        </li>
                        <li style="margin-bottom:14px">
                            <strong>Validation éditoriale</strong><br>
                            <span style="color:var(--muted);font-size:15px">La direction éditoriale évalue chaque sujet selon son <strong>intérêt public</strong>, sa <strong>pertinence</strong> et sa <strong>faisabilité</strong>.</span>
                        </li>
                        <li style="margin-bottom:14px">
                            <strong>Enquête de terrain et vérification</strong><br>
                            <span style="color:var(--muted);font-size:15px">Collecte de preuves, recoupement des sources, travail de terrain et d'analyse documentaire.</span>
                        </li>
                        <li style="margin-bottom:14px">
                            <strong>Production multimédia</strong><br>
                            <span style="color:var(--muted);font-size:15px">Chaque enquête est publiée sous plusieurs formats : <strong>article long</strong>, <strong>vidéo</strong>, <strong>podcast</strong>, <strong>infographie</strong>, <strong>fil social</strong>.</span>
                        </li>
                        <li>
                            <strong>Diffusion & impact</strong><br>
                            <span style="color:var(--muted);font-size:15px">Les enquêtes validées sont diffusées sur <strong>LCM+</strong>, les <strong>réseaux sociaux</strong> et nos <strong>partenaires médias</strong>.</span>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="panel" style="margin-top:20px">
                <header>Nos valeurs</header>
                <div class="body">
                    <ul style="margin:0 0 20px;padding-left:20px;line-height:1.8">
                        <li style="margin-bottom:10px">
                            <strong>Indépendance absolue</strong> : aucune influence politique, commerciale ou institutionnelle.
                        </li>
                        <li style="margin-bottom:10px">
                            <strong>Rigueur et vérification</strong> : chaque information publiée est recoupée, sourcée et validée.
                        </li>
                        <li style="margin-bottom:10px">
                            <strong>Protection des sources</strong> : confidentialité totale garantie par LCM+.
                        </li>
                        <li>
                            <strong>Journalisme d'impact</strong> : nos enquêtes ne s'arrêtent pas à la publication — elles cherchent à changer les choses.
                        </li>
                    </ul>

                    <div style="margin:24px 0;padding:20px;background:var(--sky);border-left:5px solid var(--blue-3);border-radius:8px">
                        <p style="margin:0 0 6px;font-weight:700;font-size:16px;color:var(--blue)">Nous ne faisons pas du bruit.</p>
                        <p style="margin:0;font-weight:700;font-size:16px;color:var(--blue)">Nous faisons la lumière.</p>
                    </div>

                    <div style="margin-top:30px;text-align:center">

                        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:20px">
                            <button class="btn primary" onclick="document.querySelector('[data-tab=projects]').click()">Explorer les enquêtes</button>
                            <button class="btn secondary" onclick="document.querySelector('[data-tab=submit]').click()">Proposer une enquête</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enquêtes en cours -->
    <section id="projects" class="section">
        <div class="container">
            <div class="panel">
                <header>Enquêtes en cours de validation ou d'investigation</header>
                <div class="body">
                    <div class="pro grid" id="projectGrid">
                        @forelse($proposals as $proposal)
                            <div class="card">
                                <div class="media">{{ strtoupper(substr($proposal->theme, 0, 1)) }}</div>
                                <div class="content">
                                    <div class="meta">
                                        <span class="pill">{{ $proposal->format }}</span>
                                        <span class="status {{ $proposal->status }}">
                                            @if ($proposal->status === 'pending')
                                                En validation
                                            @elseif($proposal->status === 'validated')
                                                Validé
                                            @elseif($proposal->status === 'in_progress')
                                                En cours
                                            @elseif($proposal->status === 'completed')
                                                Terminé
                                            @else
                                                Rejeté
                                            @endif
                                        </span>
                                    </div>
                                    <h3 style="margin:0 0 6px">{{ $proposal->title }}</h3>
                                    <p class="legend" style="margin:0">{{ Str::limit($proposal->angle, 100) }}</p>

                                    @if ($proposal->budget && $proposal->budget > 0)
                                        <div class="progress">
                                            <div
                                                style="width:{{ min(100, round(($proposal->budget_collected / $proposal->budget) * 100)) }}%">
                                            </div>
                                        </div>
                                        <div class="meta" style="margin-top:6px">
                                            <span class="legend">Objectif
                                                {{ number_format($proposal->budget, 0, ',', ' ') }} FCFA</span>
                                            <span><strong>{{ number_format($proposal->budget_collected, 0, ',', ' ') }}
                                                    FCFA</strong> collectés</span>
                                        </div>
                                    @endif

                                    <div class="actions" style="justify-content:flex-start;margin-top:10px">
                                        <button class="btn secondary"
                                            onclick="showProposalDetails({{ $proposal->id }})">Voir le dossier</button>
                                        @if ($proposal->status === 'validated' || $proposal->status === 'in_progress')
                                            <button class="btn warn"
                                                onclick="supportProposal({{ $proposal->id }})">Soutenir</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="grid-column:span 12;text-align:center;padding:40px">
                                <p class="legend">Aucune enquête en cours pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Proposer une enquête -->
    <section id="submit" class="section">
        <div class="container">
            <div class="panel">
                <header>Proposer une enquête</header>
                <div class="body">
                    <form id="proposalForm" class="form" method="POST" action="{{ route('investigation.submit') }}">
                        @csrf
                        <div id="fName" class="field">
                            <label class="label">Nom & Prénom *</label>
                            <input type="text" name="name" id="aName" class="input"
                                placeholder="Ex. Jean Dupont" required minlength="3" maxlength="120">
                            <span class="error">Nom requis (3-120 caractères)</span>
                        </div>
                        <div id="fEmail" class="field">
                            <label class="label">Email *</label>
                            <input type="email" name="email" id="aEmail" class="input"
                                placeholder="Ex. jean@email.com" required>
                            <span class="error">Email valide requis</span>
                        </div>
                        <div class="field">
                            <label class="label">Téléphone</label>
                            <input type="tel" name="phone" class="input" placeholder="+229 ...">
                        </div>
                        <div class="field">
                            <label class="label">Ville</label>
                            <input type="text" name="city" class="input" placeholder="Ex. Cotonou">
                        </div>
                        <div id="fTitle" class="field" style="grid-column:span 2">
                            <label class="label">Titre de l'enquête (10-140 caractères) *</label>
                            <div class="control">
                                <input type="text" name="title" id="aTitle" class="input"
                                    placeholder="Un titre clair et descriptif" required minlength="10" maxlength="140">
                                <span class="counter" id="cTitle">0/140</span>
                            </div>
                            <span class="error">Titre requis (10-140 caractères)</span>
                        </div>
                        <div class="field">
                            <label class="label">Thème *</label>
                            <select name="theme" id="aTheme" class="select" required>
                                <option value="">Choisir un thème</option>
                                <option value="Corruption">Corruption</option>
                                <option value="Environnement">Environnement</option>
                                <option value="Santé publique">Santé publique</option>
                                <option value="Droits humains">Droits humains</option>
                                <option value="Économie souterraine">Économie souterraine</option>
                                <option value="Politique">Politique</option>
                                <option value="Technologie">Technologie</option>
                            </select>
                        </div>
                        <div class="field">
                            <label class="label">Format souhaité *</label>
                            <select name="format" id="aFormat" class="select" required>
                                <option value="Article long">Article long</option>
                                <option value="Vidéo">Vidéo</option>
                                <option value="Podcast">Podcast</option>
                                <option value="Infographie">Infographie</option>
                                <option value="Série multimédia">Série multimédia</option>
                            </select>
                        </div>
                        <div id="fAngle" class="field" style="grid-column:span 2">
                            <label class="label">Angle journalistique (30-1200 caractères) *</label>
                            <div class="control">
                                <textarea name="angle" id="aAngle" class="textarea"
                                    placeholder="Décrivez l'angle, les questions centrales, le contexte..." required minlength="30" maxlength="1200"></textarea>
                                <span class="counter" id="cAngle">0/1200</span>
                            </div>
                            <span class="hint">Expliquez pourquoi cette enquête est importante et quelle est votre
                                approche.</span>
                            <span class="error">Angle requis (30-1200 caractères)</span>
                        </div>
                        <div class="field" style="grid-column:span 2">
                            <label class="label">Sources disponibles (optionnel)</label>
                            <div class="control">
                                <textarea name="sources" id="aSources" class="textarea" placeholder="Décrivez vos sources, documents, contacts..."
                                    maxlength="1600"></textarea>
                                <span class="counter" id="cSources">0/1600</span>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Budget estimé (FCFA)</label>
                            <input type="number" name="budget" id="aBudget" class="input"
                                placeholder="Ex. 5000000" min="0" max="999999999">
                        </div>
                        <div class="field">
                            <label class="label">Durée estimée (semaines)</label>
                            <input type="number" name="estimated_weeks" id="aWeeks" class="input"
                                placeholder="Ex. 8" min="1" max="52">
                        </div>
                        <div class="field" style="grid-column:span 2">
                            <label class="label">Besoins spécifiques</label>
                            <textarea name="needs" id="aNeeds" class="textarea"
                                placeholder="Décrivez vos besoins matériels, logistiques, humains..." maxlength="1000"></textarea>
                        </div>
                        <div class="field" style="grid-column:span 2">
                            <label class="label">Fichiers joints (max 10 Mo par fichier)</label>
                            <div class="upload" id="dropzone">
                                <input type="file" name="files[]" id="aFiles" multiple
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <p>📎 Glissez vos fichiers ici ou <strong>cliquez pour parcourir</strong></p>
                                <p class="legend" id="filesList">Aucun fichier sélectionné.</p>
                            </div>
                        </div>
                        <div class="actions" style="grid-column:span 2">
                            <button type="button" class="btn ghost" id="btnDraft">Enregistrer le brouillon</button>
                            <button type="submit" class="btn primary">Envoyer la proposition</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact -->
    <section id="impact" class="section">
        <div class="container">
            <div class="panel">
                <header>📈 Impact des enquêtes passées</header>
                <div class="body">
                    <p class="legend" style="text-align:center;padding:40px">Section en construction. Les premières
                        enquêtes publiées apparaîtront ici avec leurs impacts (réformes, poursuites, changements de
                        politique...).</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Guide -->
    <div class="guide-modal" id="modalGuide">
        <div class="guide-modal-container">
            <div class="guide-modal-header">
                <h2 class="guide-modal-title">Guide éditorial — LCM Investigation</h2>
                <button class="btn ghost" onclick="closeModal()">Fermer</button>
            </div>

            <div class="guide-modal-body">
                <div class="guide-section">
                    <h3 class="guide-section-title">Principes</h3>
                    <ul class="guide-list">
                        <li>Indépendance, transparence et droit de réponse</li>
                        <li>Protection renforcée des sources (chiffrement, anonymisation)</li>
                        <li>Vérification multi-sources, traçabilité des preuves</li>
                    </ul>
                </div>

                <div class="guide-section">
                    <h3 class="guide-section-title">Procédure</h3>
                    <ol class="guide-list">
                        <li>Pitch & angle validés par la direction</li>
                        <li>Feuille de route : méthodo, planning, budget</li>
                        <li>Collecte des preuves, confrontation, droit de réponse</li>
                        <li>Comité éditorial : validation & plan de diffusion</li>
                    </ol>
                </div>

                <div class="guide-section">
                    <h3 class="guide-section-title">Méthodologie</h3>
                    <p class="guide-text">Toute enquête suit un protocole rigoureux : vérification des sources, croisement
                        des informations, droit de réponse, relecture par un comité éditorial.</p>
                </div>
            </div>
        </div>
    </div>

<script>
    const userEmail = @json($userEmail ?? null);

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type}`;
        notification.innerHTML = `<span>${message}</span><button class="alert-close" onclick="this.parentElement.remove()">×</button>`;

        let container = document.getElementById('notification-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'notification-container';
            document.body.appendChild(container);
        }

        container.appendChild(notification);
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }

    document.querySelectorAll('.tab').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(target).classList.add('active');
        });
    });

    const counters = [
        {el: '#aTitle', c: '#cTitle', max: 140},
        {el: '#aAngle', c: '#cAngle', max: 1200},
        {el: '#aSources', c: '#cSources', max: 1600}
    ];
    counters.forEach(({el, c, max}) => {
        const input = document.querySelector(el);
        const counter = document.querySelector(c);
        const update = () => counter.textContent = `${(input.value || '').length}/${max}`;
        input.addEventListener('input', update);
        update();
    });

    function validate() {
        const name = document.querySelector('#aName').value.trim();
        const email = document.querySelector('#aEmail').value.trim();
        const title = document.querySelector('#aTitle').value.trim();
        const angle = document.querySelector('#aAngle').value.trim();
        return name.length >= 3 && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) && title.length >= 10 && angle.length >= 30;
    }

    document.getElementById('btnDraft').addEventListener('click', () => {
        showNotification('Brouillon enregistré', 'success');
    });

    const dz = document.querySelector('#dropzone');
    const inputFiles = document.querySelector('#aFiles');
    const filesList = document.querySelector('#filesList');
    dz.addEventListener('click', () => inputFiles.click());
    inputFiles.addEventListener('change', () => {
        const f = [...inputFiles.files];
        filesList.textContent = f.length ? f.map(x => `${x.name} (${Math.round(x.size/1024)} Ko)`).join(' • ') : 'Aucun fichier sélectionné.';
    });

    document.getElementById('proposalForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        e.stopPropagation();

        if (!validate()) {
            showNotification('Veuillez corriger les champs en rouge', 'error');
            return false;
        }

        const formData = new FormData(e.target);
        const submitBtn = e.target.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Envoi en cours...';

        try {
            const response = await fetch('{{ route("investigation.submit") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            let data = {};
            try {
                data = await response.json();
            } catch (err) {
                data = {success: true, message: 'Proposition soumise avec succès !'};
            }

            if (response.ok || data.success) {
                showNotification(data.message || 'Proposition soumise !', 'success');
                e.target.reset();
                filesList.textContent = 'Aucun fichier sélectionné.';
                counters.forEach(({c}) => document.querySelector(c).textContent = document.querySelector(c).textContent.replace(/^\d+/, '0'));
            } else {
                showNotification(data.message || 'Erreur lors de la soumission', 'error');
            }
        } catch (error) {
            showNotification('Erreur réseau. Réessayez.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Envoyer la proposition';
        }

        return false;
    });

    function showProposalDetails(id) { console.log('Details:', id); }
    function supportProposal(id) { console.log('Support:', id); }
    function openModal() { document.getElementById('modalGuide').classList.add('open'); }
    function closeModal() { document.getElementById('modalGuide').classList.remove('open'); }
</script>
@endsection
