<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestigatorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expertise_areas',
        'portfolio_url',
        'experience',
        'languages',
        'is_verified',
        'investigations_completed',
        'total_budget_managed',
    ];

    protected $casts = [
        'expertise_areas' => 'array',
        'languages' => 'array',
        'is_verified' => 'boolean',
        'total_budget_managed' => 'decimal:2',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Méthodes
    public function verify()
    {
        $this->update(['is_verified' => true]);
    }

    public function incrementInvestigations()
    {
        $this->increment('investigations_completed');
    }

    public function addBudgetManaged($amount)
    {
        $this->increment('total_budget_managed', $amount);
    }
}
