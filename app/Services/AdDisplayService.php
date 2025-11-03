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
        // Bypass cache si rotation
        if (isset($context['no_cache']) && $context['no_cache']) {
            return $this->fetchAd($placementCode, $context);
        }

        $cacheKey = "ad_placement_{$placementCode}_" . md5(json_encode($context));

        return Cache::remember($cacheKey, now()->addMinutes(1), function () use ($placementCode, $context) {
            return $this->fetchAd($placementCode, $context);
        });
    }
    private function fetchAd(string $placementCode, array $context): ?Advertisement
    {
        $placement = AdvertisementPlacement::where('code', $placementCode)
            ->active()
            ->first();

        if (!$placement) {
            return null;
        }

        $context = $this->enrichContext($context, $placement);

        $query = Advertisement::active()
            ->forPlacement($placementCode)
            ->withinBudget();

        // Exclure les IDs déjà vus (pour rotation)
        if (isset($context['exclude_ids']) && !empty($context['exclude_ids'])) {
            $query->whereNotIn('id', $context['exclude_ids']);
        }

        if (isset($context['page'])) {
            $query->forPage($context['page']);
        }

        if (isset($context['device'])) {
            $query->forDevice($context['device']);
        }

        $ads = $query->orderByDesc('priority')
            ->orderByDesc('budget')
            ->get()
            ->filter(function ($ad) use ($context) {
                return $ad->canDisplay() && $ad->matchesTargeting($context);
            });

        return $this->selectAdWithRotation($ads);
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
    // public function recordImpression(Advertisement $ad): void
    // {
    //     $agent = new Agent();

    //     $ad->recordImpression([
    //         'device_type' => $agent->isMobile() ? 'mobile' : 'desktop',
    //         'browser' => $agent->browser(),
    //         'os' => $agent->platform(),
    //     ]);
    // }

    // Dans AdDisplayService
    public function recordImpression(Advertisement $ad): void
    {
        $agent = new Agent();

        // Clé unique par utilisateur/session + pub
        $sessionKey = session()->getId();
        $cacheKey = "impression_{$ad->id}_{$sessionKey}";

        // Si déjà vue dans les 5 dernières minutes, ne pas compter
        if (Cache::has($cacheKey)) {
            return;
        }

        // Enregistrer l'impression
        $ad->recordImpression([
            'device_type' => $agent->isMobile() ? 'mobile' : 'desktop',
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
        ]);

        // Marquer comme vue pour 5 minutes
        Cache::put($cacheKey, true, now()->addMinutes(1));
    }
}
