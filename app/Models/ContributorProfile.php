<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialties',
        'bio',
        'website',
        'linkedin',
        'twitter',
        'articles_published',
        'total_earned',
    ];

    protected $casts = [
        'specialties' => 'array',
        'total_earned' => 'decimal:2',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Méthodes
    public function incrementArticles()
    {
        $this->increment('articles_published');
    }

    public function addEarnings($amount)
    {
        $this->increment('total_earned', $amount);
    }
}
