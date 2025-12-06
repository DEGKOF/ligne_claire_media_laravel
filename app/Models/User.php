<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'username',
        'email',
        'password',
        'phone',
        'city',
        'display_name',
        'company_name',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    // ==================== RELATIONS ====================

    // Relations pour les profils spécifiques
    public function contributorProfile()
    {
        return $this->hasOne(ContributorProfile::class);
    }

    public function investigatorProfile()
    {
        return $this->hasOne(InvestigatorProfile::class);
    }

    public function witnessProfile()
    {
        return $this->hasOne(WitnessProfile::class);
    }

    public function advertiserProfile()
    {
        return $this->hasOne(AdvertiserProfile::class);
    }

    // Relations pour les soumissions
    public function communitySubmissions()
    {
        return $this->hasMany(CommunitySubmission::class);
    }

    public function investigationProposals()
    {
        return $this->hasMany(InvestigationProposal::class);
    }

    public function witnessTestimonies()
    {
        return $this->hasMany(WitnessTestimony::class);
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'advertiser_id');
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    // ==================== ACCESSEURS ====================

    public function getPublicNameAttribute(): string
    {
        if ($this->display_name) {
            return $this->display_name;
        }
        return trim("{$this->prenom} {$this->nom}");
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->prenom} {$this->nom}");
    }

    // ==================== VÉRIFICATIONS DE RÔLES ====================

    public function isMasterAdmin(): bool
    {
        return $this->role === 'master_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'master_admin']);
    }

    public function isJournalist(): bool
    {
        return in_array($this->role, ['journaliste', 'redacteur', 'admin', 'master_admin']);
    }

    public function canWriteArticles(): bool
    {
        return in_array($this->role, ['journaliste', 'redacteur', 'admin', 'master_admin']);
    }

    public function canManageRubriques(): bool
    {
        // return $this->isAdmin();
        return in_array($this->role, ['journaliste', 'redacteur', 'admin', 'master_admin']);
    }

    // Nouveaux rôles externes
    public function isContributor(): bool
    {
        return $this->role === 'contributor';
    }

    public function isInvestigator(): bool
    {
        return $this->role === 'investigator';
    }

    public function isWitness(): bool
    {
        return $this->role === 'witness';
    }

    public function isAdvertiser(): bool
    {
        return $this->role === 'advertiser';
    }

    public function isExternalUser(): bool
    {
        return in_array($this->role, ['contributor', 'investigator', 'witness', 'advertiser']);
    }

    public function isInternalUser(): bool
    {
        return in_array($this->role, ['journaliste', 'redacteur', 'admin', 'master_admin']);
    }

    // ==================== MÉTHODES MÉTIER ====================

    /**
     * Créer le profil approprié selon le rôle
     */
    public function createProfile(): void
    {
        switch ($this->role) {
            case 'contributor':
                if (!$this->contributorProfile) {
                    $this->contributorProfile()->create([]);
                }
                break;
            case 'investigator':
                if (!$this->investigatorProfile) {
                    $this->investigatorProfile()->create([]);
                }
                break;
            case 'witness':
                if (!$this->witnessProfile) {
                    $this->witnessProfile()->create([]);
                }
                break;
            case 'advertiser':
                if (!$this->advertiserProfile) {
                    $this->advertiserProfile()->create([
                        'status' => 'pending',
                        'balance' => 0,
                    ]);
                }
                break;
        }
    }

    /**
     * Obtenir le profil approprié selon le rôle
     */
    public function getProfile()
    {
        return match($this->role) {
            'contributor' => $this->contributorProfile,
            'investigator' => $this->investigatorProfile,
            'witness' => $this->witnessProfile,
            'advertiser' => $this->advertiserProfile,
            default => null,
        };
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    public function scopeInternalUsers($query)
    {
        return $query->whereIn('role', ['journaliste', 'redacteur', 'admin', 'master_admin']);
    }

    public function scopeExternalUsers($query)
    {
        return $query->whereIn('role', ['contributor', 'investigator', 'witness', 'advertiser']);
    }

    public function scopeContributors($query)
    {
        return $query->where('role', 'contributor');
    }

    public function scopeInvestigators($query)
    {
        return $query->where('role', 'investigator');
    }

    public function scopeWitnesses($query)
    {
        return $query->where('role', 'witness');
    }

    public function scopeAdvertisers($query)
    {
        return $query->where('role', 'advertiser');
    }
}
