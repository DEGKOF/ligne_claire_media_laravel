<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Publication;
use Illuminate\Support\Str;
use App\Mail\CandidatureRecue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CandidatureRequest;

class RecruitmentController extends Controller
{
    /**
     * Afficher la page de recrutement
     */
    public function index()
    {
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('recruitment.index', compact('breakingNews'));
    }

    /**
     * Traiter la soumission de candidature
     */
    public function store(CandidatureRequest $request)
    {
        try {
            // Préparer les données
            $data = $request->validated();

            // Stocker le CV
            $cvPath = $request->file('cv')->store('candidatures/cv', 'public');
            $data['cv_path'] = $cvPath;

            // Gérer la lettre de motivation
            if ($request->hasFile('lettre_motivation_fichier')) {
                // Si fichier uploadé
                $lettrePath = $request->file('lettre_motivation_fichier')->store('candidatures/lettres', 'public');
                $data['lettre_motivation_path'] = $lettrePath;
                $data['lettre_motivation_texte'] = null;
            } else {
                // Si texte écrit
                $data['lettre_motivation_texte'] = $request->input('lettre_motivation_texte');
                $data['lettre_motivation_path'] = null;
            }

            // Créer la candidature
            $candidature = Candidature::create($data);

            // Envoyer l'email de confirmation au candidat
            Mail::to($candidature->email)->send(new CandidatureRecue($candidature));

            // Rediriger avec message de succès
            return redirect()
                ->route('recruitment.index')
                ->with('success', 'Votre candidature a été envoyée avec succès ! Un email de confirmation vous a été envoyé.');

        } catch (\Exception $e) {
            // En cas d'erreur, supprimer les fichiers uploadés
            if (isset($cvPath) && Storage::disk('public')->exists($cvPath)) {
                Storage::disk('public')->delete($cvPath);
            }
            if (isset($lettrePath) && Storage::disk('public')->exists($lettrePath)) {
                Storage::disk('public')->delete($lettrePath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'envoi de votre candidature. Veuillez réessayer.');
        }
    }
}
