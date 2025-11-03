<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Advertisement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'advertiser_id',
        'placement_id',
        'name',
        'description',
        'content_type',
        'image_path',
        'video_url',
        'html_content',
        'headline',
        'caption',
        'cta_text',
        'target_url',
        'open_new_tab',
        'start_date',
        'end_date',
        'is_permanent',
        'budget',
        'spent',
        'daily_budget',
        'target_rubriques',
        'target_pages',
        'target_devices',
        'target_cities',
        'target_days',
        'target_time_start',
        'target_time_end',
        'max_impressions',
        'max_clicks',
        'max_daily_impressions',
        'max_daily_clicks',
        'impressions_count',
        'clicks_count',
        'ctr',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
        'priority',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'approved_at' => 'datetime',
        'is_permanent' => 'boolean',
        'open_new_tab' => 'boolean',
        'budget' => 'decimal:2',
        'spent' => 'decimal:2',
        'daily_budget' => 'decimal:2',
        'ctr' => 'decimal:2',
        'target_rubriques' => 'array',
        'target_pages' => 'array',
        'target_devices' => 'array',
        'target_cities' => 'array',
        'target_days' => 'array',
        'impressions_count' => 'integer',
        'clicks_count' => 'integer',
        'max_impressions' => 'integer',
        'max_clicks' => 'integer',
        'max_daily_impressions' => 'integer',
        'max_daily_clicks' => 'integer',
        'priority' => 'integer',
    ];

    // ==================== BOOT ====================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($advertisement) {
            if (!$advertisement->reference) {
                $advertisement->reference = self::generateReference();
            }
        });
    }

    // ==================== RELATIONS ====================

    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    public function placement()
    {
        return $this->belongsTo(AdvertisementPlacement::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function impressions()
    {
        return $this->hasMany(AdvertisementImpression::class);
    }

    public function clicks()
    {
        return $this->hasMany(AdvertisementClick::class);
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where(function($q) {
                $q->where('end_date', '>=', now())
                  ->orWhere('is_permanent', true);
            });
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeForPlacement($query, $placementCode)
    {
        return $query->whereHas('placement', function($q) use ($placementCode) {
            $q->where('code', $placementCode);
        });
    }

    public function scopeForPage($query, string $page)
    {
        return $query->where(function($q) use ($page) {
            $q->whereNull('target_pages')
              ->orWhereJsonContains('target_pages', $page);
        });
    }

    public function scopeForDevice($query, string $device)
    {
        return $query->where(function($q) use ($device) {
            $q->whereNull('target_devices')
              ->orWhereJsonContains('target_devices', $device);
        });
    }

    public function scopeWithinBudget($query)
    {
        return $query->where(function($q) {
            $q->whereNull('budget')
              ->orWhereRaw('spent < budget');
        });
    }

    // ==================== ACCESSEURS ====================

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'draft' => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Brouillon</span>',
            'pending' => '<span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">En attente</span>',
            'approved' => '<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Approuvé</span>',
            'active' => '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>',
            'paused' => '<span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">En pause</span>',
            'completed' => '<span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Terminée</span>',
            'rejected' => '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejetée</span>',
            'expired' => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Expirée</span>',
            default => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Inconnu</span>',
        };
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : null;
    }

    public function getBudgetProgressAttribute(): float
    {
        if (!$this->budget || $this->budget == 0) {
            return 0;
        }

        return min(($this->spent / $this->budget) * 100, 100);
    }

    public function getDaysRemainingAttribute(): int
    {
        if ($this->is_permanent) {
            return -1;
        }

        $now = now();
        if ($now->greaterThan($this->end_date)) {
            return 0;
        }

        return $now->diffInDays($this->end_date);
    }

    // ==================== MÉTHODES ====================

    public static function generateReference(): string
    {
        $year = now()->year;
        $lastAd = self::whereYear('created_at', $year)->latest('id')->first();
        $number = $lastAd ? intval(substr($lastAd->reference, -3)) + 1 : 1;

        return sprintf('AD-%d-%03d', $year, $number);
    }

    public function submit(): void
    {
        $this->update(['status' => 'pending']);
    }

    public function approve(User $approver): void
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $approver->id,
            'rejection_reason' => null,
        ]);
    }

    public function reject(string $reason, User $approver): void
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'approved_at' => now(),
            'approved_by' => $approver->id,
        ]);
    }

    public function activate(): void
    {
        if ($this->status !== 'approved') {
            throw new \Exception('Only approved advertisements can be activated');
        }

        $this->update(['status' => 'active']);
    }

    public function pause(): void
    {
        if (!in_array($this->status, ['active', 'approved'])) {
            throw new \Exception('Only active or approved advertisements can be paused');
        }

        $this->update(['status' => 'paused']);
    }

    public function resume(): void
    {
        if ($this->status !== 'paused') {
            throw new \Exception('Only paused advertisements can be resumed');
        }

        $this->update(['status' => 'active']);
    }

    public function complete(): void
    {
        $this->update(['status' => 'completed']);
    }

    public function recordImpression(array $data = []): void
    {
        $this->impressions()->create(array_merge([
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referer' => request()->header('referer'),
            'page_url' => request()->fullUrl(),
            'viewed_at' => now(),
        ], $data));

        $this->increment('impressions_count');
        $this->updateCTR();
        $this->checkLimits();
    }

    public function recordClick(array $data = []): void
    {
        $this->clicks()->create(array_merge([
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referer' => request()->header('referer'),
            'page_url' => request()->fullUrl(),
            'clicked_at' => now(),
        ], $data));

        $this->increment('clicks_count');
        $this->updateCTR();
        $this->checkLimits();
    }

    private function updateCTR(): void
    {
        if ($this->impressions_count > 0) {
            $ctr = ($this->clicks_count / $this->impressions_count) * 100;
            $this->update(['ctr' => round($ctr, 2)]);
        }
    }

    private function checkLimits(): void
    {
        // Vérifier les limites et compléter si atteint
        if ($this->max_impressions && $this->impressions_count >= $this->max_impressions) {
            $this->complete();
        }

        if ($this->max_clicks && $this->clicks_count >= $this->max_clicks) {
            $this->complete();
        }

        // Vérifier la date de fin
        if (!$this->is_permanent && now()->greaterThan($this->end_date)) {
            $this->update(['status' => 'expired']);
        }
    }

    public function canDisplay(): bool
    {
        // Vérifier le statut
        if ($this->status !== 'active') {
            return false;
        }

        // Vérifier les dates
        if (!$this->is_permanent) {
            if (now()->lessThan($this->start_date) || now()->greaterThan($this->end_date)) {
                return false;
            }
        }

        // Vérifier le budget
        if ($this->budget && $this->spent >= $this->budget) {
            return false;
        }

        // Vérifier les limites d'impressions
        if ($this->max_impressions && $this->impressions_count >= $this->max_impressions) {
            return false;
        }

        if ($this->max_clicks && $this->clicks_count >= $this->max_clicks) {
            return false;
        }

        return true;
    }

    public function matchesTargeting(array $context = []): bool
    {
        // Vérifier le ciblage par page
        if ($this->target_pages && isset($context['page'])) {
            if (!in_array($context['page'], $this->target_pages)) {
                return false;
            }
        }

        // Vérifier le ciblage par device
        if ($this->target_devices && isset($context['device'])) {
            if (!in_array($context['device'], $this->target_devices)) {
                return false;
            }
        }

        // Vérifier le ciblage par rubrique
        if ($this->target_rubriques && isset($context['rubrique_id'])) {
            if (!in_array($context['rubrique_id'], $this->target_rubriques)) {
                return false;
            }
        }

        // Vérifier le ciblage par jour
        if ($this->target_days) {
            $currentDay = strtolower(now()->format('l')); // monday, tuesday, etc.
            if (!in_array($currentDay, array_map('strtolower', $this->target_days))) {
                return false;
            }
        }

        // Vérifier le ciblage par heure
        if ($this->target_time_start && $this->target_time_end) {
            $currentTime = now()->format('H:i:s');
            if ($currentTime < $this->target_time_start || $currentTime > $this->target_time_end) {
                return false;
            }
        }

        return true;
    }
}
