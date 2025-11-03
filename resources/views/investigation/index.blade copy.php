@extends('layouts.frontend')

@section('title', 'LCM Investigation — Enquêter, révéler, comprendre')

@section('content')
    <style>
        :root {
            --ink: #0e1116;
            --blue: #0B2B5A;
            --blue-2: #143F86;
            --blue-3: #1E56B3;
            --sky: #E8F1FF;
            --accent: #FFC940;
            --bg: #F7F9FC;
            --card: #FFFFFF;
            --muted: #5E6B7A;
            --line: #E5EDF6;
            --green: #1FA37B;
            --red: #D04A4A;
            --warn: #B97400;
            --radius: 14px;
            --shadow: 0 6px 22px rgba(10, 35, 80, .08);
            --shadow-sm: 0 4px 14px rgba(10, 35, 80, .06);
            --focus: 0 0 0 4px rgba(30, 86, 179, .18);
        }

        * {
            box-sizing: border-box
        }

        /* html,
            body {
                margin: 0;
                padding: 0;
                background: var(--bg);
                color: var(--ink);
                font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
                line-height: 1.5
            } */

        img {
            max-width: 100%;
            display: block
        }

        /* a {
            color: var(--blue-3);
            text-decoration: none
        } */

        .container {
            /* max-width: 1200px; */
            margin: 0 auto;
            /* padding: 0 20px */
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: linear-gradient(180deg, #fff, #fbfdff);
            border-bottom: 1px solid var(--line);
            padding-top: 5px;
            /* box-shadow: var(--shadow-sm) */
        }

        .topbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--blue), var(--blue-2));
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 900;
            letter-spacing: .5px
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
            color: var(--blue-2);
            border: 1px solid var(--line)
        }

        .btn {
            border: 0;
            border-radius: 12px;
            padding: 12px 16px;
            font-weight: 800;
            letter-spacing: .2px;
            cursor: pointer
        }

        .btn.primary {
            background: var(--blue-3);
            color: #fff;
            box-shadow: var(--shadow-sm)
        }

        .btn.secondary {
            background: #fff;
            color: var(--blue-3);
            border: 2px solid var(--blue-3)
        }

        .btn.warn {
            background: var(--accent);
            color: #5a3d00
        }

        .btn.ghost {
            background: #fff;
            border: 2px solid var(--line);
            color: var(--blue)
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
            max-width: 860px;
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
            top: 68px;
            z-index: 19;
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
            background: var(--blue-3);
            border-color: var(--blue-3);
            color: #fff
        }

        .section {
            display: none;
            padding: 26px 0
        }

        .section.active {
            display: block
        }

         #projectGrid{
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 18px
        }

        .card {
            grid-column: span 4;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow)
        }

        .card .media {
            height: 150px;
            background: linear-gradient(135deg, #dfe9ff, #f6f9ff);
            display: grid;
            place-items: center;
            color: #6d7c90;
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

        .progress {
            height: 8px;
            background: #edf3ff;
            border-radius: 999px;
            overflow: hidden;
            margin-top: 8px
        }

        .progress>div {
            height: 8px;
            background: linear-gradient(90deg, var(--accent), #ffe487);
            width: 0%
        }

        .panel {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden
        }

        .panel header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--line);
            font-weight: 900;
            color: #143F86
        }

        .panel .body {
            padding: 16px
        }

        .kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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
            color: var(--blue-3)
        }

        .legend {
            font-size: 12px;
            color: #6b7688
        }

        .list .item {
            border: 1px dashed var(--line);
            border-radius: 12px;
            padding: 12px;
            margin: 10px 0;
            background: #fbfdff
        }

        /* Form */
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
            border-color: var(--blue-3);
            box-shadow: var(--focus);
            outline: none
        }

        .textarea {
            min-height: 130px;
            resize: vertical
        }

        .hint {
            font-size: 12px;
            color: #6b7688
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
            color: #4a5b77
        }

        .upload.drag {
            background: #e8f1ff;
            border-color: var(--blue-3)
        }

        .upload input {
            display: none
        }

        .divider {
            height: 1px;
            background: var(--line);
            margin: 14px 0
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
            margin-top: 6px
        }

        /* Modal */
        .modal {
            position: fixed;
            inset: 0;
            display: none;
            background: rgba(13, 23, 41, .5);
            align-items: center;
            justify-content: center;
            padding: 18px;
            z-index: 50
        }

        .modal.open {
            display: flex
        }

        .modal .box {
            background: #fff;
            border-radius: 16px;
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

        /* Responsive */
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

        /* Conteneur de notifications */
        #notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
        }

        /* Style des alertes */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease-out;
            transition: opacity 0.3s ease;
        }

        .alert-success {
            background-color: #10b981;
            color: white;
            border-left: 4px solid #059669;
        }

        .alert-error {
            background-color: #ef4444;
            color: white;
            border-left: 4px solid #dc2626;
        }

        .alert-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .alert-close:hover {
            opacity: 1;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Modal Guide éditorial */
        .guide-modal {
            position: fixed;
            inset: 0;
            display: none;
            background: rgba(0, 0, 0, 0.4);
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 9999;
        }

        .guide-modal.open {
            display: flex;
        }

        .guide-modal-container {
            background: white;
            border-radius: 8px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .guide-modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .guide-modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #000;
        }

        .guide-modal-body {
            padding: 20px 20px 24px;
            overflow-y: auto;
        }

        .guide-section {
            margin-bottom: 24px;
        }

        .guide-section:last-child {
            margin-bottom: 0;
        }

        .guide-section-title {
            font-size: 16px;
            font-weight: 700;
            color: #000;
            margin-bottom: 12px;
        }

        .guide-list {
            margin: 0;
            padding-left: 24px;
            list-style-position: outside;
        }

        .guide-list li {
            margin-bottom: 8px;
            color: #333;
            line-height: 1.5;
        }

        .guide-text {
            color: #333;
            line-height: 1.6;
            margin: 0;
        }
    </style>

    {{-- <div class="topbar">
        <div class="container">
            <div class="brand">
                <div class="logo">LC</div>
                 <div class="brand-title">LCM <span style="font-weight:400">Investigation</span></div>
                <span class="tag">Enquêter · Révéler · Comprendre</span>
            </div>
            <div>
                <button class="btn secondary" onclick="openModal()">Guide éditorial</button>
                <button class="btn primary" id="btnProposer">+ Proposer une enquête</button>
            </div>
        </div>
    </div> --}}

    <section class="hero">
        <center>
        <div class="container">
            <h1>Le pôle d'enquêtes d'intérêt public de LCM +</h1>
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
                <button class="tab" data-tab="how">Fonctionnement & rémunération</button>
                <button class="tab" data-tab="impact">Impact</button>
            </div>
        </center>
    </div>

    <!-- Présentation -->
    <section id="overview" class="section active">
        <div class="container grid">
            <div class="panel" style="grid-column:span 8">
                <header>Objectif</header>
                <div class="body">
                    <p>Faire de LCM + un acteur majeur de l'investigation numérique en Afrique francophone, avec une
                        cellule dédiée à la <strong>recherche de vérité</strong> et à la <strong>transparence</strong>.</p>
                </div>
            </div>
            <div class="panel" style="grid-column:span 4">
                <header>KPIs</header>
                <div class="body">
                    <div class="kpis" style="grid-template-columns:1fr 1fr">
                        <div class="kpi">
                            <div class="v" id="kpi_projects">{{ $totalProposals }}</div>
                            <div class="legend">Enquêtes</div>
                        </div>
                        <div class="kpi">
                            <div class="v" id="kpi_supporters">{{ $totalSupporters }}</div>
                            <div class="legend">Soutiens</div>
                        </div>
                        <div class="kpi">
                            <div class="v" id="kpi_funds">{{ number_format($totalFunds, 0, ',', ' ') }} FCFA</div>
                            <div class="legend">Fonds levés</div>
                        </div>
                        <div class="kpi">
                            <div class="v" id="kpi_impact">{{ $totalImpact }}</div>
                            <div class="legend">Impact</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel" style="grid-column:span 12">
                <header>📚 Thèmes prioritaires</header>
                <div class="body">
                    <div class="badges">
                        <span class="pill">Corruption</span>
                        <span class="pill">Environnement</span>
                        <span class="pill">Santé publique</span>
                        <span class="pill">Droits humains</span>
                        <span class="pill">Économie souterraine</span>
                        <span class="pill">Politique</span>
                        <span class="pill">Technologie</span>
                    </div>
                </div>
            </div>
            <div class="panel" style="grid-column:span 6">
                <header>🔒 Principes éditoriaux</header>
                <div class="body">
                    <ul style="margin:0;padding-left:18px">
                        <li>Vérification systématique des sources</li>
                        <li>Respect du droit de réponse</li>
                        <li>Protection des lanceurs d'alerte et témoins</li>
                        <li>Transparence sur la méthode et les limites</li>
                        <li>Indépendance éditoriale totale</li>
                    </ul>
                </div>
            </div>
            <div class="panel" style="grid-column:span 6">
                <header>📝 Formats disponibles</header>
                <div class="body">
                    <ul style="margin:0;padding-left:18px">
                        <li><strong>Article long</strong> (3000-8000 mots)</li>
                        <li><strong>Vidéo</strong> (reportage, interview, data viz)</li>
                        <li><strong>Podcast</strong> (enquête audio narrative)</li>
                        <li><strong>Infographie</strong> (data journalism)</li>
                        <li><strong>Série multimédia</strong> (combinaison formats)</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Enquêtes en cours -->
    <section id="projects" class="section">
        <div class="container">
            <div class="panel">
                <header>🔎 Enquêtes en cours de validation ou d'investigation</header>
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
                <header>✍️ Proposer une enquête</header>
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
                            <button type="button" class="btn ghost" id="btnDraft">💾 Enregistrer le brouillon</button>
                            <button type="submit" class="btn primary">Envoyer la proposition</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel" style="margin-top:20px">
                <header>📋 Mes propositions</header>
                <div class="body">
                    <div class="list" id="proposalList">
                        <p class="legend">Connectez-vous ou entrez votre email ci-dessus pour voir vos propositions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fonctionnement -->
    <section id="how" class="section">
        <div class="container grid">
            <div class="panel" style="grid-column:span 6">
                <header>⚙️ Comment ça marche</header>
                <div class="body">
                    <ol style="margin:0;padding-left:18px">
                        <li><strong>Proposition :</strong> Remplissez le formulaire avec votre sujet</li>
                        <li><strong>Validation :</strong> La direction éditoriale évalue la proposition (délai : 7-14 jours)
                        </li>
                        <li><strong>Investigation :</strong> Si validée, l'enquête est lancée avec un budget et un
                            calendrier</li>
                        <li><strong>Publication :</strong> L'enquête est diffusée sur LCM + en libre accès</li>
                        <li><strong>Impact :</strong> Suivi des retombées et actions déclenchées</li>
                    </ol>
                </div>
            </div>
            <div class="panel" style="grid-column:span 6">
                <header>💰 Rémunération</header>
                <div class="body">
                    <ul style="margin:0;padding-left:18px">
                        <li><strong>Pigistes externes :</strong> Tarif négocié selon le projet
                        </li>
                        <li><strong>Contributeurs citoyens :</strong> Prime symbolique si contribution majeure</li>
                        <li><strong>Partenariats :</strong> Co-financement avec ONG ou médias partenaires</li>
                        <li><strong>Transparence :</strong> Budget détaillé publié pour chaque enquête</li>
                    </ul>
                </div>
            </div>
            <div class="panel" style="grid-column:span 12">
                <header>🛡️ Protection des sources</header>
                <div class="body">
                    <p>LCM + garantit la <strong>protection absolue</strong> des lanceurs d'alerte et des sources
                        anonymes. Canal sécurisé disponible : <strong>signal@lcmpress.africa</strong> (Signal, ProtonMail).
                    </p>
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

    async function loadUserProposals() {
        if (!userEmail) {
            document.getElementById('proposalList').innerHTML = '<p class="legend">Connectez-vous pour voir vos propositions.</p>';
            return;
        }
        try {
            const response = await fetch('{{ route('investigation.myProposals') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({email: userEmail})
            });
            const data = await response.json();
            if (data.success && data.proposals.length > 0) {
                renderProposals(data.proposals);
            } else {
                document.getElementById('proposalList').innerHTML = '<p class="legend">Vous n\'avez aucune proposition pour le moment.</p>';
            }
        } catch (error) {
            console.error('Erreur:', error);
        }
    }

    function renderProposals(proposals) {
        const listHtml = proposals.map(p => `
            <div class="item">
                <div class="meta">
                    <span class="pill">${p.format}</span>
                    <span class="status ${p.status}">${p.status_label}</span>
                </div>
                <h4 style="margin:6px 0">${p.title}</h4>
                <p class="legend" style="margin:4px 0">Thème : ${p.theme}</p>
                <div class="meta" style="margin-top:8px">
                    <span class="legend">Soumis le ${p.created_at}</span>
                    ${p.budget ? `<span><strong>${new Intl.NumberFormat('fr-FR').format(p.budget)} FCFA</strong></span>` : ''}
                </div>
                ${p.rejection_reason ? `<p style="color:var(--red);font-size:12px;margin-top:6px">Motif : ${p.rejection_reason}</p>` : ''}
            </div>
        `).join('');
        document.getElementById('proposalList').innerHTML = listHtml;
    }

    document.querySelectorAll('.tab').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(target).classList.add('active');
            if (target === 'submit') loadUserProposals();
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

    // 🔥 LA PARTIE IMPORTANTE - SOUMISSION DU FORMULAIRE
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
                setTimeout(() => loadUserProposals(), 1000);
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
