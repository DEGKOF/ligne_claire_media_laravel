@extends('layouts.frontend')

@section('title', 'LCM TÉMOINS — Vous êtes nos yeux, nos oreilles, notre vérité')

@section('content')
    <style>
        ol, ul, menu {
            all: revert;
        }

        :root {
            --ink: #0e1116;
            --bg: #F6F8FC;
            --card: #fff;
            --line: #E6EEF8;
            --blue: #0B2B5A;
            --blue2: #1A4180;
            --blue3: #1E56B3;
            --sky: #E8F1FF;
            --accent: #FFC940;
            --muted: #5E6B7A;
            --green: #1FA37B;
            --red: #D94B4B;
            --warn: #B97400;
            --radius: 16px;
            --shadow: 0 12px 28px rgba(10, 35, 80, .10);
            --shadow-sm: 0 6px 18px rgba(10, 35, 80, .08);
            --focus: 0 0 0 4px rgba(30, 86, 179, .20);
        }

        * {
            box-sizing: border-box
        }

        .container {
            /* max-width: 1220px; */
            margin: 0 auto;
            /* padding: 0 22px */
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: linear-gradient(180deg, #fff, #fbfdff);
            border-bottom: 1px solid var(--line);
            box-shadow: var(--shadow-sm)
        }

        .topbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .logo {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background:
                conic-gradient(from 200deg at 50% 50%, #1E56B3 0deg, #0B2B5A 200deg, #1A4180 320deg);
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 900;
            letter-spacing: .4px;
            box-shadow: inset 0 0 10px rgba(255, 255, 255, .2)
        }

        .brand-title {
            font-weight: 900;
            letter-spacing: .2px
        }

        .tag {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 999px;
            background: var(--sky);
            color: var(--blue2);
            border: 1px solid var(--line)
        }

        .btn {
            border: 0;
            border-radius: 14px;
            padding: 12px 16px;
            font-weight: 800;
            cursor: pointer;
            transition: transform .05s ease, box-shadow .2s ease
        }

        .btn:active {
            transform: translateY(1px)
        }

        .btn.primary {
            background: var(--blue3);
            color: #fff;
            box-shadow: var(--shadow-sm)
        }

        .btn.secondary {
            background: #fff;
            color: var(--blue3);
            border: 2px solid var(--blue3)
        }

        .btn.warn {
            background: var(--accent);
            color: #5a3d00
        }

        .btn.ghost {
            background: #fff;
            border: 2px solid var(--line);
            color: #2b3e64
        }

        .btn.success {
            background: var(--green);
            color: #fff
        }

        .btn:focus {
            outline: none;
            box-shadow: var(--focus)
        }

        .hero {
            padding: 20px 0 28px;
            background: linear-gradient(180deg, #fff, #f8fbff);
            border-bottom: 1px solid var(--line)
        }

        .hero h1 {
            font-size: 42px;
            line-height: 1.15;
            margin: 8px 0 10px
        }

        .hero p {
            max-width: 880px;
            color: var(--muted);
            font-size: 18px
        }

        .badges {
            /* display: flex;
                gap: 10px;
                flex-wrap: wrap; */
            margin-top: 14px
        }

        .pill {
            padding: 6px 12px;
            border-radius: 999px;
            background: #F0F6FF;
            border: 1px solid var(--line);
            font-size: 12px;
            color: #223a67
        }

        .subnav {
            position: sticky;
            top: 70px;
            z-index: 40;
            background: #fff;
            border-bottom: 1px solid var(--line)
        }

        .subnav .container {
            /* display: flex;
                gap: 8px;
                flex-wrap: wrap; */
            padding: 10px 0
        }

        .tab {
            padding: 10px 14px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--line);
            cursor: pointer;
            font-weight: 700;
            color: #223a67
        }

        .tab.active {
            background: var(--blue3);
            border-color: var(--blue3);
            color: #fff
        }

        .section {
            display: none;
            padding: 28px 0
        }

        .section.active {
            display: block
        }

        .p-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px
        }

        .card {
            grid-column: span 4;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow)
        }

        .card .media {
            height: 140px;
            background: linear-gradient(135deg, #dfe9ff, #f6f9ff);
            display: grid;
            place-items: center;
            color: #5f6f88;
            font-weight: 800
        }

        .card .content {
            padding: 14px
        }

        .meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #6b778a;
            font-size: 12px;
            margin-bottom: 6px
        }

        .status {
            font-size: 12px;
            font-weight: 900
        }

        .status.pending {
            color: var(--warn)
        }

        .status.validated {
            color: var(--green)
        }

        .status.rejected {
            color: var(--red)
        }

        .panel {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden
        }

        .panel header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--line);
            font-weight: 900;
            color: #143F86
        }

        .panel .body {
            padding: 16px
        }

        .kpis {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px
        }

        .kpi {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
            box-shadow: var(--shadow-sm)
        }

        .kpi .v {
            font-size: 26px;
            font-weight: 900;
            color: var(--blue3)
        }

        .legend {
            font-size: 12px;
            color: #6b7688
        }

        .form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px
        }

        .label {
            font-size: 13px;
            color: #2d3b52;
            font-weight: 700
        }

        .control {
            position: relative
        }

        .input,
        .select,
        .textarea {
            width: 100%;
            border: 1.6px solid #cfdef3;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            background: #fff;
            transition: border .15s ease, box-shadow .15s ease
        }

        .input:focus,
        .select:focus,
        .textarea:focus {
            border-color: var(--blue3);
            box-shadow: var(--focus);
            outline: none
        }

        .textarea {
            min-height: 120px;
            resize: vertical
        }

        .error {
            color: var(--red);
            font-size: 12px;
            display: none
        }

        .invalid .input,
        .invalid .textarea,
        .invalid .select {
            border-color: var(--red)
        }

        .invalid .error {
            display: block
        }

        .counter {
            position: absolute;
            right: 12px;
            bottom: -18px;
            font-size: 12px;
            color: #6b7688
        }

        .upload {
            border: 2px dashed #cfe0ff;
            border-radius: 14px;
            padding: 18px;
            text-align: center;
            background: #f5f9ff;
            color: #4a5b77;
            cursor: pointer
        }

        .upload.drag {
            background: #e8f1ff;
            border-color: var(--blue3)
        }

        .upload input {
            display: none
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
            margin-top: 10px
        }

        .modal {
            position: fixed;
            inset: 0;
            display: none;
            background: rgba(13, 23, 41, .5);
            align-items: center;
            justify-content: center;
            padding: 18px;
            z-index: 70
        }

        .modal.open {
            display: flex
        }

        .modal .box {
            background: #fff;
            border-radius: var(--radius);
            max-width: 940px;
            width: 100%;
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            overflow: hidden
        }

        .modal header {
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            gap: 10px
        }

        .modal .content {
            padding: 16px
        }

        @media (max-width:980px) {
            .grid .card {
                grid-column: span 6
            }

            .form {
                grid-template-columns: 1fr
            }
        }

        @media (max-width:600px) {
            .grid .card {
                grid-column: span 12
            }
        }

        /* Ajouter dans votre fichier CSS */
        .media {
            position: relative;
            overflow: hidden;
        }

        .media-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .media-badge {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .media-count {
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
        }

        .no-media {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
        }
    </style>


    <section class="hero">
        <center>
            <div class="container">
                <h1>Devenez témoin de votre société</h1>
                <p>Partagez vos <strong>vidéos</strong>, <strong>photos</strong> et <strong>témoignages</strong> sur des
                    événements d'intérêt public. Notre rédaction <strong>vérifie</strong> chaque contenu avant diffusion —
                    pour
                    une information participative mais fiable.</p>
                <center>
                    <div class="badges">
                        <span class="pill">Vérification des faits</span>
                        <span class="pill">Protection des témoins</span>
                        <span class="pill">Géolocalisation</span>
                        <span class="pill">Publication après validation</span>
                    </div>
                </center>
            </div>
        </center>
    </section>

    <div class="subnav">
        <center>
            <div class="container">
                <button class="tab active" data-tab="intro">Présentation</button>
                <button class="tab" data-tab="temoins">Témoignages publiés</button>
                <button class="tab" data-tab="submit">Envoyer un témoignage</button>
                <button class="tab" data-tab="mes-envois">Mes envois</button>
            </div>
        </center>
    </div>

    <!-- Introduction -->
<!-- Introduction -->
    <section id="intro" class="section active">
        <div class="container p-grid">
            <div class="panel" style="grid-column:span 12;margin-bottom:20px">
                <header>Notre mission</header>
                <div class="body">
                    <p style="margin-bottom:14px;line-height:1.7">Donner la parole à ceux qui vivent l'actualité au quotidien.</p>
                    <p style="margin-bottom:14px;line-height:1.7">LCM TÉMOINS est la plateforme participative de <strong>LCM+</strong> où chaque citoyen peut partager ses vidéos, photos ou témoignages sur des faits d'intérêt public : accidents, injustices, initiatives locales, réussites communautaires, environnement ou innovation.</p>
                    <p style="line-height:1.7">Nous croyons que le journalisme participatif est un pilier essentiel d'une société informée et responsable. Grâce à LCM Témoins, chaque citoyen devient acteur de l'information, aux côtés de notre rédaction.</p>
                </div>
            </div>

            <div class="panel" style="grid-column:span 12;margin-bottom:20px">
                <header>Comment ça marche</header>
                <div class="body">
                    <ol style="margin:0;padding-left:20px;line-height:1.9">
                        <li style="margin-bottom:12px">
                            <strong>Vous témoignez.</strong><br>
                            <span style="color:var(--muted);font-size:15px">Vous envoyez votre vidéo, photo ou récit directement sur la plateforme LCM Témoins.</span>
                        </li>
                        <li style="margin-bottom:12px">
                            <strong>Nous vérifions.</strong><br>
                            <span style="color:var(--muted);font-size:15px">Notre équipe journalistique analyse, authentifie et contextualise chaque témoignage.</span>
                        </li>
                        <li>
                            <strong>Nous publions.</strong><br>
                            <span style="color:var(--muted);font-size:15px">Après validation, votre contribution est diffusée sur <strong>LCM+</strong>, nos réseaux sociaux et nos émissions.</span>
                        </li>
                    </ol>
                    <p style="margin-top:16px;font-style:italic;color:var(--muted);line-height:1.7">Votre regard devient une information vérifiée.</p>
                </div>
            </div>

            <div class="panel" style="grid-column:span 12;margin-bottom:20px">
                <header>Fonctionnalités de la plateforme</header>
                <div class="body">
                    <ul style="margin:0;padding-left:20px;line-height:1.9">
                        <li><strong>Formulaire sécurisé</strong> d'envoi de témoignages (texte, photo, vidéo)</li>
                        <li><strong>Autodiffusion</strong> et protection des données personnelles</li>
                        <li><strong>Statut de suivi</strong> : <em>En attente, Vérifié, Publié</em></li>
                        <li><strong>Section publique</strong> "Les témoignages du mois" avec mini-reportages citoyens</li>
                        <li><strong>Espace contributeur</strong> : suivre ses publications, voir ses statistiques</li>
                        <li><strong>Option WhatsApp Direct</strong> : envoi rapide pour les signalements urgents</li>
                    </ul>
                </div>
            </div>

            <div class="panel" style="grid-column:span 12;margin-bottom:20px">
                <header>Éthique et sécurité</header>
                <div class="body">
                    <p style="margin-bottom:14px;line-height:1.7">LCM Témoins garantit :</p>
                    <ul style="margin:0 0 16px;padding-left:20px;line-height:1.9">
                        <li>la <strong>confidentialité</strong> des sources et témoins,</li>
                        <li>la <strong>vérification systématique</strong> des contenus avant toute diffusion,</li>
                        <li>le <strong>respect de la dignité humaine</strong> et du droit à l'image,</li>
                        <li>une <strong>modération stricte</strong> contre les fausses informations, la diffamation ou les contenus sensibles.</li>
                    </ul>
                    <p style="line-height:1.7">Chaque envoi passe par une <strong>double vérification humaine et numérique</strong> avant publication.</p>
                </div>
            </div>

            <div class="panel" style="grid-column:span 12;margin-bottom:20px">
                <header>Reconnaissance et récompenses</header>
                <div class="body">
                    <p style="margin-bottom:14px;line-height:1.7">Les contributeurs les plus actifs peuvent recevoir :</p>
                    <ul style="margin:0;padding-left:20px;line-height:1.9">
                        <li>le badge <strong>"Reporter citoyen LCM"</strong>,</li>
                        <li>une <strong>mise en avant spéciale</strong> sur le site et les réseaux,</li>
                        <li>une <strong>invitation aux émissions</strong> LCM Communauté,</li>
                        <li>ou une <strong>prime symbolique</strong> selon l'impact de leur témoignage.</li>
                    </ul>
                    <p style="margin-top:16px;line-height:1.7">Chaque citoyen peut devenir témoin, chaque témoin peut faire bouger les lignes.</p>
                </div>
            </div>

            <div class="panel" style="grid-column:span 12;margin-bottom:20px">
                <header>Valeur ajoutée</header>
                <div class="body">
                    <ul style="margin:0;padding-left:20px;line-height:1.9">
                        <li>Approche <strong>citoyenne et participative</strong> unique au Bénin.</li>
                        <li>Création d'un <strong>réseau de correspondants indépendants</strong> à travers le pays.</li>
                        <li>Source de contenus <strong>authentiques et ancrés dans la réalité du terrain</strong>.</li>
                        <li>Contribution directe à la <strong>transparence</strong> et à la <strong>mobilisation communautaire</strong>.</li>
                    </ul>
                </div>
            </div>

            <div class="panel" style="grid-column:span 12">
                <header>LCM TÉMOINS</header>
                <div class="body">
                    <p style="margin-bottom:12px;line-height:1.7">Vous avez filmé un événement, un incident ou une initiative d'intérêt public ?<br>
                    Partagez votre témoignage avec notre rédaction.</p>
                    <p style="margin-bottom:20px;line-height:1.7">Votre vidéo, votre photo ou votre histoire peuvent aider à informer, à dénoncer ou à inspirer.</p>

                    <div style="text-align:center;padding:24px;background:var(--sky);border-radius:12px;border-left:5px solid var(--blue3)">
                        <button class="btn success" style="font-size:16px;padding:14px 24px" id="btnIntroSubmit">Envoyer un témoignage maintenant</button>
                        <button class="btn secondary" style="font-size:16px;padding:14px 24px;margin-left:10px" onclick="document.querySelector('[data-tab=temoins]').click()">Découvrir les témoignages du mois</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Témoignages publiés -->
    <section id="temoins" class="section">
        <div class="container">
            <div class="panel">
                <header>Témoignages vérifiés et publiés</header>
                <div class="body">
                   <div class="p-grid" id="gridPublies">
                        @forelse($testimonies as $witness)
                                <article class="card">
                                    <a href="{{ route('witness.show', $witness->id ) }}" style="text-decoration: none; ">
                                    <div class="media">
                                        @if ($witness->first_media)
                                            {{-- Afficher le premier média selon son type --}}
                                            @if ($witness->first_media['is_video'])
                                                <video class="media-preview" controls>
                                                    <source src="{{ Storage::url($witness->first_media['path']) }}"
                                                            type="{{ $witness->first_media['type'] }}">
                                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                                </video>
                                                <div class="media-badge">
                                                    <span>🎥 vidéo citoyenne</span>
                                                    @if($witness->media_count > 1)
                                                        <span class="media-count">+{{ $witness->media_count - 1 }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <img src="{{ Storage::url($witness->first_media['path']) }}"
                                                    alt="{{ $witness->title }}"
                                                    class="media-preview">
                                                <div class="media-badge">
                                                    <span>📷 photo{{ $witness->media_count > 1 ? 's' : '' }} citoyenne{{ $witness->media_count > 1 ? 's' : '' }}</span>
                                                    @if($witness->media_count > 1)
                                                        <span class="media-count">{{ $witness->media_count }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                        @else
                                            {{-- Pas de média --}}
                                            <div class="no-media">
                                                <span>📝 témoignage citoyen</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="content">
                                        <div class="meta">
                                            <span class="pill">{{ $witness->category }}</span>
                                            <span class="status {{ $witness->status == 'validated' ? 'validated' : 'pending' }}">
                                                {{ $witness->status }}
                                            </span>
                                        </div>
                                        <h3 style="margin:0 0 6px">{{ $witness->title }}</h3>
                                        <p class="legend" style="margin:0">
                                            {{ $witness->location ?? '—' }} — {{ Str::limit($witness->description, 80) }}
                                        </p>
                                    </div>
                            </a>
                                </article>
                        @empty
                            <div style="grid-column:span 12;text-align:center;padding:40px">
                                <p class="legend">Aucun témoignage publié pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Envoyer un témoignage -->
    <section id="submit" class="section">
        <div class="container p-grid">
            <div style="grid-column:span 7">
                <div class="panel">
                    <header>Formulaire de témoignage</header>
                    <div class="body">
                        <form id="witnessForm" class="form">
                            @csrf
                            <div id="fName" class="field">
                                <label class="label">Nom & Prénom *</label>
                                <input type="text" name="name" id="wName" class="input"
                                    placeholder="Ex. Awa Dossa" required minlength="3" maxlength="120">
                                <span class="error">Nom requis (3-120 caractères)</span>
                            </div>
                            <div id="fEmail" class="field">
                                <label class="label">Email *</label>
                                <input type="email" name="email" id="wEmail" class="input"
                                    placeholder="Ex. awa@email.com" required>
                                <span class="error">Email valide requis</span>
                            </div>
                            <div class="field">
                                <label class="label">Téléphone (WhatsApp)</label>
                                <input type="tel" name="phone" id="wPhone" class="input"
                                    placeholder="+229 ...">
                            </div>
                            <div class="field">
                                <label class="label">Ville / Commune</label>
                                <input type="text" name="city" id="wCity" class="input"
                                    placeholder="Ex. Cotonou">
                            </div>
                            <div id="fTitle" class="field" style="grid-column:span 2">
                                <label class="label">Titre du témoignage (8-120 caractères) *</label>
                                <div class="control">
                                    <input type="text" name="title" id="wTitle" class="input"
                                        placeholder="Un titre clair et descriptif" required minlength="8"
                                        maxlength="120">
                                    <span class="counter" id="cTitle">0/120</span>
                                </div>
                                <span class="error">Titre requis (8-120 caractères)</span>
                            </div>
                            <div class="field">
                                <label class="label">Catégorie *</label>
                                <select name="category" id="wCategory" class="select" required>
                                    <option value="">Choisir une catégorie</option>
                                    <option value="Corruption">Corruption</option>
                                    <option value="Injustice">Injustice</option>
                                    <option value="Infrastructure">Infrastructure</option>
                                    <option value="Sécurité">Sécurité</option>
                                    <option value="Santé">Santé</option>
                                    <option value="Éducation">Éducation</option>
                                    <option value="Environnement">Environnement</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>
                            <div class="field">
                                <label class="label">Lieu de l'événement</label>
                                <input type="text" name="location" id="wLocation" class="input"
                                    placeholder="Ex. Cotonou, Quartier Akpakpa">
                            </div>
                            <div id="fDesc" class="field" style="grid-column:span 2">
                                <label class="label">Description (30-1500 caractères) *</label>
                                <div class="control">
                                    <textarea name="description" id="wDesc" class="textarea"
                                        placeholder="Décrivez ce que vous avez vu, entendu ou vécu..." required minlength="30" maxlength="1500"></textarea>
                                    <span class="counter" id="cDesc">0/1500</span>
                                </div>
                                <span class="error">Description requise (30-1500 caractères)</span>
                            </div>
                            <div class="field">
                                <label class="label">Date de l'événement</label>
                                <input type="date" name="event_date" id="wEventDate" class="input">
                            </div>
                            <div class="field">
                                <label class="label">Médias (vidéo/photo)</label>
                                <div class="upload" id="dropzone">
                                    <input type="file" name="media_files[]" id="wFiles" multiple
                                        accept="image/jpeg,image/jpg,image/png">
                                    <p>📎 Glissez vos fichiers ici ou <strong>cliquez pour parcourir</strong></p>
                                    <p class="legend" id="filesList">Aucun fichier sélectionné.</p>
                                </div>
                                <span style="font-size:11px;color:#6b7688">Format: JPG, PNG. Max 10MB par
                                    fichier.</span>
                            </div>
                            <div class="field" style="grid-column:span 2;display:flex;align-items:center;gap:8px">
                                <input type="checkbox" name="anonymous_publication" id="wAnonymous" value="1"
                                    style="width:auto">
                                <label for="wAnonymous" style="margin:0">Publier de manière anonyme</label>
                            </div>
                            <div class="field" style="grid-column:span 2;display:flex;align-items:center;gap:8px">
                                <input type="checkbox" name="consent_given" id="wConsent" value="1" required
                                    style="width:auto">
                                <label for="wConsent" style="margin:0">J'accepte que LCM vérifie et publie mon témoignage
                                    *</label>
                                <span class="error" id="eConsent" style="display:none">Vous devez accepter les
                                    conditions</span>
                            </div>
                            <div class="actions" style="grid-column:span 2">
                                {{-- <button type="button" class="btn ghost" id="btnDraft">💾 Enregistrer le
                                    brouillon</button> --}}
                                <button type="button" class="btn ghost" id="btnReset">Réinitialiser</button>
                                <button type="submit" class="btn success">Envoyer le témoignage</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div style="grid-column:span 5">
                <div class="panel">
                    <header>Aperçu en direct</header>
                    <div class="body">
                        <article class="card" id="previewCard" style="margin:0">
                            <div class="media">Aperçu</div>
                            <div class="content">
                                <div class="meta">
                                    <span class="pill" id="pCat">—</span>
                                    <span class="legend" id="pMeta">—</span>
                                </div>
                                <h3 style="margin:0 0 6px" id="pTitle">Votre titre apparaîtra ici</h3>
                                <p class="legend" style="margin:0" id="pDesc">Votre description apparaîtra ici…</p>
                                <p class="legend" style="margin-top:8px" id="charCount">0 caractères</p>
                            </div>
                        </article>
                        {{-- <div class="actions" style="margin-top:12px;justify-content:flex-start;flex-wrap:wrap">
                            <button type="button" class="btn ghost" id="btnCopySummary" title="Copier le résumé">📋
                                Copier</button>
                            <button type="button" class="btn ghost" id="btnCopyHTML" title="Copier le HTML">🔗
                                HTML</button>
                            <button type="button" class="btn ghost" id="btnDownload" title="Télécharger la fiche">💾
                                Télécharger</button>
                            <button type="button" class="btn ghost" id="btnModalPreview" title="Voir en modal">🔍
                                Modal</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mes envois -->
    <section id="mes-envois" class="section">
        <div class="container">
            <div class="panel">
                <header>Mes témoignages envoyés</header>
                <div class="body">
                    <div class="p-grid" id="witnessList">
                        <p class="legend">Aucun envoi pour l'instant.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal" id="modal">
        <div class="box">
            <header>
                <strong id="modalTitle">Aperçu</strong>
                <div style="margin-left:auto"><button class="btn ghost" id="btnCloseModal">Fermer</button></div>
            </header>
            <div class="content" id="modalContent"></div>
        </div>
    </div>

    <div id="toast"
        style="position:fixed;bottom:18px;left:50%;transform:translateX(-50%);background:#0e1116;color:#fff;padding:10px 14px;border-radius:999px;opacity:0;transition:opacity .25s ease;z-index:80">
        Action effectuée.</div>
<script>
        // Helpers
        const $ = s => document.querySelector(s),
            $$ = s => document.querySelectorAll(s);
        const toast = m => {
            const t = $('#toast');
            if (!t) return;
            t.textContent = m;
            t.style.opacity = 1;
            setTimeout(() => t.style.opacity = 0, 2100)
        };
        const copyText = async (txt) => {
            try {
                await navigator.clipboard.writeText(txt);
                toast('Copié dans le presse-papier ✅')
            } catch {
                toast('Copie non disponible ⚠️')
            }
        };

        // Tabs
        $$('.tab').forEach(btn => btn.addEventListener('click', () => {
            $$('.tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const id = btn.dataset.tab;
            $$('.section').forEach(s => s.classList.remove('active'));
            const targetSection = $('#' + id);
            if (targetSection) targetSection.classList.add('active');
            if (id === 'temoins') renderPublies();
        }));
        // $('#btnEnvoyer').addEventListener('click', () => {
        //     document.querySelector('[data-tab="submit"]').click();
        //     document.getElementById('submit').scrollIntoView({
        //         behavior: 'smooth'
        //     })
        // });
        // $('#btnIntroSubmit').addEventListener('click', () => $('#btnEnvoyer').click());

        // Modal
        const modal = $('#modal'),
            modalTitle = $('#modalTitle'),
            modalContent = $('#modalContent');
        const openModal = (title, html) => {
            if (modalTitle) modalTitle.textContent = title;
            if (modalContent) modalContent.innerHTML = html;
            if (modal) modal.classList.add('open')
        };

        const btnCloseModal = $('#btnCloseModal');
        if (btnCloseModal && modal) {
            btnCloseModal.addEventListener('click', () => modal.classList.remove('open'));
        }

        if (modal) {
            modal.addEventListener('click', e => {
                if (e.target === modal) modal.classList.remove('open')
            });
        }


        // Publies (dynamique)
        function renderPublies() {
            // Cette fonction est déjà gérée côté serveur via Blade
            // Mais gardée pour compatibilité JavaScript
        }
        renderPublies();

        // ===== Form live preview & dynamic toolbar =====
        const toPreview = () => {
            const pCat = $('#pCat');
            const pMeta = $('#pMeta');
            const pTitle = $('#pTitle');
            const pDesc = $('#pDesc');
            const charCount = $('#charCount');
            const wCategory = $('#wCategory');
            const wCity = $('#wCity');
            const wName = $('#wName');
            const wTitle = $('#wTitle');
            const wDesc = $('#wDesc');

            if (pCat && wCategory) pCat.textContent = wCategory.value;
            if (pMeta && wCity && wName) {
                const city = wCity.value.trim() || '—';
                pMeta.textContent = (city !== '—' ? city + ' — ' : '— ') + (wName.value.trim() || 'Anonyme');
            }
            if (pTitle && wTitle) pTitle.textContent = wTitle.value.trim() || 'Votre titre apparaîtra ici';
            if (pDesc && wDesc) pDesc.textContent = wDesc.value.trim() || 'Votre description apparaîtra ici…';
            if (charCount && wDesc) charCount.textContent = `${(wDesc.value || '').length} caractères`;
        };

        ['#wName', '#wCity', '#wTitle', '#wDesc', '#wCategory'].forEach(sel => {
            const el = $(sel);
            if (el) el.addEventListener('input', toPreview);
        });
        toPreview();

        // Counters
        const counters = [{
            el: '#wTitle',
            c: '#cTitle',
            max: 120
        }, {
            el: '#wDesc',
            c: '#cDesc',
            max: 1500
        }];
        counters.forEach(({
            el,
            c,
            max
        }) => {
            const input = $(el),
                counter = $(c);
            if (!input || !counter) return;
            const update = () => {
                const n = (input.value || '').length;
                counter.textContent = `${n}/${max}`;
            };
            input.addEventListener('input', update);
            update();
        });

        // Validation
        function setInvalid(id, invalid) {
            const f = $(id);
            if (!f) return;
            invalid ? f.classList.add('invalid') : f.classList.remove('invalid');
        }

        function validateEmail(v) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
        }

        function validateForm() {
            let ok = true;
            const wName = $('#wName');
            const wEmail = $('#wEmail');
            const wTitle = $('#wTitle');
            const wDesc = $('#wDesc');
            const wConsent = $('#wConsent');
            const eConsent = $('#eConsent');

            if (wName) {
                const name = wName.value.trim();
                setInvalid('#fName', !(name.length >= 3 && name.length <= 120));
                ok &= name.length >= 3;
            }
            if (wEmail) {
                const email = wEmail.value.trim();
                setInvalid('#fEmail', !validateEmail(email));
                ok &= validateEmail(email);
            }
            if (wTitle) {
                const title = wTitle.value.trim();
                setInvalid('#fTitle', !(title.length >= 8));
                ok &= title.length >= 8;
            }
            if (wDesc) {
                const desc = wDesc.value.trim();
                setInvalid('#fDesc', !(desc.length >= 30));
                ok &= desc.length >= 30;
            }
            if (wConsent && eConsent) {
                const consent = wConsent.checked;
                eConsent.style.display = consent ? 'none' : 'block';
                ok &= consent;
            }
            return !!ok;
        }

        ['#wName', '#wEmail', '#wTitle', '#wDesc', '#wConsent'].forEach(sel => {
            const el = $(sel);
            if (el) el.addEventListener('blur', validateForm);
        });

        // Files drag&drop + checks
        const dz = $('#dropzone'),
            inFiles = $('#wFiles'),
            filesList = $('#filesList');

        if (dz && inFiles && filesList) {
            const humanSize = n => n > 1024 * 1024 ? (n / 1024 / 1024).toFixed(1) + ' Mo' : Math.round(n / 1024) + ' Ko';
            dz.addEventListener('click', () => inFiles.click());
            dz.addEventListener('dragover', e => {
                e.preventDefault();
                dz.classList.add('drag')
            });
            dz.addEventListener('dragleave', () => dz.classList.remove('drag'));
            dz.addEventListener('drop', e => {
                e.preventDefault();
                dz.classList.remove('drag');
                inFiles.files = e.dataTransfer.files;
                renderFiles();
            });
            inFiles.addEventListener('change', renderFiles);

            function renderFiles() {
                const f = [...inFiles.files];
                if (!f.length) {
                    filesList.textContent = 'Aucun fichier sélectionné.';
                    return;
                }
                const lines = [],
                    errs = [];
                f.forEach(x => {
                    const okType = ['video/mp4', 'image/jpeg', 'image/png'].includes(x.type);
                    const okSize = x.size <= 200 * 1024 * 1024;
                    if (okType && okSize) lines.push(`${x.name} — ${x.type.split('/')[0]} (${humanSize(x.size)})`);
                    else {
                        if (!okType) errs.push(`${x.name}: type non autorisé (${x.type || 'inconnu'})`);
                        if (!okSize) errs.push(`${x.name}: dépasse 200 Mo (${humanSize(x.size)})`);
                    }
                });
                filesList.innerHTML = lines.join(' • ') || 'Aucun fichier valide.';
                if (errs.length) toast('Fichiers invalides :\n' + errs.join('\n'));
            }
        }

        // Draft
        const draftKey = 'lcm-temoins-draft-v2';
        const btnDraft = $('#btnDraft');
        if (btnDraft) {
            btnDraft.addEventListener('click', () => {
                const data = {
                    name: $('#wName')?.value || '',
                    email: $('#wEmail')?.value || '',
                    phone: $('#wPhone')?.value || '',
                    city: $('#wCity')?.value || '',
                    title: $('#wTitle')?.value || '',
                    category: $('#wCategory')?.value || '',
                    description: $('#wDesc')?.value || '',
                    consent: $('#wConsent')?.checked || false
                };
                localStorage.setItem(draftKey, JSON.stringify(data));
                toast('Brouillon enregistré');
            });
        }

        const prev = localStorage.getItem(draftKey);
        if (prev) {
            const d = JSON.parse(prev);
            Object.entries(d).forEach(([k, v]) => {
                const el = document.querySelector('#w' + k.charAt(0).toUpperCase() + k.slice(1)) || document
                    .querySelector('[name="' + k + '"]');
                if (el) {
                    if (el.type === 'checkbox') el.checked = !!v;
                    else el.value = v;
                }
            });
            toPreview();
        }

        // Save submissions
        const key = 'lcm-temoins-submissions-v2';
        const read = () => JSON.parse(localStorage.getItem(key) || '[]');
        const write = (arr) => localStorage.setItem(key, JSON.stringify(arr));

        function renderList() {
            const list = $('#witnessList');
            if (!list) return;
            list.innerHTML = '';
            const items = read();
            if (!items.length) {
                list.innerHTML = '<p class="legend">Aucun envoi pour l\'instant.</p>';
                return;
            }
            items.forEach(p => {
                const el = document.createElement('div');
                el.className = 'card';
                el.style = 'grid-column:span 12; display:block;';
                el.innerHTML = `
        <div class="content">
          <div class="meta"><span class="pill">${p.category}</span><span class="status ${p.status}">[${p.status === 'pending' ? 'En attente' : p.status === 'validated' ? 'Validé' : 'Rejeté'}]</span></div>
          <h3 style="margin:0 0 6px">${p.title}</h3>
          <p class="legend" style="margin:0 0 6px">${p.city || '—'} • ${p.name} — ${p.email}</p>
          <p class="legend" style="margin:0">${p.description.slice(0, 220)}${p.description.length > 220 ? '…' : ''}</p>
        </div>`;
                list.appendChild(el);
            });
        }

        // Submit
        const witnessForm = $('#witnessForm');
        if (witnessForm) {
            witnessForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                e.stopImmediatePropagation();

                if (!validateForm()) {
                    toast('Corrigez les champs en rouge.');
                    return;
                }

                const formData = new FormData(e.target);
                const submitBtn = e.target.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.textContent = 'Envoi en cours...';

                try {
                    const response = await fetch('{{ route('witness.submit') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        toast(data.message || 'Témoignage envoyé — statut : En attente de validation.');

                        // Save to localStorage for "Mes envois"
                        const sub = {
                            id: Date.now(),
                            name: $('#wName')?.value?.trim() || '',
                            email: $('#wEmail')?.value?.trim() || '',
                            phone: $('#wPhone')?.value?.trim() || '',
                            city: $('#wCity')?.value?.trim() || '',
                            title: $('#wTitle')?.value?.trim() || '',
                            category: $('#wCategory')?.value || '',
                            description: $('#wDesc')?.value?.trim() || '',
                            status: 'pending'
                        };
                        const arr = read();
                        arr.unshift(sub);
                        write(arr);
                        renderList();

                        // Reset form
                        e.target.reset();
                        toPreview();
                        if (typeof renderFiles !== 'undefined') renderFiles();
                        localStorage.removeItem(draftKey);
                    } else {
                        toast('Erreur : ' + (data.message || 'Veuillez vérifier les champs du formulaire.'));
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    toast('Une erreur est survenue. Veuillez réessayer.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = '📤 Envoyer le témoignage';
                }
            });
        }

        // ===== DYNAMIC ACTION BUTTONS =====
        const previewCard = $('#previewCard');
        const btnCopySummary = $('#btnCopySummary');
        const btnCopyHTML = $('#btnCopyHTML');
        const btnDownload = $('#btnDownload');
        const btnModalPreview = $('#btnModalPreview');
        const btnReset = $('#btnReset');

        if (btnCopySummary) {
            btnCopySummary.addEventListener('click', () => {
                const pTitle = $('#pTitle');
                const pCat = $('#pCat');
                const pMeta = $('#pMeta');
                const pDesc = $('#pDesc');
                const summary = `Titre: ${pTitle?.textContent || ''}
Catégorie: ${pCat?.textContent || ''}
Auteur/Ville: ${pMeta?.textContent || ''}
Description: ${pDesc?.textContent || ''}`;
                copyText(summary);
            });
        }

        if (btnCopyHTML && previewCard) {
            btnCopyHTML.addEventListener('click', () => copyText(previewCard.outerHTML));
        }

        if (btnDownload && previewCard) {
            btnDownload.addEventListener('click', () => {
                const tpl = `<!DOCTYPE html><html lang="fr"><meta charset="utf-8"><title>LCM Témoins — Fiche</title>
<body style="font-family:Arial, sans-serif;background:#f6f8fb;padding:20px">${previewCard.outerHTML}</body></html>`;
                const blob = new Blob([tpl], {
                    type: 'text/html'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'LCM_Temoins_fiche.html';
                document.body.appendChild(a);
                a.click();
                URL.revokeObjectURL(url);
                a.remove();
                toast('Fiche téléchargée');
            });
        }

        if (btnModalPreview && previewCard) {
            btnModalPreview.addEventListener('click', () => openModal('Aperçu interne', previewCard.outerHTML));
        }

        if (btnReset) {
            btnReset.addEventListener('click', () => {
                ['#wName', '#wEmail', '#wPhone', '#wCity', '#wTitle', '#wDesc'].forEach(id => {
                    const el = $(id);
                    if (el) el.value = '';
                });
                const wCategory = $('#wCategory');
                const wConsent = $('#wConsent');
                if (wCategory) wCategory.selectedIndex = 0;
                if (wConsent) wConsent.checked = false;
                toPreview();
                if (typeof renderFiles !== 'undefined') renderFiles();
                toast('Formulaire réinitialisé');
            });
        }

        // Published list render once
        // renderList();
    </script>

@endsection
