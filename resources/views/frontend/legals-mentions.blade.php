@extends('layouts.frontend')

@section('title', 'Mentions légales - Ligne Claire Média+')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- En-tête -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 text-center">
                    Mentions légales
                </h1>
                <p class="text-lg text-gray-700 leading-relaxed">
                    Conformément aux dispositions légales en vigueur relatives aux services de communication au public en ligne, les présentes mentions légales ont pour objet d'informer les utilisateurs du site LCM Africa – Ligne Claire Média+ sur l'identité des responsables du site et les conditions de son utilisation.
                </p>
            </div>

            <!-- Éditeur du site -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Éditeur du site
                </h2>
                <div class="space-y-3 text-gray-700">
                    <p class="font-semibold text-lg">Ligne Claire Média+ (LCM+)</p>
                    <p>Média indépendant – Presse écrite & audiovisuelle 100 % numérique</p>
                    <p><span class="font-medium">Nom commercial :</span> LCM Africa – Ligne Claire Média+</p>
                    <p><span class="font-medium">Site web :</span> <a href="https://www.lcmafrica.com" class="text-blue-600 hover:underline">https://www.lcmafrica.com</a></p>
                    <div class="pt-4">
                        <p class="font-medium mb-2">📧 Contact presse, rédaction et demandes institutionnelles :</p>
                        <a href="mailto:presse@lcmafrica.com" class="text-blue-600 hover:underline text-lg">presse@lcmafrica.com</a>
                    </div>
                </div>
            </div>

            <!-- Direction du média -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Direction du média
                </h2>
                <div class="space-y-4 text-gray-700">
                    <div>
                        <p class="font-medium text-lg mb-1">Directeur de la publication :</p>
                        <p class="text-gray-900">Nafiou OGOUCHOLA</p>
                    </div>
                    <div>
                        <p class="font-medium text-lg mb-1">Directeur Général :</p>
                        <p class="text-gray-900">Boubacar BONI BIAO</p>
                    </div>
                    <p class="pt-2 text-gray-600">Ligne Claire Média+</p>
                </div>
            </div>

            <!-- Hébergement -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Hébergement
                </h2>
                <p class="text-gray-700 mb-4">Le site lcmafrica.com est hébergé par :</p>
                <div class="space-y-2 text-gray-700">
                    <p class="font-semibold text-lg">Amazon Web Services (AWS)</p>
                    <p>Amazon Web Services, Inc.</p>
                    <p>410 Terry Avenue North</p>
                    <p>Seattle, WA 98109 – États-Unis</p>
                    <p><span class="font-medium">Site web :</span> <a href="https://aws.amazon.com" class="text-blue-600 hover:underline" target="_blank" rel="noopener">https://aws.amazon.com</a></p>
                </div>
            </div>

            <!-- Nature du site -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Nature du site
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>LCM Africa est un média d'information indépendant, exclusivement numérique.</p>
                    <p>Il publie des contenus journalistiques sous forme d'articles, d'analyses, d'enquêtes, de reportages, de vidéos, de podcasts et de formats multimédias.</p>
                    <p>Le média s'organise notamment autour de trois pôles éditoriaux :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>LCM Communauté</li>
                        <li>LCM Investigation</li>
                        <li>LCM Témoins</li>
                    </ul>
                </div>
            </div>

            <!-- Indépendance éditoriale -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Indépendance éditoriale
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>Ligne Claire Média+ est un média totalement indépendant, ne bénéficiant d'aucune subvention publique directe.</p>
                    <p>Il n'est soumis à aucune influence politique, économique ou partisane.</p>
                    <p>Son financement repose principalement sur :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>les dons des lecteurs et citoyens,</li>
                        <li>les abonnements,</li>
                        <li>le soutien des membres citoyens et ambassadeurs,</li>
                        <li>des partenariats transparents, clairement identifiés et sans ingérence éditoriale.</li>
                    </ul>
                    <p class="pt-2 font-medium">Ce modèle garantit la liberté, la responsabilité et l'intégrité de la ligne éditoriale du média.</p>
                </div>
            </div>

            <!-- Propriété intellectuelle -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Propriété intellectuelle
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>L'ensemble des contenus publiés sur le site lcmafrica.com (textes, articles, images, vidéos, graphismes, logos, podcasts, éléments sonores et visuels) est protégé par le droit de la propriété intellectuelle.</p>
                    <p>Toute reproduction, représentation, modification ou exploitation, totale ou partielle, des contenus du site est interdite sans autorisation écrite préalable de Ligne Claire Média+, sauf exceptions prévues par la loi.</p>
                </div>
            </div>

            <!-- Responsabilité éditoriale -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Responsabilité éditoriale
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>LCM+ s'efforce de fournir une information fiable, vérifiée et mise à jour.</p>
                    <p>Toutefois, le média ne saurait être tenu responsable d'erreurs, d'omissions ou d'une indisponibilité temporaire du site.</p>
                    <p>Les opinions exprimées dans les tribunes, contributions et articles signés n'engagent que leurs auteurs et ne reflètent pas nécessairement la position de la rédaction.</p>
                </div>
            </div>

            <!-- Contributions citoyennes -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Contributions citoyennes
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>Les contenus transmis par des contributeurs externes ou via les dispositifs participatifs (notamment LCM Témoins) font l'objet d'un traitement éditorial, de vérifications et de validations avant toute publication.</p>
                    <p>LCM+ se réserve le droit de refuser ou de modifier tout contenu ne respectant pas sa charte éditoriale ou les lois en vigueur.</p>
                </div>
            </div>

            <!-- Protection des données personnelles -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Protection des données personnelles
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>Les données personnelles collectées via le site sont utilisées exclusivement dans le cadre des activités éditoriales de Ligne Claire Média+.</p>
                    <p>Elles ne sont ni vendues ni cédées à des tiers.</p>
                    <p>Conformément à la réglementation en vigueur, tout utilisateur dispose d'un droit d'accès, de rectification ou de suppression de ses données, qu'il peut exercer en écrivant à : <a href="mailto:presse@lcmafrica.com" class="text-blue-600 hover:underline">presse@lcmafrica.com</a></p>
                </div>
            </div>

            <!-- Droit applicable -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Droit applicable
                </h2>
                <p class="text-gray-700">
                    Le présent site est soumis aux lois et règlements en vigueur en République du Bénin, ainsi qu'aux principes internationaux relatifs à la liberté de la presse et à la communication numérique.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
