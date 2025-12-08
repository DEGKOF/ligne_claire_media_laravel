@extends('layouts.admin')

@section('page-title', 'Envoyer une Newsletter')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <!-- Retour -->
        <div class="mb-6">
            <a href="{{ route('admin.newsletter.index') }}"
                class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
        </div>

        <!-- Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 text-xl mt-0.5"></i>
                <div>
                    <p class="text-blue-900 font-medium">Abonnés actifs : {{ $activeSubscribers }}</p>
                    <p class="text-blue-700 text-sm mt-1">
                        Testez votre newsletter avant de l'envoyer à tous les abonnés.
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('admin.newsletter.send') }}" class="space-y-6">
            @csrf

            <!-- Sujet -->
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                    Sujet de l'email <span class="text-red-500">*</span>
                </label>
                <input type="text" id="subject" name="subject" required
                    value="{{ old('subject') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                    placeholder="Ex: Dernières actualités de Ligne Claire Média+">
                @error('subject')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message -->
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                    Message <span class="text-red-500">*</span>
                </label>
                <textarea id="message" name="message" rows="12" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('message') border-red-500 @enderror"
                    placeholder="Rédigez votre newsletter ici...">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-lightbulb mr-1"></i>
                    Utilisez du HTML pour formater votre message si nécessaire.
                </p>
            </div>

            <!-- Type de destinataire -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Destinataires <span class="text-red-500">*</span>
                </label>

                <div class="space-y-3">
                    <label class="flex items-start gap-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="recipient_type" value="test"
                            {{ old('recipient_type', 'test') === 'test' ? 'checked' : '' }}
                            class="mt-1" onchange="toggleTestEmail(true)">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">Email de test</p>
                            <p class="text-sm text-gray-600">Envoyer uniquement à une adresse email pour tester</p>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="recipient_type" value="active"
                            {{ old('recipient_type') === 'active' ? 'checked' : '' }}
                            class="mt-1" onchange="toggleTestEmail(false)">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">Abonnés actifs uniquement</p>
                            <p class="text-sm text-gray-600">{{ $activeSubscribers }} destinataire(s)</p>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="recipient_type" value="all"
                            {{ old('recipient_type') === 'all' ? 'checked' : '' }}
                            class="mt-1" onchange="toggleTestEmail(false)">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">Tous les abonnés</p>
                            <p class="text-sm text-gray-600">Actifs et inactifs</p>
                        </div>
                    </label>
                </div>

                @error('recipient_type')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email de test -->
            <div id="test-email-field" class="{{ old('recipient_type', 'test') === 'test' ? '' : 'hidden' }}">
                <label for="test_email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email de test <span class="text-red-500">*</span>
                </label>
                <input type="email" id="test_email" name="test_email"
                    value="{{ old('test_email', auth()->user()->email) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('test_email') border-red-500 @enderror"
                    placeholder="exemple@email.com">
                @error('test_email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Avertissement -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mt-0.5"></i>
                    <div>
                        <p class="text-yellow-900 font-medium">Attention</p>
                        <p class="text-yellow-700 text-sm mt-1">
                            Une fois envoyée, la newsletter ne pourra pas être annulée. Vérifiez bien le contenu avant d'envoyer.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                <a href="{{ route('admin.newsletter.index') }}"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                    Annuler
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium inline-flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    Envoyer la newsletter
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleTestEmail(show) {
    const field = document.getElementById('test-email-field');
    const input = document.getElementById('test_email');

    if (show) {
        field.classList.remove('hidden');
        input.required = true;
    } else {
        field.classList.add('hidden');
        input.required = false;
    }
}
</script>
@endsection
