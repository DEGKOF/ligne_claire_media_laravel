<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Rubrique extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'order',
        'is_active',
        'icon',
        'color',
        'views_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'views_count' => 'integer',
    ];

    // Boot method pour auto-générer le slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rubrique) {
            if (empty($rubrique->slug)) {
                $rubrique->slug = Str::slug($rubrique->name);
            }
        });

        static::updating(function ($rubrique) {
            if ($rubrique->isDirty('name')) {
                $rubrique->slug = Str::slug($rubrique->name);
            }
        });
    }

    // Relations
    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    public function publishedPublications()
    {
        return $this->publications()->published();
    }

    // Méthodes
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function scopePopular($query, int $limit = 10)
    {
        return $query->orderByDesc('views_count')->limit($limit);
    }

    // Accesseurs
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
