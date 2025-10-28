<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'publication_id',
        'user_id',
        'guest_name',
        'guest_email',
        'content',
        'is_approved',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Retirer le 'with' pour éviter les problèmes
    // protected $with = ['user'];

    // Relations
    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesseurs
    public function getAuthorNameAttribute(): string
    {
        // Vérifier d'abord si l'utilisateur existe
        if ($this->user_id && $this->user) {
            return $this->user->public_name;
        }

        // Sinon retourner le nom de l'invité
        return $this->guest_name ?? 'Anonyme';
    }

    public function getAuthorInitialsAttribute(): string
    {
        $name = $this->author_name;
        $words = explode(' ', $name);

        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        return strtoupper(substr($name, 0, 2));
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->locale('fr')->diffForHumans();
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeForPublication($query, $publicationId)
    {
        return $query->where('publication_id', $publicationId);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
