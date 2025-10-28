<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestigationProposal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'theme',
        'angle',
        'sources',
        'format',
        'budget',
        'estimated_weeks',
        'needs',
        'files',
        'status',
        'rejection_reason',
        'budget_collected',
        'validated_at',
        'started_at',
        'completed_at',
        'validated_by',
    ];

    protected $casts = [
        'files' => 'array',
        'budget' => 'decimal:2',
        'budget_collected' => 'decimal:2',
        'estimated_weeks' => 'integer',
        'validated_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Scopes
     */
    public function scopeValidated($query)
    {
        return $query->where('status', 'validated');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Accessors
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'En attente de validation',
            'validated' => 'Validé',
            'rejected' => 'Rejeté',
            'in_progress' => 'En cours',
            'completed' => 'Terminé',
            default => 'Statut inconnu',
        };
    }

    public function getBudgetProgressAttribute()
    {
        if (!$this->budget || $this->budget <= 0) {
            return 0;
        }
        return min(100, round(($this->budget_collected / $this->budget) * 100));
    }

    /**
     * Méthodes utilitaires
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isValidated()
    {
        return $this->status === 'validated';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function validate($userId = null)
    {
        $this->update([
            'status' => 'validated',
            'validated_at' => now(),
            'validated_by' => $userId,
        ]);
    }

    public function reject($reason = null)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);
    }

    public function startInvestigation()
    {
        $this->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);
    }

    public function complete()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
