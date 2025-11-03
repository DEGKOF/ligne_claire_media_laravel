<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;

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
}
