@extends('layouts.frontend')

@section('title', 'Conditions Générales d\'Utilisation - Ligne Claire Média+')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- En-tête -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 text-center">
                    Conditions Générales d'Utilisation (CGU)
                </h1>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>Les présentes Conditions Générales d'Utilisation ont pour objet de définir les modalités d'accès et d'utilisation du site LCM Africa – Ligne Claire Média+, accessible à l'adresse :</p>
                    <p>👉 <a href="https://www.lcmafrica.com" class="text-blue-600 hover:underline font-medium">https://www.lcmafrica.com</a></p>
                    <p class="font-medium">En naviguant sur ce site, l'utilisateur reconnaît avoir pris connaissance des présentes CGU et les accepter sans réserve.</p>
                </div>
            </div>

            <!-- 1. Présentation du site -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    1. Présentation du site
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>LCM Africa – Ligne Claire Média+ (LCM+) est un média d'information indépendant, presse écrite et audiovisuelle 100 % numérique.</p>
                    <p>Le site propose notamment :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>des articles d'actualité, analyses et enquêtes ;</li>
                        <li>des contenus audiovisuels (vidéos, podcasts, émissions) ;</li>
                        <li>des contributions éditoriales externes ;</li>
                        <li>des dispositifs participatifs (LCM Communauté, LCM Investigation, LCM Témoins) ;</li>
                        <li>des appels aux dons et abonnements citoyens.</li>
                    </ul>
                </div>
            </div>

            <!-- 2. Accès au site -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    2. Accès au site
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>L'accès au site est libre et gratuit, hors contenus réservés aux abonnés ou membres.</p>
                    <p>LCM+ se réserve le droit de :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>suspendre temporairement ou définitivement l'accès au site pour maintenance ou raisons techniques ;</li>
                        <li>limiter l'accès à certains contenus sans préavis.</li>
                    </ul>
                    <p>L'utilisateur est responsable de son équipement et de sa connexion Internet.</p>
                </div>
            </div>

            <!-- 3. Utilisation du site -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    3. Utilisation du site
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>L'utilisateur s'engage à utiliser le site :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>dans le respect des lois en vigueur ;</li>
                        <li>dans le respect des présentes CGU ;</li>
                        <li>de manière loyale, responsable et non préjudiciable.</li>
                    </ul>
                    <p className="font-medium pt-2">Il est strictement interdit :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>de porter atteinte à l'intégrité du site ;</li>
                        <li>de publier des contenus diffamatoires, haineux, violents, discriminatoires ou contraires à l'ordre public ;</li>
                        <li>d'usurper l'identité d'autrui ;</li>
                        <li>de détourner les fonctionnalités du site à des fins frauduleuses.</li>
                    </ul>
                </div>
            </div>

            <!-- 4. Contenus éditoriaux -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    4. Contenus éditoriaux
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>Les contenus publiés sur LCM+ sont produits par la rédaction, des journalistes partenaires ou des contributeurs externes.</p>
                    <p>LCM+ s'efforce de fournir une information fiable, vérifiée et rigoureuse, sans garantir l'absence totale d'erreurs ou d'omissions.</p>
                    <p>Les opinions exprimées dans les tribunes, analyses ou contributions signées n'engagent que leurs auteurs.</p>
                </div>
            </div>

            <!-- 5. Contributions des utilisateurs -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    5. Contributions des utilisateurs
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>Les utilisateurs peuvent proposer des contenus (articles, tribunes, témoignages, photos, vidéos) via les dispositifs dédiés.</p>
                    <p>Toute contribution :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>est soumise à un contrôle éditorial ;</li>
                        <li>peut être acceptée, modifiée ou refusée sans obligation de justification ;</li>
                        <li>doit respecter la charte éditoriale et les lois en vigueur.</li>
                    </ul>
                    <p>En soumettant un contenu, l'utilisateur autorise LCM+ à l'exploiter à des fins éditoriales, sans contrepartie financière automatique, sauf accord spécifique.</p>
                </div>
            </div>

            <!-- 6. Dispositif LCM Témoins -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    6. Dispositif LCM Témoins
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>Les témoignages transmis par les citoyens font l'objet :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>d'un examen éditorial ;</li>
                        <li>de vérifications ;</li>
                        <li>d'un traitement journalistique avant toute publication.</li>
                    </ul>
                    <p>LCM+ se réserve le droit de ne pas publier un témoignage jugé non conforme, non vérifiable ou contraire à sa ligne éditoriale.</p>
                </div>
            </div>

            <!-- 7. Dons, abonnements et soutien citoyen -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    7. Dons, abonnements et soutien citoyen
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>LCM+ propose un modèle de financement citoyen reposant sur :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>les dons ponctuels ou récurrents ;</li>
                        <li>les abonnements ;</li>
                        <li>l'adhésion en tant que membre citoyen ou ambassadeur.</li>
                    </ul>
                    <p>Les dons sont volontaires, non obligatoires et non remboursables, sauf disposition légale contraire.</p>
                    <p>Les soutiens financiers n'impliquent aucun droit d'ingérence dans les contenus éditoriaux, mais peuvent ouvrir un droit de regard consultatif, selon les modalités précisées par LCM+.</p>
                </div>
            </div>

            <!-- 8. Propriété intellectuelle -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    8. Propriété intellectuelle
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>L'ensemble des contenus du site (textes, images, vidéos, graphismes, logos, sons) est protégé par le droit de la propriété intellectuelle.</p>
                    <p>Toute reproduction, diffusion ou exploitation sans autorisation écrite préalable de LCM+ est interdite.</p>
                </div>
            </div>

            <!-- 9. Responsabilité -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    9. Responsabilité
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>LCM+ ne saurait être tenu responsable :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>d'une interruption du service ;</li>
                        <li>de dommages directs ou indirects liés à l'utilisation du site ;</li>
                        <li>du contenu des sites tiers accessibles via des liens hypertextes.</li>
                    </ul>
                </div>
            </div>

            <!-- 10. Protection des données personnelles -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    10. Protection des données personnelles
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>Les données personnelles collectées sont utilisées exclusivement pour les besoins éditoriaux et administratifs de LCM+.</p>
                    <p>Aucune donnée n'est vendue ou cédée à des tiers.</p>
                    <p>Toute demande relative aux données personnelles peut être adressée à :<br>
                    📧 <a href="mailto:presse@lcmafrica.com" class="text-blue-600 hover:underline">presse@lcmafrica.com</a></p>
                </div>
            </div>

            <!-- 11. Modification des CGU -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    11. Modification des CGU
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>LCM+ se réserve le droit de modifier à tout moment les présentes CGU.</p>
                    <p>Les utilisateurs sont invités à les consulter régulièrement.</p>
                </div>
            </div>

            <!-- 12. Droit applicable -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    12. Droit applicable
                </h2>
                <div class="space-y-4 text-gray-700 text-justify">
                    <p>Les présentes CGU sont régies par les lois en vigueur en République du Bénin.</p>
                    <p>En cas de litige, une solution amiable sera recherchée avant toute action judiciaire.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
