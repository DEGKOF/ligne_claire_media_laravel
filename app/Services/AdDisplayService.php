<?php

namespace App\Services;

use App\Models\Advertisement;
use App\Models\AdvertisementPlacement;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;

class AdDisplayService
{
    /**
     * Récupérer une pub pour un emplacement donné
     */
    public function getAdForPlacement(string $placementCode, array $context = []): ?Advertisement
    {
        $cacheKey = "ad_placement_{$placementCode}_" . md5(json_encode($context));

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($placementCode, $context) {
            $placement = AdvertisementPlacement::where('code', $placementCode)
                ->active()
                ->first();

            if (!$placement) {
                return null;
            }

            // Enrichir le contexte
            $context = $this->enrichContext($context, $placement);

            // Récupérer les pubs éligibles
            $query = Advertisement::active()
                ->forPlacement($placementCode)
                ->withinBudget();

            // Appliquer les filtres de ciblage
            if (isset($context['page'])) {
                $query->forPage($context['page']);
            }

            if (isset($context['device'])) {
                $query->forDevice($context['device']);
            }

            // Récupérer et filtrer par ciblage avancé
            $ads = $query->orderByDesc('priority')
                ->orderByDesc('budget')
                ->get()
                ->filter(function ($ad) use ($context) {
                    return $ad->canDisplay() && $ad->matchesTargeting($context);
                });

            // Rotation aléatoire pondérée par priorité
            return $this->selectAdWithRotation($ads);
        });
    }

    /**
     * Enrichir le contexte avec des données de la requête
     */
    private function enrichContext(array $context, AdvertisementPlacement $placement): array
    {
        $agent = new Agent();

        $context['device'] = $agent->isMobile() ? 'mobile' : 'desktop';
        $context['browser'] = $agent->browser();
        $context['os'] = $agent->platform();

        // Déterminer la page actuelle si non fournie
        if (!isset($context['page'])) {
            $route = request()->route();
            if ($route) {
                $context['page'] = $route->getName();
            }
        }

        return $context;
    }

    /**
     * Sélectionner une pub avec rotation pondérée
     */
    private function selectAdWithRotation($ads): ?Advertisement
    {
        if ($ads->isEmpty()) {
            return null;
        }

        // Pondération par priorité et budget restant
        $weights = $ads->mapWithKeys(function ($ad) {
            $weight = ($ad->priority + 1) * 10;

            if ($ad->budget > 0) {
                $remainingBudgetRatio = ($ad->budget - $ad->spent) / $ad->budget;
                $weight *= (1 + $remainingBudgetRatio);
            }

            return [$ad->id => $weight];
        });

        $totalWeight = $weights->sum();
        $random = mt_rand(0, $totalWeight * 100) / 100;

        $cumulative = 0;
        foreach ($weights as $id => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                return $ads->firstWhere('id', $id);
            }
        }

        return $ads->first();
    }

    /**
     * Enregistrer une impression
     */
    public function recordImpression(Advertisement $ad): void
    {
        $agent = new Agent();

        $ad->recordImpression([
            'device_type' => $agent->isMobile() ? 'mobile' : 'desktop',
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
        ]);
    }
}
