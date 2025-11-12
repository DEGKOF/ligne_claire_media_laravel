@extends('layouts.frontend')

@section('title', 'LCM Communauté — la voix des contributeurs')

@section('content')
<style>

        .container {
            max-width: 1220px;
            margin: 0 auto;
            /* padding: 0 22px */
        }
/* Styles isolés pour la communauté */
.lcm-community-wrapper {
    --comm-blue: #0C2D57;
    --comm-blue-2: #184178;
    --comm-blue-light: #2563eb;
    --comm-accent: #FFD54F;
    --comm-bg: #f6f8fb;
    --comm-bg-soft: #fafbfd;
    --comm-text: #1f2630;
    --comm-muted: #6c7a8a;
    --comm-ok: #2fa66a;
    --comm-warn: #ff9f40;
    --comm-danger: #e05263;
    --comm-border: #e7edf5;
    padding: 10px 0;
    background: var(--comm-bg);
}

.lcm-community-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Hero - Fond dégradé doux */
.lcm-community-hero {
    background: linear-gradient(180deg, #fafcfe, #f0f6ff);
    padding: 30px 20px 30px;
    border-radius: 16px;
    margin-bottom: 40px;
    border: 1px solid var(--comm-border);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.lcm-community-hero:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(12, 45, 87, 0.12);
    border-color: rgba(12, 45, 87, 0.2);
}

.lcm-community-hero h1 {
    font-size: 36px;
    color: var(--comm-blue);
    margin: 0 0 15px;
    transition: color 0.3s ease;
}

.lcm-community-hero:hover h1 {
    /* color: var(--comm-blue-light); */
}

.lcm-community-hero h2 {
    font-size: 24px;
    color: var(--comm-blue);
    margin: 20px 0 15px;
    font-weight: 700;
    transition: transform 0.3s ease;
}

.lcm-community-hero:hover h2 {
    transform: scale(1.02);
}

.lcm-community-hero p {
    font-size: 18px;
    color: #425060;
    max-width: 800px;
    line-height: 1.6;
}

/* Boutons avec animations */
.lcm-comm-submit-btn {
    background: white;
    color: var(--comm-blue);
    border: 2px solid var(--comm-blue);
    display: inline-block;
    padding: 14px 24px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.lcm-comm-submit-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(12, 45, 87, 0.1);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.lcm-comm-submit-btn:hover::before {
    width: 300px;
    height: 300px;
}

.lcm-comm-submit-btn:hover {
    background: var(--comm-blue);
    /* color: white !important; */
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(12, 45, 87, 0.25);
}

.lcm-comm-submit-btn2 {
    display: inline-block;
    background: var(--comm-blue);
    color: white;
    padding: 16px 32px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 16px;
    border: none;
    cursor: pointer;
    margin-top: 24px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    box-shadow: 0 4px 16px rgba(12, 45, 87, 0.2);
    position: relative;
    overflow: hidden;
}

.lcm-comm-submit-btn2::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.lcm-comm-submit-btn2:hover::after {
    width: 400px;
    height: 400px;
}

.lcm-comm-submit-btn2:hover {
    background: var(--comm-blue-2);
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 8px 24px rgba(12, 45, 87, 0.3);
}

/* Panel avec fond doux et animations */
.panel {
    background: linear-gradient(135deg, #fafcfe 0%, #f5f9ff 100%);
    border: 1px solid var(--comm-border);
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 16px rgba(12, 45, 87, 0.06);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.panel:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 32px rgba(12, 45, 87, 0.12);
    border-color: rgba(12, 45, 87, 0.2);
    background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
}

/* Grille des soumissions */
.lcm-submissions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    margin: 40px 0;
}

.lcm-submission-card {
    background: linear-gradient(135deg, #ffffff 0%, #fafcfe 100%);
    border: 1px solid var(--comm-border);
    border-radius: 14px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.lcm-submission-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--comm-blue), var(--comm-blue-light));
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.lcm-submission-card:hover::before {
    transform: scaleX(1);
}

.lcm-submission-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 16px 40px rgba(12, 45, 87, 0.15);
    border-color: var(--comm-blue);
    background: linear-gradient(135deg, #ffffff 0%, #f5f9ff 100%);
}

.lcm-submission-thumb {
    height: 180px;
    background: linear-gradient(135deg, #e8f1ff, #d5e5ff);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #5e738f;
    font-weight: 700;
    overflow: hidden;
    transition: all 0.4s ease;
}

.lcm-submission-card:hover .lcm-submission-thumb {
    transform: scale(1.05);
}

.lcm-submission-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.lcm-submission-card:hover .lcm-submission-thumb img {
    transform: scale(1.1);
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
    background: linear-gradient(135deg, #e8f1ff, #dae7ff);
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    color: #4a596d;
    transition: all 0.3s ease;
}

.lcm-submission-card:hover .lcm-submission-section {
    background: var(--comm-blue);
    color: white;
    transform: scale(1.05);
}

.lcm-submission-access {
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
    transition: all 0.3s ease;
}

.lcm-submission-access.free {
    color: var(--comm-ok);
    background: #e8f5f0;
}

.lcm-submission-card:hover .lcm-submission-access.free {
    background: var(--comm-ok);
    color: white;
    transform: scale(1.05);
}

.lcm-submission-access.premium {
    color: #b25b00;
    background: #fff4e6;
}

.lcm-submission-card:hover .lcm-submission-access.premium {
    background: #ff9f40;
    color: white;
    transform: scale(1.05);
}

.lcm-submission-status {
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
    transition: all 0.3s ease;
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
    transition: all 0.3s ease;
}

.lcm-submission-card:hover h3 {
    color: var(--comm-blue);
    transform: translateX(5px);
}

.lcm-submission-author {
    font-size: 13px;
    color: var(--comm-muted);
}

/* Cartes d'offres avec animations */
.offer-card {
    background: linear-gradient(135deg, #f8fbff 0%, #f0f6ff 100%);
    border: 1px solid var(--comm-border);
    border-radius: 12px;
    padding: 20px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.offer-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(12, 45, 87, 0.05), transparent);
    transition: left 0.6s ease;
}

.offer-card:hover::before {
    left: 100%;
}

.offer-card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 12px 32px rgba(12, 45, 87, 0.15);
    border-color: var(--comm-blue);
    background: linear-gradient(135deg, #ffffff 0%, #f5f9ff 100%);
}

.offer-card h3 {
    color: var(--comm-blue);
    margin: 0 0 10px;
    font-size: 16px;
    font-weight: 700;
    transition: all 0.3s ease;
}

.offer-card:hover h3 {
    transform: translateX(5px);
    color: var(--comm-blue-light);
}

.offer-card p {
    margin: 0;
    color: var(--comm-muted);
    line-height: 1.6;
}

/* Étapes "Comment ça marche" avec animations */
.step-item {
    display: flex;
    gap: 15px;
    align-items: start;
    padding: 15px;
    background: linear-gradient(135deg, #fafcff 0%, #f5f9ff 100%);
    border-radius: 10px;
    border-left: 4px solid var(--comm-blue);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: default;
}

.step-item:hover {
    transform: translateX(10px);
    box-shadow: 0 8px 24px rgba(12, 45, 87, 0.12);
    border-left-width: 6px;
    background: linear-gradient(135deg, #ffffff 0%, #f0f6ff 100%);
}

.step-number {
    background: var(--comm-blue);
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.step-item:hover .step-number {
    transform: scale(1.2) rotate(360deg);
    background: var(--comm-blue-light);
    box-shadow: 0 4px 12px rgba(12, 45, 87, 0.3);
}

.step-item h3 {
    margin: 0 0 5px;
    color: var(--comm-blue);
    font-size: 16px;
    font-weight: 700;
    transition: all 0.3s ease;
}

.step-item:hover h3 {
    color: var(--comm-blue-light);
}

.step-item p {
    margin: 0;
    color: var(--comm-muted);
    line-height: 1.6;
}

/* Encadré info avec animations */
.info-box {
    background: linear-gradient(135deg, #e8f1ff, #f0f6ff);
    border-left: 5px solid var(--comm-blue);
    border-radius: 12px;
    padding: 20px;
    margin: 25px auto;
    max-width: 900px;
    text-align: left;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.info-box:hover {
    transform: translateX(10px);
    box-shadow: 0 8px 24px rgba(12, 45, 87, 0.12);
    border-left-width: 8px;
    background: linear-gradient(135deg, #d5e5ff, #e8f1ff);
}

.info-box h3 {
    color: var(--comm-blue);
    margin: 0 0 10px;
    font-size: 18px;
    transition: all 0.3s ease;
}

.info-box:hover h3 {
    transform: translateX(5px);
}

/* CTA final avec animations */
.cta-final {
    background: linear-gradient(135deg, var(--comm-blue), var(--comm-blue-2));
    border-radius: 16px;
    padding: 40px;
    text-align: center;
    margin-bottom: 40px;
    color: white;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.cta-final::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
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

.cta-final:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 20px 50px rgba(12, 45, 87, 0.3);
}

.cta-final h2 {
    margin: 0 0 15px;
    font-size: 28px;
    font-weight: 700;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
}

.cta-final:hover h2 {
    transform: scale(1.05);
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
    backdrop-filter: blur(4px);
}

.lcm-modal-overlay.active {
    display: flex !important;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
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
    animation: lcmModalSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes lcmModalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
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
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.lcm-modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg) scale(1.1);
}

.lcm-modal-body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
    background: #fafcfe;
}

.lcm-modal-footer {
    padding: 20px 24px;
    border-top: 1px solid var(--comm-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
    background: #f5f9ff;
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
    transition: all 0.3s ease;
    background: white;
}

.lcm-form-input:hover,
.lcm-form-select:hover,
.lcm-form-textarea:hover {
    border-color: var(--comm-blue-light);
    box-shadow: 0 2px 8px rgba(12, 45, 87, 0.08);
}

.lcm-form-input:focus,
.lcm-form-select:focus,
.lcm-form-textarea:focus {
    outline: none;
    border-color: var(--comm-blue);
    box-shadow: 0 0 0 3px rgba(12, 45, 87, 0.1);
    transform: translateY(-2px);
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
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.lcm-form-chip:hover {
    background: #dfe8f5;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 4px 12px rgba(12, 45, 87, 0.15);
}

.lcm-form-chip.active {
    border-color: var(--comm-blue);
    background: #e0ecff;
    color: var(--comm-blue);
    font-weight: 600;
    transform: scale(1.05);
}

.lcm-btn {
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    border: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.lcm-btn-primary {
    background: #0C2D57!important;
    color: white;
    border: 1px solid #0C2D57!important;
}

.lcm-btn-primary:hover {
    background: var(--comm-blue-2)!important;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(12, 45, 87, 0.3);
}

.lcm-btn-secondary {
    background: transparent;
    border: 2px solid #d7e1ee;
    color: var(--comm-text);
}

.lcm-btn-secondary:hover {
    background: #f5f7fa;
    transform: translateY(-2px);
    border-color: var(--comm-blue);
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
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.lcm-toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(-10px);
}

/* Panel mes soumissions */
.lcm-my-submissions {
    background: linear-gradient(135deg, #fafcfe 0%, #f5f9ff 100%);
    border: 1px solid var(--comm-border);
    border-radius: 14px;
    padding: 24px;
    margin: 40px 0;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.lcm-my-submissions:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(12, 45, 87, 0.12);
    background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
}

.lcm-my-submissions h3 {
    color: var(--comm-blue);
    margin: 0 0 20px;
    font-size: 18px;
}

.lcm-my-submission-item {
    padding: 16px;
    background: linear-gradient(135deg, #fafcff 0%, #f5f9ff 100%);
    border: 1px solid var(--comm-border);
    border-radius: 10px;
    margin-bottom: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.lcm-my-submission-item:hover {
    transform: translateX(10px);
    box-shadow: 0 4px 16px rgba(12, 45, 87, 0.1);
    background: white;
    border-color: var(--comm-blue);
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

    .lcm-community-hero h2 {
        font-size: 20px;
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

        <!-- Mes soumissions (si connecté) -->
        @if(Auth::check())
        <div class="lcm-my-submissions">
            <h3>Mes soumissions</h3>
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
                    <label class="lcm-form-label">Contenu / Résumé *</label>
                    <textarea name="summary" class="lcm-form-textarea" placeholder="Collez ici votre texte ou décrivez votre sujet..." required></textarea>
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
            </div>
        } catch (error) {
            console.error(error);
        }
    }

    loadMySubmissions();
    @endif
})();
</script>
@endsection
