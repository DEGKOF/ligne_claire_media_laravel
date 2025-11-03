<?php

namespace App\Http\Controllers;

use App\Services\AdDisplayService;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function getNextAd(Request $request, $position)
    {
        $service = app(AdDisplayService::class);

        $excludeIds = $request->input('exclude', '');
        $exclude = $excludeIds ? explode(',', $excludeIds) : [];

        $context = [
            'exclude_ids' => array_filter($exclude),
            'no_cache' => true,
        ];

        $ad = $service->getAdForPlacement($position, $context);

        if ($ad) {
            $service->recordImpression($ad);
        }

        return view('components.ad-slot', [
            'ad' => $ad,
            'position' => $position,
            'fallback' => null,
        ]);
    }
}
