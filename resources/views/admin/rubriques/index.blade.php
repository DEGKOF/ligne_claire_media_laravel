@extends('layouts.admin')

@section('page-title', 'Rubriques')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-black">Gestion des Rubriques</h1>
    <a href="{{ route('admin.rubriques.create') }}"
       class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition flex items-center gap-2">
        <span class="text-xl">+</span> Nouvelle rubrique
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Ordre
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Rubrique
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Slug
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Publications
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Vues
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Statut
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($rubriques as $rubrique)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm font-medium text-gray-900">
                        {{ $rubrique->order }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">{{ $rubrique->icon }}</span>
                        <div>
                            <div class="text-sm font-medium text-gray-900">
                                {{ $rubrique->name }}
                            </div>
                            @if($rubrique->description)
                            <div class="text-xs text-gray-500 max-w-md truncate">
                                {{ $rubrique->description }}
                            </div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <code class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-700">
                        {{ $rubrique->slug }}
                    </code>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-900">
                        {{ $rubrique->publications_count ?? 0 }} articles
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm font-semibold text-gray-900">
                        {{ number_format($rubrique->views_count) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <form action="{{ route('admin.rubriques.toggle', $rubrique) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1 text-xs font-semibold rounded-full transition {{ $rubrique->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            {{ $rubrique->is_active ? '✓ Active' : '✗ Inactive' }}
                        </button>
                    </form>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('rubrique.show', $rubrique->slug) }}"
                           target="_blank"
                           class="text-gray-600 hover:text-gray-900"
                            style="text-decoration: underline"
                           title="Voir">
                            Voir
                        </a>

                    @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.rubriques.edit', $rubrique) }}"
                            class="text-blue-600 hover:text-blue-900"
                                style="text-decoration: underline"
                            title="Modifier">
                                Modifier
                            </a>
                            @if(($rubrique->publications_count ?? 0) === 0)
                            <form action="{{ route('admin.rubriques.destroy', $rubrique) }}"
                                method="POST"
                                class="inline"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette rubrique ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                style="text-decoration: underline"
                                        class="text-red-600 hover:text-red-900"
                                        title="Supprimer">
                                    Supp
                                </button>
                            </form>
                            @else
                            <span class="text-gray-400 cursor-not-allowed" title="Impossible de supprimer : contient des publications">
                                Supp
                            </span>
                            @endif
                    @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex items-start gap-3">
        {{-- <div class="text-2xl">💡</div> --}}
        <div class="flex-1">
            <h3 class="font-bold text-blue-900 mb-1">Conseils</h3>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>• Les rubriques inactives ne sont pas visibles sur le site frontend</li>
                <li>• L'ordre détermine l'affichage dans le menu de navigation</li>
                <li>• Les rubriques contenant des publications ne peuvent pas être supprimées</li>
                <li>• Le slug est généré automatiquement à partir du nom</li>
            </ul>
        </div>
    </div>
</div>
@endsection
