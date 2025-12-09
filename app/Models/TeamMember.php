<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'poste',
        'telephone',
        'email',
        'photo',
        'bio',
        'ordre',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * Scope pour les membres visibles
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope pour l'ordre d'affichage
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre', 'asc')->orderBy('nom', 'asc');
    }

    /**
     * Obtenir le nom complet
     */
    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    /**
     * Obtenir l'URL de la photo
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return Storage::url($this->photo);
        }

        // Avatar par défaut avec initiales
        return null;
    }

    /**
     * Supprimer la photo lors de la suppression du membre
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($member) {
            if ($member->photo) {
                Storage::delete($member->photo);
            }
        });
    }
}
