<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Issue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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
        'stock_quantity' => 'integer',
    ];

    /**
     * Boot method pour auto-générer le numéro de journal
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($issue) {
            if (empty($issue->issue_number)) {
                $issue->issue_number = static::generateIssueNumber();
            }
        });
    }

    /**
     * Générer un numéro de journal automatique
     * Format: AANNNN (2 chiffres année + 4 chiffres séquence)
     * Exemple: 250001 pour le premier journal de 2025
     */
    public static function generateIssueNumber(): string
    {
        $year = date('y'); // 2 derniers chiffres de l'année (ex: 25 pour 2025)

        // Récupérer le dernier numéro de l'année en cours
        $lastIssue = static::withTrashed()
            ->where('issue_number', 'like', $year . '%')
            ->orderBy('issue_number', 'desc')
            ->first();

        if ($lastIssue) {
            // Extraire le numéro séquentiel et l'incrémenter
            $lastNumber = (int) substr($lastIssue->issue_number, 2);
            $newNumber = $lastNumber + 1;
        } else {
            // Premier journal de l'année
            $newNumber = 1;
        }

        // Format: AA + NNNN (année sur 2 chiffres + séquence sur 4 chiffres)
        return $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    /**
     * Accesseurs pour les URLs complètes
     */
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image
            ? Storage::disk('public')->url($this->cover_image)
            : null;
    }

    public function getPdfFileUrlAttribute()
    {
        return $this->pdf_file
            ? Storage::disk('public')->url($this->pdf_file)
            : null;
    }

    /**
     * Vérifier si le journal est en stock
     */
    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Vérifier si le journal est publié
     */
    public function isPublished()
    {
        return $this->status === 'published';
    }

    /**
     * Badge de statut pour l'affichage
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'published' => '<span class="badge bg-success">Publié</span>',
            'draft' => '<span class="badge bg-warning">Brouillon</span>',
            'archived' => '<span class="badge bg-secondary">Archivé</span>',
            default => '<span class="badge bg-light">Inconnu</span>',
        };
    }

    /**
     * Obtenir le label du statut
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'published' => 'Publié',
            'draft' => 'Brouillon',
            'archived' => 'Archivé',
            default => 'Inconnu',
        };
    }
}
