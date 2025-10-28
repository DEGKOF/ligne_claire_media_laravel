<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Affiche la page de la boutique avec tous les numéros
     */
    public function index()
    {
        // Récupérer le numéro le plus récent
        $currentIssue = Issue::where('status', 'published')
            ->latest('published_at')
            ->first();

        // Récupérer tous les numéros disponibles (2 ans d'archives)
        $issues = Issue::where('status', 'published')
            ->where('published_at', '>=', now()->subYears(2))
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('shop.index', compact('currentIssue', 'issues'));
    }

    /**
     * Recherche de numéros
     */
    public function search(Request $request)
    {
        $query = Issue::where('status', 'published')
            ->where('published_at', '>=', now()->subYears(2));

        // Recherche par numéro
        if ($request->filled('issue_number')) {
            $query->where('issue_number', $request->issue_number);
        }

        // Recherche par mois et année
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('published_at', $request->month)
                  ->whereYear('published_at', $request->year);
        } elseif ($request->filled('month')) {
            $query->whereMonth('published_at', $request->month);
        } elseif ($request->filled('year')) {
            $query->whereYear('published_at', $request->year);
        }

        $issues = $query->orderBy('published_at', 'desc')->paginate(12);

        // Récupérer le numéro actuel pour la section hero
        $currentIssue = Issue::where('status', 'published')
            ->latest('published_at')
            ->first();

        return view('shop.index', compact('currentIssue', 'issues'));
    }

    /**
     * Page de détails d'un numéro avant achat
     */
    public function show($id)
    {
        $issue = Issue::findOrFail($id);

        return view('shop.show', compact('issue'));
    }

    /**
     * Page de finalisation d'achat
     */
    public function purchase(Request $request, $id)
    {
        $issue = Issue::findOrFail($id);
        $format = $request->get('format', 'paper'); // 'paper' ou 'digital'

        // Calculer le prix en fonction du format
        $price = $format === 'digital' ? $issue->digital_price : $issue->price;

        return view('shop.purchase', compact('issue', 'format', 'price'));
    }

    /**
     * Traitement de la commande
     */
    public function processOrder(Request $request)
    {
        $validated = $request->validate([
            'issue_id' => 'required|exists:issues,id',
            'format' => 'required|in:paper,digital',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string',
            'shipping_address' => 'required_if:format,paper|string',
            'shipping_city' => 'required_if:format,paper|string',
            'shipping_postal_code' => 'required_if:format,paper|string',
            'payment_method' => 'required|in:card,mobile_money,bank_transfer',
        ]);

        // Créer la commande
        $order = Order::create([
            'issue_id' => $validated['issue_id'],
            'format' => $validated['format'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'shipping_address' => $validated['shipping_address'] ?? null,
            'shipping_city' => $validated['shipping_city'] ?? null,
            'shipping_postal_code' => $validated['shipping_postal_code'] ?? null,
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
            'total_amount' => $this->calculateTotal($validated['issue_id'], $validated['format']),
            'order_number' => 'CMD-' . strtoupper(uniqid()),
        ]);

        // Rediriger vers la page de paiement
        return redirect()->route('shop.payment', $order->id);
    }

    /**
     * Calcule le montant total
     */
    private function calculateTotal($issueId, $format)
    {
        $issue = Issue::findOrFail($issueId);
        return $format === 'digital' ? $issue->digital_price : $issue->price;
    }
}
