<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WitnessTestimony extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'location',
        'event_date',
        'media_files',
        'anonymous_publication',
        'consent_given',
        'status',
        'rejection_reason',
        'validated_at',
        'published_at',
        'validated_by',
        'views',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'media_files' => 'array',
        'anonymous_publication' => 'boolean',
        'consent_given' => 'boolean',
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
        return $query->where('status', 'published');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeAnonymous($query)
    {
        return $query->where('anonymous_publication', true);
    }

    // Méthodes
    public function validate($validatorId)
    {
        $this->update([
            'status' => 'validated',
            'validated_at' => now(),
            'validated_by' => $validatorId,
        ]);

        // Incrémenter le compteur de témoignages soumis
        $this->user->witnessProfile?->incrementSubmitted();
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
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Incrémenter le compteur de témoignages publiés
        $this->user->witnessProfile?->incrementPublished();
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getAuthorNameAttribute()
    {
        if ($this->anonymous_publication) {
            return 'Témoin anonyme';
        }
        return $this->user->public_name ?? 'Témoin';
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'En attente de validation',
            'validated' => 'Validé',
            'rejected' => 'Rejeté',
            'published' => 'Publié',
            default => $this->status,
        };
    }

    public function hasMediaFiles()
    {
        return !empty($this->media_files) && count($this->media_files) > 0;
    }

    // Dans App\Models\WitnessTestimony.php

        /**
         * Obtenir le premier média (média par défaut)
         */
        // public function getFirstMediaAttribute()
        // {
        //     $mediaFiles = is_string($this->media_files)
        //         ? json_decode($this->media_files, true)
        //         : $this->media_files;

        //     return !empty($mediaFiles) ? $mediaFiles[0] : null;
        // }

        /**
         * Obtenir tous les médias
         */
        public function getAllMediaAttribute()
        {
            $mediaFiles = is_string($this->media_files)
                ? json_decode($this->media_files, true)
                : $this->media_files;

            return $mediaFiles ?? [];
        }

        /**
         * Compter le nombre de médias
         */
        // public function getMediaCountAttribute()
        // {
        //     return count($this->all_media);
        // }

        /**
         * Vérifier s'il y a plusieurs médias
         */
        public function hasMultipleMediaAttribute()
        {
            return $this->media_count > 1;
        }

        // Dans App\Models\WitnessTestimony.php

        /**
         * Obtenir le premier média (média par défaut)
         */
        public function getFirstMediaAttribute()
        {
            $mediaFiles = is_string($this->media_files)
                ? json_decode($this->media_files, true)
                : $this->media_files;

            return !empty($mediaFiles) ? $mediaFiles[0] : null;
        }

        /**
         * Compter le nombre de médias
         */
        public function getMediaCountAttribute()
        {
            $mediaFiles = is_string($this->media_files)
                ? json_decode($this->media_files, true)
                : $this->media_files;

            return count($mediaFiles ?? []);
        }
}
