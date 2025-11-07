<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'poste',
        'cv_path',
        'lettre_motivation_texte',
        'lettre_motivation_path',
        'statut',
        'notes_admin',
        'date_examen',
    ];

    protected $casts = [
        'date_examen' => 'datetime',
    ];

    /**
     * Scope pour filtrer par statut
     */
    public function scopeStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    /**
     * Scope pour les candidatures en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope pour filtrer par poste
     */
    public function scopePoste($query, $poste)
    {
        return $query->where('poste', $poste);
    }

    /**
     * Obtenir le nom complet du candidat
     */
    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    /**
     * Obtenir l'URL du CV
     */
    public function getCvUrlAttribute()
    {
        return Storage::url($this->cv_path);
    }

    /**
     * Obtenir l'URL de la lettre de motivation (si fichier)
     */
    public function getLettreMotivationUrlAttribute()
    {
        return $this->lettre_motivation_path ? Storage::url($this->lettre_motivation_path) : null;
    }

    /**
     * Vérifier si la lettre de motivation est un texte
     */
    public function hasLettreTexte()
    {
        return !empty($this->lettre_motivation_texte);
    }

    /**
     * Vérifier si la lettre de motivation est un fichier
     */
    public function hasLettreFichier()
    {
        return !empty($this->lettre_motivation_path);
    }

    /**
     * Obtenir le libellé du poste
     */
    public function getPosteLibelleAttribute()
    {
        return match($this->poste) {
            'journaliste' => 'Journaliste',
            'redacteur' => 'Rédacteur',
            default => $this->poste,
        };
    }

    /**
     * Obtenir le libellé du statut
     */
    public function getStatutLibelleAttribute()
    {
        return match($this->statut) {
            'en_attente' => 'En attente',
            'examinee' => 'Examinée',
            'acceptee' => 'Acceptée',
            'refusee' => 'Refusée',
            default => $this->statut,
        };
    }

    /**
     * Obtenir la couleur du badge de statut
     */
    public function getStatutCouleurAttribute()
    {
        return match($this->statut) {
            'en_attente' => 'bg-yellow-100 text-yellow-800',
            'examinee' => 'bg-blue-100 text-blue-800',
            'acceptee' => 'bg-green-100 text-green-800',
            'refusee' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
