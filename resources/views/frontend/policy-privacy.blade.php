@extends('layouts.frontend')

@section('title', 'Politique de confidentialité - Ligne Claire Média+')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- En-tête -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 text-center">
                    Politique de confidentialité
                </h1>
                <div class="space-y-4 text-gray-700">
                    <p>La présente politique de confidentialité a pour objectif d'informer les utilisateurs du site LCM Africa – Ligne Claire Média+ (<a href="https://www.lcmafrica.com" class="text-blue-600 hover:underline">https://www.lcmafrica.com</a>) sur la manière dont leurs données personnelles sont collectées, utilisées et protégées.</p>
                    <p class="font-medium">Ligne Claire Média+ attache une importance particulière au respect de la vie privée et à la protection des données personnelles de ses utilisateurs.</p>
                </div>
            </div>

            <!-- 1. Responsable du traitement des données -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    1. Responsable du traitement des données
                </h2>
                <div class="space-y-3 text-gray-700">
                    <p>Le responsable du traitement des données personnelles est :</p>
                    <p class="font-semibold text-lg">Ligne Claire Média+ (LCM+)</p>
                    <p>Média indépendant – Presse écrite & audiovisuelle 100 % numérique</p>
                    <p>📧 Contact : <a href="mailto:presse@lcmafrica.com" class="text-blue-600 hover:underline">presse@lcmafrica.com</a></p>
                </div>
            </div>

            <!-- 2. Données personnelles collectées -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    2. Données personnelles collectées
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>LCM+ peut être amené à collecter les données personnelles suivantes :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>nom et prénom (ou pseudonyme) ;</li>
                        <li>adresse e-mail ;</li>
                        <li>numéro de téléphone (le cas échéant) ;</li>
                        <li>informations transmises volontairement via les formulaires (messages, contributions, témoignages) ;</li>
                        <li>données liées aux dons ou abonnements (sans conservation des données bancaires) ;</li>
                        <li>données techniques de navigation (adresse IP, type de navigateur, pages consultées).</li>
                    </ul>
                    <p class="font-medium">Aucune donnée sensible n'est collectée sans le consentement explicite de l'utilisateur.</p>
                </div>
            </div>

            <!-- 3. Finalités de la collecte -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    3. Finalités de la collecte
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>Les données personnelles sont collectées uniquement pour les finalités suivantes :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>gestion des demandes de contact et des échanges avec la rédaction ;</li>
                        <li>traitement des contributions éditoriales et des témoignages citoyens ;</li>
                        <li>gestion des dons, abonnements et soutiens citoyens ;</li>
                        <li>envoi d'informations liées à l'activité de LCM+ (si l'utilisateur y a consenti) ;</li>
                        <li>amélioration de l'expérience utilisateur et du fonctionnement du site ;</li>
                        <li>respect des obligations légales et réglementaires.</li>
                    </ul>
                </div>
            </div>

            <!-- 4. Base légale du traitement -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    4. Base légale du traitement
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>Le traitement des données personnelles repose sur :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>le consentement explicite de l'utilisateur ;</li>
                        <li>l'exécution d'un service demandé (contact, contribution, don) ;</li>
                        <li>l'intérêt légitime de LCM+ à assurer le bon fonctionnement de son média.</li>
                    </ul>
                </div>
            </div>

            <!-- 5. Conservation des données -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    5. Conservation des données
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>Les données personnelles sont conservées uniquement pendant la durée nécessaire aux finalités pour lesquelles elles ont été collectées, sauf obligation légale contraire.</p>
                    <p>LCM+ met en œuvre des mesures pour garantir que les données ne soient pas conservées au-delà de cette durée.</p>
                </div>
            </div>

            <!-- 6. Partage des données -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    6. Partage des données
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>Les données personnelles collectées par LCM+ :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>ne sont ni vendues, ni louées, ni cédées à des tiers ;</li>
                        <li>peuvent être accessibles uniquement aux membres habilités de l'équipe LCM+ ;</li>
                        <li>peuvent être hébergées sur des serveurs sécurisés (notamment via Amazon Web Services – AWS).</li>
                    </ul>
                    <p class="font-medium">Aucune donnée n'est utilisée à des fins commerciales externes.</p>
                </div>
            </div>

            <!-- 7. Sécurité des données -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    7. Sécurité des données
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>LCM+ met en place des mesures techniques et organisationnelles appropriées afin de garantir la sécurité, la confidentialité et l'intégrité des données personnelles, notamment :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>hébergement sécurisé ;</li>
                        <li>accès restreint aux données ;</li>
                        <li>protection contre les accès non autorisés, pertes ou altérations.</li>
                    </ul>
                    <p>Malgré ces mesures, aucun système n'est totalement sécurisé. LCM+ s'engage toutefois à réagir rapidement en cas d'incident.</p>
                </div>
            </div>

            <!-- 8. Droits des utilisateurs -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    8. Droits des utilisateurs
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>Conformément aux principes internationaux de protection des données, chaque utilisateur dispose des droits suivants :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>droit d'accès à ses données personnelles ;</li>
                        <li>droit de rectification des données inexactes ;</li>
                        <li>droit à l'effacement de ses données ;</li>
                        <li>droit de limitation ou d'opposition au traitement ;</li>
                        <li>droit de retrait du consentement à tout moment.</li>
                    </ul>
                    <p>Toute demande peut être adressée à :<br>
                    📧 <a href="mailto:presse@lcmafrica.com" class="text-blue-600 hover:underline">presse@lcmafrica.com</a></p>
                </div>
            </div>

            <!-- 9. Cookies -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    9. Cookies
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>Le site LCM Africa peut utiliser des cookies ou technologies similaires afin de :</p>
                    <ul class="list-disc list-inside pl-4 space-y-2">
                        <li>améliorer la navigation ;</li>
                        <li>mesurer l'audience ;</li>
                        <li>optimiser les performances du site.</li>
                    </ul>
                    <p>L'utilisateur peut configurer son navigateur pour refuser ou limiter l'utilisation des cookies.</p>
                </div>
            </div>

            <!-- 10. Contributions et témoignages -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    10. Contributions et témoignages
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>Les données transmises dans le cadre des dispositifs LCM Communauté, LCM Investigation et LCM Témoins sont traitées avec une attention particulière.</p>
                    <p>Les informations personnelles liées à ces contributions sont utilisées exclusivement à des fins journalistiques, éditoriales et de vérification, dans le respect de la confidentialité des sources.</p>
                </div>
            </div>

            <!-- 11. Modification de la politique de confidentialité -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    11. Modification de la politique de confidentialité
                </h2>
                <div class="space-y-4 text-gray-700">
                    <p>LCM+ se réserve le droit de modifier la présente politique de confidentialité à tout moment afin de l'adapter à l'évolution du site ou du cadre légal.</p>
                    <p>Les utilisateurs sont invités à la consulter régulièrement.</p>
                </div>
            </div>

            <!-- 12. Droit applicable -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    12. Droit applicable
                </h2>
                <p class="text-gray-700">
                    La présente politique de confidentialité est régie par les lois en vigueur en République du Bénin, ainsi que par les principes internationaux relatifs à la protection des données personnelles.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
