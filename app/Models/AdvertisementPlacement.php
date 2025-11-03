<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementPlacement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'width',
        'height',
        'format',
        'price_per_day',
        'price_per_impression',
        'price_per_click',
        'billing_type',
        'max_ads',
        'rotation_interval',
        'priority',
        'allowed_formats',
        'max_file_size',
        'allowed_extensions',
        'is_active',
        'show_on_mobile',
        'show_on_desktop',
        'pages',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'price_per_impression' => 'decimal:4',
        'price_per_click' => 'decimal:2',
        'allowed_formats' => 'array',
        'allowed_extensions' => 'array',
        'pages' => 'array',
        'is_active' => 'boolean',
        'show_on_mobile' => 'boolean',
        'show_on_desktop' => 'boolean',
        'width' => 'integer',
        'height' => 'integer',
        'max_ads' => 'integer',
        'rotation_interval' => 'integer',
        'priority' => 'integer',
        'max_file_size' => 'integer',
    ];

    // ==================== RELATIONS ====================

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'placement_id');
    }

    public function activeAdvertisements()
    {
        return $this->hasMany(Advertisement::class, 'placement_id')
            ->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('priority', 'desc');
    }

    // ==================== ACCESSEURS ====================

    public function getDimensionsAttribute(): string
    {
        if ($this->width && $this->height) {
            return "{$this->width}x{$this->height}px";
        }
        return 'Flexible';
    }

    public function getPriceFormatAttribute(): string
    {
        return match($this->billing_type) {
            'flat' => number_format($this->price_per_day, 0, ',', ' ') . ' FCFA/jour',
            'cpm' => number_format($this->price_per_impression * 1000, 0, ',', ' ') . ' FCFA/1000 impressions',
            'cpc' => number_format($this->price_per_click, 0, ',', ' ') . ' FCFA/clic',
            default => 'Non défini',
        };
    }

    // ==================== MÉTHODES ====================

    public function calculatePrice(int $days, int $impressions = 0, int $clicks = 0): float
    {
        return match($this->billing_type) {
            'flat' => $this->price_per_day * $days,
            'cpm' => ($impressions / 1000) * $this->price_per_impression,
            'cpc' => $clicks * $this->price_per_click,
            default => 0,
        };
    }

    public function canShowOnPage(string $page): bool
    {
        if (!$this->pages) {
            return true;
        }

        return in_array($page, $this->pages);
    }
}
