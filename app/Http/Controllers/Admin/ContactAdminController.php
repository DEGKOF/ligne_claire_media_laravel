<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactAdminController extends Controller
{
    /**
     * Liste des messages
     */
    public function index(Request $request)
    {
        $query = Contact::query()->latest();

        // Filtre par statut
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Recherche
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('sujet', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(20);

        $stats = [
            'total' => Contact::count(),
            'nouveau' => Contact::where('status', 'nouveau')->count(),
            'lu' => Contact::where('status', 'lu')->count(),
            'traite' => Contact::where('status', 'traite')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Afficher un message
     */
    public function show(Contact $contact)
    {
        // Marquer comme lu automatiquement si nouveau
        if ($contact->status === 'nouveau') {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Changer le statut
     */
    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:nouveau,lu,traite,archive',
        ]);

        $contact->update([
            'status' => $request->status,
            'read_at' => in_array($request->status, ['lu', 'traite']) ? now() : $contact->read_at,
        ]);

        return redirect()->back()
            ->with('success', 'Statut mis à jour avec succès.');
    }

    /**
     * Supprimer un message
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message supprimé avec succès.');
    }

    /**
     * Supprimer plusieurs messages
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id',
        ]);

        Contact::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', count($request->ids) . ' message(s) supprimé(s) avec succès.');
    }
}
