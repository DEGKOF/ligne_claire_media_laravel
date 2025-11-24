<?php
// app/Models/Membership.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Membership extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'formule',
        'nom',
        'prenom',
        'email',
        'telephone',
        'mode_paiement',
        'frequence',
        'montant',
        'apparaitre_publiquement',
        'statut',
        'date_adhesion',
        'date_expiration',
        'annees_soutien',
        'numero_carte',
        'charte_acceptee',
        'charte_acceptee_at',
    ];

    protected $casts = [
        'date_adhesion' => 'date',
        'date_expiration' => 'date',
        'charte_acceptee' => 'boolean',
        'charte_acceptee_at' => 'datetime',
        'apparaitre_publiquement' => 'boolean',
        'montant' => 'decimal:2',
    ];

    // Constantes pour les formules
    const FORMULE_CITOYEN = 'citoyen';
    const FORMULE_AMBASSADEUR = 'ambassadeur';

    const MONTANT_CITOYEN = 5000;
    const MONTANT_AMBASSADEUR = 10000;

    // Constantes pour les statuts
    const STATUT_EN_ATTENTE = 'en_attente';
    const STATUT_ACTIF = 'actif';
    const STATUT_SUSPENDU = 'suspendu';
    const STATUT_EXPIRE = 'expire';

    /**
     * Boot method pour générer automatiquement le numéro de carte
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($membership) {
            if (empty($membership->numero_carte)) {
                $membership->numero_carte = $membership->genererNumeroCarte();
            }
        });
    }

    /**
     * Générer un numéro de carte unique
     */
    public function genererNumeroCarte(): string
    {
        $prefix = $this->formule === self::FORMULE_AMBASSADEUR ? 'AMB' : 'CIT';
        $year = date('Y');

        do {
            $numero = $prefix . '-' . $year . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        } while (self::where('numero_carte', $numero)->exists());

        return $numero;
    }

    /**
     * Calculer la date d'expiration selon la fréquence
     */
    public function calculerDateExpiration(): Carbon
    {
        $dateDebut = $this->date_adhesion ?? now();

        return match($this->frequence) {
            'mensuel' => $dateDebut->copy()->addMonth(),
            'trimestriel' => $dateDebut->copy()->addMonths(3),
            'semestriel' => $dateDebut->copy()->addMonths(6),
            'annuel' => $dateDebut->copy()->addYear(),
            default => $dateDebut->copy()->addMonth(),
        };
    }

    /**
     * Vérifier si le membre a droit de vote (3 ans de soutien récurrent)
     */
    public function aDroitDeVote(): bool
    {
        return $this->annees_soutien >= 3 && $this->statut === self::STATUT_ACTIF;
    }

    /**
     * Obtenir le nom complet du membre
     */
    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    /**
     * Vérifier si l'abonnement est actif
     */
    public function estActif(): bool
    {
        return $this->statut === self::STATUT_ACTIF
            && $this->date_expiration
            && $this->date_expiration->isFuture();
    }

    /**
     * Vérifier si l'abonnement est expiré
     */
    public function estExpire(): bool
    {
        return $this->date_expiration && $this->date_expiration->isPast();
    }

    /**
     * Activer l'abonnement après paiement
     */
    public function activer(): void
    {
        $this->update([
            'statut' => self::STATUT_ACTIF,
            'date_adhesion' => now(),
            'date_expiration' => $this->calculerDateExpiration(),
        ]);
    }

    /**
     * Renouveler l'abonnement
     */
    public function renouveler(): void
    {
        $this->update([
            'date_expiration' => $this->calculerDateExpiration(),
            'statut' => self::STATUT_ACTIF,
        ]);

        // Incrémenter les années de soutien si annuel
        if ($this->frequence === 'annuel') {
            $this->increment('annees_soutien');
        }
    }

    /**
     * Scope pour les membres actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('statut', self::STATUT_ACTIF)
                    ->where('date_expiration', '>', now());
    }

    /**
     * Scope pour les membres citoyens
     */
    public function scopeCitoyens($query)
    {
        return $query->where('formule', self::FORMULE_CITOYEN);
    }

    /**
     * Scope pour les ambassadeurs
     */
    public function scopeAmbassadeurs($query)
    {
        return $query->where('formule', self::FORMULE_AMBASSADEUR);
    }

    /**
     * Scope pour les membres visibles publiquement
     */
    public function scopeVisiblesPubliquement($query)
    {
        return $query->where('apparaitre_publiquement', true)
                    ->where('statut', self::STATUT_ACTIF);
    }

    /**
     * Obtenir la réduction pour paiement annuel (2 mois offerts)
     */
    public function getMontantAvecReductionAttribute(): float
    {
        if ($this->frequence === 'annuel') {
            return $this->montant * 10; // 10 mois au lieu de 12
        }

        return match($this->frequence) {
            'mensuel' => $this->montant,
            'trimestriel' => $this->montant * 3,
            'semestriel' => $this->montant * 6,
            default => $this->montant,
        };
    }
}
