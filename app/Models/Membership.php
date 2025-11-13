<?php
// app/Models/Membership.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_membre',
        'civilite',
        'nom',
        'prenom',
        'nom_association',
        'nom_entreprise',
        'date_naissance',
        'lieu_naissance',
        'nationalite',
        'profession',
        'adresse_postale',
        'telephone',
        'email',
        'montant',
        'mode_paiement',
        'status',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];
}
