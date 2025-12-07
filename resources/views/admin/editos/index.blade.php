@extends('layouts.admin')

@section('title', 'Gestion des Éditos')

@section('page-title', 'Gestion des Éditos')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Liste des éditos</h2>
        <a href="{{ route('admin.editos.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm">
            <i class="fas fa-plus"></i>
            <span>Nouvel édito</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Titre
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Auteur
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date de publication
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
                @forelse($editos as $edito)
                <tr class="hover:bg-gray-50 {{ $edito->trashed() ? 'bg-gray-100' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($edito->cover_image)
                                <img src="{{ asset('storage/'. $edito->cover_image) }}"
                                     alt="{{ $edito->title }}"
                                     class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center">
                                    <i class="fas fa-pen-fancy text-gray-400"></i>
                                </div>
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $edito->title }}</div>
                                @if($edito->trashed())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mt-1">
                                        Supprimé
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($edito->user->nom ?? 'A', 0, 1)) }}
                            </div>
                            <div class="text-sm text-gray-900">
                                {{ $edito->user->prenom ?? $edito->user->username ?? 'Inconnu' }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($edito->published_at)
                            {{ $edito->published_at->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">Non publiée</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {!! $edito->status_badge !!}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            @if($edito->trashed())
                                <form action="{{ route('admin.editos.restore', $edito->id) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="text-green-600 hover:text-green-900 transition"
                                            title="Restaurer">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.editos.force-delete', $edito->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Supprimer définitivement cet édito ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition"
                                            title="Supprimer définitivement">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.editos.show', $edito) }}"
                                   class="text-blue-600 hover:text-blue-900 transition"
                                   title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.editos.edit', $edito) }}"
                                   class="text-yellow-600 hover:text-yellow-900 transition"
                                   title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.editos.destroy', $edito) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Archiver cet édito ?');">
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
                    <td colspan="5" class="px-6 py-12 text-center">
                        <i class="fas fa-pen-fancy text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 mb-4">Aucun édito trouvé</p>
                        <a href="{{ route('admin.editos.create') }}"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                            <i class="fas fa-plus"></i>
                            <span>Créer le premier édito</span>
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($editos->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $editos->links() }}
    </div>
    @endif
</div>
@endsection
