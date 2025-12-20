@extends('layouts.frontend')

@section('title', 'Qui sommes-nous - Ligne Claire Média+')

@section('content')
<div class="bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 text-white">
        <div class="container mx-auto px-4 py-20 md:py-28">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Qui sommes-nous ?
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 leading-relaxed">
                    Ligne Claire Média+ est un média indépendant, 100 % numérique, fondé au Bénin avec l'ambition de contribuer à une information claire, fiable et accessible, au service de l'intérêt public.
                </p>
            </div>
        </div>
    </div>

    <!-- Introduction -->
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <p class="text-lg text-gray-700 leading-relaxed text-justify">
                    Dans un environnement médiatique fragilisé par la désinformation, les pressions économiques et la défiance croissante du public, LCM+ est né d'une conviction simple : <span class="font-semibold text-gray-900">une démocratie solide repose sur une information rigoureuse, vérifiée et indépendante.</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Notre Mission -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Notre mission
                    </h2>
                    <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 md:p-12">
                    <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                        LCM+ a pour mission de :
                    </p>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-600 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">informer avec exactitude et responsabilité ;</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-600 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">analyser les enjeux politiques, économiques, sociaux et culturels ;</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-600 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">enquêter sur les sujets d'intérêt général ;</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-600 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">donner la parole aux citoyens, aux experts et aux acteurs de la société civile ;</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-600 text-xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">rendre l'information compréhensible, sans la simplifier à l'excès.</span>
                        </li>
                    </ul>

                    <p class="text-lg text-gray-800 font-medium bg-white rounded-lg p-6 shadow-md">
                        Nous privilégions un journalisme de fond, exigeant, fondé sur les faits, les données et la confrontation des points de vue.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Un média indépendant -->
    <div class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Un média indépendant par choix
                    </h2>
                    <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                            {{-- <i class="fas fa-shield-alt text-blue-600 text-2xl"></i> --}}
                            <!-- Au lieu de fas fa-shield-alt -->
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Notre indépendance</h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            LCM+ est un média totalement indépendant.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            Nous ne recevons aucune subvention publique et n'acceptons aucune influence politique, économique ou partisane sur notre ligne éditoriale.
                        </p>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                            {{-- <i class="fas fa-coins text-green-600 text-2xl"></i> --}}
                            <!-- Au lieu de fas fa-coins -->
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Notre modèle</h3>
                        <p class="text-gray-700 leading-relaxed mb-3">Notre fonctionnement repose sur :</p>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-circle text-green-600 text-xs mt-2"></i>
                                <span>le soutien des lecteurs et citoyens ;</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-circle text-green-600 text-xs mt-2"></i>
                                <span>les dons et abonnements ;</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-circle text-green-600 text-xs mt-2"></i>
                                <span>des partenariats transparents, encadrés et clairement identifiés.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 bg-blue-600 text-white rounded-xl p-6 text-center">
                    <p class="text-lg font-medium">
                        Ce modèle garantit notre liberté éditoriale et notre responsabilité vis-à-vis du public.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Une équipe expérimentée -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Une équipe expérimentée et innovante
                    </h2>
                    <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
                </div>

                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 md:p-12">
                    <p class="text-lg text-gray-700 mb-8 leading-relaxed">
                        LCM+ est porté par :
                    </p>

                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white rounded-lg p-6 shadow-md border-l-4 border-blue-600">
                            <div class="flex items-start gap-4">
                                <i class="fas fa-users text-blue-600 text-3xl mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-2">Équipe éditoriale</h4>
                                    <p class="text-gray-700">
                                        Des journalistes disposant chacun de plus de vingt années d'expérience en investigation, analyse et reportage
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-6 shadow-md border-l-4 border-green-600">
                            <div class="flex items-start gap-4">
                                <i class="fas fa-laptop-code text-green-600 text-3xl mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-2">Équipe technique</h4>
                                    <p class="text-gray-700">
                                        Une équipe jeune et qualifiée, spécialisée dans le numérique, l'audiovisuel et l'innovation médiatique
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-600 text-white rounded-lg p-6 text-center">
                        <p class="text-lg font-medium">
                            Ensemble, nous développons un média moderne, agile et adapté aux nouveaux usages de l'information.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Média 100% numérique -->
    <div class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Un média 100 % numérique et responsable
                    </h2>
                    <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        LCM+ est un média sans support papier, pensé dès sa conception comme une plateforme numérique complète.
                    </p>

                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        Ce choix s'inscrit dans :
                    </p>

                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center p-6 bg-green-50 rounded-lg">
                            <i class="fas fa-leaf text-green-600 text-4xl mb-4"></i>
                            <p class="text-gray-700 font-medium">Une démarche écologique et durable</p>
                        </div>
                        <div class="text-center p-6 bg-blue-50 rounded-lg">
                            <i class="fas fa-seedling text-blue-600 text-4xl mb-4"></i>
                            <p class="text-gray-700 font-medium">Une volonté de réduire l'empreinte environnementale de la presse</p>
                        </div>
                        <div class="text-center p-6 bg-purple-50 rounded-lg">
                            <i class="fas fa-handshake text-purple-600 text-4xl mb-4"></i>
                            <p class="text-gray-700 font-medium">Une approche alignée avec les principes de la RSE</p>
                        </div>
                    </div>

                    <div class="mt-6 bg-gray-100 rounded-lg p-4">
                        <p class="text-gray-700 text-center">
                            <span class="font-semibold">RSE :</span> transparence, durabilité, impact social et inclusion
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nos pôles éditoriaux -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">
                        Nos pôles éditoriaux
                    </h2>
                    <div class="w-24 h-1 bg-blue-500 mx-auto mb-6"></div>
                    <p class="text-xl text-gray-300">
                        LCM+ s'organise autour de trois pôles complémentaires
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- LCM Communauté -->
                    <div class="bg-white text-gray-900 rounded-xl shadow-xl overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white">
                            <i class="fas fa-users-cog text-4xl mb-3"></i>
                            <h3 class="text-2xl font-bold">LCM Communauté</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 leading-relaxed text-justify">
                                Un espace éditorial ouvert aux journalistes indépendants, universitaires, analystes, experts et auteurs, favorisant le pluralisme, la réflexion et le débat public de qualité.
                            </p>
                        </div>
                    </div>

                    <!-- LCM Investigation -->
                    <div class="bg-white text-gray-900 rounded-xl shadow-xl overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
                        <div class="bg-gradient-to-br from-red-500 to-red-600 p-6 text-white">
                            <i class="fas fa-search text-4xl mb-3"></i>
                            <h3 class="text-2xl font-bold">LCM Investigation</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 leading-relaxed text-justify">
                                Une cellule dédiée aux enquêtes approfondies sur les enjeux de gouvernance, d'économie, de justice, d'environnement, de santé et de société, avec un journalisme d'impact fondé sur la vérification et la rigueur.
                            </p>
                        </div>
                    </div>

                    <!-- LCM Témoins -->
                    <div class="bg-white text-gray-900 rounded-xl shadow-xl overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 text-white">
                            <i class="fas fa-camera text-4xl mb-3"></i>
                            <h3 class="text-2xl font-bold">LCM Témoins</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 leading-relaxed text-justify">
                                Un dispositif participatif permettant aux citoyens de transmettre témoignages, photos, vidéos et alertes, analysés et vérifiés par notre rédaction, afin de documenter les réalités du terrain.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notre engagement -->
    <div class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Notre engagement
                    </h2>
                    <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                    <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                        LCM+ s'engage à :
                    </p>

                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                            <i class="fas fa-balance-scale text-blue-600 text-2xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">respecter l'éthique journalistique;</span>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                            <i class="fas fa-user-shield text-blue-600 text-2xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">protéger ses sources;</span>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                            <i class="fas fa-divide text-blue-600 text-2xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">séparer strictement information et communication;</span>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                            <i class="fas fa-clipboard-check text-blue-600 text-2xl mt-1 flex-shrink-0"></i>
                            <span class="text-gray-700 text-lg">rendre des comptes à son public.</span>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl p-8 text-center">
                        <p class="text-xl font-bold mb-4">
                            LCM+ n'appartient à aucun groupe d'intérêt.
                        </p>
                        <p class="text-lg">
                            Il appartient à celles et ceux qui croient qu'une information libre se construit avec rigueur, indépendance et responsabilité.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Final -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center text-white">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    Soutenez un journalisme indépendant
                </h2>
                <p class="text-xl text-blue-100 mb-8">
                    Votre soutien est essentiel pour garantir notre indépendance et la qualité de notre travail.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('contact') }}"
                        class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold hover:bg-blue-50 transition shadow-lg inline-flex items-center gap-2">
                        <i class="fas fa-envelope"></i>
                        Nous contacter
                    </a>
                    <a href="{{ route('team.index') }}"
                        class="bg-blue-700 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-800 transition shadow-lg inline-flex items-center gap-2">
                        <i class="fas fa-users"></i>
                        Rencontrer l'équipe
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
