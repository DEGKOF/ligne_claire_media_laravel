<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'sujet',
        'message',
        'status',
        'ip_address',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Obtenir le nom complet
     */
    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    /**
     * Scope pour les nouveaux messages
     */
    public function scopeNouveau($query)
    {
        return $query->where('status', 'nouveau');
    }

    /**
     * Scope pour les messages lus
     */
    public function scopeLu($query)
    {
        return $query->where('status', 'lu');
    }

    /**
     * Scope pour les messages traités
     */
    public function scopeTraite($query)
    {
        return $query->where('status', 'traite');
    }

    /**
     * Marquer comme lu
     */
    public function markAsRead()
    {
        $this->update([
            'status' => 'lu',
            'read_at' => now(),
        ]);
    }

    /**
     * Marquer comme traité
     */
    public function markAsProcessed()
    {
        $this->update([
            'status' => 'traite',
        ]);
    }

    /**
     * Archiver
     */
    public function archive()
    {
        $this->update([
            'status' => 'archive',
        ]);
    }

    /**
     * Badge de statut
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'nouveau' => 'bg-blue-100 text-blue-800',
            'lu' => 'bg-yellow-100 text-yellow-800',
            'traite' => 'bg-green-100 text-green-800',
            'archive' => 'bg-gray-100 text-gray-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Libellé du statut
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'nouveau' => 'Nouveau',
            'lu' => 'Lu',
            'traite' => 'Traité',
            'archive' => 'Archivé',
        ];

        return $labels[$this->status] ?? 'Inconnu';
    }
}
