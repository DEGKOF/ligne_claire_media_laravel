<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertiserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'legal_form',
        'rccm',
        'ifu',
        'sector',
        'employees_count',
        'founded_year',
        'address',
        'city',
        'country',
        'phone',
        'website',
        'contact_name',
        'contact_phone',
        'contact_email',
        'contact_position',
        'logo',
        'company_document',
        'id_document',
        'status',
        'rejection_reason',
        'validated_at',
        'validated_by',
        'balance',
        'credit_limit',
        'auto_recharge',
        'auto_recharge_threshold',
        'auto_recharge_amount',
        'notify_low_balance',
        'notify_campaign_end',
        'notify_campaign_approved',
    ];

    protected $casts = [
        'validated_at' => 'datetime',
        'balance' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'auto_recharge' => 'boolean',
        'auto_recharge_threshold' => 'decimal:2',
        'auto_recharge_amount' => 'decimal:2',
        'notify_low_balance' => 'boolean',
        'notify_campaign_end' => 'boolean',
        'notify_campaign_approved' => 'boolean',
        'employees_count' => 'integer',
        'founded_year' => 'integer',
    ];

    // ==================== RELATIONS ====================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'advertiser_id', 'user_id');
    }

    // ==================== SCOPES ====================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // ==================== ACCESSEURS ====================

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => '<span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">En attente</span>',
            'active' => '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Actif</span>',
            'suspended' => '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Suspendu</span>',
            'rejected' => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Rejeté</span>',
            default => '<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Inconnu</span>',
        };
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo
            ? asset('storage/' . $this->logo)
            : asset('images/default-company-logo.png');
    }

    // ==================== MÉTHODES ====================

    public function approve(User $validator): void
    {
        $this->update([
            'status' => 'active',
            'validated_at' => now(),
            'validated_by' => $validator->id,
            'rejection_reason' => null,
        ]);

        // Mettre à jour le statut de l'utilisateur
        $this->user->update(['advertiser_status' => 'active']);
    }

    public function reject(string $reason, User $validator): void
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'validated_at' => now(),
            'validated_by' => $validator->id,
        ]);

        $this->user->update(['advertiser_status' => 'pending']);
    }

    public function suspend(string $reason): void
    {
        $this->update([
            'status' => 'suspended',
            'rejection_reason' => $reason,
        ]);

        $this->user->update(['advertiser_status' => 'suspended']);

        // Mettre en pause toutes les campagnes actives
        $this->advertisements()
            ->where('status', 'active')
            ->update(['status' => 'paused']);
    }

    public function reactivate(): void
    {
        $this->update([
            'status' => 'active',
            'rejection_reason' => null,
        ]);

        $this->user->update(['advertiser_status' => 'active']);
    }

    public function addBalance(float $amount): void
    {
        $this->increment('balance', $amount);
    }

    public function deductBalance(float $amount): bool
    {
        if ($this->balance < $amount) {
            return false;
        }

        $this->decrement('balance', $amount);
        return true;
    }

    public function hasLowBalance(): bool
    {
        if (!$this->auto_recharge_threshold) {
            return false;
        }

        return $this->balance <= $this->auto_recharge_threshold;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }
}
