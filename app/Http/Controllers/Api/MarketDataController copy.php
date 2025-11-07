<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\YahooFinanceService;
use Illuminate\Http\Request;

class MarketDataController extends Controller
{
    /**
     * Récupère les données des marchés financiers
     */
    public function index(YahooFinanceService $service)
    {
        try {
            $data = $service->getMarketData();

            return response()->json([
                'success' => true,
                'data' => $data,
                'updated_at' => now()->format('H:i:s'),
                'timestamp' => now()->toIso8601String()
            ]);
        } catch (\Exception $e) {
            \Log::error('Market Data API Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des données',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
