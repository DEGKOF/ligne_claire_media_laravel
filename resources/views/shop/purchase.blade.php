@extends('layouts.frontend')

@section('title', 'Finaliser votre achat')

@section('content')

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-8 text-sm">
            <ol class="flex items-center gap-2 text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-blue-600">Accueil</a></li>
                <li>/</li>
                <li><a href="{{ route('shop.index') }}" class="hover:text-blue-600">Boutique</a></li>
                <li>/</li>
                <li class="text-gray-900 font-semibold">Finaliser l'achat</li>
            </ol>
        </nav>

        <h1 class="text-3xl md:text-4xl font-black mb-8 text-center">
            Finaliser votre commande
        </h1>

        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Formulaire de commande -->
                <div class="lg:col-span-2">
                    <form action="{{ route('shop.process-order') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                        <input type="hidden" name="format" value="digital">

                        <!-- Informations client -->
                        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                            <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                                <span class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                                Vos informations
                            </h2>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nom complet <span class="text-blue-500">*</span>
                                    </label>
                                    <input type="text"
                                           id="customer_name"
                                           name="customer_name"
                                           required
                                           value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('customer_name') border-blue-500 @enderror">
                                    @error('customer_name')
                                        <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email <span class="text-blue-500">*</span>
                                    </label>
                                    <input type="email"
                                           id="customer_email"
                                           name="customer_email"
                                           required
                                           value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('customer_email') border-blue-500 @enderror">
                                    @error('customer_email')
                                        <p class="text-blue-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="customer_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Téléphone
                                    </label>
                                    <input type="tel"
                                           id="customer_phone"
                                           name="customer_phone"
                                           value="{{ old('customer_phone') }}"
                                           placeholder="+229 XX XX XX XX"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <!-- Quantité -->
                        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                            <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                                <span class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                                Quantité
                            </h2>

                            <div class="flex items-center gap-4">
                                <label for="quantity" class="text-sm font-semibold text-gray-700">
                                    Nombre d'exemplaires <span class="text-blue-500">*</span>
                                </label>
                                <div class="flex items-center gap-3">
                                    <button type="button"
                                            id="decrease-qty"
                                            class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg font-bold text-xl transition">
                                        -
                                    </button>
                                    <input type="number"
                                           id="quantity"
                                           name="quantity"
                                           value="{{ old('quantity', 1) }}"
                                           min="1"
                                           max="100"
                                           required
                                           class="w-20 px-4 py-3 border-2 border-gray-300 rounded-lg text-center font-bold text-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <button type="button"
                                            id="increase-qty"
                                            class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg font-bold text-xl transition">
                                        +
                                    </button>
                                </div>
                            </div>
                            @error('quantity')
                                <p class="text-blue-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Méthode de paiement -->
                        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                            <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                                <span class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span>
                                Méthode de paiement
                            </h2>

                            <div class="space-y-4">
                                <!-- Carte bancaire -->
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio"
                                           name="payment_method"
                                           value="card"
                                           class="w-5 h-5 text-blue-600"
                                           required>
                                    <span class="ml-4 flex-1">
                                        <strong class="block text-lg">💳 Carte bancaire</strong>
                                        <span class="text-sm text-gray-600">Visa, Mastercard, American Express</span>
                                    </span>
                                </label>

                                <!-- Mobile Money -->
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio"
                                           name="payment_method"
                                           value="mobile_money"
                                           class="w-5 h-5 text-blue-600">
                                    <span class="ml-4 flex-1">
                                        <strong class="block text-lg">📱 Mobile Money</strong>
                                        <span class="text-sm text-gray-600">MTN, Moov, Celtiis Cash</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                                Procéder au paiement →
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Récapitulatif de commande -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                        <h2 class="text-xl font-bold mb-6">Récapitulatif</h2>

                        <!-- Image du journal -->
                        <div class="mb-6">
                            @if($issue->cover_image)
                                <img src="{{ asset('storage/' . $issue->cover_image) }}"
                                     alt="Couverture"
                                     class="w-full h-auto rounded-lg shadow-md">
                            @else
                                <div class="aspect-[3/4] bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white text-6xl">📰</span>
                                </div>
                            @endif
                        </div>

                        <!-- Détails -->
                        <div class="space-y-4 mb-6">
                            <div>
                                <p class="text-sm text-gray-600">Numéro</p>
                                <p class="font-bold text-lg">{{ $issue->issue_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date</p>
                                <p class="font-semibold">{{ $issue->formatted_date }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Format</p>
                                <p class="font-semibold">
                                    📱 Version numérique (PDF)
                                </p>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Prix unitaire</span>
                                <span class="font-semibold">{{ number_format($issue->digital_price, 2) }} FCFA</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Quantité</span>
                                <span class="font-semibold" id="display-quantity">1</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold">Total</span>
                                <span class="text-3xl font-black text-blue-600" id="total-price">
                                    {{ number_format($issue->digital_price, 2) }} FCFA
                                </span>
                            </div>
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="mt-6 pt-6 border-t text-sm text-gray-600">
                            <p class="flex items-start gap-2 mb-2">
                                <span>✓</span>
                                <span>Paiement 100% sécurisé</span>
                            </p>
                            <p class="flex items-start gap-2 mb-2">
                                <span>✓</span>
                                <span>Accès immédiat après paiement</span>
                            </p>
                            <p class="flex items-start gap-2 mb-2">
                                <span>✓</span>
                                <span>Téléchargement illimité du PDF</span>
                            </p>
                            <p class="flex items-start gap-2">
                                <span>✓</span>
                                <span>Service client disponible 24/7</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const unitPrice = {{ $issue->digital_price }};
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');
        const displayQuantity = document.getElementById('display-quantity');
        const totalPrice = document.getElementById('total-price');

        function updateTotal() {
            const quantity = parseInt(quantityInput.value) || 1;
            const total = unitPrice * quantity;

            displayQuantity.textContent = quantity;
            totalPrice.textContent = new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(total) + ' FCFA';
        }

        decreaseBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value) || 1;
            if (value > 1) {
                quantityInput.value = value - 1;
                updateTotal();
            }
        });

        increaseBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value) || 1;
            if (value < 100) {
                quantityInput.value = value + 1;
                updateTotal();
            }
        });

        quantityInput.addEventListener('input', function() {
            let value = parseInt(this.value);
            if (value < 1) this.value = 1;
            if (value > 100) this.value = 100;
            updateTotal();
        });

        // Initialiser le total au chargement
        updateTotal();
    });
</script>

@endsection
