<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'issue_id',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'format',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
        'total_amount',
        'payment_method',
        'payment_status',
        'transaction_id',
        'paid_at',
        'status',
        'notes',
        'tracking_number',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Relation avec le numéro (Issue)
     */
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour les commandes payées
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Scope pour les commandes en attente
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Vérifie si la commande est payée
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Vérifie si la commande est en version numérique
     */
    public function isDigital()
    {
        return $this->format === 'digital';
    }

    /**
     * Vérifie si la commande est en version papier
     */
    public function isPaper()
    {
        return $this->format === 'paper';
    }

    /**
     * Marque la commande comme payée
     */
    public function markAsPaid($transactionId = null)
    {
        $this->update([
            'payment_status' => 'paid',
            'status' => 'paid',
            'paid_at' => now(),
            'transaction_id' => $transactionId,
        ]);
    }

    /**
     * Annule la commande
     */
    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }

    /**
     * Obtient le statut en français
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'En attente',
            'paid' => 'Payé',
            'processing' => 'En préparation',
            'shipped' => 'Expédié',
            'delivered' => 'Livré',
            'cancelled' => 'Annulé',
            'refunded' => 'Remboursé',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Obtient le statut de paiement en français
     */
    public function getPaymentStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'En attente',
            'paid' => 'Payé',
            'failed' => 'Échoué',
            'refunded' => 'Remboursé',
        ];

        return $statuses[$this->payment_status] ?? $this->payment_status;
    }
}
