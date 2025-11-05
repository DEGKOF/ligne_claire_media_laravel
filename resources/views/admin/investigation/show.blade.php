@extends('layouts.admin')

@section('title', 'Détails de la proposition #' . $proposal->id)

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.investigations.index') }}"
               class="text-blue-600 hover:text-blue-700">
                ← Retour à la liste
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Proposition #{{ $proposal->id }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Soumise le {{ $proposal->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>
        <div class="flex gap-2">
            @if($proposal->status === 'pending')
                <button onclick="validateProposal()"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    ✓ Valider
                </button>
                <button onclick="rejectProposal()"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    ✗ Rejeter
                </button>
            @elseif($proposal->status === 'validated')
                <button onclick="startInvestigation()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    ▶ Démarrer
                </button>
            @elseif($proposal->status === 'in_progress')
                <button onclick="completeInvestigation()"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    ✓ Terminer
                </button>
            @endif
            <a href="{{ route('admin.investigations.edit', $proposal) }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                ✏️ Modifier
            </a>
            <button onclick="deleteProposal()"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                🗑️ Supprimer
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Proposal Details --}}
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-bold mb-2">{{ $proposal->title }}</h2>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                            {{ $proposal->theme }}
                        </span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full">
                            {{ $proposal->format }}
                        </span>
                        @if($proposal->status === 'validated')
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                ✓ Validé
                            </span>
                        @elseif($proposal->status === 'in_progress')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">
                                🔄 En cours
                            </span>
                        @elseif($proposal->status === 'completed')
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                ✅ Terminé
                            </span>
                        @elseif($proposal->status === 'rejected')
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">
                                ✗ Rejeté
                            </span>
                        @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">
                                ⏳ En attente
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    {{-- Angle --}}
                    <div>
                        <h3 class="text-lg font-semibold mb-2">🎯 Angle d'investigation</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $proposal->angle }}</p>
                    </div>

                    {{-- Sources --}}
                    @if($proposal->sources)
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-2">📚 Sources disponibles</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $proposal->sources }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Needs --}}
                    @if($proposal->needs)
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-2">🛠️ Besoins spécifiques</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $proposal->needs }}</p>
                    </div>
                    @endif

                    {{-- Files --}}
                    @if(!empty($proposal->files) && count($proposal->files) > 0)
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-3">📎 Documents joints</h3>
                        <div class="space-y-2">
                            @foreach($proposal->files as $file)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded flex items-center justify-center">
                                        @if(str_contains($file['type'], 'pdf'))
                                            📄
                                        @elseif(str_contains($file['type'], 'image'))
                                            🖼️
                                        @else
                                            📁
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $file['name'] }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ number_format($file['size'] / 1024, 2) }} KB
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ asset('storage/' . $file['path']) }}"
                                       target="_blank"
                                       class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                        Télécharger
                                    </a>
                                    <button onclick="deleteFile('{{ $file['path'] }}')"
                                            class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Rejection Reason --}}
                    @if($proposal->status === 'rejected' && $proposal->rejection_reason)
                    <div class="border-t pt-6">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-red-800 mb-2">Raison du rejet</h3>
                            <p class="text-red-700">{{ $proposal->rejection_reason }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Timeline --}}
            @if($proposal->validated_at || $proposal->started_at || $proposal->completed_at)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">⏳ Timeline</h2>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <div class="w-0.5 h-full bg-gray-300"></div>
                        </div>
                        <div class="pb-4">
                            <div class="font-medium">Proposition soumise</div>
                            <div class="text-sm text-gray-500">
                                {{ $proposal->created_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                    </div>

                    @if($proposal->validated_at)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            @if($proposal->started_at || $proposal->completed_at)
                                <div class="w-0.5 h-full bg-gray-300"></div>
                            @endif
                        </div>
                        <div class="pb-4">
                            <div class="font-medium">Proposition validée</div>
                            <div class="text-sm text-gray-500">
                                {{ $proposal->validated_at->format('d/m/Y à H:i') }}
                                @if($proposal->validator)
                                    par {{ $proposal->validator->prenom }} {{ $proposal->validator->nom }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($proposal->started_at)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            @if($proposal->completed_at)
                                <div class="w-0.5 h-full bg-gray-300"></div>
                            @endif
                        </div>
                        <div class="pb-4">
                            <div class="font-medium">Investigation démarrée</div>
                            <div class="text-sm text-gray-500">
                                {{ $proposal->started_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($proposal->completed_at)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                        </div>
                        <div>
                            <div class="font-medium">Investigation terminée</div>
                            <div class="text-sm text-gray-500">
                                {{ $proposal->completed_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Author Info --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold mb-4">👤 Auteur</h3>
                <div class="space-y-3">
                    <div>
                        <div class="text-sm text-gray-600">Nom</div>
                        <div class="font-medium">
                            {{ $proposal->user->prenom }} {{ $proposal->user->nom }}
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Email</div>
                        <div class="font-medium">{{ $proposal->user->email }}</div>
                    </div>
                    @if($proposal->user->phone)
                    <div>
                        <div class="text-sm text-gray-600">Téléphone</div>
                        <div class="font-medium">{{ $proposal->user->phone }}</div>
                    </div>
                    @endif
                    @if($proposal->user->city)
                    <div>
                        <div class="text-sm text-gray-600">Ville</div>
                        <div class="font-medium">{{ $proposal->user->city }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Budget Info --}}
            @if($proposal->budget)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold mb-4">💰 Budget</h3>
                <div class="space-y-3">
                    <div>
                        <div class="text-sm text-gray-600">Budget total</div>
                        <div class="text-2xl font-bold text-blue-600">
                            {{ number_format($proposal->budget, 0, ',', ' ') }} F
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Collecté</div>
                        <div class="text-xl font-bold text-green-600">
                            {{ number_format($proposal->budget_collected, 0, ',', ' ') }} F
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full"
                                 style="width: {{ $proposal->budget_progress }}%"></div>
                        </div>
                        <div class="text-sm text-gray-600 mt-1">
                            {{ $proposal->budget_progress }}% financé
                        </div>
                    </div>
                    <div class="pt-2 border-t">
                        <div class="text-sm text-gray-600">Restant</div>
                        <div class="font-bold">
                            {{ number_format($proposal->budget - $proposal->budget_collected, 0, ',', ' ') }} F
                        </div>
                    </div>
                </div>

                {{-- Update Budget Form --}}
                <form onsubmit="updateBudget(event)" class="mt-4 pt-4 border-t">
                    <label class="block text-sm font-medium mb-2">Mettre à jour le montant collecté</label>
                    <div class="flex gap-2">
                        <input type="number"
                               id="budget-collected"
                               value="{{ $proposal->budget_collected }}"
                               class="flex-1 px-3 py-2 border rounded-lg"
                               min="0"
                               max="{{ $proposal->budget }}">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            OK
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- Details Info --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold mb-4">ℹ️ Informations</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Format</span>
                        <span class="font-medium">{{ $proposal->format }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Thème</span>
                        <span class="font-medium">{{ $proposal->theme }}</span>
                    </div>
                    @if($proposal->estimated_weeks)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Durée estimée</span>
                        <span class="font-medium">{{ $proposal->estimated_weeks }} semaines</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Statut</span>
                        <span class="font-medium">{{ $proposal->status_label }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Créée le</span>
                        <span class="font-medium">{{ $proposal->created_at->format('d/m/Y') }}</span>
                    </div>
                    @if($proposal->updated_at != $proposal->created_at)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Modifiée le</span>
                        <span class="font-medium">{{ $proposal->updated_at->format('d/m/Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold mb-4">⚡ Actions rapides</h3>
                <div class="space-y-2">
                    @if($proposal->status === 'pending')
                        <button onclick="validateProposal()"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-left">
                            ✓ Valider
                        </button>
                        <button onclick="rejectProposal()"
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-left">
                            ✗ Rejeter
                        </button>
                    @elseif($proposal->status === 'validated')
                        <button onclick="startInvestigation()"
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-left">
                            ▶ Démarrer l'investigation
                        </button>
                    @elseif($proposal->status === 'in_progress')
                        <button onclick="completeInvestigation()"
                                class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-left">
                            ✓ Marquer comme terminée
                        </button>
                    @endif

                    <a href="{{ route('admin.investigations.edit', $proposal) }}"
                       class="block w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-center">
                        ✏️ Modifier
                    </a>

                    @if($proposal->trashed())
                        <button onclick="restoreProposal()"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-left">
                            ↩️ Restaurer
                        </button>
                    @else
                        <button onclick="deleteProposal()"
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-left">
                            🗑️ Supprimer
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: Reject --}}
<div id="modal-reject" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold mb-4">Rejeter la proposition</h3>
        <form id="form-reject" onsubmit="handleReject(event)">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Raison du rejet <span class="text-red-600">*</span>
                </label>
                <textarea id="rejection-reason" rows="4" required minlength="10"
                          class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"
                          placeholder="Expliquez pourquoi cette proposition est rejetée..."></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Annuler
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Rejeter
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
const proposalId = {{ $proposal->id }};

function getToken() {
    return localStorage.getItem('auth_token') || '';
}

function showNotification(message, type = 'info') {
    alert(message);
}

async function validateProposal() {
    if (!confirm('Valider cette proposition ?')) return;

    try {
        const response = await fetch(`/api/admin/investigations/${proposalId}/validate`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Proposition validée avec succès', 'success');
            window.location.reload();
        } else {
            showNotification(result.message || 'Erreur', 'error');
        }
    } catch (error) {
        showNotification('Erreur lors de la validation', 'error');
    }
}

function rejectProposal() {
    document.getElementById('modal-reject').classList.remove('hidden');
}

async function handleReject(e) {
    e.preventDefault();
    const reason = document.getElementById('rejection-reason').value;

    try {
        const response = await fetch(`/api/admin/investigations/${proposalId}/reject`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ rejection_reason: reason })
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Proposition rejetée', 'success');
            window.location.reload();
        } else {
            showNotification(result.message || 'Erreur', 'error');
        }
    } catch (error) {
        showNotification('Erreur lors du rejet', 'error');
    }
}

async function startInvestigation() {
    if (!confirm('Démarrer cette investigation ?')) return;

    try {
        const response = await fetch(`/api/admin/investigations/${proposalId}/start`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Investigation démarrée', 'success');
            window.location.reload();
        } else {
            showNotification(result.message || 'Erreur', 'error');
        }
    } catch (error) {
        showNotification('Erreur', 'error');
    }
}

async function completeInvestigation() {
    if (!confirm('Marquer cette investigation comme terminée ?')) return;

    try {
        const response = await fetch(`/api/admin/investigations/${proposalId}/complete`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Investigation terminée', 'success');
            window.location.reload();
        } else {
            showNotification(result.message || 'Erreur', 'error');
        }
    } catch (error) {
        showNotification('Erreur', 'error');
    }
}

async function deleteProposal() {
    if (!confirm('Supprimer cette proposition ?')) return;

    try {
        const response = await fetch(`/api/admin/investigations/${proposalId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Proposition supprimée', 'success');
            window.location.href = '{{ route("admin.investigations.index") }}';
        } else {
            showNotification('Erreur', 'error');
        }
    } catch (error) {
        showNotification('Erreur', 'error');
    }
}

async function restoreProposal() {
    if (!confirm('Restaurer cette proposition ?')) return;

    try {
        const response = await fetch(`/api/admin/investigations/${proposalId}/restore`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Proposition restaurée', 'success');
            window.location.reload();
        } else {
            showNotification('Erreur', 'error');
        }
    } catch (error) {
        showNotification('Erreur', 'error');
    }
}

async function deleteFile(filePath) {
    if (!confirm('Supprimer ce fichier ?')) return;

    try {
        const response = await fetch(`/api/admin/investigations/${proposalId}/files`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ file_path: filePath })
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Fichier supprimé', 'success');
            window.location.reload();
        } else {
            showNotification('Erreur', 'error');
        }
    } catch (error) {
        showNotification('Erreur', 'error');
    }
}

async function updateBudget(e) {
    e.preventDefault();
    const budgetCollected = document.getElementById('budget-collected').value;

    try {
        const response = await fetch(`/api/admin/investigations/${proposalId}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${getToken()}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ budget_collected: budgetCollected })
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Budget mis à jour', 'success');
            window.location.reload();
        } else {
            showNotification('Erreur', 'error');
        }
    } catch (error) {
        showNotification('Erreur', 'error');
    }
}

function closeModal() {
    document.getElementById('modal-reject').classList.add('hidden');
}
</script>
@endpush
