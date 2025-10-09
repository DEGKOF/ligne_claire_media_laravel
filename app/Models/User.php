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
        'display_name',
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

    // Relations
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    // Accesseurs
    public function getPublicNameAttribute(): string
    {
        // Si display_name est défini, l'utiliser
        if ($this->display_name) {
            return $this->display_name;
        }

        // Sinon, utiliser nom + prenom
        return trim("{$this->prenom} {$this->nom}");
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->prenom} {$this->nom}");
    }

    // Vérifications de rôles
    public function isMasterAdmin(): bool
    {
        return $this->role === 'master_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'master_admin']);
    }

    public function canWriteArticles(): bool
    {
        return in_array($this->role, ['journaliste', 'redacteur', 'admin', 'master_admin']);
    }

    public function canManageRubriques(): bool
    {
        return $this->isAdmin();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }
}
