<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;

use App\Services\AdDisplayService;

class AdTrackingController extends Controller
{
    /**
     * Tracker un clic
     */
    public function trackClick(Advertisement $advertisement)
    {
        $agent = new Agent();

        $advertisement->recordClick([
            'device_type' => $agent->isMobile() ? 'mobile' : 'desktop',
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
        ]);

        return redirect($advertisement->target_url);
    }


    public function getNextAd(Request $request, $position)
    {
        $service = app(AdDisplayService::class);

        $context = [
            'exclude_ids' => $request->input('exclude', []),
            'no_cache' => true, // ← Flag pour bypass le cache
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
