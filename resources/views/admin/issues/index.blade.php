@extends('layouts.admin')

@section('title', 'Gestion des Journaux')

@section('page-title', 'Gestion des Journaux')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Liste des journaux</h2>
        <a href="{{ route('admin.issues.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm">
            <i class="fas fa-plus"></i>
            <span>Ajouter un journal</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Couverture
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        N° Journal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Titre
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Prix
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Statut
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        PDF
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($issues as $issue)
                <tr class="hover:bg-gray-50 {{ $issue->trashed() ? 'bg-gray-100' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($issue->cover_image)
                            <img src="{{ asset('storage/' . $issue->cover_image) }}"
                                 alt="{{ $issue->title }}"
                                 class="w-16 h-20 object-cover rounded shadow-sm">
                        @else
                            <div class="w-16 h-20 bg-gray-100 rounded flex items-center justify-center">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-semibold text-gray-900">{{ $issue->issue_number }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $issue->title }}</div>
                        @if($issue->trashed())
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mt-1">
                                Supprimé
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $issue->published_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="text-gray-900">{{ number_format($issue->price, 2) }} FCFA</div>
                        <div class="text-gray-500 text-xs">Digital: {{ number_format($issue->digital_price, 2) }} FCFA</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($issue->stock_quantity > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $issue->stock_quantity }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Épuisé
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($issue->status === 'published')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Publié
                            </span>
                        @elseif($issue->status === 'draft')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Brouillon
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Archivé
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($issue->pdf_file)
                            <a href="{{ asset('storage/' . $issue->pdf_file) }}"
                               target="_blank"
                               class="text-red-600 hover:text-red-800 transition">
                                <i class="fas fa-file-pdf text-lg"></i>
                            </a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            @if($issue->trashed())
                                <form action="{{ route('admin.issues.restore', $issue->id) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="text-green-600 hover:text-green-900 transition"
                                            title="Restaurer">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.issues.force-delete', $issue->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Supprimer définitivement ce journal ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition"
                                            title="Supprimer définitivement">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.issues.show', $issue) }}"
                                   class="text-blue-600 hover:text-blue-900 transition"
                                   title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.issues.edit', $issue) }}"
                                   class="text-yellow-600 hover:text-yellow-900 transition"
                                   title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.issues.destroy', $issue) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Archiver ce journal ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition"
                                            title="Archiver">
                                        <i class="fas fa-archive"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <i class="fas fa-newspaper text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 mb-4">Aucun journal trouvé</p>
                        <a href="{{ route('admin.issues.create') }}"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                            <i class="fas fa-plus"></i>
                            <span>Ajouter le premier journal</span>
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($issues->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $issues->links() }}
    </div>
    @endif
</div>
@endsection
