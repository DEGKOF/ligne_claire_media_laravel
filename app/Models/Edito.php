<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Edito extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Boot method pour auto-générer le slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($edito) {
            if (empty($edito->slug)) {
                $edito->slug = static::generateUniqueSlug($edito->title);
            }

            // Si status published et pas de date, mettre la date actuelle
            if ($edito->status === 'published' && !$edito->published_at) {
                $edito->published_at = now();
            }
        });

        static::updating(function ($edito) {
            // Si on passe de draft à published, mettre la date
            if ($edito->isDirty('status') && $edito->status === 'published' && !$edito->published_at) {
                $edito->published_at = now();
            }
        });
    }

    /**
     * Générer un slug unique
     */
    public static function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    /**
     * Relation avec l'utilisateur (auteur)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at');
                    // Retiré la condition ->where('published_at', '<=', now())
                    // pour permettre les publications programmées dans le futur
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Accesseurs pour les URLs complètes
     */
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image
            ? Storage::disk('public')->url($this->cover_image)
            : null;
    }

    /**
     * Obtenir le dernier édito publié
     */
    public static function getLatestPublished()
    {
        return static::published()->latest()->first();
    }

    /**
     * Obtenir les anciens éditos publiés (sauf le dernier)
     */
    public static function getOlderPublished($limit = null)
    {
        $query = static::published()->latest()->skip(1);

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }

    /**
     * Vérifier si l'édito est publié
     */
    public function isPublished()
    {
        return $this->status === 'published'
            && $this->published_at;
    }

    /**
     * Badge de statut pour l'affichage
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'published' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Publié</span>',
            'draft' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Brouillon</span>',
            'archived' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Archivé</span>',
            default => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inconnu</span>',
        };
    }

    /**
     * Obtenir le label du statut
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'published' => 'Publié',
            'draft' => 'Brouillon',
            'archived' => 'Archivé',
            default => 'Inconnu',
        };
    }

    /**
     * Obtenir un extrait du contenu si excerpt n'est pas défini
     */
    public function getExcerptOrContentAttribute()
    {
        if ($this->excerpt) {
            return $this->excerpt;
        }

        // Extraire du contenu HTML
        $text = strip_tags($this->content);
        return Str::limit($text, 200);
    }
}
