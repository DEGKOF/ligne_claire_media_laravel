<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunitySubmission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'section',
        'access_type',
        'summary',
        'content',
        'image_path',
        'status',
        'rejection_reason',
        'validated_at',
        'published_at',
        'validated_by',
        'views',
        'shares',
    ];

    protected $casts = [
        'validated_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeValidated($query)
    {
        return $query->where('status', 'validated');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopePremium($query)
    {
        return $query->where('access_type', 'premium');
    }

    public function scopeFree($query)
    {
        return $query->where('access_type', 'free');
    }

    public function scopeBySection($query, $section)
    {
        return $query->where('section', $section);
    }

    // Méthodes
    public function validate($validatorId, $publish = false)
    {
        $this->update([
            'status' => 'validated',
            'validated_at' => now(),
            'validated_by' => $validatorId,
            'published_at' => $publish ? now() : null,
        ]);

        // Incrémenter le compteur du contributeur
        $this->user->contributorProfile?->incrementArticles();
    }

    public function reject($reason, $validatorId)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'validated_by' => $validatorId,
            'validated_at' => now(),
        ]);
    }

    public function publish()
    {
        $this->update(['published_at' => now()]);
    }

    public function isPremium()
    {
        return $this->access_type === 'premium';
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function incrementShares()
    {
        $this->increment('shares');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'En attente de validation',
            'validated' => 'Validé',
            'rejected' => 'Rejeté',
            default => $this->status,
        };
    }
}
