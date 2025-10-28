<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WitnessProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'anonymous_allowed',
        'receive_notifications',
        'categories_interest',
        'testimonies_submitted',
        'testimonies_published',
    ];

    protected $casts = [
        'anonymous_allowed' => 'boolean',
        'receive_notifications' => 'boolean',
        'categories_interest' => 'array',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Méthodes
    public function incrementSubmitted()
    {
        $this->increment('testimonies_submitted');
    }

    public function incrementPublished()
    {
        $this->increment('testimonies_published');
    }

    public function getPublicationRateAttribute()
    {
        if ($this->testimonies_submitted === 0) {
            return 0;
        }
        return round(($this->testimonies_published / $this->testimonies_submitted) * 100, 2);
    }
}
