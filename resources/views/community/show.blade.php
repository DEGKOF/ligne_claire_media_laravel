@extends('layouts.frontend')

@section('title', $submission->title . ' — LCM Communauté')

@section('content')
    <style>
        /* Styles pour la page détail */
        .lcm-detail-wrapper {
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
            background: var(--comm-bg);
            padding: 40px 0;
        }

        .lcm-detail-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Breadcrumb */
        .lcm-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
            font-size: 14px;
            color: var(--comm-muted);
        }

        .lcm-breadcrumb a {
            color: var(--comm-blue);
            text-decoration: none;
            transition: color 0.2s;
        }

        .lcm-breadcrumb a:hover {
            color: var(--comm-blue-2);
        }

        /* Article principal */
        .lcm-article-main {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 40px;
            margin-bottom: 60px;
        }

        .lcm-article-content {
            background: white;
            border-radius: 16px;
            padding: 40px;
            border: 1px solid var(--comm-border);
        }

        .lcm-article-meta-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .lcm-meta-badge {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .lcm-meta-badge.section {
            background: var(--comm-blue);
            color: white;
        }

        .lcm-meta-badge.access-free {
            background: #e8f5f0;
            color: var(--comm-ok);
        }

        .lcm-meta-badge.access-premium {
            background: #fff4e6;
            color: #b25b00;
        }

        .lcm-meta-badge.status-pending {
            background: #fff3e0;
            color: var(--comm-warn);
        }

        .lcm-meta-badge.status-validated {
            background: #e8f5f0;
            color: var(--comm-ok);
        }

        .lcm-meta-badge.status-rejected {
            background: #fee;
            color: var(--comm-danger);
        }

        .lcm-article-title {
            font-size: 32px;
            color: var(--comm-blue);
            line-height: 1.3;
            margin: 0 0 20px;
        }

        .lcm-article-author-info {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            background: #fafcff;
            border-radius: 12px;
            margin-bottom: 30px;
            border: 1px solid var(--comm-border);
        }

        .lcm-author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--comm-blue), var(--comm-blue-2));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .lcm-author-details h4 {
            margin: 0 0 4px;
            font-size: 16px;
            color: var(--comm-text);
        }

        .lcm-author-details p {
            margin: 0;
            font-size: 13px;
            color: var(--comm-muted);
        }

        .lcm-article-image {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .lcm-article-image-placeholder {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #dfe8f5, #eef3f9);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7787a1;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .lcm-article-body {
            font-size: 17px;
            line-height: 1.8;
            color: var(--comm-text);
        }

        .lcm-article-body p {
            margin-bottom: 20px;
        }

        .lcm-rejection-notice {
            background: #fef3f3;
            border: 2px solid #fecaca;
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
        }

        .lcm-rejection-notice h4 {
            color: var(--comm-danger);
            margin: 0 0 10px;
            font-size: 16px;
        }

        .lcm-rejection-notice p {
            margin: 0;
            color: #7f1d1d;
            font-size: 14px;
        }

        /* Sidebar */
        .lcm-article-sidebar {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .lcm-sidebar-card {
            background: white;
            border: 1px solid var(--comm-border);
            border-radius: 14px;
            padding: 24px;
        }

        .lcm-sidebar-card h3 {
            font-size: 16px;
            color: var(--comm-blue);
            margin: 0 0 16px;
        }

        .lcm-sidebar-action {
            display: block;
            width: 100%;
            padding: 14px 20px;
            background: var(--comm-blue);
            color: white !important;
            text-align: center;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .lcm-sidebar-action:hover {
            background: var(--comm-blue-2);
            transform: translateY(-2px);
        }

        .lcm-sidebar-action.secondary {
            background: transparent;
            color: var(--comm-blue) !important;
            border: 2px solid var(--comm-border);
        }

        .lcm-sidebar-action.secondary:hover {
            background: #f5f7fa;
            transform: translateY(0);
        }

        .lcm-mini-submission {
            padding: 12px 0;
            border-bottom: 1px solid var(--comm-border);
        }

        .lcm-mini-submission:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .lcm-mini-submission h4 {
            font-size: 14px;
            margin: 0 0 6px;
            color: var(--comm-text);
        }

        .lcm-mini-submission p {
            font-size: 12px;
            color: var(--comm-muted);
            margin: 0;
        }

        /* Section soumissions similaires */
        .lcm-related-section {
            background: white;
            border-radius: 16px;
            padding: 40px;
            border: 1px solid var(--comm-border);
        }

        .lcm-related-section h2 {
            font-size: 24px;
            color: var(--comm-blue);
            margin: 0 0 30px;
        }

        .lcm-related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 24px;
        }

        .lcm-related-card {
            border: 1px solid var(--comm-border);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
        }

        .lcm-related-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(12, 45, 87, 0.1);
        }

        .lcm-related-thumb {
            height: 140px;
            background: #dfe8f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5e738f;
            font-weight: 700;
            overflow: hidden;
        }

        .lcm-related-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lcm-related-body {
            padding: 16px;
        }

        .lcm-related-body h3 {
            font-size: 15px;
            margin: 0 0 8px;
            color: var(--comm-text);
        }

        .lcm-related-body p {
            font-size: 12px;
            color: var(--comm-muted);
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .lcm-article-main {
                grid-template-columns: 1fr;
            }

            .lcm-article-sidebar {
                order: -1;
            }

            .lcm-article-title {
                font-size: 26px;
            }

            .lcm-related-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .lcm-article-content {
                padding: 24px 20px;
            }

            .lcm-related-section {
                padding: 24px 20px;
            }
        }
    </style>

    <div class="lcm-detail-wrapper">
        <div class="lcm-detail-container">

            <!-- Breadcrumb -->
            <nav class="lcm-breadcrumb">
                <a href="{{ route('community.index') }}">Communauté</a>
                <span>›</span>
                <span>{{ $submission->section }}</span>
                <span>›</span>
                <span>{{ Str::limit($submission->title, 50) }}</span>
            </nav>

            <!-- Article principal + Sidebar -->
            <div class="lcm-article-main">

                <!-- Contenu principal -->
                <article class="lcm-article-content">

                    <!-- Badges meta -->
                    <div class="lcm-article-meta-top">
                        <span class="lcm-meta-badge section">{{ $submission->section }}</span>
                        <span class="lcm-meta-badge access-{{ $submission->access_type }}">
                            {{ $submission->access_type === 'premium' ? '💎 Premium' : '🌐 Gratuit' }}
                        </span>
                        <span class="lcm-meta-badge status-{{ $submission->status }}">
                            {{ $submission->status_label }}
                        </span>
                        <span style="margin-left: auto; font-size: 13px; color: var(--comm-muted);">
                            {{ $submission->created_at->format('d/m/Y à H:i') }}
                        </span>
                    </div>

                    <!-- Titre -->
                    <h1 class="lcm-article-title">{{ $submission->title }}</h1>

                    <!-- Info auteur -->
                    <div class="lcm-article-author-info">
                        <div class="lcm-author-avatar">
                            {{ strtoupper(substr($submission->user->prenom, 0, 1)) }}{{ strtoupper(substr($submission->user->nom, 0, 1)) }}
                        </div>
                        <div class="lcm-author-details">
                            <h4>{{ $submission->user->prenom }} {{ $submission->user->nom }}</h4>
                            <p>
                                Contributeur LCM
                                @if ($submission->user->city)
                                    • {{ $submission->user->city }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Image -->
                    @if ($submission->image_path)
                        <img src="{{ Storage::url($submission->image_path) }}" alt="{{ $submission->title }}"
                            class="lcm-article-image">
                    @else
                        <div class="lcm-article-image-placeholder">
                            📷 Aucune image fournie
                        </div>
                    @endif

                    <!-- Contenu / Résumé -->
                    <div class="lcm-article-body text-justify">
                        {!! nl2br(e($submission->summary)) !!}
                    </div>

                    <!-- Notice de rejet si applicable -->
                    @if ($submission->status === 'rejected' && $submission->rejection_reason)
                        <div class="lcm-rejection-notice">
                            <h4>❌ Soumission refusée</h4>
                            <p><strong>Raison :</strong> {{ $submission->rejection_reason }}</p>
                        </div>
                    @endif

                </article>

                <!-- Sidebar -->
                <aside class="lcm-article-sidebar">

                    <!-- Action rapide -->
                    <div class="lcm-sidebar-card">
                        <h3>✍️ Vous aussi, contribuez</h3>
                        <a href="{{ route('community.index') }}" class="lcm-sidebar-action">
                            Soumettre un article
                        </a>
                    </div>

                    <!-- Autres articles de l'auteur -->
                    @if ($otherSubmissions->isNotEmpty())
                        <div class="lcm-sidebar-card">
                            <h3>📝 Du même auteur</h3>
                            @foreach ($otherSubmissions as $other)
                                <div class="lcm-mini-submission">
                                    <h4>
                                        <a href="{{ route('community.show', $other) }}"
                                            style="color: inherit; text-decoration: none;">
                                            {{ Str::limit($other->title, 60) }}
                                        </a>
                                    </h4>
                                    <p>{{ $other->section }} • {{ $other->created_at->format('d/m/Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Retour -->
                    <div class="lcm-sidebar-card">
                        <a href="{{ route('community.index') }}" class="lcm-sidebar-action secondary">
                            ← Retour à la communauté
                        </a>
                    </div>

                </aside>

            </div>

            <!-- Soumissions similaires -->
            @if ($relatedSubmissions->isNotEmpty())
                <section class="lcm-related-section">
                    <h2>📚 Dans la même rubrique : {{ $submission->section }}</h2>
                    <div class="lcm-related-grid">
                        @foreach ($relatedSubmissions as $related)
                            <a href="{{ route('community.show', $related) }}" class="lcm-related-card">
                                <div class="lcm-related-thumb">
                                    @if ($related->image_path)
                                        <img src="{{ Storage::url($related->image_path) }}" alt="{{ $related->title }}">
                                    @else
                                        📄
                                    @endif
                                </div>
                                <div class="lcm-related-body">
                                    <h3>{{ Str::limit($related->title, 70) }}</h3>
                                    <p>
                                        Par {{ $related->user->prenom }} {{ $related->user->nom }}
                                        • {{ $related->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>
    </div>

@endsection
