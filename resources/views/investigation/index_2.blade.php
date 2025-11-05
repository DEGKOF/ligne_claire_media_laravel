@extends('layouts.admin')

@section('title', 'Pôle Investigation - Proposez vos enquêtes')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Hero Section --}}
    <section class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Pôle Investigation</h1>
                <p class="text-xl mb-8 text-red-100">
                    Proposez des sujets d'enquête journalistique. La communauté finance, nous enquêtons.
                </p>
                <button onclick="document.getElementById('submit-form').scrollIntoView({behavior: 'smooth'})"
                        class="bg-white text-red-600 px-8 py-3 rounded-lg font-semibold hover:bg-red-50 transition">
                    Proposer une enquête
                </button>
            </div>
        </div>
    </section>

    {{-- KPIs Section --}}
    <section class="py-12 bg-white border-b">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl font-bold text-red-600">{{ $totalProposals }}</div>
                    <div class="text-gray-600 mt-2">Propositions</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-red-600">{{ $totalSupporters }}</div>
                    <div class="text-gray-600 mt-2">Soutiens</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-red-600">{{ number_format($totalFunds, 0, ',', ' ') }} FCFA</div>
                    <div class="text-gray-600 mt-2">Fonds collectés</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-red-600">{{ $totalImpact }}</div>
                    <div class="text-gray-600 mt-2">Enquêtes publiées</div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                {{-- Tabs --}}
                <div class="bg-white rounded-lg shadow-sm mb-6">
                    <div class="border-b">
                        <nav class="flex -mb-px">
                            <button onclick="showTab('proposals')"
                                    id="tab-proposals"
                                    class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-red-600 text-red-600">
                                Propositions actives
                            </button>
                            <button onclick="showTab('submit')"
                                    id="tab-submit"
                                    class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Proposer une enquête
                            </button>
                            <button onclick="showTab('my-proposals')"
                                    id="tab-my-proposals"
                                    class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Mes propositions
                            </button>
                        </nav>
                    </div>
                </div>

                {{-- Proposals List Tab --}}
                <div id="content-proposals" class="tab-content">
                    {{-- Filters --}}
                    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                        <div class="flex flex-wrap gap-4">
                            <select id="filter-status" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                                <option value="">Tous les statuts</option>
                                <option value="validated">Validé</option>
                                <option value="in_progress">En cours</option>
                                <option value="completed">Terminé</option>
                            </select>
                            <select id="filter-theme" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                                <option value="">Tous les thèmes</option>
                                <option value="Corruption">Corruption</option>
                                <option value="Environnement">Environnement</option>
                                <option value="Santé publique">Santé publique</option>
                                <option value="Justice">Justice</option>
                                <option value="Économie">Économie</option>
                                <option value="Droits humains">Droits humains</option>
                            </select>
                            <select id="filter-format" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                                <option value="">Tous les formats</option>
                                <option value="Article long">Article long</option>
                                <option value="Vidéo">Vidéo</option>
                                <option value="Podcast">Podcast</option>
                                <option value="Infographie">Infographie</option>
                                <option value="Série multimédia">Série multimédia</option>
                            </select>
                        </div>
                    </div>

                    {{-- Proposals Grid --}}
                    <div class="space-y-6">
                        @forelse($proposals as $proposal)
                        <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                            <div class="p-6">
                                {{-- Header --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold mb-2 hover:text-red-600">
                                            <a href="{{ route('investigation.show', $proposal) }}">
                                                {{ $proposal->title }}
                                            </a>
                                        </h3>
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                                {{ $proposal->theme }}
                                            </span>
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                {{ $proposal->format }}
                                            </span>
                                            @if($proposal->status === 'validated')
                                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                                    ✓ Validé
                                                </span>
                                            @elseif($proposal->status === 'in_progress')
                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                                    🔄 En cours
                                                </span>
                                            @elseif($proposal->status === 'completed')
                                                <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">
                                                    ✅ Terminé
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <p class="text-gray-700 mb-4 line-clamp-3">
                                    {{ Str::limit($proposal->angle, 200) }}
                                </p>

                                {{-- Budget Progress --}}
                                @if($proposal->budget && $proposal->budget > 0)
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600">Budget nécessaire</span>
                                        <span class="font-semibold">
                                            {{ number_format($proposal->budget_collected, 0, ',', ' ') }} / {{ number_format($proposal->budget, 0, ',', ' ') }} FCFA
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-red-600 h-2 rounded-full"
                                             style="width: {{ $proposal->budget_progress }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $proposal->budget_progress }}% financé
                                    </div>
                                </div>
                                @endif

                                {{-- Footer --}}
                                <div class="flex items-center justify-between pt-4 border-t">
                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                        <span>👤 {{ $proposal->user->prenom }} {{ $proposal->user->nom }}</span>
                                        @if($proposal->estimated_weeks)
                                            <span>⏱️ {{ $proposal->estimated_weeks }} semaines</span>
                                        @endif
                                        <span>📅 {{ $proposal->created_at->diffForHumans() }}</span>
                                    </div>
                                    <a href="{{ route('investigation.show', $proposal) }}"
                                       class="text-red-600 hover:text-red-700 font-medium">
                                        Lire plus →
                                    </a>
                                </div>
                            </div>
                        </article>
                        @empty
                        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                            <div class="text-gray-400 text-6xl mb-4">🔍</div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune proposition pour le moment</h3>
                            <p class="text-gray-500 mb-6">Soyez le premier à proposer une enquête !</p>
                            <button onclick="showTab('submit')"
                                    class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                                Proposer une enquête
                            </button>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Submit Form Tab --}}
                <div id="content-submit" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow-sm p-6" id="submit-form">
                        <h2 class="text-2xl font-bold mb-6">Proposer une enquête</h2>

                        <form id="investigation-form" class="space-y-6">
                            @csrf

                            {{-- Personal Info --}}
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nom complet <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="name" required
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                           placeholder="Prénom et nom">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Email <span class="text-red-600">*</span>
                                    </label>
                                    <input type="email" name="email" required
                                           value="{{ $userEmail ?? '' }}"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                           placeholder="votre@email.com">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                    <input type="tel" name="phone"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                           placeholder="+229 XX XX XX XX">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                    <input type="text" name="city"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                           placeholder="Cotonou">
                                </div>
                            </div>

                            {{-- Investigation Details --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Titre de l'enquête <span class="text-red-600">*</span>
                                </label>
                                <input type="text" name="title" required minlength="10" maxlength="140"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                       placeholder="Un titre percutant (10-140 caractères)">
                                <p class="text-xs text-gray-500 mt-1">
                                    <span id="title-count">0</span>/140 caractères
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Thème <span class="text-red-600">*</span>
                                </label>
                                <select name="theme" required
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                                    <option value="">Sélectionnez un thème</option>
                                    <option value="Corruption">Corruption</option>
                                    <option value="Environnement">Environnement</option>
                                    <option value="Santé publique">Santé publique</option>
                                    <option value="Justice">Justice</option>
                                    <option value="Économie">Économie</option>
                                    <option value="Droits humains">Droits humains</option>
                                    <option value="Éducation">Éducation</option>
                                    <option value="Sécurité">Sécurité</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Angle d'investigation <span class="text-red-600">*</span>
                                </label>
                                <textarea name="angle" required minlength="30" maxlength="1200" rows="5"
                                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                          placeholder="Décrivez précisément l'angle que vous souhaitez que nous explorions (30-1200 caractères)"></textarea>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span id="angle-count">0</span>/1200 caractères
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Sources disponibles
                                </label>
                                <textarea name="sources" maxlength="1600" rows="4"
                                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                          placeholder="Avez-vous des sources, des documents ou des contacts qui pourraient nous aider ?"></textarea>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Format souhaité <span class="text-red-600">*</span>
                                    </label>
                                    <select name="format" required
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                                        <option value="">Sélectionnez un format</option>
                                        <option value="Article long">Article long</option>
                                        <option value="Vidéo">Vidéo</option>
                                        <option value="Podcast">Podcast</option>
                                        <option value="Infographie">Infographie</option>
                                        <option value="Série multimédia">Série multimédia</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Durée estimée (semaines)
                                    </label>
                                    <input type="number" name="estimated_weeks" min="1" max="52"
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                           placeholder="Ex: 8">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Budget nécessaire (FCFA)
                                </label>
                                <input type="number" name="budget" min="0" max="999999999"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                       placeholder="Ex: 500000">
                                <p class="text-xs text-gray-500 mt-1">
                                    Budget approximatif pour mener cette enquête (optionnel)
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Besoins spécifiques
                                </label>
                                <textarea name="needs" maxlength="1000" rows="3"
                                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                                          placeholder="Y a-t-il des besoins particuliers ? (expertise technique, traduction, déplacements, etc.)"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Documents joints (optionnel)
                                </label>
                                <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                                <p class="text-xs text-gray-500 mt-1">
                                    PDF, Word, images (10 MB max par fichier)
                                </p>
                            </div>

                            {{-- Alert Box --}}
                            <div id="form-alert" class="hidden"></div>

                            {{-- Submit Button --}}
                            <div class="flex gap-4">
                                <button type="submit" id="submit-btn"
                                        class="flex-1 bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                                    Soumettre la proposition
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- My Proposals Tab --}}
                <div id="content-my-proposals" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-bold mb-6">Mes propositions</h2>

                        <div class="mb-4">
                            <input type="email" id="my-email"
                                   value="{{ $userEmail ?? '' }}"
                                   placeholder="Entrez votre email"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                            <button onclick="loadMyProposals()"
                                    class="mt-2 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                                Charger mes propositions
                            </button>
                        </div>

                        <div id="my-proposals-list" class="space-y-4">
                            <p class="text-gray-500 text-center py-8">
                                Entrez votre email pour voir vos propositions
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                {{-- Breaking News --}}
                @if($breakingNews->count() > 0)
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6 sticky top-4">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <span class="text-red-600">🔴</span>
                        À la une
                    </h3>
                    <div class="space-y-4">
                        @foreach($breakingNews->take(5) as $news)
                        <a href="{{ route('publication.show', $news) }}"
                           class="block group">
                            <h4 class="font-semibold text-sm group-hover:text-red-600 transition line-clamp-2">
                                {{ $news->title }}
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $news->published_at->diffForHumans() }}
                            </p>
                        </a>
                        @if(!$loop->last)
                        <hr>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Info Box --}}
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="font-bold mb-3">💡 Comment ça marche ?</h3>
                    <ol class="space-y-3 text-sm">
                        <li class="flex gap-2">
                            <span class="font-bold text-blue-600">1.</span>
                            <span>Proposez un sujet d'enquête</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="font-bold text-blue-600">2.</span>
                            <span>Notre équipe valide votre proposition</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="font-bold text-blue-600">3.</span>
                            <span>La communauté finance l'enquête</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="font-bold text-blue-600">4.</span>
                            <span>Nous menons l'investigation</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="font-bold text-blue-600">5.</span>
                            <span>Publication de l'enquête</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Tab Management
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-red-600', 'text-red-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected tab
    document.getElementById('content-' + tabName).classList.remove('hidden');

    // Add active class to selected button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.add('active', 'border-red-600', 'text-red-600');
    activeButton.classList.remove('border-transparent', 'text-gray-500');
}

// Character Counter
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.querySelector('input[name="title"]');
    const angleInput = document.querySelector('textarea[name="angle"]');

    if (titleInput) {
        titleInput.addEventListener('input', function() {
            document.getElementById('title-count').textContent = this.value.length;
        });
    }

    if (angleInput) {
        angleInput.addEventListener('input', function() {
            document.getElementById('angle-count').textContent = this.value.length;
        });
    }
});

// Form Submission
document.getElementById('investigation-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submit-btn');
    const formAlert = document.getElementById('form-alert');

    // Disable submit button
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="inline-block animate-spin mr-2">⏳</span> Envoi en cours...';

    const formData = new FormData(this);

    try {
        const response = await fetch('{{ route("investigation.submit") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (data.success) {
            formAlert.className = 'bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg';
            formAlert.innerHTML = `
                <strong>✅ Succès !</strong> ${data.message}
            `;
            formAlert.classList.remove('hidden');

            // Reset form
            this.reset();
            document.getElementById('title-count').textContent = '0';
            document.getElementById('angle-count').textContent = '0';

            // Show proposals tab after 2 seconds
            setTimeout(() => {
                showTab('proposals');
            }, 2000);
        } else {
            throw new Error(data.message || 'Une erreur est survenue');
        }
    } catch (error) {
        formAlert.className = 'bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg';
        formAlert.innerHTML = `
            <strong>❌ Erreur :</strong> ${error.message}
        `;
        formAlert.classList.remove('hidden');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Soumettre la proposition';

        // Scroll to alert
        formAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
});

// Load My Proposals
async function loadMyProposals() {
    const email = document.getElementById('my-email').value;
    const listContainer = document.getElementById('my-proposals-list');

    if (!email) {
        alert('Veuillez entrer votre email');
        return;
    }

    listContainer.innerHTML = '<p class="text-center py-8 text-gray-500">Chargement...</p>';

    try {
        const response = await fetch('{{ route("investigation.myProposals") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email })
        });

        const data = await response.json();

        if (data.success && data.proposals.length > 0) {
            listContainer.innerHTML = data.proposals.map(proposal => `
                <div class="border rounded-lg p-4">
                    <h4 class="font-semibold mb-2">${proposal.title}</h4>
                    <div class="flex gap-2 mb-2">
                        <span class="px-2 py-1 bg-gray-100 text-xs rounded">${proposal.theme}</span>
                        <span class="px-2 py-1 text-xs rounded ${
                            proposal.status === 'validated' ? 'bg-green-100 text-green-800' :
                            proposal.status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' :
                            proposal.status === 'completed' ? 'bg-purple-100 text-purple-800' :
                            proposal.status === 'rejected' ? 'bg-red-100 text-red-800' :
                            'bg-gray-100 text-gray-800'
                        }">${proposal.status_label}</span>
                    </div>
                    ${proposal.budget ? `
                        <p class="text-sm text-gray-600">
                            Budget: ${proposal.budget_collected.toLocaleString()} / ${proposal.budget.toLocaleString()} FCFA
                        </p>
                    ` : ''}
                    <p class="text-xs text-gray-500 mt-2">Soumis le ${proposal.created_at}</p>
                    ${proposal.rejection_reason ? `
                        <div class="mt-2 p-2 bg-red-50 text-red-800 text-sm rounded">
                            <strong>Raison du rejet:</strong> ${proposal.rejection_reason}
                        </div>
                    ` : ''}
                </div>
            `).join('');
        } else {
            listContainer.innerHTML = '<p class="text-center py-8 text-gray-500">Aucune proposition trouvée</p>';
        }
    } catch (error) {
        listContainer.innerHTML = '<p class="text-center py-8 text-red-500">Erreur lors du chargement</p>';
    }
}

// Filters
document.getElementById('filter-status')?.addEventListener('change', function() {
    // Implement filter logic
});

document.getElementById('filter-theme')?.addEventListener('change', function() {
    // Implement filter logic
});

document.getElementById('filter-format')?.addEventListener('change', function() {
    // Implement filter logic
});
</script>
@endpush
@endsection
