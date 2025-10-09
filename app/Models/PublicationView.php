<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'publication_id',
        'ip_address',
        'user_agent',
        'referer',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    // Relation
    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }

    // Méthode statique pour enregistrer une vue
    public static function recordView(Publication $publication, $request)
    {
        // Vérifier si cette IP a déjà vu cet article dans les 5 dernières minutes
        $recentView = self::where('publication_id', $publication->id)
            ->where('ip_address', $request->ip())
            ->where('viewed_at', '>', now()->subMinutes(5))
            ->exists();

        if (!$recentView) {
            self::create([
                'publication_id' => $publication->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer'),
                'viewed_at' => now(),
            ]);

            $publication->incrementViews();
        }
    }
}
