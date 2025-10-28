<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Publication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'rubrique_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'type',
        'featured_image',
        'video_url',
        'external_link',
        'video_duration',
        'status',
        'is_featured',
        'is_breaking',
        'published_at',
        'views_count',
        'comments_count',
        'shares_count',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_breaking' => 'boolean',
        'views_count' => 'integer',
        'comments_count' => 'integer',
        'shares_count' => 'integer',
        'video_duration' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($publication) {
            if (empty($publication->slug)) {
                $publication->slug = Str::slug($publication->title);
            }
            if (empty($publication->published_at) && $publication->status === 'published') {
                $publication->published_at = now();
            }
        });

        static::updating(function ($publication) {
            if ($publication->isDirty('title')) {
                $publication->slug = Str::slug($publication->title);
            }
        });
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rubrique()
    {
        return $this->belongsTo(Rubrique::class);
    }

    public function views()
    {
        return $this->hasMany(PublicationView::class);
    }

    // Accesseurs
    public function getIsNewAttribute(): bool
    {
        if (!$this->published_at) return false;
        return $this->published_at->diffInDays(now()) <= 3; // "NEW" pendant 3 jours
    }

    public function getReadTimeAttribute(): int
    {
        // Estimation: 200 mots par minute
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        return max(1, ceil($wordCount / 200));
    }

    public function getFormattedPublishedDateAttribute(): string
    {
        if (!$this->published_at) return '';
        return $this->published_at->locale('fr')->isoFormat('D MMMM YYYY à HH:mm');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Méthodes
    public function incrementViews()
    {
        $this->increment('views_count');
        $this->rubrique->incrementViews();
    }

    public function publish()
    {
        $this->update([
            'status' => 'published',
            'published_at' => $this->published_at ?? now(),
        ]);
    }

    public function unpublish()
    {
        $this->update(['status' => 'hidden']);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBreaking($query)
    {
        return $query->where('is_breaking', true);
    }

    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('published_at', '>=', now()->subDays($days));
    }

    public function scopePopular($query, int $limit = 10)
    {
        return $query->orderByDesc('views_count')->limit($limit);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByRubrique($query, $rubriqueId)
    {
        return $query->where('rubrique_id', $rubriqueId);
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%");
        });
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->approved()->latest();
    }
}
