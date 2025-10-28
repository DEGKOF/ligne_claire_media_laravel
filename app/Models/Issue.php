<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_number',
        'title',
        'cover_image',
        'description',
        'published_at',
        'price',
        'digital_price',
        'status',
        'stock_quantity',
        'pdf_file',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'price' => 'decimal:2',
        'digital_price' => 'decimal:2',
    ];

    /**
     * Scope pour les numéros publiés
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope pour les numéros des 2 dernières années
     */
    public function scopeRecentTwoYears($query)
    {
        return $query->where('published_at', '>=', now()->subYears(2));
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getFormattedDateAttribute()
    {
        return $this->published_at->locale('fr')->isoFormat('dddd D MMMM YYYY');
    }

    /**
     * Vérifie si le numéro est disponible en stock
     */
    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Vérifie si le numéro est disponible en version numérique
     */
    public function hasDigitalVersion()
    {
        return !empty($this->pdf_file);
    }

    /**
     * Relation avec les commandes
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope pour rechercher par numéro
     */
    public function scopeByNumber($query, $number)
    {
        return $query->where('issue_number', $number);
    }

    /**
     * Scope pour rechercher par mois
     */
    public function scopeByMonth($query, $month)
    {
        return $query->whereMonth('published_at', $month);
    }

    /**
     * Scope pour rechercher par année
     */
    public function scopeByYear($query, $year)
    {
        return $query->whereYear('published_at', $year);
    }
}
